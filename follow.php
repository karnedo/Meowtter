<?php
define('UPLOAD_SUCCESS', 0);
define('UPLOAD_ERROR', 1);
define('INVALID_TYPE', 2);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["followingUser"]) && isset($_POST["followedUser"])) {
        $followingUser = $_POST["followingUser"];
        $followedUser = $_POST["followedUser"];

        // Incluir la función toggleFollow
        include 'includes/functions.php';
        include 'database.php';

        toggleFollow($conn, $followingUser, $followedUser);

        // Ir de vuelta a la pantalla de perfil
        header("Location: {$_SERVER['HTTP_REFERER']}");

    } else {
        echo "Datos no proporcionados.\n";
    }
}
?>