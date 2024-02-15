<?php
define('UPLOAD_SUCCESS', 0);
define('UPLOAD_ERROR', 1);
define('INVALID_TYPE', 2);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["username"]) && isset($_FILES["picture"])) {
        $username = $_POST["username"];
        $picture = $_FILES["picture"];

        // Incluir la función uploadProfilePicture
        include 'includes/functions.php';

        // Llamar a la función y obtener el código de error
        $errorCode = uploadProfilePicture($username, $picture);

        // Mostrar el resultado según el código de error
        if ($errorCode === UPLOAD_SUCCESS) {
            echo "Imagen de perfil subida.\n";

            // Ir de vuelta a la pantalla de perfil
            header("Location: {$_SERVER['HTTP_REFERER']}");
        } elseif ($errorCode === UPLOAD_ERROR) {
            echo "Error al cargar la imagen.\n";
        } elseif ($errorCode === INVALID_TYPE) {
            echo "La imagen no es un archivo JPG.\n";
        } else {
            echo "Error desconocido: $errorCode\n";
        }
    } else {
        echo "Datos no proporcionados.\n";
    }
}
?>