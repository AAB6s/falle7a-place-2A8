<?php
require_once __DIR__ . '/../../Config.php';

$pdo = Config::getConnexion();

// Set default status filter (show "in progress" by default)
$statusFilter = $_GET['status_filter'] ?? 'in progress';
$itemsPerPage = 10; // Transactions per page

// Get the current page from the URL (default is 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

try {
    // Fetch transaction history based on the selected status
    $stmt = $pdo->prepare("
        SELECT * 
        FROM transaction 
        WHERE status = :status 
        ORDER BY created_at DESC 
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':status', $statusFilter);
    $stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the total number of transactions for pagination
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM transaction WHERE status = :status");
    $stmt->bindValue(':status', $statusFilter);
    $stmt->execute();
    $totalTransactions = $stmt->fetchColumn();
    $totalPages = ceil($totalTransactions / $itemsPerPage);
} catch (Exception $e) {
    die("Error fetching transactions: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
            animation: fadeInPage 0.8s ease-out;
        }

        @keyframes fadeInPage {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        h1 {
            text-align: center;
            color: white;
            padding: 20px;
            background-color: #28a745;
            font-size: 2em;
            margin: 0;
        }

        .status-buttons {
            text-align: center;
            margin: 20px 0;
        }

        .status-buttons a {
            padding: 12px 25px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            margin: 0 10px;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
        }

        .status-buttons a:hover {
            background-color: #0056b3;
            transform: scale(1.05);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .status-buttons .active {
            background-color: #28a745;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            animation: fadeInContainer 0.8s ease-out;
        }

        @keyframes fadeInContainer {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .product-details {
            font-size: 14px;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 8px;
            margin-top: 5px;
        }

        .product-item {
            margin-bottom: 8px;
        }

        .product-item span {
            font-weight: bold;
        }

        .pagination {
            text-align: center;
            margin-top: 30px;
        }

        .pagination a {
            padding: 10px 20px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            margin: 0 5px;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }

        .pagination a:hover {
            background-color: #0056b3;
            transform: scale(1.05);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .no-transaction {
            text-align: center;
            color: #888;
            padding: 20px;
            font-size: 1.2em;
        }

    </style>
</head>
<body>

    <h1>Transaction History</h1>

    <!-- Filter buttons for status -->
    <div class="status-buttons">
        <a href="?status_filter=in progress&page=1" class="status-btn <?php echo ($statusFilter === 'in progress') ? 'active' : ''; ?>">In Progress</a>
        <a href="?status_filter=delivered&page=1" class="status-btn <?php echo ($statusFilter === 'delivered') ? 'active' : ''; ?>">Delivered</a>
        <a href="?status_filter=canceled&page=1" class="status-btn <?php echo ($statusFilter === 'canceled') ? 'active' : ''; ?>">Canceled</a>
    </div>

    <!-- Transaction Table -->
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Phone Number</th>
                    <th>Delivery Address</th>
                    <th>Product Details</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($transactions) > 0): ?>
                    <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?= htmlspecialchars($transaction['full_name']) ?></td>
                        <td><?= htmlspecialchars($transaction['phone_number']) ?></td>
                        <td><?= htmlspecialchars($transaction['delivery_address']) ?></td>
                        <td class="product-details">
                            <?php
                            $productDetails = json_decode($transaction['product_details'], true);
                            foreach ($productDetails as $item): ?>
                                <div class="product-item">
                                    <span>Product:</span> <?= htmlspecialchars($item['name']) ?><br>
                                    <span>Price:</span> <?= number_format($item['price']) ?> TND<br>
                                    <span>Quantity:</span> <?= htmlspecialchars($item['quantity']) ?>
                                </div>
                            <?php endforeach; ?>
                        </td>
                        <td><?= htmlspecialchars($transaction['status']) ?></td>
                        <td><?= htmlspecialchars($transaction['created_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="no-transaction">No transactions found for this status.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?status_filter=<?= $statusFilter ?>&page=<?= $page - 1 ?>">Previous</a>
        <?php endif; ?>
        
        Page <?= $page ?> of <?= $totalPages ?>
        
        <?php if ($page < $totalPages): ?>
            <a href="?status_filter=<?= $statusFilter ?>&page=<?= $page + 1 ?>">Next</a>
        <?php endif; ?>
    </div>

</body>
</html>
