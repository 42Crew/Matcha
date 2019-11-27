<?php
session_start();
include_once '../config/database.php';
try {
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query= $bdd->prepare("DELETE FROM images WHERE image=:image AND flag=:flag");
    $query->execute(array(':image' => $_POST['image'], ':flag' => $_SESSION['flag']));
    $query->closeCursor();
    unlink($_POST['image']);
    } catch (PDOException $e) {
        echo ($e->getMessage());
}
?>