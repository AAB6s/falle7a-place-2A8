<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employes_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer les employés
$sql = "SELECT id, nom, prenom, email, telephone, status FROM employes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
        echo "<td>" . htmlspecialchars($row['prenom']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['telephone']) . "</td>";
        echo "<td>";
        echo "<form method='post' action='update_status.php'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "<select name='status' onchange='this.form.submit();'>";
        echo "<option value='approved'" . ($row['status'] == 'approved' ? ' selected' : '') . ">Approved</option>";
        echo "<option value='denied'" . ($row['status'] == 'denied' ? ' selected' : '') . ">Denied</option>";
        echo "</select>";
        echo "</form>";
        echo "</td>";
        echo "<td>";
        echo "<form method='post' action='delete_employee.php'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "<button type='submit' class='btn btn-danger btn-sm'>Supprimer</button>";
        echo "</form>";
        echo "</td>";
        echo "<td>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8' class='text-center'>Aucun employé trouvé</td></tr>";
}

$conn->close();
?>