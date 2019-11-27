<?php
session_start();
include_once '../config/database.php';

if (($_POST['profile'] != "0" && $_POST['profile'] != "1") || !$_FILES || !$_SESSION['flag'])
{
    echo "You don't have access to this page";
    exit();
}


try {
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $query= $bdd->prepare("SELECT COUNT(*) FROM images WHERE flag=:flag AND profile=:profile");
    $query->execute(array(':flag' => $_SESSION['flag'], ':profile' => $_POST['profile']));
    $number = $query->fetch()[0];
    if ($_POST['profile'] == '0')
    {
        if ($number >= 4) {
            $_SESSION['error'] = "Vous avez deja " . $number . " photos (max 4)";
            $query->closeCursor();
            header("Location: ../pages/myprofil.php");
            return(-1);
        }
    }
    else if ($_POST['profile'] == '1')
    {
        if ($number >= 1) {
            $get= $bdd->prepare("SELECT image FROM images WHERE flag=:flag AND profile=:profile");
            $get->execute(array(':flag' => $_SESSION['flag'], ':profile' => $_POST['profile']));
            $imgtodel = $get->fetch();
            $get->closeCursor();
            unlink($imgtodel['image']);
            $delete= $bdd->prepare("DELETE FROM images WHERE flag=:flag AND profile=:profile");
            $delete->execute(array(':flag' => $_SESSION['flag'], ':profile' => $_POST['profile']));
            $delete->closeCursor();
        }       
    }
    $query->closeCursor();
} catch (PDOException $e) {
    $_SESSION['error'] = "ERROR: ".$e->getMessage();
    header("Location: ../pages/myprofil.php");
    return(-1);
}

$repertoire = "../images/";
$nom = $repertoire . $_SESSION['flag'] . uniqid(rand(), true) . ".png";

if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false && $check["mime"] === "image/png") 
    {
        if ($_FILES["fileToUpload"]["size"] > 1000000) {
            $_SESSION['error'] = "Le fichier est trop volumineux";
            header("Location: ../pages/myprofil.php");
            return(-1);
        }
        if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $nom)) 
        {
            $_SESSION['error'] = "Le fichier n'a pas pu etre telecharger";
            header("Location: ../pages/myprofil.php");
            return(-1);
        }
    } 
    else
    {
        $_SESSION['error'] = "Le fichier n'est pas une image PNG";
        header("Location: ../pages/myprofil.php");
        return(-1);
    }
}
        try 
        {
            $bdd= new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query= $bdd->prepare("INSERT INTO images  (image, flag, profile) VALUES (:image, :flag, :profile)");
            $query->execute(array(':image' => $nom, ':flag' => $_SESSION['flag'], ':profile' => $_POST['profile']));
            header("Location: ../pages/myprofil.php");
            return (0);
        } 
        catch (PDOException $e) 
        {
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../pages/myprofil.php");
            return ($e->getMessage());
        }
?>