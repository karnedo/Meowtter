<?php
require 'includes/database.php';
include 'includes/getUser.php';

if(isset($_GET['content'])){
    $username = $user['username'];
    $content = $_GET['content'];

    // Insert meow
    $insertPost = $conn->prepare('INSERT INTO MEOWS (user, content) VALUES (:user, :content)');
    $insertPost->bindParam(':user', $username);
    $insertPost->bindParam(':content', $content);
    $insertPost->execute();

    // Go back to feed
    header('Location: /MEOWTTER');
    die();
} else {
    // If there is no user or content, go back to the feed
    header('Location: /MEOWTTER');
    die();
}
?>
