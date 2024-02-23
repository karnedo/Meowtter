<?php
function usersTable($conn){
    $query = "SELECT * FROM USERS";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    echo '<table border="1">';
    echo '<thead>';
    echo '<tr>';

    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo '</tbody>';
    echo '</table>';


    echo
    "<table border=\"1\">
    <thead>
        <tr>
            <th>Usuario<th>
        </tr>
    </thead>
    <tbody>"
        .
    "</tbody>
    </table>";
}
?>

<tr>
      <th>Month</th>