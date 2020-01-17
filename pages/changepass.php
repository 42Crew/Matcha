<?php 
    session_start();

    include '../templates/header.php';
?>

<link rel='stylesheet' href='../css/login.css'/>

<div id='main'>
    <center>Reintialiser le mot de passe :</center>
    <form action="../functiondb/lostpw.php" method="POST">
        <div>
            E-mail
            <br/>
            <input type="text" name="mail" value="" required>
        </div>
        <input type="submit" id="login-button" name="submit" value="Reintialiser">
    </form>
    <center>Changer le mot de passe :</center>
    <form action="../functiondb/changepw.php" method="POST">
        <div>
            E-mail
            <br/>
            <input type="text" name="mail" value="" required>
        </div>
        <div>
            Mot de passe
            <br/>
            <input type="password" name="password" value="" required autocomplete>
        </div>
        <div>
            Nouveau Mot de passe
            <br/>
            <input type="password" name="newpassword" minlength=3 value="" required autocomplete>
        </div>
        <input type="submit" id="login-button" name="submit" value="Changer">
    </form>
    <?php
        if (isset($_SESSION['error'])){
            echo $_SESSION['error'];
        $_SESSION['error'] = null;}
        if (isset($_SESSION['change_success'])) {
            echo "Operation reussie !\n";
        $_SESSION['change_success'] = null;
        }
    ?>
</div>
<?php
include_once '../templates/bottom.php';
?>
