<?php
error_reporting(0);
include 'nav.php';
require('model.php');
$method = $_SERVER['REQUEST_METHOD'];
$dsn = 'mysql:host=localhost;dbname=cs_350';
$user = 'student';
$pass = 'CS350';
$db = new PDO($dsn,$user,$pass);

if($method == 'GET'){
    $page = $_GET['page'] ?? 'none';
    switch ($page){
        case 'home':
            include 'home.php';
            break;
        case 'newUser':
            include 'new_user.php';
            break;
        case 'login':
            include 'login.php';
            break;
        case 'logout':
            logout();
            break;
        case 'addCard':
            include 'addCard.php';
            break;
        case 'insertCard':
            $url = $_GET['url'];
            $name = $_GET['name'];
            insertCard($url, $name, $db);
            echo '<h1>Card Inserted</h1>';
            break;
        case 'read':
            include 'read.php';
            read($db);
            break;
        case 'deleteCard':
            $id = $_GET['id'];
            deleteCard($id, $db);
            echo '<h1>Card Deleted</h1>';
        case 'changePassword':
            include 'changePassword.php';
            break;
    }
}
else{
    $hidden = $_POST['hidden'];
    switch ($hidden){
        case 'newUser':
            $username = $_POST['username'];
            $password = $_POST['password'];
            createNewUser($db, $username, $password);
            break;
        case 'login':
            $username = $_POST['username'];
            $password = $_POST['password'];
            login($db, $username, $password);
            break;
        case 'addCard':
            echo '<h2>Click a Card to add it to your Collection</h2>';
            $keyword = $_POST['keyword'];
            addCard($keyword);
            break;
        case 'changePassword':
            $oldPass = $_POST['oldPass'];
            $newPass = $_POST['newPass'];
            $confirmNewPass = $_POST['confirmNewPass'];
            deletePassword($oldPass, $newPass, $confirmNewPass, $db);
            break;
    }
}