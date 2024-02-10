<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    session_start();

    //If there's a logged user, redirect to the main page
    if(isset($_SESSION['username'])){
        header('Location: /MEOWTTER');
    }

    require 'database.php';

    if(!empty($_POST['email']) && !empty($_POST['password'])){
        $records = $conn->prepare('SELECT username, email, password FROM USERS WHERE email = :email');
        $records->bindParam(':email', $_POST['email']);
        $records->execute();
        $result = $records->fetch(PDO::FETCH_ASSOC);

        $message = '';

        //Set the session and redirect to the main page
        if($result != null && count($result) > 0 && password_verify($_POST['password'], $result['password'])){
            $_SESSION['username'] = $result['username'];
            header('Location: /MEOWTTER');
        }else{
            $message = 'Credenciales incorrectas.';
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <link rel="stylesheet" href="assets/style/style.css">
    </head>
    <body>
        <?php require 'includes/header.php' ?>

        <?php if(!empty($message)): ?>
            <p><?= $message ?></p>
        <?php endif; ?>

        <h1>Inicia sesión</h1>
        <span>o <a href="signup.php">regístrate</a></span>
        
        <form action="login.php" method="post">
            <input type="text" name="email" placeholder="Ingresa tu email">
            <input type="password" name="password" placeholder="Ingresa tu contraseña">
            <input type="submit" value="Send">
        </form>
    </body>
</html>