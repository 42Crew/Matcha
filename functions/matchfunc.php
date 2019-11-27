<?php

session_start();
if (!$_SESSION['flag'])
{
    echo "Vous n'etes pas connecter";
    return;
}

function distance($dist1, $dist2) {
    $dist1 = explode(",", $dist1);
    $dist2 = explode(",", $dist2);
    $lat1 = $dist1[0];
    $lon1 = $dist1[1];
    $lat2 = $dist2[0];
    $lon2 = $dist2[1];
    if (($lat1 == $lat2) && ($lon1 == $lon2)) return 0;
    else {
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($lon1 - $lon2));
        $dist = rad2deg(acos($dist));
        $km = $dist * 60 * 1.1515;
        return ($km * 1.609344);
    }
}

function blockuser()
{
    include '../config/database.php';
    $blockeur = $_SESSION['flag'];
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT * FROM block WHERE blockeur='$blockeur'");
        $query->execute();
        $val = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            return -1;
        }
        $query->closeCursor();
        return ($val);
    } catch (PDOException $e) {
        $_SESSION['error'] = "ERROR: ".$e->getMessage();
        return -1;
    }
}

function getmatchs($val)
{
    include '../config/database.php';
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $query= $bdd->prepare("SELECT username,flag,prenom,nom,age,genre,interet,bio,tag,localisation,popularite FROM users WHERE verified='Y'");
        $query->execute();
        $val = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            $_SESSION['error'] = "ERROR: Aucun matchs de disponible";
            return (-1);
        }
        $query->closeCursor();
        return ($val);
    } catch (PDOException $e) {
        $_SESSION['error'] = "ERROR: ".$e->getMessage();
        return -1;
    }
}

function unsetmatchs($matchs, $val, $blocked, $sortby)
{
    foreach ($matchs as $key=>$tab)
    {
        $matchs[$key]['distance'] = distance($val['localisation'], $tab['localisation']);
        if ($tab['username'] == $val['username'])
            unset($matchs[$key]);
        else if ($tab['genre'] != $val['interet'] && $val['interet'] != 'Homme et Femme')
            unset($matchs[$key]);
        else if ($tab['genre'] == 'Non renseigne')
            unset($matchs[$key]);
        else if ($tab['interet'] != $val['genre'] && $tab['interet'] != 'Homme et Femme')
            unset($matchs[$key]);
        else if($blocked != -1)
        {
            foreach ($blocked as $keyblo=>$values)
            {
                if ($values['blocked'] == $tab['flag'])
                {
                    unset($matchs[$key]);
                    unset($blocked[$keyblo]);
                }
            }
        }
        foreach ($tab as $value)
        {
            if ($value == NULL || $value == "" )
                unset($matchs[$key]);
        }
    }
    $mytags = explode(",",$val['tag']);

    usort($matchs, function($a, $b) use ($mytags) {
        if ($a['distance'] == $b['distance']) {
            $counta = count(array_intersect($mytags, explode(",", $a['tag'])));
            $countb = count(array_intersect($mytags, explode(",", $b['tag'])));
            if ($counta == $countb)
            {
                if ($a['popularite'] == $b['popularite']) return (0);
                return ($a['popularite'] < $b['popularite']) ? 1 : -1;
            }
            return ($counta < $countb) ? 1 : -1;
        }
        return ($a['distance'] < $b['distance']) ? -1 : 1;
    });

    if ($sortby == 'age')
    {
        usort($matchs, function($a, $b){return($a['age'] - $b['age']);});
    }
    else if($sortby == 'distance')
    {
        usort($matchs, function($a, $b){return($a['distance'] - $b['distance']);});   
    }
    else if($sortby == 'popularite')
    {
        usort($matchs, function($a, $b){return($b['popularite'] - $a['popularite']);});   
    }
    else if($sortby == 'tags')
    {
        usort($matchs, function($a, $b) use ($mytags) {
            $counta = count(array_intersect($mytags, explode(",", $a['tag'])));
            $countb = count(array_intersect($mytags, explode(",", $b['tag'])));
            if ($counta == $countb) return (0);
            return ($counta < $countb) ? 1 : -1;
        });
    }
    return $matchs;
}
?>