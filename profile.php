<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require 'database.php';
include 'includes/functions.php';

    //Check if there's a logged user
if ( isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $record = $conn->prepare('SELECT username, email, password, role FROM USERS WHERE username = :username AND `password` = :password');
    $record->bindParam(':username', $_COOKIE['username']);
    $record->bindParam(':password', $_COOKIE['password']);
    $record->execute();
    $result = $record->fetch(PDO::FETCH_ASSOC);
    $user = null;

    if ($record && $result !== false && count($result) > 0) {
        $username = $result;
    }
    
    //Get username from index.php
    if(isset($_GET['user'])){
        $user = $_GET['user'];
    }
    
    //List of following users of your user and the followed user is $user 
    $postsQuery = $conn->prepare('SELECT `followed_user` FROM FOLLOWS WHERE following_user = :username and followed_user = :follow_user');
    $postsQuery->bindParam(':username', $username['username'] );
    $postsQuery->bindParam(':follow_user', $user);
    $postsQuery->execute();
    $followedUsers = $postsQuery->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html>

<head> 
    <meta charset="utf-8">
    <title>MEOWTTER</title>
    <link rel="stylesheet" href="assets/style/style.css">
</head>

<body>

    <!-- If there's a user, show the feed. If not, go to the login screen -->
    <?php if (!empty($user)) : ?>
        <div class="container">
            <!-- -->
            <a href="index.php">Feed</a>

            <h2><?= htmlspecialchars($user) ?></h2>
        
            <!-- If the obtained $user matches the $username, show the edit profile picture -->
            <?php if($_GET['user'] == $username['username']): ?>
                <form action="upload_profile_picture.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="username" name="username" value="<?= $username['username']?>" required>    
                <input type="file" id="picture" name="picture" accept=".jpg" required>
                    <input type="submit" value="Subir Imagen">
                </form>
                <!-- If not, show the button to unfollow the user  -->
            <?php else: ?>
                <form method="post" action="follow.php">
                    <input type="hidden" name="followingUser" value="<?=$username['username'];?>">
                    <input type="hidden" name="followedUser" value="<?=$user;?>">
                    <button type="submit">
                        <?php echo isFollowing($conn, $username['username'], $user) ? "Dejar de seguir" : "Seguir"; ?>
                    </button>
                </form>
            <?php endif;?>

            <div class="posts-section" id="posts-section">
                <h2>My Posts</h2>
                <!-- List of meows of your user -->
                <?php
                $postsQuery = 'SELECT M.`id` AS id, M.`content` AS content, M.`user` AS user, DATE_FORMAT(M.postTime, \'%H:%i\') AS postHour, COUNT(L.id) AS like_count
                            FROM MEOWS M LEFT JOIN LIKES L ON M.id = L.meow
                            WHERE M.user = :user
                            GROUP BY M.id, M.content, M.user, M.postTime
                            ORDER BY M.postTime DESC
                            LIMIT 25; ';
                fetchMeows($username['username'], $conn, $postsQuery, [':user' => $user]);
                ?>

            </div>
            <div class="following-section" id="following-section">
                <!-- List of following users of your user -->
                <h2>Following</h2>
                <?php
                    $postsQuery = $conn->prepare('SELECT `followed_user` FROM FOLLOWS WHERE following_user = :user');
                    $postsQuery->bindParam(':user', $user);
                    $postsQuery->execute();
                    while ($post = $postsQuery->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                    <div class="post">
                    <p><strong><a href="profile.php?user=<?= htmlspecialchars($post['followed_user'])?>"><?= htmlspecialchars($post['followed_user'])?></a>
                    </div>
                <?php
                }
                ?>

                <!-- List of followers of your user -->
                <h2>Followers</h2>
                <?php
                    $postsQuery = $conn->prepare('SELECT `following_user` FROM FOLLOWS WHERE followed_user = :user');
                    $postsQuery->bindParam(':user', $user);
                    $postsQuery->execute();
                    while ($post = $postsQuery->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                    <div class="post">
                        <p><strong><a href="profile.php?user=<?= htmlspecialchars($post['following_user'])?>"><?= htmlspecialchars($post['following_user'])?></a>
                    </div>
                <?php
                }
                ?>
            </div>

            <script>
                function toggleLike(postId, user) {
                    // Make an AJAX request to a PHP script that handles like/unlike
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            console.log(xhr.responseText);
                            // Update the like count in the DOM
                            document.getElementById('likeCount_' + postId).innerHTML = xhr.responseText;

                            // Get the current like button element
                            var likeButton = document.querySelector('#likeButton_' + postId);

                            // Toggle between 💖 and 💔
                            likeButton.innerText = (likeButton.innerText === '💖') ? '💔' : '💖';
                        }
                    };
                    xhr.open('POST', 'like_handler.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    // Combine data into a single call to send
                    var data = 'postId=' + postId + '&user=' + user;
                    xhr.send(data);
                }
            </script>

            <script src="./script/showFilters.js"></script>
        </div>
    <?php else : ?>
        <?php header('Location: /MEOWTTER/login.php'); ?>
    <?php endif; ?>

</body>

</html>