<?php
include 'database.php';
if (isset($_POST['id'])) {
    $meowId = $_POST['id'];

    //Delete user from the database
    $stmt = $conn->prepare("DELETE FROM MEOWS WHERE id = :meowId");

    $stmt->bindParam(':meowId', $meowId);

    $success = $stmt->execute();

    header('Location: /MEOWTTER/administrationPanel.php?message=' . ($success ? 'Meow eliminado correctamente' : 'Ha ocurrido un error eliminando el meow'));
    exit();
}
header('Location: /MEOWTTER/administrationPanel.php?message=Ha ocurrido un error inesperado.');
