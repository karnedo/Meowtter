<?php
function usersTable($conn){
    $query = "SELECT * FROM USERS";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    //Delete this
    echo '
        <style>
            img{
                width: 100px;
            }
        </style>
    ';

    echo
    "<table border=\"1\">
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Imagen</th>
            <th>Baneado</th>
            
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
            <td>' . ($bannedUntil < new DateTime() ? 'No' : $bannedUntil->format('Y-m-d')) . '</td>
            <td>
                <form action="administrationPanel.php">
                    <input type="hidden" id="page" name="page" value="modify">
                    <input type="hidden" id="username" name="username" value="' . $userRow['username'] . '">
                    <button type="submit">Modificar</button>
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

    

}
?>