<?php
require 'database.php';

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
    <!-- This, unlike "include", does not allow the website to be executed if it does not find the file -->
    <?php require 'includes/header.php' ?>

    <!-- If there's a user, show the feed. If not, go to the login screen -->
    <?php if (!empty($user)) : ?>
        <div class="container">
        
            <h2><?= htmlspecialchars($user) ?></h2>
        
            <!-- If the obtained $user matches the $username, show the edit profile picture -->
            <?php if($_GET['user'] == $username['username']): ?>

                <form action="upload_profile_picture.php" method="post" enctype="multipart/form-data">
                    <label for="picture">Selecciona tu nueva foto (solo JPG)</label>
                    <input type="file" id="picture" name="picture" accept=".jpg" required>
                    <input type="submit" value="Subir Imagen">
                </form>
                <!-- If not, show the button to unfollow the user  -->
            <?php else: ?>
                <?php $buttonName = "follow";?>
                <input type="submit" value=" <?php echo $buttonName = "Unfollow"  ?>" />
            <?php endif;?>

            <div>
            <!-- If the obtained $username have ADMIN role, show Ban and Admin buttons -->
            <?php if($username['role'] == "ADMIN"): ?>
                <button id="admin-section" onclick="banUser()">Ban User</button>
                <button id="admin-section" onclick="doAdmin()">Hacer admin</button>
            <?php endif;?>

            <!-- User profile information -->
            <a href="logout.php">Cerrar sesión</a>
            <a href="index.php">Feed</a>
            
            <div class="posts-section" id="posts-section">
                <h2>My Posts</h2>
                <!-- List of meows of your user -->
                <?php
                $postsQuery = $conn->prepare('SELECT `user`, `content`, DATE_FORMAT(postTime, \'%H:%i\') AS postHour FROM MEOWS WHERE USER = :user');
                $postsQuery->bindParam(':user', $user);
                $postsQuery->execute();

                while ($post = $postsQuery->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <div class="post">
                        <p><strong><?= htmlspecialchars($post['user']) ?>:</strong> <?= htmlspecialchars($post['content']) ?></p>
                        <p><small><?= htmlspecialchars($post['postHour']) ?></small></p>
                    </div>
                <?php
                }
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
            <script src="./script/showFilters.js"></script>
        </div>
    <?php else : ?>
        <?php header('Location: /MEOWTTER/login.php'); ?>
    <?php endif; ?>

</body>

</html>