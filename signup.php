<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    require 'database.php';

    $message = '';

    if (!empty($_POST['email']) &&
        !empty($_POST['password']) &&
        !empty($_POST['username']) &&
        !empty($_POST['confirm_password'])
    ){
        if($_POST['password'] !== $_POST['confirm_password']){
            $message = 'Las contraseñas no coinciden.';
        }else{
            $sql = "INSERT INTO USERS (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $_POST['username']);
            $stmt->bindParam(':email', $_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password);
    
            try{
                if($stmt->execute()){
                    $message = 'Has sido registrado con éxito';
                }else{
                    echo implode(' ', $stmt->errorInfo());
                    $message = 'No ha sido posible el registro';
                }
            }catch (PDOException $e){
                //23000: Unique constraint violation
                if ($e->getCode() == '23000') {
                    $message = 'El nombre de usuario o el correo electrónico ya están registrados.';
                } else {
                    $message = 'Ha ocurrido un error inesperado registrando el usuario.';
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
        <title>MEOWTTER</title>
        <link rel="stylesheet" href="assets/style/style.css">
    </head>
    <body>
        <?php require 'includes/header.php' ?>

        <?php if(!empty($message)): ?>
            <p> <?= $message ?></p>
        <?php endif; ?>

        <h1>Registro</h1>
        <span>o <a href="login.php">inicia sesión</a></span>
        
        <form action="signup.php" method="post">
            <input type="text" name="username" placeholder="Ingresa tu nombre de usuario">
            <input type="text" name="email" placeholder="Ingresa tu email">
            <input type="password" name="password" placeholder="Ingresa tu contraseña">
            <input type="password" name="confirm_password" placeholder="Confirma tu contraseña">
            <input type="submit" value="Send">
        </form>
    </body>
</html>