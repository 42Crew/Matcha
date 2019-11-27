<?php
session_start();

if ($_POST['todel'] != NULL)
{
    include '../config/database.php';

    $id = $_POST['todel'];
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("DELETE FROM notifications WHERE id='$id'");
        $query->execute();
        $query->closeCursor();
        echo "1";
        exit();
    } catch (PDOException $e) {
        echo ($e->getMessage());
        exit();
    }
}
else if($_POST['getnotif'] != NULL)
{
    echo json_encode(getnotif());
}
else if($_POST['delall'] != NULL)
{
    include '../config/database.php';
    $flag = $_SESSION['flag'];

    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("DELETE FROM notifications WHERE flag='$flag'");
        $query->execute();
        $query->closeCursor();
        echo "1";
        exit();
    } catch (PDOException $e) {
        echo ($e->getMessage());
        exit();
    }
}

function sendnotification($flag, $type, $message)
{
    include '../config/database.php';
    $myname = $_SESSION['username'];
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("INSERT INTO notifications (flag, type, message, user) VALUES ('$flag', '$type', '$message', '$myname')");
        $query->execute();
        $query->closeCursor();
        return (1);
    } catch (PDOException $e) {
        return ($e->getMessage());
    }
}

function getnotif()
{
    $flag = $_SESSION['flag'];
    include '../config/database.php';

    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT * FROM notifications WHERE flag=:flag ORDER BY `date` ASC");
        $query->execute(array(':flag' => $flag));
        $val = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            exit();
        }
        $query->closeCursor();
        return ($val);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}

?>