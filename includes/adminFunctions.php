<?php
function usersTable($conn){
    $query = "SELECT * FROM USERS";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    echo
    "<table border=\"1\">
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Imagen</th>
            <th>Baneado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>";

    
    while($userRow = $stmt ->fetch(PDO::FETCH_ASSOC)){
        $bannedUntil = new DateTime($userRow['bannedUntil']);
        echo
        '<tr ' . ($userRow['role'] == "ADMIN" ? 'class="adminRow"' : '') . '>
            <td>' . $userRow['username'] . '</td>
            <td>' . $userRow['email'] . '</td>
            <td>' . getProfilePicture($userRow['username']) . '</td>
            <td>' . ($bannedUntil < new DateTime() ? ($userRow['role'] != "ADMIN" ? 'No' : 'No aplicable') : $bannedUntil->format('Y-m-d')) . '</td>
            <td>'.
                ($userRow['role'] != "ADMIN" ?
                '<form action=\"administrationPanel.php\">
                    <input type="hidden" id="page" name="page" value="modify">
                    <input type="hidden" id="username" name="username" value="' . $userRow['username'] . '">
                    <button type="submit">Modificar</button>
                </form>
                <form action="administrationPanel.php">
                    <input type="hidden" id="page" name="page" value="meows">
                    <input type="hidden" id="username" name="username" value="' . $userRow['username'] . '">
                    <button type="submit">Ver meows</button>
                </form>' : '')
            .'</td>
        </tr>';
    }
    
    echo "</tbody>
    </table>";
}

function showMeowsTable($conn, $username){
    $query = "SELECT * FROM MEOWS WHERE user = :user";
    $stmt = $conn->prepare($query);
    $stmt->execute([':user' => $username]);
    $stmt->execute();

    echo
    "<table border=\"1\">
    <thead>
        <tr>
            <th>Contenido</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th></th>
        </tr>
    </thead>
    <tbody>";

    
    while($meowRow = $stmt ->fetch(PDO::FETCH_ASSOC)){
        $date = new DateTime($meowRow['postTime']);
        echo
        '<tr>
            <td>' . $meowRow['content'] . '</td>
            <td>' . $date->format('Y-m-d') . '</td>
            <td>' . $date->format('H:i:s') . '</td>
            <td>
                <form action="includes/deleteMeow.php" method="POST">
                    <input type="hidden" id="id" name="id" value="' . $meowRow['id'] . '">
                    <button type="submit">Eliminar</button>
                </form>
            </th>
        </tr>';
    }
    
    echo "</tbody>
    </table>";
}

function showModifyUser($conn, $username){
    $query = "SELECT * FROM USERS WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $banDate = new DateTime($user['bannedUntil']);
    $minDate = new DateTime();
    $minDate->modify('+1 day');
    echo'
    <script>
        function confirmDelete() {
            var result = confirm("¿Está completamente seguro de que desea eliminar este usuario?");
            return result;
        }
    </script>
    <div class="userContainer">
        <form action="includes/modifyUser.php" method="post">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" value="'. $username .'" readonly><br>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="'. $user['email'] .'" required><br>

            <label for="bannedUntil">Baneado:</label>
            <input type="date" id="bannedUntil" min="' . $minDate->format('Y-m-d') . '" ' . ($banDate < new DateTime() ? '' : 'value="' . $banDate->format('Y-m-d') . '"') .' name="bannedUntil"><br>
        
            <label for="deleteImg">Eliminar foto de perfil </label>
            <input type="checkbox" id="deleteImg" name="deleteImg"><br>

            <input type="submit" value="Modificar">
        </form>
        <hr>
        <form class="deleteButton" action="includes/deleteUser.php" method="post" onsubmit="return confirmDelete()">
            <input type="hidden" id="username" name="username" value="'. $username .'">
            <input type="submit" value="Eliminar">
        </form>
    </div>';
}
?>