<?php
session_start();
include '../functiondb/notification.php';
?>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<script src='../javascript/notification.js'></script>
<script src='../javascript/header.js'></script>

<link rel='stylesheet' href='../css/header.css'/>

<div class="header"> 
    <a href="./match.php" class="list-nav logo">Matcha</a>
    <div class="header-right">
        <?php if (!$_SESSION['flag']):?>
            <a href="./login.php" class='list-nav'>Connexion</a>
            <a href="./signupform.php" class='list-nav'>Creer un compte</a>
        <?php else:?>
            <a href="./myprofil.php" class='list-nav'>Mon Profil</a>
            <a href="./logout.php" class='list-nav'>Déconnexion</a>
            <div class='list-nav notif'>Notifications</div>
        <?php endif;?>
    </div>
</div>
<div id='shownotif'>
    <div id='divreadall'>
        <button id='readall'>Tout supprimer</button>
    </div>
    <div class='notification'>
    </div>
</div>