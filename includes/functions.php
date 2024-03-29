<?php
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

    $targetDirectory = '../img/users/';

    if (!is_dir($targetDirectory)) {
        mkdir($targetDirectory, 0755, true);
    }

    if($extension != 'jpg'){
        $exitCode = 2;
    } else {
        $path = $targetDirectory . $username . '.' . $extension;
        if(move_uploaded_file($picture['tmp_name'], $path)){
            $exitCode = 0;
        }
    }
    
    return $exitCode;
}

// function to check if a user has liked a post
function hasUserLikedPost($conn, $username, $postId) {
    $query = "SELECT COUNT(*) FROM LIKES WHERE user = ? AND meow = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$username, $postId]);
    $likeCount = $stmt->fetchColumn();

    return $likeCount > 0;
}

function fetchMeows($conn, $query, $params = null) {
    $meows = $conn->prepare($query);

    if($params){
        $meows->execute($params);
    }else{
        $meows->execute();
    }

    echo '<div class="meows-list">';
    while ($meow = $meows->fetch(PDO::FETCH_ASSOC)) {
        $likedByUser = hasUserLikedPost($conn, $_SESSION['username'], $meow['id']);
        $likeEmoji = $likedByUser ? '💖' : '💔';

        echo '<div class="post">
            <div class="meow-header">'
                . getProfilePicture($meow['user']) . '
                <p><strong>
                    <a id="perfil" href="profile.php?user='.$meow['user'].'"><?= htmlspecialchars($meow[\'user\'])?>
                    </strong> ' . htmlspecialchars($meow['user']) . '</a>
                </p>
            </div>
            <div class="meow-content">
                <p id="text">' . htmlspecialchars($meow['content']) . '</p>
            </div>
            <div class="meow-like">    
                <p>
                    <small id="likeCount_' . $meow['id'] . '">' . $meow['like_count'] . '</small>
                    <button id="likeButton_'.$meow['id'].'" onclick="toggleLike(' . $meow['id'] . ', \'' . $_SESSION['username'] . '\')">' . $likeEmoji . '</button>
                    <p id="hora"><small>' . htmlspecialchars($meow['postHour']) . '</small></p>
                </p>
            </div>
        </div>';
    }
    echo '</div>';
}

function isFollowing($conn, $followingUser, $followedUser){
    $query = "SELECT COUNT(*) FROM FOLLOWS WHERE following_user = :followingUser AND followed_user = :followedUser";
    $stmt = $conn->prepare($query);
    $stmt->execute([':followingUser' => $followingUser, ':followedUser' => $followedUser]);
    $following = ($stmt->fetchColumn()) > 0;

    return $following;
}

function toggleFollow($conn, $followingUser, $followedUser){
    $following = isFollowing($conn, $followingUser, $followedUser);    

    if($following){
        $sql = "DELETE FROM FOLLOWS WHERE following_user = ? AND followed_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$followingUser, $followedUser]);
    }else{
        $sql = "INSERT INTO FOLLOWS VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$followingUser, $followedUser]);
    }
}

?>
