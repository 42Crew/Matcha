<?php 
    session_start();
    include_once '../config/database.php';

    $mail = strtolower($_POST['email']);
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $_SESSION['error'] = null;

    if ($mail == "" || $mail == null || $username == "" || $username == null || $password == "" || $password == null || $nom == "" || $nom == null || $prenom == "" || $prenom == null) {
        $_SESSION['error'] = "You need to fill all fields";
        header("Location: ../pages/signupform.php");
        return;
    }
    if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "You need to enter a valid email";
        header("Location: ../pages/signupform.php");
        return;
    }
    if ($_POST['age'] == "")
        $_POST['age'] = null;
    if ($_POST['genre'] == "")
        $_POST['genre'] = "Non renseigne";
    if ($_POST['interet'] == "")
        $_POST['interet'] = "Homme et Femme";
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT id FROM users WHERE username=:username OR mail=:mail");
        $query->execute(array(':username' => $username, ':mail' => $mail));
        if ($val = $query->fetch()) {
            $_SESSION['error'] = "user already exist";
            $query->closeCursor();
            header("Location: ../pages/signupform.php");
            return(-1);
        }
        $query->closeCursor();
        $password = hash("whirlpool", $password);
        $query= $bdd->prepare("INSERT INTO users (username, mail, password, flag, nom, prenom, age, genre, interet, bio, tag, localisation) VALUES (:username, :mail, :password, :flag, :nom, :prenom, :age, :genre, :interet, :bio, :tag, :localisation)");
        $flag = uniqid(rand(), true);

        $query->execute(array(':username' => $username, ':mail' => $mail, ':password' => $password, 
        ':flag' => $flag, ':nom' => $nom, ':prenom' => $prenom,  ':age' => $_POST['age'], ':genre' => $_POST['genre'], 
        ':interet' => $_POST['interet'], ':bio' => $_POST['bio'], ':tag' => $_POST['tag'], ':localisation' => $_POST['geoloc']));


        $_SESSION['signup_success'] = true;
        header("Location: ../pages/signupform.php");
        return (0);
    } catch (PDOException $e) {
        $_SESSION['error'] = "ERROR: ".$e->getMessage();
    }
    header("Location: ../pages/signupform.php");
?>