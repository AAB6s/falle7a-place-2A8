<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employes_db";

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch approved employees
    $query = "SELECT * FROM employes WHERE status = 'approved'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $approvedEmployees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Employees</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .add-reservation-btn {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }
        .add-reservation-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Approved Employees</h1>

    <?php if (!empty($approvedEmployees)) : ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($approvedEmployees as $employee) : ?>
                    <tr>
                        <td><?= htmlspecialchars($employee['id']) ?></td>
                        <td><?= htmlspecialchars($employee['nom']) ?> <?= htmlspecialchars($employee['prenom']) ?></td>
                        <td><?= htmlspecialchars($employee['email']) ?></td>
                        <td><?= htmlspecialchars($employee['telephone']) ?></td>
                        <td><?= htmlspecialchars($employee['status']) ?></td>
                        <td>
                            <a 
                                class="add-reservation-btn" 
                                href="../../front/template/add_reservation.php?employee_id=<?= htmlspecialchars($employee['id']) ?>">
                                Add Reservation
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No approved employees found.</p>
    <?php endif; ?>
</body>
</html>
