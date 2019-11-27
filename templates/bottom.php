<?php
    session_start();
    include '../functions/chatfunc.php';
    $val = select_chat();
?>


<script src='../javascript/chat.js'></script>


<link rel='stylesheet' href='../css/bottom.css'/>
<link rel='stylesheet' href='../css/chat.css'/>

<?php if($_SESSION['flag']): ?>

    <div id='mychat'>
        <div id="available-chats"></div>

        <div id='chat' style="display:none;">
        <br />
        <input type='hidden' name='id' value=''>
        <input type='hidden' name='flag' value=''>
        Envoyer un message :
        <textarea style="resize: none;" rows="5" cols="40" maxlength="250" name="message"></textarea>
        <button id='envoyer'>Envoyer</button>
        <p id='error'></p>
        <button id='retour'>Retour</button>

        </div>
    </div>

    <div id='bottom'><div id='bottombutton'>Chat Instantanne</div></div>
<?php else:?>
    <div id='bottom'></div>
<?php endif;?>
