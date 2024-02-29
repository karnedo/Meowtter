<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include 'database.php';
    if (isset($_POST['username']) && isset($_POST['email'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];

        //Delete its profile pictuire
        if(isset($_POST['deleteImg'])){
            $deleteImg = $_POST['deleteImg'];

            $path = '../img/users/'.$username.'.jpg';
            unlink($path);
        }
        
        //Update user in the database
        if(isset($_POST['bannedUntil'])){
            $bannedUntil = $_POST['bannedUntil'];
            
            $stmt = $conn->prepare("UPDATE USERS SET email = :email, bannedUntil = :bannedUntil WHERE username = :username");
            $stmt->bindParam(':bannedUntil', $bannedUntil);
        }else{
            $stmt = $conn->prepare("UPDATE USERS SET email = :email WHERE username = :username");
        }

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);

        $success = $stmt -> execute();

        header('Location: /MEOWTTER/administrationPanel.php?message='.($success ? 'Usuario actualizado correctamente' : 'Ha ocurrido un error actualizando el usuario'));
        exit();
    }
    header('Location: /MEOWTTER/administrationPanel.php?message=Ha ocurrido un error inesperado.');
?>