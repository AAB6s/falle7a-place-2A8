<?php
require_once __DIR__ . '/../../Controller/OrderController.php';

$orderController = new OrderController();
$orders = $orderController->listOrders(); // Fetch updated orders from the database

if (isset($_GET['status']) && isset($_GET['message'])) {
    $status = htmlspecialchars($_GET['status']);
    $message = htmlspecialchars($_GET['message']);
    echo "<div class='alert alert-$status'>$message</div>";
}
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= htmlspecialchars($order['product_id']); ?></td>
            <td><?= htmlspecialchars($order['name']); ?></td>
            <td><?= htmlspecialchars($order['description']); ?></td>
            <td><?= htmlspecialchars($order['price']); ?></td>
            <td>
                <?= htmlspecialchars($order['quantity']); ?>
            </td>
            <td>
                <form method="POST" action="updateOrder.php" style="display: inline;">
                    <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
                    <input type="hidden" name="quantity" value="<?= $order['quantity']; ?>">
                    <button name="action" value="increment" class="btn btn-success btn-sm">+</button>
                    <button name="action" value="decrement" class="btn btn-warning btn-sm">-</button>
                </form>
                <form method="POST" action="deleteOrder.php" style="display: inline;">
                    <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
