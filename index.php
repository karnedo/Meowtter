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
            <div class="profile-section">
                <h2><?= $user['username'] ?></h2>

                <button onclick="showPosts()">Posts</button>
                <button onclick="showExplore()">Explore</button>
                <!-- -->
                <!-- User profile information -->
                <a href="profile.php?user=<?= htmlspecialchars($user['username'])?>"> Mi Perfil</a>
                <a href="logout.php">Cerrar sesión</a>
            </div>
            <div class="posts-section" id="posts-section">
                <h2>Feed</h2>

                <!-- Post a new meow -->
                <form action="./upload_meow.php" method="get" onsubmit="return validateMeow();">
                    <textarea id="content" name="content" placeholder="Maúlla al mundo lo que sientes..." required></textarea>
                    <button type="submit">Publicar</button>
                    <p id="errorMessage" style="color: red;"></p>
                </form>

                <script src="./script/validateMeow.js"></script>

                <!-- List of meows of your follows -->
                <?php
                $postsQuery = $conn->prepare('SELECT `user`, `content`, DATE_FORMAT(postTime, \'%H:%i\') AS postHour FROM MEOWS
                                                    WHERE USER IN
                                                        (SELECT DISTINCT(FOLLOWED_USER) FROM FOLLOWS WHERE FOLLOWING_USER = :user)
                                                    ORDER BY postTime DESC
                                                    LIMIT 25');
                $postsQuery->bindParam(':user', $user['username']);
                $postsQuery->execute();

                while ($post = $postsQuery->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <div class="post">
                        <p><strong><a href="profile.php?user=<?= htmlspecialchars($post['user'])?>"><?= htmlspecialchars($post['user'])?></a>:</strong> <?= htmlspecialchars($post['content']) ?></p>
                        <p><small><?= htmlspecialchars($post['postHour']) ?></small></p>
                    </div>
                <?php
                }
                ?>

            </div>
            <div class="explore-section" id="explore-section" style="display: none;">
                <h2>Explore</h2>

                <!-- List of all meows -->
                <?php
                $postsQuery = $conn->prepare('SELECT `user`, `content`, DATE_FORMAT(postTime, \'%H:%i\') AS postHour FROM MEOWS
                                                    ORDER BY postTime DESC
                                                    LIMIT 25');
                $postsQuery->execute();

                while ($post = $postsQuery->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <div class="post">
                        <p><strong><a href="profile.php?user=<?= htmlspecialchars($post['user'])?>"><?= htmlspecialchars($post['user'])?></a>:</strong> <?= htmlspecialchars($post['content']) ?></p>
                        <p><small><?= htmlspecialchars($post['postHour']) ?></small></p>
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