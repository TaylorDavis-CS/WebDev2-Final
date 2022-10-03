<?php
if(!isset($_SESSION['user_loggin_in'])){
    $_SESSION['user_loggin_in'] = false;
}

if($_SESSION['user_loggin_in'] != true){
    echo '<h1>Please Log in</h1>';
}
else{

    ?>
    <form action="controller.php" method="post">
        Old Password:     <input type="password" name="oldPass" required><br>
        New Password:     <input type="password" name="newPass" required><br>
        Confirm New Password:     <input type="password" name="confirmNewPass" required><br>
        <input type="hidden" name="hidden" value="changePassword">
        <input type="submit" value="Change Password">
    </form>

    <?php
}