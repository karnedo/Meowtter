<?php
    session_start();

    require 'includes/database.php';

    // If there is a session go to the main page
    if(isset($_SESSION['username']) && isset($_SESSION['password'])){
        header('Location: /MEOWTTER');
        die();
    }

    //If there is no session, use the form
    if(!empty($_POST['email']) && !empty($_POST['password'])){
        $records = $conn->prepare('SELECT username, email, password FROM USERS WHERE email = :email');
        $records->bindParam(':email', $_POST['email']);
        $records->execute();
        $result = $records->fetch(PDO::FETCH_ASSOC);

        $message = '';

        // Set the session and cookies, and redirect to the main page
        if ($result != null && count($result) > 0 && password_verify($_POST['password'], $result['password'])) {
            //setcookie('password', $result['password'], time() + 604800, '/');
            $_SESSION["username"] = $result['username'];
            $_SESSION["password"] = $result["password"];
            header('Location: /MEOWTTER');
            die();
        } else {
            $message = 'Credenciales incorrectas.';
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
    <?php if(!empty($message)): ?>
    <p><?= $message ?></p>
    <?php endif; ?>
        <div class="container">
            <div class="top-section">
                <img src="img/logoSistemas1.png" alt="Logo de la página" class="logo">
                <div class="top-section-text">
                    <text>Inicia Sesión</text>
                    <text><span class="enlace"> o <a href="signup.php">Regístrate</a></span></text>
                </div>
            </div>
            <div  class="form-section">
                <form action="login.php" method="post">
                <input type="text" name="email" placeholder="Ingresa tu email" required/>
                <input type="password" name="password" placeholder="Ingresa tu contraseña" required/>
                <input type="submit" value="Enviar">
                </form>
            </div>
            
        </div>
    </body>
</html>
