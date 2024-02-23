<?php
    include 'includes/getUser.php';
    include 'includes/functions.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MEOWTTER</title>
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
    <div class="container">
        <?php include 'includes/userSection.php'; ?>
        <div class="posts-section" id="posts-section">
            <?php
                $section = "feed";
                if(isset($_GET['section'])){
                    $section = $_GET['section'];
                }
                switch($section){
                    case "feed":
                        $postsQuery = 'SELECT M.`id` AS id, M.`content` AS content, M.`user` AS user,
                                    DATE_FORMAT(M.postTime, \'%H:%i\') AS postHour, COUNT(L.id) AS like_count
                                FROM MEOWS M LEFT JOIN LIKES L ON M.id = L.meow
                                WHERE M.USER IN
                                    (SELECT DISTINCT(FOLLOWED_USER) FROM FOLLOWS WHERE FOLLOWING_USER = :user)
                                GROUP BY M.id, M.content, M.user, M.postTime
                                ORDER BY M.postTime DESC
                                LIMIT 25';
                        $params = [':user' => $_SESSION['username']];
                        break;
                    case "explore":
                        $postsQuery = 'SELECT M.`id` AS id, M.`content` AS content, M.`user` AS user,
                                    DATE_FORMAT(M.postTime, \'%H:%i\') AS postHour, COUNT(L.id) AS like_count
                                FROM MEOWS M LEFT JOIN LIKES L ON M.id = L.meow
                                GROUP BY M.id, M.content, M.user, M.postTime
                                ORDER BY M.postTime DESC
                                LIMIT 25';
                        $params = [];
                        break;
                    default:
                        header("Location: 404.php");
                        break;
                }
                echo '<h2>'.ucfirst($section).'</h2>';
            ?>    
        

            <!-- Post a new meow -->
            <form action="./upload_meow.php" method="get" onsubmit="return validateMeow();">
                <textarea id="content" name="content" placeholder="Maúlla al mundo lo que sientes..." required></textarea>
                <button type="submit">Publicar</button>
                <p id="errorMessage" style="color: red;"></p>
            </form>
            <script src="./script/validateMeow.js"></script>

            <!-- List of meows of your follows -->
            <?php
                fetchMeows($conn, $postsQuery, $params);
            ?>

        </div>

        <script src="./script/toggleLike.js"></script>
    </div>

    <?php require 'includes/footer.php' ?>
</body>
</html>