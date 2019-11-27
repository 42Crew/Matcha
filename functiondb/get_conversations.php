<?php
    session_start();
    include '../functions/chatfunc.php';

    $tab = select_chat();
    echo json_encode($tab);
?>