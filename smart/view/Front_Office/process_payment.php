<?php
// process_payment.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentMethodId = $_POST['payment_method_id'];

    // Process the payment using Stripe's API
    try {
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => 5000, // Example amount in cents
            'currency' => 'usd',
            'payment_method' => $paymentMethodId,
            'confirmation_method' => 'manual',
            'confirm' => true,
        ]);

        if ($paymentIntent->status === 'succeeded') {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Payment failed']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
