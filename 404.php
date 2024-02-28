<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404</title>
</head>
<body>

    <h1>404!</h1>
    <p>La página a la que intentas acceder no existe... </p>
    <img src="img/sadCat404.gif" alt="Página no encontrada"></img>


</body>
</html>

<?php
    http_response_code(404);
    die();
?>