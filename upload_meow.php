<?php
require 'database.php';

if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_GET['content'])){
    $user = $_COOKIE['username'];
    $content = $_GET['content'];

    // Insert meow
    $insertPost = $conn->prepare('INSERT INTO MEOWS (user, content) VALUES (:user, :content)');
    $insertPost->bindParam(':user', $user);
    $insertPost->bindParam(':content', $content);
    $insertPost->execute();

    // Go back to feed
    header('Location: /MEOWTTER');
} else {
    // If there is no user or content, go back to the login screen
    header('Location: /MEOWTTER/login.php');
}
?>
