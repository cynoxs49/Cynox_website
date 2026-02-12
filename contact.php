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
    // Collect and sanitize form data from $_POST superglobal
    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $subject = sanitize_input($_POST['subject'] ?? '');
    $messageContent = nl2br(sanitize_input($_POST['message'] ?? '')); // nl2br preserves line breaks

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($messageContent)) {
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
        <h2>New Contact Form Message</h2>
        <table>
            <tr><td><strong>Name:</strong></td><td>$name</td></tr>
            <tr><td><strong>Email:</strong></td><td>$email</td></tr>
            <tr><td><strong>Subject:</strong></td><td>$subject</td></tr>
            <tr><td><strong>Message:</strong></td><td>$messageContent</td></tr>
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
        $mail->setFrom('harshbajaj@cynoxsecurity.com', 'Cynox Website Contact'); // Sender email and name
        $mail->addAddress('support@cynoxsecurity.com'); // Recipient email (where you want to receive messages)
        $mail->addReplyTo($email, $name); // Allow replying directly to the user's email

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = "New Contact Message: $subject";
        $mail->Body    = $message;
        $mail->AltBody = strip_tags($message); // Plain text for non-HTML mail clients
        $mail->SMTPDebug = 2; // Verbose debug output
        $mail->Debugoutput = function($str, $level) {
            error_log("SMTP DEBUG [$level]: $str\n", 3, "/tmp/phpmailer_debug.log");
        };

        $mail->send();
        echo json_encode(['success' => true]); // Send success response
    } catch (Exception $e) {
        // Log the error (optional, for debugging on server)
        error_log("PHPMailer Error for /contact: {$mail->ErrorInfo}");
        echo json_encode(['success' => false, 'error' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    // Not a POST request
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>