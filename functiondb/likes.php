<?php
session_start();
include '../functions/profileuserfunc.php';

if (!$_POST['liked'] || !$_SESSION['flag'])
{
    echo "Vous n'etes pas autoriser a acceder a cette page";
    exit();
}
 
function likeperson($flag)
{
    include '../config/database.php';
    include './notification.php';

    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT * FROM likes WHERE liked=:liked AND likeur=:likeur");
        $query->execute(array(':liked' => $flag, ':likeur' => $_SESSION['flag']));
        $val = $query->fetch(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            $query= $bdd->prepare("INSERT INTO likes (liked, likeur) VALUES (:liked, :likeur)");
            $query->execute(array(':liked' => $flag, ':likeur' => $_SESSION['flag']));
            $query->closeCursor();

            $query= $bdd->prepare("UPDATE users SET popularite = popularite + 1 WHERE flag=:flag");
            $query->execute(array(':flag' => $flag));
            $query->closeCursor();

            if (getlike($_SESSION['flag'], $flag) == 'Dislike')
                sendnotification($flag, "like", $_SESSION['username'] . " vous a liker aussi !");
            else
                sendnotification($flag, "like", "Vous avez ete liker par " . $_SESSION['username']);
            return -1;
        }
        $query->closeCursor();
        $query= $bdd->prepare("DELETE FROM likes WHERE liked=:liked AND likeur=:likeur");
        $query->execute(array(':liked' => $flag, ':likeur' => $_SESSION['flag']));
        if (getlike($_SESSION['flag'], $flag) == 'Dislike')
            sendnotification($flag, "unlike", $_SESSION['username'] . " ne vous like plus");
        $query->closeCursor();

        $query= $bdd->prepare("UPDATE users SET popularite = popularite - 1 WHERE flag=:flag");
        $query->execute(array(':flag' => $flag));
        $query->closeCursor();

        return (1);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}

function create_chat($flag)
{
    include '../config/database.php';

    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT * FROM chat_id WHERE user1=:user1 AND user2=:user2");
        $query->execute(array(':user1' => $flag, ':user2' => $_SESSION['flag']));
        $val = $query->fetch(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            $query= $bdd->prepare("INSERT INTO chat_id (user1, user2) VALUES (:user1, :user2)");
            $query->execute(array(':user1' => $flag, ':user2' => $_SESSION['flag']));
            $query->closeCursor();
            return -1;
        }
        $query->closeCursor();
        return (1);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}

function delete_chat($flag)
{
    include '../config/database.php';

    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT * FROM chat_id WHERE user1=:user1 AND user2=:user2");
        $query->execute(array(':user1' => $flag, ':user2' => $_SESSION['flag']));
        $val = $query->fetch(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            $query= $bdd->prepare("DELETE FROM chat_id WHERE user1=:user1 AND user2=:user2");
            $query->execute(array(':user2' => $flag, ':user1' => $_SESSION['flag']));
            $query->closeCursor();
            return -1;
        }
        $query->closeCursor();
        $query= $bdd->prepare("DELETE FROM chat_id WHERE user1=:user1 AND user2=:user2");
        $query->execute(array(':user1' => $flag, ':user2' => $_SESSION['flag']));
        $query->closeCursor();
        return (1);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}

$like = likeperson($_POST['liked']);

if (getlike($_SESSION['flag'], $_POST['liked']) == 'Dislike' && $like == -1)
    create_chat($_POST['liked']);
else
    delete_chat($_POST['liked']);

?>