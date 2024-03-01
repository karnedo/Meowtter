<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];

    switch ($page) {
        case 'login':
            header('Location: login.php'); //index.php?page=contact
            break;
        case 'contact':
            header('Location: contact.php');
            break;
        case 'explore':
            header("Location: home.php?section=explore");
            break;
        case 'feed':
            header("Location: home.php");
            break;
        case 'profile':
            header("Location: profile.php");
            break;
        case 'administrationPanel':
            header('Location: administrationPanel.php');
            break;
        default:
            header("Location: 404.php");
            break;
    }
} else {
    header('Location: home.php');
}
