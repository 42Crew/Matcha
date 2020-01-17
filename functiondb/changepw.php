<?php
if (!$_POST['mail'])
{
    echo "Vous n'etes pas autoriser a acceder a cette page";
    exit();
}
  include '../config/database.php';

  $password = hash("whirlpool", $_POST['password']);
  $mail = strtolower($_POST['mail']);
  try {
          $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
          $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query= $bdd->prepare("SELECT id, username FROM users WHERE mail=:mail AND password=:password");
          $query->execute(array(':mail' => $mail, ':password' => $password));
          $val = $query->fetch();
          if ($val == null) {
            $_SESSION['error'] = "user not found";
            $query->closeCursor();
            header("Location: ../pages/changepass.php");
            return(-1);
          }
          $query->closeCursor();
          $newpassword = hash("whirlpool", $_POST['newpassword']);
          $query= $bdd->prepare("UPDATE users SET password=:password WHERE mail=:mail");
          $query->execute(array(':password' => $newpassword, ':mail' => $mail));
          $_SESSION['change_success'] = true;
          header("Location: ../pages/changepass.php");
          return (0);
      } catch (PDOException $e) {
          $_SESSION['error'] = "ERROR: ".$e->getMessage();
          header("Location: ../pages/changepass.php");
          return (-1);
      }
?>