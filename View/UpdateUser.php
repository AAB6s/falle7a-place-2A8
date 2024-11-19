<?php
require_once '../controller/UserController.php';

// Instantiate the UserController
$userController = new UserController();

// Fetch users
$users = $userController->getUser();

// Handle the update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $updatedUser = new User($_POST['name'], $_POST['email'], $_POST['password'], $_POST['address']);
    $userController->updateUser($_POST['update_id'], $updatedUser);
    // Refresh the page after updating
    header('Location: userList.php'); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./styles/list.css">
    <title>Manage Users</title>
    <style>
        .form-input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
        }
        .btn-edit, .btn-delete {
            cursor: pointer;
        }
    </style>
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
                                    <th>Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr id="user-row-<?= $user['id'] ?>">
                                        <form method="POST">
                                            <td>
                                                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-input" />
                                            </td>
                                            <td>
                                                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-input" />
                                            </td>
                                            <td>
                                                <input type="text" name="password" value="<?= htmlspecialchars($user['password']) ?>" class="form-input" />
                                            </td>
                                            <td>
                                                <input type="text" name="address" value="<?= htmlspecialchars($user['adresse']) ?>" class="form-input" />
                                            </td>
                                            <td>
                                                <input type="hidden" name="update_id" value="<?= $user['id'] ?>" />
                                                <button type="submit" class="btn-circle btn-edit" aria-label="Update User">
                                                    <i class="fa fa-save"></i> 
                                                </button>
                                                <a href="DeleteUser.php?id=<?= $user['id'] ?>" class="btn-circle btn-delete ml-2" aria-label="Delete User">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </form>
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
