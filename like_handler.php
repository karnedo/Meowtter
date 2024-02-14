<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['postId'];
    $username = $_POST['user'];

    // Check if there's a like for this user
    $likeQuery = "SELECT * FROM LIKES WHERE meow = :postId AND user = :username";
    $stmt = $conn->prepare($likeQuery);
    $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    
    // If there is, delete it
    if ($stmt->rowCount() > 0) {
        $query = 'DELETE FROM LIKES WHERE meow = :postId AND user = :username';
    } else { //If there isn't, insert it
        $query = 'INSERT INTO LIKES (meow, user) VALUES (:postId, :username)';
    }
    $statement = $conn->prepare($query);
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();

    $newLikeCountQuery = "SELECT COUNT(*) FROM LIKES WHERE meow = :postId";
    $newLikeCountStmt = $conn->prepare($newLikeCountQuery);
    $newLikeCountStmt->bindParam(':postId', $postId, PDO::PARAM_INT);
    $newLikeCountStmt->execute();
    $newLikeCount = $newLikeCountStmt->fetchColumn();

    // Devuelve el nuevo conteo de likes como parte de la respuesta
    echo $newLikeCount;
    
} else {
    http_response_code(400);
    echo 'Solicitud no válida';

    echo "error";
}
?>