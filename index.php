<?php
session_start();

if (!$_SESSION['flag'])
{
    header("Location: ./pages/login.php");
    return;
}
else
{
    header("Location: ./pages/match.php");
    return;
}
?>