<?php
include 'database.php';
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    //Delete user from the database
    $stmt = $conn->prepare("DELETE FROM USERS WHERE username = :username");

    $stmt->bindParam(':username', $username);

    $success = $stmt->execute();

    header('Location: /MEOWTTER/administrationPanel.php?message=' . ($success ? 'Usuario eliminado correctamente' : 'Ha ocurrido un error eliminando el usuario'));
    exit();
}
header('Location: /MEOWTTER/administrationPanel.php?message=Ha ocurrido un error inesperado.');
