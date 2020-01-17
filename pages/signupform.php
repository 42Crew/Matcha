<?php 
session_start();

if ($_SESSION['username'] != NULL)
{
    header("Location: ./match.php");
    return;
}
include '../templates/header.php';

?>

<script src='../javascript/getloca.js'></script>
<script src='../javascript/tags.js'></script>
<link rel="stylesheet" href="../css/style.css"/>
<link rel='stylesheet' href='../css/signupform.css'/>


<form action="../functiondb/signup.php" method= "POST">
    <input type="hidden" name="geoloc" value="">
    Email* : <input type="mail" name="email" value="" required>
    <br />
    Nom d'utilisateur* : <input type="text" name="username" value="" minlength=3  maxlength="30" required>
    <br />
    Prenom* : <input type="text" name="prenom" value="" minlength=2 required>
    <br />
    Nom* : <input type="text" name="nom" value="" minlength=2 required>
    <br />
    Mot de passe* : <input type="password" name="password" minlength=3 value="" required autocomplete>
    <br />
    <hr >
    Vous avez : <input type="number" name="age" min="18" max="100" value=""> ans
    <br />
    Vous etes :
    <select name="genre">
        <option value="" selected></option> 
        <option value="Homme">Homme</option>
        <option value="Femme">Femme</option>
    </select>
    <br />
    Interesser par :
    <select name="interet">
        <option value="" selected></option> 
        <option value="Homme">Homme</option>
        <option value="Femme">Femme</option>
        <option value="Homme et Femme">Homme et Femme</option>
    </select>
    <br />
    Biographie :
    <textarea style="resize: none;" rows="5" cols="40" maxlength="150" name="bio"></textarea>
    <br>
    Tags : <input type="hidden" name="tag" value="">
    <div id="tags">
        <input type="text" value="" placeholder="Ajouter des tags" />
    </div>
    <br />
    <input type="submit" name="submit" value="S'inscrire">

    <?php
    echo $_SESSION['error'];
    $_SESSION['error'] = null;
    if (isset($_SESSION['signup_success'])) {
        echo "Signup success please check your mail box";
        $_SESSION['signup_success'] = null;
    }
    ?>
</form>

<?php
include_once '../templates/bottom.php';
?>
