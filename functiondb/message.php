<?php
session_start();
if (!$_POST['notif'] || !$_POST['message'] || !$_POST['id'] || !$_SESSION['flag'])
{
    echo "Vous n'etes pas autoriser a acceder a cette page";
    exit();
}

include '../config/database.php';
include './notification.php';

$id = intval($_POST['id']);
$flag = $_SESSION['flag'];
$message = $_POST['message'];

try {
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query= $bdd->prepare("INSERT INTO chat_message (chat_id, flag, message) VALUES ('$id', '$flag', '$message')");
    $query->execute();
    $query->closeCursor();
    $retour = sendnotification($_POST['notif'], "message", "Vous avez un nouveau message de " . $_SESSION['username']);
    if ($retour != 1)
        echo $retour;
    else
        echo "OK";
    return (1);
} catch (PDOException $e) {
    echo $e->getMessage();
    return (-1);
}

?>