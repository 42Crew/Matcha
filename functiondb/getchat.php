<?php
session_start();
if (!$_POST['id'] || !$_SESSION['flag'])
{
    echo "Vous n'etes pas autoriser a acceder a cette page";
    exit();
}

include '../functions/chatfunc.php';

function getchat($id)
{
    include '../config/database.php';
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $bdd->prepare("SELECT * FROM chat_message WHERE chat_id=:chat_id ORDER BY `date` ASC");
        $query->execute(array(':chat_id' => $id));
        $val = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($val == null) {
            $query->closeCursor();
            return -1;
        }
        $query->closeCursor();
        return ($val);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}
$messages = getchat($_POST['id']);
$tab = [];
foreach($messages as $value)
{
    $user = getuserinfo_chat($value['flag'])['username'];
    $value['username'] = $user;
    array_push($tab, $value);
}

echo json_encode($tab);
?>