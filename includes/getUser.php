<?php
session_set_cookie_params(36000,"/");
session_start();

require 'database.php';

//Check if there's a logged user //NOTE: THIS SECTION IS IRRELEVANT WITH SESSIONS, BUT IT WILL BE USED TO CHECK IF THE USER IS BANNED
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $record = $conn->prepare('SELECT username, email, password, role, coalesce(DATE(`bannedUntil`) > DATE(NOW()), 0) AS is_Banned
                                FROM USERS WHERE username = :username AND `password` = :password');
    $record->bindParam(':username', $_SESSION['username']);
    $record->bindParam(':password', $_SESSION['password']);
    $record->execute();
    $result = $record->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if ($record && $result !== false && count($result) > 0) {
        $user = $result;
        // If the user is banned, go back to login
        if($user['is_Banned'] !== null and $user['is_Banned'] == 1){
            header('Location: /MEOWTTER/logout.php');
        }
    }else{
        header('Location: /MEOWTTER/logout.php');
    }
}else{
    header('Location: /MEOWTTER/logout.php');
}

?>
