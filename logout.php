<?php

    session_start();

    session_unset();

    session_destroy();

    setcookie('username', $result['username'], time() - 3600, '/'); 
    setcookie('password', $result['password'], time() - 3600, '/');

    header('Location: /MEOWTTER');

?>