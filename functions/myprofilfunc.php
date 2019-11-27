<?php
session_start();
if (!$_SESSION['flag'])
{
    echo "Vous n'etes pas connecter";
    return;
}
function get_profile_photo()
{
    include '../config/database.php';

    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT image FROM images WHERE flag=:flag AND profile='1'");
        $query->execute(array(':flag' => $_SESSION['flag']));
        $val = $query->fetch();
        if ($val == null) {
            echo "Vous n'avez pas de photo de profile";
            return (-1);
        }
        $query->closeCursor();
        $profilephoto = $val['image'];
        echo '<img height="180" width="180" src="'. $profilephoto .'" alt="" />';
        return (1);
    } catch (PDOException $e) {
        echo ($e->getMessage());
        return (-1);
    }
}

function get_galery_photos()
{
    include '../config/database.php';

    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT image FROM images WHERE flag=:flag AND profile='0'");
        $query->execute(array(':flag' => $_SESSION['flag']));
        $val = $query->fetchAll(PDO::FETCH_COLUMN, 0);
        if ($val == null) {
            echo "Vous n'avez pas de photos";
            return (-1);
        }
        $query->closeCursor();
        foreach ($val as $value)
        {
            echo '<img src="'. $value .'" alt="" />';
        }
        return (1);
    } catch (PDOException $e) {
        echo ($e->getMessage());
        return (-1);
    }
}
?>