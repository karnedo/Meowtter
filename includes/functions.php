<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
function getProfilePicture($username) {
    $path = 'img/users/'.$username.'.jpg';
    if($username === null || $username === ''){
        $path = 'img/defaultProfileImage.jpg';
    }else{
        // If the profile picture does not exist, take the default one
        if(!file_exists($path)){
            $path = 'img/defaultProfileImage.jpg';
        }
    }

    return '<img src="'.$path.'">';
}

// returns 0 for success, 1 for error, 2 in case the picture is not jpg
function uploadProfilePicture($username, $picture){
    $exitCode = 1; 
    $extension = pathinfo($picture['name'], PATHINFO_EXTENSION);

    if($extension != 'jpg'){
        $exitCode = 2;
    }else{
        $path = 'img/users/'.$username.'.'.$extension;
        if(move_uploaded_file($picture['tmp_name'], $path)){
            $exitCode = 0;
        }
    }
    
    return $exitCode;
}

// function to check if the user has liked a post
function hasUserLikedPost($conn, $username, $postId) {
    $query = "SELECT COUNT(*) FROM LIKES WHERE user = ? AND meow = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$username, $postId]);
    $likeCount = $stmt->fetchColumn();

    return $likeCount > 0;
}

function fetchMeows($sessionUser, $conn, $query, $params = null) {
    $meows = $conn->prepare($query);

    if($params){
        $meows->execute($params);
    }else{
        $meows->execute();
    }

    while ($meow = $meows->fetch(PDO::FETCH_ASSOC)) {
        $likedByUser = hasUserLikedPost($conn, $sessionUser, $meow['id']);
        $likeEmoji = $likedByUser ? '💖' : '💔';
    
        echo '<div class="post">
            <p>' . getProfilePicture($meow['user']) . '</p>
            <p><strong>' . htmlspecialchars($meow['user']) . ':</strong> ' . htmlspecialchars($meow['content']) . '</p>
            <p><small id="likeCount_' . $meow['id'] . '">' . $meow['like_count'] . '</small>
            <button id="likeButton_'.$meow['id'].'" onclick="toggleLike(' . $meow['id'] . ', \'' . $sessionUser . '\')">' . $likeEmoji . '</button>
            <p><small>' . htmlspecialchars($meow['postHour']) . '</small></p>
        </div>';
    }
}

?>