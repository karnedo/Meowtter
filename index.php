<?php

require 'database.php';
include 'includes/functions.php';

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
    <!-- If there's a user, show the feed. If not, go to the login screen -->
    <?php if (!empty($user)) : ?>
        <div class="container">
            <div class="profile-section">
                <h2><?= $user['username'] ?></h2>

                <button onclick="showPosts()">Posts</button>
                <button onclick="showExplore()">Explore</button>

                <!-- User profile information -->
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
                $postsQuery = 'SELECT M.`id` AS id, M.`content` AS content, M.`user` AS user,
                                    DATE_FORMAT(M.postTime, \'%H:%i\') AS postHour, COUNT(L.id) AS like_count
                                FROM MEOWS M LEFT JOIN LIKES L ON M.id = L.meow
                                WHERE M.USER IN
                                    (SELECT DISTINCT(FOLLOWED_USER) FROM FOLLOWS WHERE FOLLOWING_USER = :user)
                                GROUP BY M.id, M.content, M.user, M.postTime
                                ORDER BY M.postTime DESC
                                LIMIT 25';

                fetchMeows($user['username'], $conn, $postsQuery, [':user' => $user['username']]);
                ?>

            </div>
            <div class="explore-section" id="explore-section" style="display: none;">
                <h2>Explore</h2>

                <!-- List of all meows -->
                <?php
                $postsQuery = 'SELECT M.`id` AS id, M.`content` AS content, M.`user` AS user,
                                    DATE_FORMAT(M.postTime, \'%H:%i\') AS postHour, COUNT(L.id) AS like_count
                                FROM MEOWS M LEFT JOIN LIKES L ON M.id = L.meow
                                GROUP BY M.id, M.content, M.user, M.postTime
                                ORDER BY M.postTime DESC
                                LIMIT 25';
                fetchMeows($user['username'], $conn, $postsQuery);
                ?>

            </div>

            <script src="./jquery-3.7.1.min.js"></script>

            <script src="./script/showFilters.js"></script>
        </div>
    <?php else : ?>
        <?php header('Location: /MEOWTTER/login.php'); ?>
    <?php endif; ?>

    <?php require 'includes/footer.php' ?>
</body>

</html>