<?php
session_start();
if (!$_POST['blocked'] || !$_SESSION['flag'])
{
    echo "Vous n'etes pas autoriser a acceder a cette page";
    exit();
}

function blockuser($flag)
{
    include '../config/database.php';
    $blockeur = $_SESSION['flag'];

    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT * FROM block WHERE blocked='$flag' AND blockeur='$blockeur'");
        $query->execute();
        $val = $query->fetch(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            if ($_POST['get'] == "get")
            {
                echo"NO";
                return -1;
            }
            $query= $bdd->prepare("INSERT INTO block (blocked, blockeur) VALUES ('$flag', '$blockeur')");
            $query->execute();
            $query->closeCursor();
            return -1;
        }
        $query->closeCursor();
        if ($_POST['get'] == "get")
        {
            echo"YES";
            return -1;
        }
        $query= $bdd->prepare("DELETE FROM block WHERE blocked='$flag' AND blockeur='$blockeur'");
        $query->execute();
        $query->closeCursor();
        return (1);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}
blockuser($_POST['blocked']);
?>