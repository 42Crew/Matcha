<?php
session_start();

if (!$_SESSION['flag'])
{
    echo "You don't have access to this page";
    exit();
}

function update_activity()
{
    $DB_NAME = "matcha";
    $DB_DSN = "mysql:host=127.0.0.1:3306;dbname=".$DB_NAME;
    $DB_DSN_LIGHT = "mysql:host=127.0.0.1:3306".$DB_NAME;
    $DB_USER = "root";
    $DB_PASSWORD = "root";

    try 
    {
        date_default_timezone_set("Europe/Paris");
        $bdd= new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("UPDATE users SET last_activity=NOW() WHERE flag=:flag");
        $query->execute(array(':flag' => $_SESSION['flag']));
        return;
    } 
    catch (PDOException $e) 
    {
        echo "Erreur sur la mise a jour: " . $e->getMessage();
        return;
    }
}
update_activity();

function get_activity($flag)
{
    $DB_NAME = "matcha";
    $DB_DSN = "mysql:host=127.0.0.1:3306;dbname=".$DB_NAME;
    $DB_DSN_LIGHT = "mysql:host=127.0.0.1:3306".$DB_NAME;
    $DB_USER = "root";
    $DB_PASSWORD = "root";

    try 
    {
        date_default_timezone_set("Europe/Paris");
        $bdd= new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT last_activity from users WHERE flag=:flag");
        $query->execute(array(':flag' => $flag));
        $lasttime = $query->fetch()[0];
        return ($lasttime);
    } 
    catch (PDOException $e) 
    {
        echo "Erreur sur la mise a jour: " . $e->getMessage();
        return;
    }
}
?>