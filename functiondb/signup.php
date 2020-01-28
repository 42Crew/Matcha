<?php 
    session_start();
    include_once '../config/database.php';
    include_once '../functiondb/mail.php';

    $mail = htmlspecialchars(strtolower($_POST['email']));
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $age = htmlspecialchars($_POST['age']);
    $bio = htmlspecialchars($_POST['bio']);
    $tag = htmlspecialchars($_POST['tag']);
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
    if ($age == "")
        $age = null;
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
        ':flag' => $flag, ':nom' => $nom, ':prenom' => $prenom,  ':age' => $age, ':genre' => $_POST['genre'], 
        ':interet' => $_POST['interet'], ':bio' => $bio, ':tag' => $_POST['tag'], ':localisation' => $_POST['geoloc']));

        $url = $_SERVER['HTTP_HOST'] . str_replace("/signup.php", "", $_SERVER['REQUEST_URI']);
        send_verification_email($mail, $username, $flag, $url);
        $_SESSION['signup_success'] = true;
        header("Location: ../pages/signupform.php");
        return (0);
    } catch (PDOException $e) {
        $_SESSION['error'] = "ERROR: ".$e->getMessage();
    }
    header("Location: ../pages/signupform.php");
?>