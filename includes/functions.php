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

function fetchMeows($conn, $query, $params = null) {
    $meows = $conn->prepare($query);

    if($params){
        $meows->execute($params);
    }else{
        $meows->execute();
    }
    

    while ($meow = $meows->fetch(PDO::FETCH_ASSOC)) {
        echo showPost($meow['user'], $meow['content'], $meow['postHour']);
    }
}

function showPost($username, $content, $hour) {
    return '<div class="post">
        <p><strong>' . htmlspecialchars($username) . ':</strong> ' . htmlspecialchars($content) . '</p>
        <p><small>' . htmlspecialchars($hour) . '</small></p>
    </div>';
}

?>