<?php
session_start();

function getuserinfo_chat($flag)
{
    include '../config/database.php';
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT username,prenom,nom,age,genre,interet,bio,tag,localisation,popularite,flag FROM users WHERE flag=:flag AND verified='Y'");
        $query->execute(array(':flag' => $flag));
        $val = $query->fetch(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            return -1;
        }
        $query->closeCursor();
        return ($val);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}

function select_chat()
{
    include '../config/database.php';
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT * FROM chat_id WHERE user1=:user or user2=:user");
        $query->execute(array(':user' => $_SESSION['flag']));
        $val = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            return(-1);
        }
        $query->closeCursor();
        $tab = [];
        foreach ($val as $value)
        {
            if ($value['user1'] == $_SESSION['flag'])
                $newchat = getuserinfo_chat($value['user2']);
            else
                $newchat = getuserinfo_chat($value['user1']);
            $newchat['id'] = $value['id'];
            array_push($tab, $newchat);
        }
        return ($tab);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}

?>