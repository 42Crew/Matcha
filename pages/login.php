<?php 
    session_start();

    if ($_SESSION['flag'] != NULL)
    {
        header("Location: ./match.php");
        exit();
    }
    include '../templates/header.php';
?>

<link rel='stylesheet' href='../css/login.css'/>

<div id='main'>
    <form action="../functiondb/connect.php" method="POST">
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
        <input type="submit" id="login-button" name="submit" value="Log in">
    </form>
    <center><a class='resize1' href="./changepass.php" class='list-nav'>Mot de passe perdu ?</a></center>
    <?php
        if (isset($_SESSION['error'])){
            echo $_SESSION['error'];
        $_SESSION['error'] = null;}
    ?>
</div>
<?php
include_once '../templates/bottom.php';
?>
