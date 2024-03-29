<?php
    if (isset($_POST['email']) && isset($_POST['subject']) && $_POST['content']) {
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $content = $_POST['content'];

        // Mail to which the form is sent 
        $recipient = "contact@meowtter.com";

        $header = "From: $email\r\n";

        $content = 'Formulario de contacto recibido de: '.$email.' con mensaje: '.$_POST['content'];

        $success = mail($recipient, $subject, $content, $header);
        echo $success;
        if (!$success) {
            print_r(error_get_last()['message']);
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
    <meta name="HandheldFriendly" content="true">
    <title>MEOWTTER</title>
    <link rel="stylesheet" href="assets/style/styleContact.css">
</head>

<body>
    <div class="contenedorContacto">
        <div class="contactForm">
            <form action="/MEOWTTER/contact.php" method="post">
            <img src="img/logoSistemas1.png" alt="Logo de la página" class="logo">
                <input id="email" type="email" name="email" placeholder="Email" required="">
                <input id="subject" type="text" name="subject" placeholder="Asunto" required="">
                <textarea id="content" name="content" placeholder="Escribe aquí lo que nos quieras decir..." required=""></textarea>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
    <?php require 'includes/footer.php' ?>
</body>

</html>