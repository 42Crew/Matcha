<?php
session_start();

if (!$_GET['user'] || !$_SESSION['flag'])
{
    header("Location: ./match.php");
    exit();
}

include_once '../templates/header.php';
include '../functiondb/updateactivity.php';
include '../functions/profileuserfunc.php';
include '../functions/matchfunc.php';

$val = getuserinfo($_GET['user']);
$myval = getuserinfo($_SESSION['username']);

if ($val == -1 || $myval == -1)
{
    $_SESSION['error'] = NULL;
    header("Location: ./match.php");
    exit();  
}
updatehistorique($val['flag']);
$photos = getuserphoto($val['flag']);
$online = get_activity($val['flag']);

// if ($val['flag'] == $_SESSION['flag'])
// {
//     header("Location: ./myprofil.php");
//     exit();  
// }



?>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<script src='../javascript/profileuser.js'></script>
<link rel='stylesheet' href='../css/style.css'/>
<link rel='stylesheet' href='../css/myprofil.css'/>

<div id='changeprofile'>
        <div id='vosinfos'>Profil de <?php echo $val['username'];?></div>
        <div class='align'>
            <?php if (round(abs(strtotime($online) - time()) / 60) < 5):?>
                L'utilisateur est connecter
            <?php else:?>
                Derniere connexion: <?php echo $online;?>
            <?php endif;?>
        </div>
        <div id='actions'>
            <?php if(getlike($_SESSION['flag'], $val['flag']) != "Like") echo "<br/><div class='align'>Cette personne vous a liker</div>";?>
            <?php if ($photos != -1):?>
                <input type='hidden' name='liked' value='<?php echo $val['flag'] ?>'>
                <button id='like' class='align'><?php echo getlike($val['flag'], $_SESSION['flag']);?></button>
            <?php endif;?>
            <button id='report' class='align'>Report</button>
            <button id='block' class='align'>Bloquer</button>
        </div>
        <div class='resize1'>Prenom : <?php echo $val['prenom'];?></div>
        <div class='resize1'>Nom : <?php echo $val['nom'];?></div>
        <div class='resize1'>Age : <?php echo $val['age'];?></div>
        <div class='resize1'>Est : <?php echo $val['genre'];?></div>
        <div class='resize1'>Recherche : <?php echo $val['interet'];?></div>
        <div class='resize1'>Biographie : <?php echo $val['bio'];?></div>
        <div class='resize1'>Tags : <input type='hidden' name='tag' value='<?php echo $val['tag'] ?>'>
            <div id='tags'><?php
                $tags = explode(",", $val['tag']);
                array_pop($tags);
                foreach ($tags as $value) {echo '<span class="tag">'. $value . '</span>';}?>
            </div>
        </div>
        <div class='resize1 clear'>Localisation : <?php echo round(distance($myval['localisation'],$val['localisation']));?> kms</div>
        <span class='resize1'>Popularite : </span><span class='resize1' id='pop'><?php echo $val['popularite'];?></span>
</div>

<div id='rightside'>
    <div>Photo de profil :</div>
    <?php foreach ($photos as $values){
            if ($values['profile'] == 1)
                echo '<img height=180 witdh=180 src="'. $values['image'] .'" alt="" />';
        }?>
    <br/>
    <div>Photos :</div>
    <div id='galerie'>
        <?php foreach ($photos as $values){
            if ($values['profile'] == 0)
            echo '<img src="'. $values['image'] .'" alt="" />';
        }?>
    </div>
</div>
<?php
    include_once '../templates/bottom.php';
?>
