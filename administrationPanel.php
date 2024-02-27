<?php
    include 'includes/getUser.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MEOWTTER</title>
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
    <div class="container">
        <?php
            if($user != 'ADMIN'){
                echo "No tienes privilegios para acceder a esta página...";
            }else{
                echo "Enhorabuena, tienes privilegios de administración.";
                include 'includes/adminFunctions.php';
                usersTable($conn);
            }
        ?>
    </div>
    <?php require 'includes/footer.php' ?>
</body>
</html>