<?php
session_start();

if (!$_POST['mail'])
{
    echo "Vous n'etes pas autoriser a acceder a cette page";
    exit();
}
  include '../config/database.php';
  include '../functiondb/mail.php';

$mail = strtolower($_POST['mail']);

  try {
      $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query= $bdd->prepare("SELECT id, username FROM users WHERE mail=:mail AND verified='Y'");
      $query->execute(array(':mail' => $mail));
      $val = $query->fetch();
      if ($val == null) {
          $query->closeCursor();
          header("Location: ../pages/changepass.php");
          return (-1);
      }
      $query->closeCursor();
      $password = uniqid('');
      $passEncrypt = hash("whirlpool", $password);
      $query= $bdd->prepare("UPDATE users SET password=:password WHERE mail=:mail");
      $query->execute(array(':password' => $passEncrypt, ':mail' => $mail));
      $query->closeCursor();
      send_forget_mail($mail, $val['username'], $password);
      $_SESSION['change_success'] = true;
      header("Location: ../pages/changepass.php");
      return (0);
    } catch (PDOException $e) {
      header("Location: ../pages/changepass.php");
      return ($e->getMessage());
    }

?>