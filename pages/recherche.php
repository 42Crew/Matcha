<?php
session_start();

if (!$_SESSION['flag'])
{
    header("Location: ./login.php");
    return;
}

include '../functiondb/updateactivity.php';
include '../functions/matchfunc.php';
include '../functions/globalfunc.php';
include_once '../templates/header.php';

$val = getuserinfo();
if (!isset($_SESSION['error']))
    $matchs = getmatchs($val);
if (!isset($_SESSION['error']))
    $blocked = blockuser();

if (isset($_SESSION['error']))
{
    echo $_SESSION['error'];
    $_SESSION['error'] = null;
    return;
}

foreach ($val as $key=>$value)
{
    if ($value == NULL || $value == "" || $val['genre'] == 'Non renseigne')
    {
        echo "Votre profil n'est pas complet, merci d'y remedier ici : <a href='./myprofil.php'>Mon profil</a>";
        return;
    }
}

$matchs = unsetmatchs($matchs, $val, $blocked, $_GET['sortby']);

if (count($matchs) <= 0)
{
    echo "Il n'y a plus de matchs disponible";
    return;   
}
?>

<head>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src='../javascript/sliders.js'></script>
  <link rel='stylesheet' href='../css/match.css'/>
</head>

<body>
<div id='gestion'>
    <form id='tri' class='onefiltre' action="./match.php" method="get">
        Trier par: 
        <select name="sortby" required>
            <option value="age" selected>Age</option>
            <option value="distance">Distance</option> 
            <option value="popularite">Popularite</option>
            <option value="tags">Tags en commun</option>
        </select>
    <input type="submit" value="Submit">
    </form>

    <div id='filtres'>
        <div class='onefiltre'>
            <label>Ages des matchs:</label>
            <input type="text" id="age" readonly style="border:0; color:#f6931f; font-weight:bold;" value="18 ans - 100 ans">
            <input type='hidden' id='agevalues' value='18,100'>
            <div id="slider-age"></div>
        </div>

        <div class='onefiltre'>
            <label>Distance:</label>
            <input type='hidden' name='maxdistance' value='<?php echo round(end($matchs)['distance']);?>'>
            <input type='hidden' id='locavalues' value='0,<?php echo round(end($matchs)['distance']);?>'>
            <input type="text" id="localisation" readonly style="border:0; color:#f6931f; font-weight:bold;" value="0 km - <?php echo round(end($matchs)['distance']);?> km">
            <div id="slider-localisation"></div>
        </div>

        <div class='onefiltre'>
            <label>Popularite:</label>
            <input type='hidden' name='popularite' value='<?php echo max($matchs)['popularite'] ;?>'>
            <input type='hidden' id='popvalues' value='0,<?php echo max($matchs)['popularite'] ;?>'>
            <input type="text" id="popularite" readonly style="border:0; color:#f6931f; font-weight:bold;" value="0 points - <?php echo max($matchs)['popularite'];?> points">
            <div id="slider-popularite"></div>
        </div>

        
    </div>
</div>
<div id='gestion'>
    <label>Tags:</label>
    <?php
        $tags = explode(",", $val['tag']);
        array_pop($tags);
        foreach ($tags as $value) {
            echo '<span class="mytag">'. $value . '</span> , ';}?>
</div>

<div id='users'>
<?php 
foreach ($matchs as $tab){
    ?>
    <div class='user'>
        <input type='hidden' name='distance' value='<?php echo $tab['distance'];?>'>
        <input type='hidden' name='age' value='<?php echo $tab['age'];?>'>
        <input type='hidden' name='popularite' value='<?php echo $tab['popularite'];?>'>

        <div class='username'>Nom d'utilisateur: <a href="./profileuser.php?user=<?php echo $tab['username'];?>"><?php echo $tab['username'];?></a></div>
        <div class='distance'>Distance: <?php echo round($tab['distance']);?> kms</div>
        <div class='age'>Age: <?php echo $tab['age'];?> ans</div>
        <div class='popularite'>Popularite: <?php echo $tab['popularite'];?> points</div>
        <div class='genre'>Est: <?php echo $tab['genre'];?></div>
        <div class='interet'>Interesser par: <?php echo $tab['interet'];?></div>
        <div class='tags'>Tags:
        <?php
            $tags = explode(",", $tab['tag']);
            array_pop($tags);
            foreach ($tags as $value) {?>
                <span class="matchtag"><?php echo $value;?></span>,<?php
            }
        ?>
        </div>
    </div>
    <?php
}
?>
</div>
<?php
    include_once '../templates/bottom.php';
?>