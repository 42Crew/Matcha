<?php
session_start();

if (!$_SESSION['flag'])
{
    header("Location: ./login.php");
    return;
}

include '../functiondb/updateactivity.php';
include '../functions/myprofilfunc.php';
include '../functions/globalfunc.php';
include '../templates/header.php';

$val = getuserinfo();
?>

<script src='../javascript/tags.js'></script>
<script src='../javascript/myprofile.js'></script>
<script src='../javascript/getloca.js'></script>
<link rel='stylesheet' href='../css/style.css'/>
<link rel='stylesheet' href='../css/myprofil.css'/>


<div id='changeprofile'>
    <form action='../functiondb/changeprofile.php' method= 'POST'>
        <div id='vosinfos'>Vos informations</div>
        <div class='resize1'>Nom d'utilisateur : <?php echo $val['username'];?></div>
        <div class='resize1'>Adresse mail : <input type='mail' name='mail' value='<?php echo $val['mail'] ?>' required></div>
        <div class='resize1'>Prenom : <input type='text' name='prenom' value='<?php echo $val['prenom'] ?>' minlength=2 required></div>
        <div class='resize1'>Nom : <input type='text' name='nom' value='<?php echo $val['nom'] ?>' minlength=2 required></div>
        <div class='resize1'>Vous avez : <input type="number" name="age" min="18" max="100" value="<?php echo $val['age'] ?>"> ans</div>
        <div class='resize1'>Genre :
        <?php if ($val['genre'] == "Homme"): ?>
            <select name='genre'><option value='Homme' selected>Homme</option><option value='Femme'>Femme</option><option value='Non renseigne'>Non renseigne</option></select>
        <?php elseif ($val['genre'] == "Femme"): ?>
            <select name='genre'><option value='Homme'>Homme</option><option value='Femme' selected>Femme</option><option value='Non renseigne'>Non renseigne</option></select>
        <?php else: ?>
            <select name='genre'><option value='Homme'>Homme</option><option value='Femme'>Femme</option><option value='Non renseigne' selected>Non renseigne</option></select>
        <?php endif; ?></div>
        <div class='resize1'>Interesser par :
        <?php if ($val['interet'] == "Homme"): ?>
            <select name='interet'><option value='Homme' selected>Homme</option><option value='Femme'>Femme</option><option value='Homme et Femme'>Homme et Femme</option></select>
        <?php elseif ($val['interet'] == "Femme"): ?>
            <select name='interet'><option value='Homme'>Homme</option><option value='Femme' selected>Femme</option><option value='Homme et Femme'>Homme et Femme</option></select>
        <?php else: ?>
            <select name='interet'><option value='Homme'>Homme</option><option value='Femme'>Femme</option><option value='Homme et Femme' selected>Homme et Femme</option></select>
        <?php endif; ?></div>
        <div class='resize1'>Biographie : <textarea style='resize: none;' rows='5' cols='40' maxlength='150' name='bio'><?php echo $val['bio'] ?></textarea></div>
        <div class='resize1'>Tags : <input type='hidden' name='tag' value='<?php echo $val['tag'] ?>'>
            <div id='tags'>
                <?php
                    $tags = explode(",", $val['tag']);
                    array_pop($tags);
                    foreach ($tags as $value) {
                        echo '<span class="tag">'. $value . '</span>';
                    }
                ?>
                <input type='text' value='' placeholder='Ajouter des tags' />
            </div>
        </div>
        <div class='resize1 clear'>Localisation : <input type='text' name='geoloc' value='<?php echo $val['localisation'] ?>' readonly required>
        <button type="button" id="localisation">Actualiser</button></div>
        <div class='resize1'>
            <?php if (isset($_SESSION['error'])){
                echo $_SESSION['error'];
                $_SESSION['error'] = null;
                return;}
            ?>
            <?php
            if (isset($_SESSION['change_success'])) {
                echo "Vos informations ont bien ete modifies";
                $_SESSION['change_success'] = null;
            }
            ?>
        </div>
        <div class='resize1'><input type='submit' name='submit' value='Modifier mes informations'></div>
    </form>
</div>

<div id='rightside'>
    <div>Ma photo de profil :</div>
    <?php get_profile_photo(); ?>
    <form action="../functiondb/upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id='uploadprofile' accept=".png" class='hidden' required>
        <div id='uploadbutton'><label for="uploadprofile">Mes Fichiers</label></div>
        <input type='hidden' name='profile' value='1'>
        <input type="submit" value="Telecharger" name="submit" id='submitprofile' class='hidden' >
        <div id='uploadbutton'><label for="submitprofile">Telecharger</label></div>
    </form>
    <br/>
    <div>Mes photos :</div>
    <div id='galerie'><?php get_galery_photos();?></div>
    <div class="clear">
        <form action="../functiondb/upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id='uploadphoto' accept=".png" class='hidden' required>
            <div id='uploadbutton'><label for="uploadphoto">Mes Fichiers</label></div>
            <input type='hidden' name='profile' value='0'>
            <input type="submit" value="Telecharger" name="submit" id='submitphoto' class='hidden' >
            <div id='uploadbutton'><label for="submitphoto">Telecharger</label></div>
        </form>
    </div>
</div>

<?php
    include_once '../templates/bottom.php';
?>