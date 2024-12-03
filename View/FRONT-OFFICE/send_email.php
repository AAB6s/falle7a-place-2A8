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
        $mail->Password = ''; // SMTP password
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
<body>
    <div style="text-align:center;">
        <h1>Check your Email for confirmation.</h1>
    </div>
    
</body>



