<?php
require 'database.php';

    //Check if there's a logged user
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $record = $conn->prepare('SELECT username, email, password, role FROM USERS WHERE username = :username AND `password` = :password');
    $record->bindParam(':username', $_COOKIE['username']);
    $record->bindParam(':password', $_COOKIE['password']);
    $record->execute();
    $result = $record->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if ($record && $result !== false && count($result) > 0) {
        $user = $result;
    }
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
            <h2><?= $user['username'] ?></h2>
            
            <div>
                <button id="follow-section" onclick="followUser()">Follow </button>
                <button id="unfollow-section" style="display: none" onclick="unfollowUser()">Unfollow </button>
                <button id="admin-section" style="display: none" onclick="banUser()">Ban User</button>
                <button id="admin-section" style="display: none" onclick="doAdmin()">Hacer admin</button>
                

            <!-- User profile information -->
            <a href="logout.php">Cerrar sesión</a>
            <a href="index.php">Feed</a>
            
            <div class="posts-section" id="posts-section">
                <h2>My Posts</h2>
                <!-- List of meows of your user -->
                <?php
                $postsQuery = $conn->prepare('SELECT `user`, `content`, DATE_FORMAT(postTime, \'%H:%i\') AS postHour FROM MEOWS WHERE USER = :user');
                $postsQuery->bindParam(':user', $user['username']);
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
                    $postsQuery->bindParam(':user', $user['username']);
                    $postsQuery->execute();
                    while ($post = $postsQuery->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                    <div class="post">
                        <p><strong><?= htmlspecialchars($post['followed_user']) ?>
                    </div>
                <?php
                }
                ?>

                <!-- List of followes of your user -->
                <h2>Followers</h2>
                <?php
                    $postsQuery = $conn->prepare('SELECT `following_user` FROM FOLLOWS WHERE followed_user = :user');
                    $postsQuery->bindParam(':user', $user['username']);
                    $postsQuery->execute();
                    while ($post = $postsQuery->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                    <div class="post">
                        <p><strong><?= htmlspecialchars($post['following_user']) ?>
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