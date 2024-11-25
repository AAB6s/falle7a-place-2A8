<?php
require_once __DIR__ . '/../../Config.php';

$pdo = Config::getConnexion();

// Fetch user information (replace with actual logic if user data is dynamic)
$user = [
    'full_name' => 'John Doe',
    'phone_number' => '123456789',
    'delivery_address' => '123 Main Street'
];

// Fetch current orders from the database
$stmt = $pdo->prepare("SELECT o.product_id, o.quantity, p.name, p.price 
                       FROM orders o 
                       JOIN products p ON o.product_id = p.product_id");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = []; // Initialize an array to store validation errors

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Update user information (coming from the form)
        $user['full_name'] = $_POST['full_name'];
        $user['phone_number'] = $_POST['phone_number'];
        $user['delivery_address'] = $_POST['delivery_address'];

        // Validate inputs
        if (empty($user['full_name'])) {
            $errors['full_name'] = 'Full Name is required.';
        }
        
        if (empty($user['phone_number']) || !is_numeric($user['phone_number']) || strlen($user['phone_number']) < 8) {
            $errors['phone_number'] = 'Please enter a valid phone number (at least 8 digits).';
        }
        
        if (empty($user['delivery_address'])) {
            $errors['delivery_address'] = 'Delivery Address is required.';
        }

        // If no errors, proceed to insert the transaction
        if (empty($errors)) {
            // Prepare product details for insertion
            $productDetails = [];
            foreach ($orders as $order) {
                $productDetails[] = [
                    'product_id' => $order['product_id'],
                    'name' => $order['name'],
                    'price' => $order['price'],
                    'quantity' => $order['quantity'],
                ];
            }

            // Insert transaction into the database (status is 'in progress' by default)
            $status = 'in progress';  // Set initial status as 'in progress'
            $stmt = $pdo->prepare("
                INSERT INTO transaction 
                (full_name, phone_number, delivery_address, product_details, status) 
                VALUES 
                (:full_name, :phone_number, :delivery_address, :product_details, :status)
            ");
            $stmt->execute([
                ':full_name' => $user['full_name'],
                ':phone_number' => $user['phone_number'],
                ':delivery_address' => $user['delivery_address'],
                ':product_details' => json_encode($productDetails),
                ':status' => $status,
            ]);

            // Clear the orders table (only if necessary)
            $pdo->prepare("DELETE FROM orders")->execute();

            // Success message or redirect
            header("Location: transactions.php?status=success");
            exit;
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; margin: 20px;">
    <h1 style="color: #333; text-align: center;">Complete Your Transaction</h1>
    <form method="POST" style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9;">
        <div style="margin-bottom: 15px;">
            <label for="full_name" style="display: block; font-weight: bold; margin-bottom: 5px;">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php if (isset($errors['full_name'])): ?>
                <div class="error"><?php echo $errors['full_name']; ?></div>
            <?php endif; ?>
        </div>
        <div style="margin-bottom: 15px;">
            <label for="phone_number" style="display: block; font-weight: bold; margin-bottom: 5px;">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php if (isset($errors['phone_number'])): ?>
                <div class="error"><?php echo $errors['phone_number']; ?></div>
            <?php endif; ?>
        </div>
        <div style="margin-bottom: 15px;">
            <label for="delivery_address" style="display: block; font-weight: bold; margin-bottom: 5px;">Delivery Address</label>
            <textarea id="delivery_address" name="delivery_address" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"><?php echo htmlspecialchars($user['delivery_address']); ?></textarea>
            <?php if (isset($errors['delivery_address'])): ?>
                <div class="error"><?php echo $errors['delivery_address']; ?></div>
            <?php endif; ?>
        </div>
        <h2 style="color: #555;">Products in Cart</h2>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background-color: #f1f1f1;">
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Product Name</th>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: center;">Quantity</th>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: right;">Price (TND)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 10px;"><?php echo htmlspecialchars($order['name']); ?></td>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: center;"><?php echo $order['quantity']; ?></td>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: right;"><?php echo number_format($order['price']); ?> TND</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" style="width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">Complete Order</button>
    </form>
</body>
</html>
