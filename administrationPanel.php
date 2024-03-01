<?php
    include 'includes/getUser.php';
    include 'includes/functions.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MEOWTTER</title>
    <link rel="stylesheet" href="assets/style/style.css">
    <link rel="stylesheet" href="assets/style/administrationStyle.css">
</head>
<body>
    <div class="container">
        <?php
            if($user['role'] != 'ADMIN'){
                echo "No tienes privilegios para acceder a esta página...";
            }else{
                echo "<div class=\"adminHeader\"><h2>PANEL DE ADMINISTRACIÓN</h2></div>";
                include 'includes/adminFunctions.php';
                
                if (isset($_GET['message'])) {
                    echo '<div class="confirmationMessage">' . $_GET['message'] . '</div>';
                }

                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                    switch ($page) {
                        case 'modify':
                                if(isset($_GET['username'])){
                                    showModifyUser($conn, $_GET['username']);
                                }else{
                                    echo "No ha especificado ningún usuario que modificar.";
                                }
                            break;
                        case 'meows':
                                if(isset($_GET['username'])){
                                    showMeowsTable($conn, $_GET['username']);
                                }else{
                                    echo "No ha especificado ningún usuario que modificar.";
                                }
                            break;
                        default:
                            usersTable($conn);
                            break;
                    }
                }else{
                    usersTable($conn);
                }
            }
        ?>
    </div>
    <?php require 'includes/footer.php' ?>
</body>
</html>