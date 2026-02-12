<?php
// require Composer's autoloader for PHPMailer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Set content type for JSON response
header('Content-Type: application/json');

// Function to sanitize input data
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    error_log(print_r($_POST, true)); // Logs to server's error log

    $cert_no = sanitize_input($_POST['certificate_no'] ?? '');
    $name = sanitize_input($_POST['name'] ?? '');
    $phone = sanitize_input($_POST['no'] ?? ''); // 'no' for phone number
    $email = sanitize_input($_POST['email'] ?? '');

    // Basic validation
    if (empty($cert_no) || empty($name) || empty($phone) || empty($email)) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields.']);
        exit;
    }

    // Construct the email message in HTML format
    $message = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; color: #333; }
            table { width: 100%; border-collapse: collapse; }
            td { padding: 8px; border-bottom: 1px solid #ddd; }
            tr:nth-child(even) { background: #f9f9f9; }
        </style>
    </head>
    <body>
        <h2>New Certificate Verification Request</h2>
        <table>
            <tr><td><strong>Certificate No.:</strong></td><td>$cert_no</td></tr>
            <tr><td><strong>Name:</strong></td><td>$name</td></tr>
            <tr><td><strong>Phone:</strong></td><td>$phone</td></tr>
            <tr><td><strong>Email:</strong></td><td>$email</td></tr>
        </table>
    </body>
    </html>
    ";

    $mail = new PHPMailer(true); // Enable exceptions

    try {
        // Server settings for Gmail SMTP
        $mail->isSMTP();
        $mail->Host       = 'mail.cynoxsecurity.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'harshbajaj@cynoxsecurity.com'; // Your Gmail address
        $mail->Password   = 'harshbajaj123'; // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SMTPS (SSL/TLS implicit on port 465)
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('harshbajaj@cynoxsecurity.com', 'Cynox Certificate Verify'); // Sender email and name
        $mail->addAddress('support@cynoxsecurity.com'); // Recipient email (where you want to receive requests)
        $mail->addReplyTo($email, $name); // Allow replying directly to the user's email

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = "New Certificate Verification Request: $cert_no";
        $mail->Body    = $message;
        $mail->AltBody = strip_tags($message); // Plain text for non-HTML mail clients

        $mail->send();
        echo json_encode(['success' => true]); // Send success response
    } catch (Exception $e) {
        // Log the error (optional, for debugging on server)
        error_log("PHPMailer Error for /verify: {$mail->ErrorInfo}");
        echo json_encode(['success' => false, 'error' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    // Not a POST request
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>