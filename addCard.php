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
    Enter Card Name Keyword:     <input type="text" name="keyword" required><br>
    <input type="hidden" name="hidden" value="addCard">
    <input type="submit" value="Search Cards">
</form>

<?php
}