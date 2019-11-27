<?php
session_start();

function log_user($email, $password) {
  include_once '../config/database.php';
  try {
      $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query= $bdd->prepare("SELECT id, username, flag FROM users WHERE mail=:mail AND password=:password AND verified='Y'");
      $email = strtolower($email);
      $password = hash("whirlpool", $password);
      $query->execute(array(':mail' => $email, ':password' => $password));
      $val = $query->fetch();
      if ($val == null) {
          $query->closeCursor();
          return (-1);
      }
      $query->closeCursor();
      return ($val);
    } catch (PDOException $e) {
      $v['err'] = $e->getMessage();
      return ($v);
    }
}

$email = $_POST['mail'];
$password = $_POST['password'];

if (($val = log_user($email, $password)) == -1) 
{
  $_SESSION['error'] = "user not found";
  header("Location: ../pages/login.php");
} 
else if (isset($val['err'])) 
{
  $_SESSION['error'] = $val['err'];
  header("Location: ../pages/login.php");
} 
else 
{
  $_SESSION['id'] = $val['id'];
  $_SESSION['flag'] = $val['flag'];
  $_SESSION['username'] = $val['username'];
  header("Location: ../pages/match.php");
}
?>