<?php
session_start();

if(!isset($_SESSION['user_loggin_in'])){
    $_SESSION['user_loggin_in'] = false;
}

function createNewUser($db, $username, $password)
{
    $password = password_hash($password,PASSWORD_DEFAULT);
    $insert = "INSERT INTO mtgUsers (username, password) VALUES (:username,:password)";
    $statement = $db->prepare($insert);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $statement->closeCursor();
}

function login($db, $username, $password){
    $query = "SELECT * FROM mtgUsers WHERE username='".$username."';";
    $statement = $db->prepare($query);
    $statement->execute();
    $users = $statement->fetchAll();
    if(count($users) == 1){
            if ($users[0][1] === $username) {
                $userPassword = $users[0][2];
                if(password_verify($password, $userPassword) === true) {
                    $_SESSION['user_loggin_in'] = true;
                    $_SESSION['userID'] = $users[0];
                    header("Location: controller.php?page=home");
                }
                else {
                    echo "<h1>Error: username or password did not match, please try again</h1>";
                }
            }
        $statement->closeCursor();
    }
    else{
        return false;
    }
    $statement->closeCursor();
}

function logout(){
    if($_SESSION['user_loggin_in'] !== true){
        echo 'Please Login';
    } else {
        session_unset();
        session_destroy();
        header("Location: controller.php");
    }
}

function addCard($keyword){
    $request = file_get_contents('https://api.magicthegathering.io/v1/cards?name='.$keyword);
    $response = json_decode($request, true);
    $cards = $response['cards'];
    echo '<table>';
    echo '<th>Card</th>';
    foreach ($cards as $card){
        echo '<tr>
                <td>
                    <img src="'. $card['imageUrl'] . '">
                </td>
                <td>
                    <a href="controller.php?page=insertCard&url='.$card['imageUrl'].'&name='.$card['name'].'">ADD TO COLLECTION</a>
                </td>
               </tr>';
    }
    echo '</table>';
}

function insertCard($url, $name, $db){
    $id= $_SESSION['userID']['id'];
    $query = "INSERT INTO mtgCards (name, url, ownerId) VALUES (:name,:url, :ownerId)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':url', $url);
    $statement->bindValue(':ownerId', $id);
    $statement->execute();
    $statement->closeCursor();
}

function read($db){
    $id= $_SESSION['userID']['id'];
    $query = "SELECT * FROM mtgCards WHERE ownerId='".$id."';";
    $statement = $db->prepare($query);
    $statement->execute();
    $cards = $statement->fetchAll();
    echo '<table>';
    echo '<th>Card</th>';
    foreach ($cards as $card){
        echo '<tr>
                <td>
                    <img src="'. $card['url'] . '&type=card">
                </td>
                <td>
                    <a href="controller.php?page=deleteCard&id='.$card['id'].'">DELETE FROM COLLECTION</a>
                </td>
               </tr>';
    }
    echo '</table>';
    $statement->closeCursor();
}

function deleteCard($id, $db){
    $delete = 'DELETE FROM mtgCards WHERE id='.$id;
    $statement = $db->prepare($delete);
    $statement->execute();
    $statement->closeCursor();
}

function deletePassword($oldPassword, $newPassword, $confirmNewPass, $db){
    $id= $_SESSION['userID']['id'];
    $query = "SELECT * FROM mtgUsers WHERE id='".$id."';";
    $statement = $db->prepare($query);
    $statement->execute();
    $users = $statement->fetchAll();
    if(count($users) == 1){
        if ($users[0][0] === $id) {
            $userPassword = $users[0][2];
            if(password_verify($oldPassword, $userPassword) == true) {
                if($newPassword == $confirmNewPass){
                    $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
                    $update = "UPDATE mtgUsers SET password='".$newHash."' WHERE id='".$id."';";
                    $updateStatement = $db->prepare($update);
                    $updateStatement->execute();
                    $updateStatement->closeCursor();
                    echo '<h1>Password Changed</h1>';
                }
            }
            else {
                echo "<h1>Error: username or password did not match, please try again</h1>";
            }
        }
        $statement->closeCursor();
    }
    else{
        return false;
    }
    $statement->closeCursor();
}
