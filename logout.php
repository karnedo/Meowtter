<?php
    session_start();
    session_unset();
    session_destroy();

    header('Location: /MEOWTTER?page=login');
    die();
?>