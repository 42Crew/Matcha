<?php
session_start();
if (!$_SESSION['flag'])
{
    echo "Vous n'etes pas connecter";
    return;
}

function getuserinfo($username)
{
    include '../config/database.php';
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT username,prenom,nom,age,genre,interet,bio,tag,localisation,popularite,flag FROM users WHERE username=:username AND verified='Y'");
        $query->execute(array(':username' => $username));
        $val = $query->fetch(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            $_SESSION['error'] = "ERROR: Aucun matchs de disponible";
            return -1;
        }
        $query->closeCursor();
        return ($val);
    } catch (PDOException $e) {
        $_SESSION['error'] =  $e->getMessage();
        return -1;
    }
}

function getuserphoto($flag)
{
    include '../config/database.php';
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT image, profile FROM images WHERE flag=:flag");
        $query->execute(array(':flag' => $flag));
        $val = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            return -1;
        }
        $query->closeCursor();
        return ($val);
    } catch (PDOException $e) {
        $_SESSION['error'] =  $e->getMessage();
        return -1;
    }
}

function getlike($liked, $likeur)
{
    include '../config/database.php';
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT * FROM likes WHERE liked=:liked AND likeur=:likeur");
        $query->execute(array(':liked' => $liked, ':likeur' => $likeur));
        $val = $query->fetch(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            return ("Like");
        }
        $query->closeCursor();
        return ("Dislike");
    } catch (PDOException $e) {
        $_SESSION['error'] =  $e->getMessage();
        return -1;
    }
}

function updatehistorique($profil)
{
    include '../config/database.php';
    include_once '../functiondb/notification.php';

    try 
    {
        $bdd= new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("INSERT INTO historique  (profil, visiteur) VALUES (:profil, :visiteur)");
        $query->execute(array(':profil' => $profil, ':visiteur' => $_SESSION['flag']));
        sendnotification($profil, "visite", "Vous avez une visite de " . $_SESSION['username']);
        return (0);
    } 
    catch (PDOException $e)
    {
        $_SESSION['error'] =  $e->getMessage();
        return -1;
    }   
}
?>