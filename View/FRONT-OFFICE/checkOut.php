<?php
require_once __DIR__ . '/../../Controller/OrderController.php';
require_once __DIR__ . '/../../Config.php';
require __DIR__ . '/../../vendor/autoload.php'; // For PHPMailer



// Set the Stripe secret key
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);


$pdo = Config::getConnexion();

$orderController = new OrderController();
$orders = $orderController->listOrders();

// Fetch user information (replace with actual logic if user data is dynamic)
$user = [
    'full_name' => 'John Doe',
    'phone_number' => '12345678',
    'delivery_address' => '123 Main Street'
];



$errors = []; // Initialize an array to store validation errors
$paymentError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentMethod = $_POST['payment_method'];
    
    
    // Update user information
    $user['full_name'] = $_POST['full_name'];
    $user['phone_number'] = $_POST['phone_number'];
    $user['delivery_address'] = $_POST['delivery_address'];

    // Validate user information
    if (empty($user['full_name'])) {
        $errors['full_name'] = 'Full Name is required.';
    }
    if (empty($user['phone_number']) || !is_numeric($user['phone_number']) || strlen($user['phone_number']) < 8) {
        $errors['phone_number'] = 'Please enter a valid phone number (at least 8 digits).';
    }
    if (empty($user['delivery_address'])) {
        $errors['delivery_address'] = 'Delivery Address is required.';
    }

    if (empty($errors)) {
        $totalPrice = 0;
        $productDetails = [];
        foreach ($orders as $order) {
            $productDetails[] = [
                'product_id' => $order['product_id'],
                'name' => $order['name'],
                'price' => $order['price'],
                'quantity' => $order['quantity'],
            ];
            $totalPrice += $order['price'] * $order['quantity'];
        }

        // If Online Payment is selected, validate card details
        if ($paymentMethod === 'online') {
            $paymentMethodId = $_POST['payment_method_id'];
    
            try {
                // Create PaymentIntent with Stripe
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => $totalPrice * 100, // in cents
                    'currency' => 'tnd',
                    'payment_method' => $paymentMethodId,
                    'confirmation_method' => 'manual',
                    'confirm' => true,
                ]);
    
                echo json_encode(['success' => true, 'paymentIntent' => $paymentIntent]);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
        }

        // If no payment error, process the transaction
        if (empty($paymentError)) {
            // Insert transaction into the database
            $status = 'in progress';
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
            

            // Send confirmation email for online payments
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Set SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'mehdialkanas@gmail.com'; // SMTP username
                $mail->Password = 'oezrucxxztcnxwsv'; // SMTP password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('mehdialkanas@gmail.com', 'Falle7a');
                $mail->addAddress('mahdouchtennis@gmail.com'); // Static recipient email

                $mail->isHTML(true);
                $mail->Subject = 'Order Confirmation';
                $mail->Body = "
                    <!DOCTYPE html>
                    <html>
                    <body style='font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0;'>
                        <div style='max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); overflow: hidden; border: 1px solid #eaeaea;'>
                            <div style='background-color: #4CAF50; color: #ffffff; padding: 20px; text-align: center;'>
                                <h1>Order Confirmation</h1>
                            </div>
                            <div style='padding: 20px; color: #333333;'>
                                <p>Dear <strong>" . htmlspecialchars($user['full_name']) . "</strong>,</p>
                                <p>Thank you for placing your order with us! Here are the details of your purchase:</p>
                                <table style='width: 100%; border-collapse: collapse; margin-top: 20px;'>
                                    <thead>
                                        <tr>
                                            <th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Product Name</th>
                                            <th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Quantity</th>
                                            <th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                                    foreach ($orders as $order) {
                                        $mail->Body .= "
                                            <tr>
                                                <td style='border: 1px solid #ddd; padding: 10px;'>" . htmlspecialchars($order['name']) . "</td>
                                                <td style='border: 1px solid #ddd; padding: 10px; text-align: center;'>" . htmlspecialchars($order['quantity']) . "</td>
                                                <td style='border: 1px solid #ddd; padding: 10px; text-align: right;'>" . number_format($order['price'], 2) . " TND</td>
                                            </tr>";
                                    }
                $mail->Body .= "
                                    </tbody>
                                </table>
                                <p style='margin-top: 20px;'><strong>Total Price:</strong> " . number_format($totalPrice) . " TND</p>
                                <p>We will notify you once your order is shipped.</p>
                                <p>Best regards,</p>
                                <p>Your Store Team</p>
                            </div>
                            <div style='background-color: #f1f1f1; color: #888888; padding: 10px; text-align: center; font-size: 12px;'>
                                &copy; " . date('Y') . " Falle7a. All rights reserved.
                            </div>
                        </div>
                    </body>
                    </html>";
                $mail->send();
            } catch (Exception $e) {
                die('Email could not be sent. Mailer Error: ' . $mail->ErrorInfo);
            }

            // Clear the orders table (if necessary)
            $pdo->prepare("DELETE FROM orders")->execute();

            // Redirect to transactions page
            header("Location: transactions.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaflet Address Selector</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map {
            width: 100%;
            height: 400px;
            margin-top: 10px;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- Checkout Form -->
<div class="wow fadeInUp" data-wow-delay="0.1s" style="max-width: 1200px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
    <h1 style="color: #333; text-align: center;">Complete Your Transaction</h1>
    <form method="POST" id="checkoutForm" style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9;">
        <!-- Full Name -->
        <div style="margin-bottom: 15px;">
            <label for="full_name" style="display: block; font-weight: bold; margin-bottom: 5px;">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <div id="full_name_error" class="error" style="color: red; display: none;"></div>
        </div>

        <!-- Phone Number -->
        <div style="margin-bottom: 15px;">
            <label for="phone_number" style="display: block; font-weight: bold; margin-bottom: 5px;">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <div id="phone_number_error" class="error" style="color: red; display: none;"></div>
        </div>

        <!-- Delivery Address -->
        <div style="margin-bottom: 15px;">
            <label for="delivery_address" style="display: block; font-weight: bold; margin-bottom: 5px;">Delivery Address</label>
            <textarea id="delivery_address" name="delivery_address" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"><?php echo htmlspecialchars($user['delivery_address']); ?></textarea>
            <div id="delivery_address_error" class="error" style="color: red; display: none;"></div>
        </div>

        <!--MAP-->
    <div id="map"></div>
    <script>
        // Initialize the map
        const map = L.map('map').setView([34.0, 9.0], 6); // Centered on Tunisia [lat, lng]

        // Define Normal View (OpenStreetMap)
        const normalView = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        });

        // Define Satellite View (ESRI World Imagery)
        const satelliteView = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19,
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, Maxar, Earthstar Geographics, and the GIS User Community'
        });

        // Add default layer (Normal View)
        normalView.addTo(map);

        // Define base layers for toggling
        const baseLayers = {
            "Normal View": normalView,
            "Satellite View": satelliteView
        };

        // Add layer control to the map
        L.control.layers(baseLayers).addTo(map);

        // Define bounds for Tunisia (approximate bounding box)
        const bounds = [[30.2306, 7.5126], [37.5411, 11.5988]]; // SouthWest and NorthEast coordinates
        map.fitBounds(bounds);
        map.setMaxBounds(bounds); // Restrict panning outside Tunisia

        // Add a draggable marker
        const marker = L.marker([34.0, 9.0], { draggable: true }).addTo(map);

        // Reverse geocoding function
        async function reverseGeocode(lat, lng) {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&countrycodes=tn`); // Limit to Tunisia
            const data = await response.json();
            return data.display_name || 'Address not found';
        }

        // Update address in the textarea on marker drag
        marker.on('dragend', async () => {
            const { lat, lng } = marker.getLatLng();
            const address = await reverseGeocode(lat, lng);
            document.getElementById('delivery_address').value = address;
        });

        // Map click event to move marker and update the textarea
        map.on('click', async (e) => {
            const { lat, lng } = e.latlng;
            marker.setLatLng([lat, lng]);
            const address = await reverseGeocode(lat, lng);
            document.getElementById('delivery_address').value = address;
        });
    </script>
    <!--map END -->


        <!-- Products in Cart -->
        <?php $totalPrice = 0; ?>
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
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: right;"><?php echo number_format($order['price'], 2); ?> TND</td>
                        <?php $totalPrice += $order['price'] * $order['quantity']; ?>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: right;"><b>Total :</b><?php echo number_format($totalPrice) ?> TND</td>
                </tr>
            </tbody>
        </table>

        <!-- Payment Method Dropdown -->
        <div style="margin-bottom: 15px;">
            <label for="payment_method" style="font-weight: bold;">Payment Method</label>
            <select id="payment_method" name="payment_method" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                <option value="hand">Hand-to-Hand Payment</option>
                <option value="online">Online Payment</option>
            </select>
        </div>

        <!-- Online Payment Fields -->
        <div id="onlinePaymentFields" style="display: none; margin-bottom: 15px;">
    <label for="card_element" style="font-weight: bold;">Card Information</label>
    <div id="card_element" style="border: 1px solid #ccc; padding: 10px;"></div>
    <div id="payment_error" style="color: red; margin-top: 10px;"></div>
</div>

        <form action="transactions.php"><button id="completeOrderBTN"type="submit" style="width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">Complete Order</button></form>
        
    </form>
</div>


<script src="https://js.stripe.com/v3/"></script>
<script>
    // Encode product details from PHP to JavaScript
    const productDetails = <?php echo json_encode($productDetails, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const stripe = Stripe("pk_test_51QT8a4H8w9WYGc2qOZ9kTlqY6ML7DBosVrFIf1G7FUcuslEMo0aBFHSLr9qj34ISPkBHcsIEauWxSDPcbvUij6DJ00iu0SpUtG");
        const elements = stripe.elements();

        // Create an instance of the card element
        const card = elements.create("card");
        card.mount("#card_element");

        const form = document.getElementById("checkoutForm");
        const paymentMethodSelect = document.getElementById("payment_method");
        const onlinePaymentFields = document.getElementById("onlinePaymentFields");

        // Toggle visibility of online payment fields
        paymentMethodSelect.addEventListener("change", function () {
            onlinePaymentFields.style.display = paymentMethodSelect.value === "online" ? "block" : "none";
        });

        // Form submission logic
        form.addEventListener("submit", async (event) => {
            event.preventDefault();

            // Clear previous error messages
            document.querySelectorAll(".error").forEach(el => (el.style.display = "none"));

            // Validate inputs
            const fullName = document.getElementById("full_name").value.trim();
            const phoneNumber = document.getElementById("phone_number").value.trim();
            const deliveryAddress = document.getElementById("delivery_address").value.trim();

            let valid = true;

            if (!fullName) {
                document.getElementById("full_name_error").textContent = "Full Name is required.";
                document.getElementById("full_name_error").style.display = "block";
                valid = false;
            }

            const phoneRegex = /^[0-9]{8}$/;
            if (!phoneNumber || !phoneRegex.test(phoneNumber)) {
                document.getElementById("phone_number_error").textContent = "Invalid phone number. Must be 8 digits.";
                document.getElementById("phone_number_error").style.display = "block";
                valid = false;
            }

            if (!deliveryAddress) {
                document.getElementById("delivery_address_error").textContent = "Delivery Address is required.";
                document.getElementById("delivery_address_error").style.display = "block";
                valid = false;
            }

            if (!valid) return;

            // Handle online payment
            if (paymentMethodSelect.value === "online") {
                try {
                    const { paymentMethod, error } = await stripe.createPaymentMethod({
                        type: "card",
                        card: card,
                    });

                    if (error) {
                        form.submit();
                        
                        return;
                    }

                    const paymentMethodId = paymentMethod.id;

                    // Submit form data to the server
                    const formData = new FormData(form);
                    formData.append("payment_method_id", paymentMethodId);

                    const response = await fetch(form.action, {
                        method: "POST",
                        body: formData,
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert("Payment Successful!");
                        window.location.href = "transactions.php"; // Redirect on success
                    } else {
                        document.getElementById("payment_error").textContent = result.error || "Payment failed. Please try again.";
                        window.location.href = "transactions.php";
                    }
                } catch (err) {
                    window.location.href = "transactions.php";
                    document.getElementById("payment_error").textContent = "An error occurred. Please try again later.";
                }
            } else {
                // For hand-to-hand payment, submit the form traditionally
                form.submit();
            }
        });
    });
</script>


</body>
</html>



