<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Employee Registration</title>
    <style>
        /* Base styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 1rem;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .approve-btn,
        .deny-btn {
            padding: 5px 10px;
            font-size: 0.9rem;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s;
        }

        .approve-btn {
            background-color: #28a745;
            color: white;
        }

        .approve-btn:hover {
            background-color: #218838;
        }

        .deny-btn {
            background-color: #dc3545;
            color: white;
        }

        .deny-btn:hover {
            background-color: #c82333;
        }

        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-top: 15px;
            border-radius: 4px;
            text-align: center;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        .employee-card {
            background-color: #f9f9f9;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .employee-info {
            display: flex;
            flex-direction: column;
        }

        .employee-info span {
            font-size: 1rem;
            color: #333;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

    </style>
</head>

<body>
    <div class="container">
        <h1>Employee Registration</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone:</label>
                <input type="text" id="telephone" name="telephone" required>
            </div>
            <button type="submit">Submit</button>
        </form>

        <?php if (!empty($message)): ?>
            <div class="alert"><?= htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <?php if (!empty($employees)): ?>
            <h3>List of All Employees:</h3>
            <ul>
                <?php foreach ($employees as $employee): ?>
                    <li class="employee-card">
                        <div class="employee-info">
                            <span><strong>Name:</strong> <?= htmlspecialchars($employee['nom']); ?></span>
                            <span><strong>Surname:</strong> <?= htmlspecialchars($employee['prenom']); ?></span>
                            <span><strong>Email:</strong> <?= htmlspecialchars($employee['email']); ?></span>
                            <span><strong>Telephone:</strong> <?= htmlspecialchars($employee['telephone']); ?></span>
                        </div>
                        <a 
                      class="approve-btn add-reservation-btn" 
                      href="../../front/template/add_reservation.php?employee_id=<?= htmlspecialchars($employee['id']) ?>">
                       Approved
                </a>

                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>

</html>
