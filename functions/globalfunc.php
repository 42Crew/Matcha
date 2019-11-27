<?php

session_start();
if (!$_SESSION['flag'])
{
    echo "Vous n'etes pas connecter";
    return;
}
function getuserinfo()
{
    include '../config/database.php';
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT * FROM users WHERE flag=:flag AND verified='Y'");
        $query->execute(array(':flag' => $_SESSION['flag']));
        $val = $query->fetch(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            $_SESSION['error'] = "ERROR: Votre profile n'existe plus";
            session_destroy();
            return (-1);
        }
        $query->closeCursor();
        return ($val);
    } catch (PDOException $e) {
        $_SESSION['error'] = "ERROR: ".$e->getMessage();
        return -1;
    }
}

?>