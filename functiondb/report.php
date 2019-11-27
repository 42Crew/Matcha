<?php
session_start();
if (!$_POST['reported'] || !$_SESSION['flag'])
{
    echo "Vous n'etes pas autoriser a acceder a cette page";
    exit();
}

function reportuser($flag)
{
    include '../config/database.php';

    $reporteur = $_SESSION['flag'];
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT * FROM report WHERE reported='$flag' AND reporteur='$reporteur'");
        $query->execute();
        $val = $query->fetch(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            if ($_POST['get'] == "get")
            {
                echo"NO";
                return (-1);
            }
            $query= $bdd->prepare("INSERT INTO report (reported, reporteur) VALUES ('$flag', '$reporteur')");
            $query->execute();
            $query->closeCursor();
            return -1;
        }
        $query->closeCursor();
        if ($_POST['get'] == "get")
            echo "YES";
        return (1);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}
reportuser($_POST['reported']);
?>