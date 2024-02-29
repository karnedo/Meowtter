<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
    require 'includes/database.php';

    $message = '';
    
    if (!empty($_POST['email']) &&
        !empty($_POST['password']) &&
        !empty($_POST['username']) &&
        !empty($_POST['confirm_password'])
    ){
        if($_POST['password'] !== $_POST['confirm_password']){
            $message = 'Las contraseñas no coinciden.';
        }else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $message = 'Email inválido';
        }else{
            $sql = "INSERT INTO USERS (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $_POST['username']);
            $stmt->bindParam(':email', $_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password);
    
            try{
                if($stmt->execute()){
                    session_start();
                    $_SESSION["username"] = $_POST['username'];
                    $_SESSION["password"] = $password;
                    header('Location: /MEOWTTER');
                    die();
                }else{
                    echo implode(' ', $stmt->errorInfo());
                    $message = 'No ha sido posible el registro';
                }
            }catch (PDOException $e){
                //23000: Unique constraint violation
                if ($e->getCode() == '23000') {
                    $message = 'El nombre de usuario o el correo electrónico ya están registrados.';
                } else {
                    $message = 'Ha ocurrido un error inesperado registrando el usuario.'.$e;
                }
            }
        }
    }else{
        $message = 'Por favor, rellena todos los campos.';
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
        <meta name="HandheldFriendly" content="true">
        <title>MEOWTTER</title>
        <link rel="stylesheet" href="assets/style/styleLoginSignUp.css">
    </head>
    <body>
        <div class="container">
            <div class="top-section">
                <img src="img/logoSistemas1.png" alt="Logo de la página" class="logo">
                <div class="top-section-text">
                    <text class="principal">Registro</text>
                    <text><span class="enlace"> o <a href="login.php">inicia sesión</a></span></text>
                </div>
            </div>
            <div  class="form-section">
                <form action="signup.php" method="post">
                <input type="text" name="username" placeholder="Ingresa tu nombre de usuario">
                <input type="text" name="email" placeholder="Ingresa tu email">
                <input type="password" name="password" placeholder="Ingresa tu contraseña">
                <input type="password" name="confirm_password" placeholder="Confirma tu contraseña">
                    <?php if(!empty($message)): ?>
                    <p><?= $message ?></p>
                    <?php endif; ?>
                <input type="submit" value="Enviar">
                    
                </form>
            </div>
            
        </div>
    </body>
</html>
