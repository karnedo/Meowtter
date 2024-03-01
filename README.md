# MEOWTTER

Bienvenido a Meowtter, una plataforma social divertida y amigable donde los usuarios comparten sus pensamientos a través de Meows, pequeñas historias del día a día de no más de un par de frases.

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