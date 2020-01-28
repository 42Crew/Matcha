<?php
session_start();
print_r($_POST);
if (!$_POST['age'] || !$_POST['geoloc'] || !$_POST['mail'] || !$_POST['prenom'] || !$_POST['nom'] || !$_POST['genre'] || !$_POST['interet'] || !$_SESSION['flag'])
{
    echo "You don't have access to this page";
    exit();
}
if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Adresse email invalide";
    header("Location: ../pages/myprofil.php");
    return;
}
    include_once '../config/database.php';
  
    $mail = htmlspecialchars($_POST['mail']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $age = htmlspecialchars($_POST['age']);
    $bio = htmlspecialchars($_POST['bio']);
    $tag = htmlspecialchars($_POST['tag']);
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT username, mail, prenom, nom, genre, interet, bio, tag FROM users WHERE flag=:flag");
        $query->execute(array(':flag' => $_SESSION['flag']));
        $val = $query->fetch();
        if ($val == null) {
            $_SESSION['error'] = "user not found";
            $query->closeCursor();
            header("Location: ../pages/myprofil.php");
            return(-1);
        }
        $query->closeCursor();
        print_r($val);
        $query= $bdd->prepare("UPDATE users SET mail=:mail, prenom=:prenom, nom=:nom, age=:age, genre=:genre, interet=:interet, bio=:bio, tag=:tag, localisation=:localisation WHERE flag=:flag");
        $query->execute(array(':mail' => $mail, ':prenom' => $prenom, 'nom' => $nom, 'age' => $age, 'genre' => $_POST['genre'], 
        'interet' => $_POST['interet'], 'bio' => $bio, 'tag' => $tag, 'localisation' => $_POST['geoloc'], 
        ':flag' => $_SESSION['flag']));
        $_SESSION['change_success'] = true;
        header("Location: ../pages/myprofil.php");
        return (0);
    } catch (PDOException $e) {
        $_SESSION['error'] = "ERROR: ".$e->getMessage();
    }
    header("Location: ../pages/myprofil.php");

?>