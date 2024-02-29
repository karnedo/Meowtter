<?php
include 'includes/getUser.php';
include 'includes/functions.php';

if (isset($_GET['user'])) {
    $targetUser = $_GET['user']; //this users page
}else{
    //If no user is provided, use session's current user
    $targetUser = $user['username'];
}

//List of following users of your user and the followed user is $user 
$postsQuery = $conn->prepare('SELECT `followed_user` FROM FOLLOWS WHERE following_user = :username and followed_user = :follow_user');
$postsQuery->bindParam(':username', $user['username']);
$postsQuery->bindParam(':follow_user', $targetUser);
$postsQuery->execute();
$followedUsers = $postsQuery->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>MEOWTTER</title>
    <link rel="stylesheet" href="assets/style/style.css">
    <link rel="stylesheet" href="assets/style/meowStyle.css">
</head>

<body>

    <div class="container">
        <?php include 'includes/userSection.php'; ?>

        <div class="posts-section" id="posts-section">
            <div class="edit_user">
                 <h2><?= htmlspecialchars($targetUser) ?></h2>

                <?php echo '<span class="profile-picture">'.getProfilePicture($targetUser) .'</span>'?>

                <!-- If the obtained $user matches the $username, show the edit profile picture -->
                <?php if ($targetUser == $user['username']) : ?>
                    <form action="upload_profile_picture.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="username" name="username" value="<?= $user['username'] ?>" required>
                        <input type="file" id="picture" name="picture" accept=".jpg" required>
                        <input type="submit" value="Subir Imagen">
                    </form>
                    <!-- If not, show the button to unfollow the user  -->
                <?php else : ?>
                    <form method="post" action="follow.php">
                        <input type="hidden" name="followingUser" value="<?= $user['username']; ?>">
                        <input type="hidden" name="followedUser" value="<?= $targetUser; ?>">
                        <button type="submit">
                            <?php echo isFollowing($conn, $user['username'], $targetUser) ? "Dejar de seguir" : "Seguir"; ?>
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <h2>Meows</h2>
            <!-- List of meows of your user -->
            <div class="meows-list">
                <?php
                $postsQuery = 'SELECT M.`id` AS id, M.`content` AS content, M.`user` AS user, DATE_FORMAT(M.postTime, \'%H:%i\') AS postHour, COUNT(L.id) AS like_count
                                FROM MEOWS M LEFT JOIN LIKES L ON M.id = L.meow
                                WHERE M.user = :user
                                GROUP BY M.id, M.content, M.user, M.postTime
                                ORDER BY M.postTime DESC
                                LIMIT 25; ';
                fetchMeows($conn, $postsQuery, [':user' => $targetUser]);
                ?>
            </div>
        </div>

        <div class="follows-section" id="following-section">
            <!-- List of following users of your user -->
            <h2>Following</h2>
            <?php
            $postsQuery = $conn->prepare('SELECT `followed_user` FROM FOLLOWS WHERE following_user = :user');
            $postsQuery->bindParam(':user', $targetUser);
            $postsQuery->execute();
            while ($post = $postsQuery->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <div class="usuario">
                    <p><strong><a href="profile.php?user=<?= htmlspecialchars($post['followed_user']) ?>"><?= htmlspecialchars($post['followed_user']) ?></a>
                </div>
            <?php
            }
            ?>

            <!-- List of followers of your user -->
            <h2>Followers</h2>
            <?php
            $postsQuery = $conn->prepare('SELECT `following_user` FROM FOLLOWS WHERE followed_user = :user');
            $postsQuery->bindParam(':user', $targetUser);
            $postsQuery->execute();
            while ($post = $postsQuery->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <div class="usuario">
                    <p><strong><a href="profile.php?user=<?= htmlspecialchars($post['following_user']) ?>"><?= htmlspecialchars($post['following_user']) ?></a>
                </div>
            <?php
            }
            ?>
        </div>

        <script src="./script/toggleLike.js"></script>
    </div>

    <?php require 'includes/footer.php' ?>
</body>
</html>