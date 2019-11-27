<?php 
    session_start();

    if ($_SESSION['flag'] != NULL)
    {
        header("Location: ./match.php");
        exit();
    }
    include_once '../templates/header.php';
?>

<link rel='stylesheet' href='../css/login.css'/>

<div id='main'>
    <form action="../functiondb/connect.php" method="POST">
        <div class='someinput'>
            E-mail
            <br/>
            <input type="text" name="mail" value="" required>
        </div>
        <div class='someinput'>
            Mot de passe
            <br/>
            <input type="password" name="password" value="" required>
        </div>
        <!-- <a href="./lostpw.php"> Lost password ?</a> -->
        <input type="submit" id="login-button" name="submit" value="Log in">
    </form>
    <?php
        if (isset($_SESSION['error'])){
            echo $_SESSION['error'];
        $_SESSION['error'] = null;}
    ?>
</div>
<?php
include_once '../templates/bottom.php';
?>
