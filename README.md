# MEOWTTER

Bienvenido a Meowtter, una plataforma social divertida y amigable donde los usuarios comparten sus pensamientos a través de Meows, pequeñas historias del día a día de no más de un par de frases.

### Presentación
[![Video de presentación](https://i.imgur.com/1WADGta.png)](https://youtu.be/_NWJ9TxkT_Q?si=9lcVKkGSDj-TDCVL)

### Características

- **Meows:** Comparte con tus amigos tus pequeñas historias del día a día.
- **Seguidores:** Sigue a tus amigos para ver sus meows y no perderte nada de lo que publican.
- **Likes:** Te ha gustado un meow? Puedes darle un "me gusta" y sacarle una sonrisa a su dueño.
- **Seguridad:** Nos comprometemos a darte una experiencia amena y segura, evitando a usuarios y contenidos que puedan resultar agresivos.

### Instalación

> **_NOTA:_**  Es necesaria una instalación de XAMPP o LAMPP.

1. Clona el repositorio en tu servidor:
```bash
cd <ruta_a_xampp>/htdocs
git clone https://github.com/karnedo/Meowtter.git
```

2. Prepara la base de datos:
En PHPMyAdmin, importa el fichero que encontrarás en <ruta_a_xampp>/htdocs/Meowtter/database/MEOWTTER.sql

Para acceder al panel de administración es posible utilizar un usuario con correo meowtter@info.eu y contraseña MANAGER. Adicionalmente, se pueden añadir usuarios administradores poniendo en el campo "role" el texto "ADMIN".

3. Formulario de contacto:
Para que el formulario de contacto llegue correctamente al correo electrónico empresarial, será necesario seguir estos pasos:
- Debemos acceder al archivo php.ini que se ecuentra en la carpeta .../xampp/php/php.ini.
- Dentro de este archivo buscaremos el apartado [mail function] y en él cambiaremos el valor de SMTP y smtp_port. Donde pondremos los siguientes valores: SMTP=smtp.gmail.com | smtp_port=587
- En el mismo, debajo de los valores que acabamos de cmabiar aparecen sendmail_from y sendmail_path. Cambiaremos esos valores a los siguientes: sendmail_from = "correo gmail desde el que se envia" | sendmail_path= "C:\xampp\sendmail\sendmail.exe -t".
(Para encontrar la ruta por si fuera distinta, ir a la carpeta xampp, acceder a la carpeta sendmail, click derecho sobre la aplicación sendmail, propiedades, seguridad y copiamos la ruta que sale.)
- Ahora debemos ir a la carpeta sendmail, encontrar el archivo sendmail.ini y abrirlo.
- En el apartado [sendmail] debemos cambiar los valores de smtp_server, smtp_port, auth_username, auth_password a smtp_server=smtp.gmail.com | smtp_port=587 | auth_username= "mismo correo que sendmail_from".
- Para darle un valor a auth_password debemos acceder a nuestra cuenta de google > Seguridad > Cómo inicias sesión en Google > Verificación en dos pasos > Contraseñas de Aplicación, y ahí se generará una contraseña, la copiamos y la pegamos en auth_password. 
- Debemos reiniciar Apache y MySQL para que pueda funcionar y ya podremos enviar emails desde la pantalla de Contacto.
- Dentro del archivo contact.php en la variable $recipient escribiremos el mismo correo que hemos usado.
