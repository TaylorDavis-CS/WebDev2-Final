<?php
session_start();
if(!isset($_SESSION['user_loggin_in'])){
    $_SESSION['user_loggin_in'] = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HW13</title>
    <style>
        body{background-color: lavender;}
        li {
            display: inline;
            font-size: medium;
            color: yellow;
            border: groove black 1px;
        }
        table, tr, td{
            border: groove teal 5px;
        }
    </style>
</head>
<body>
<ul>
    <li><a href="controller.php?page=home">Home</a></li>
    <?php if($_SESSION['user_loggin_in'] === true){ ?>
        <li><a href="controller.php?page=addCard"> Add a card </a></li>
        <li><a href="controller.php?page=read">View your collection</a></li>
        <li><a href="controller.php?page=logout"> Logout </a></li>
        <li><a href="controller.php?page=changePassword"> Change Password </a></li>
    <?php }else{ ?>
    <li><a href="controller.php?page=newUser"> Create New User </a></li>
    <li><a href="controller.php?page=login"> Login </a></li>
    <?php } ?>


</ul>

