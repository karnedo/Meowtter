<?php
    session_start();

    require 'database.php';

    //Check if there's a logged user
    if(isset($_SESSION['username'])){
        $record = $conn->prepare('SELECT username, email, password, role FROM USERS WHERE username = :username');
        $record->bindParam(':username', $_SESSION['username']);
        $record->execute();
        $result = $record->fetch(PDO::FETCH_ASSOC);

        $user = null;

        if(count($result) > 0){
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

        <!--This, unlike "include", does not allow the website to be executed if it does not find the file-->
        <?php require 'includes/header.php' ?>

        <!-- If there's a user, show the feed. If not, give the option to log in or sign up -->
        <?php if(!empty($user)): ?>
            <br>Bienvenido, <?= $user['username'] ?>
            <br>Este debería de ser el feed</br>
            <?php
                switch($user['role']){
                    case "REGULAR":
                        echo "<br>Eres un usuario normal</br>";
                        break;
                    case "MOD":
                        echo "<br>Eres un moderador</br>";
                        break;
                    case "ADMIN":
                        echo "<br>Eres un administrador</br>";
                        break;
                }
            ?>
            <br>Tienes la sesión iniciada
            <a href="logout.php">Cerrar sesión</a>
        <?php else: ?>
            <h1>Login or Sign up</h1>

            <a href="login.php">Login</a> or
            <a href="signup.php">Sign up</a>
        <?php endif; ?>

    </body>
</html>