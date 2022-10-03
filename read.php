<?php
if(!isset($_SESSION['user_loggin_in'])){
    $_SESSION['user_loggin_in'] = false;
}

if($_SESSION['user_loggin_in'] != true){
    echo '<h1>Please Log in</h1>';
}
else{

    ?>
    <h1>Here are your Cards!</h1>
    <?php
}