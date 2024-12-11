<?php


require __DIR__ . '/../../vendor/autoload.php'; // For PHPMailer

if (empty($errors)) {
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
                <p>Dear User</strong>,</p>
                <p>Thank you for placing your order with us!</p>
                <p>Please confirm or decline your order by clicking one of the buttons below:</p>
                <div style='text-align: center; margin-top: 20px;'>
                    <a href='http://localhost/projetWeb2A/projetWeb2A/View/FRONT-OFFICE/checkOut.php?' style='text-decoration: none; color: white; background-color: #28a745; padding: 10px 20px; border-radius: 5px; margin-right: 10px;'>Confirm Order</a>
                    <a href='http://localhost/projetWeb2A/projetWeb2A/View/FRONT-OFFICE/login.html' style='text-decoration: none; color: white; background-color: #dc3545; padding: 10px 20px; border-radius: 5px;'>Decline Order</a>
                </div>
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
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f3f4f6;">
    <div style="text-align: center; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); max-width: 400px; width: 90%;">
        <h1 style="color: #4CAF50; font-size: 1.8rem; margin-bottom: 20px;">Check Your Email</h1>
        <p style="color: #6c757d; font-size: 1rem; margin-top: 0;">We've sent a confirmation link to your email. Please check your inbox and follow the link to confirm your account.</p>
        <a href="send_email.php" style="display: inline-block; margin-top: 20px; padding: 10px 20px; font-size: 1rem; color: white; background-color: #4CAF50; border: none; border-radius: 5px; text-decoration: none; cursor: pointer;">Resend Email</a>
    </div>
</body>
</html>



