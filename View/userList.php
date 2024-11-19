<?php
require_once '../controller/UserController.php';

// Instantiate the UserController
$userController = new UserController();

// Fetch users
$users = $userController->getUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./styles/list.css">
    <title>Manage Users</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title manage-users-title">Manage Users</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap user-table mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Adress</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $index => $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['name']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['password']) ?></td>
                                    <td><?= htmlspecialchars($user['adresse']) ?></td>
                                    <td>
                                        <a href="UpdateUser.php?id=<?= $user['id'] ?>" class="btn-circle btn-edit" aria-label="Edit User">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="DeleteUser.php?id= <?php echo $user['id'] ?>" class="btn-circle btn-delete ml-2" aria-label="Delete User">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
