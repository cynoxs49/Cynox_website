<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Function to sanitize user input
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Collect and sanitize form data
$name = sanitize_input($_POST['name']);
$emailid = sanitize_input($_POST['email']);
$subject = sanitize_input($_POST['subject']);
$message1 = nl2br(sanitize_input($_POST['message']));

// Construct the professional HTML email message
$message = "
<!DOCTYPE html>
<html>
<head>
    <title>New Enquiry Received</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 22px;
            font-weight: bold;
        }
        .email-body {
            padding: 30px;
            font-size: 16px;
            color: #333;
        }
        .email-body table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .email-body td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }
        .email-body tr:nth-child(even) {
            background: #f9f9f9;
        }
        .email-footer {
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #777;
            background: #f1f1f1;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            text-decoration: none;
            color: #ffffff;
            background: #007bff;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class='email-container'>
        <div class='email-header'> New Enquiry from Website</div>
        <div class='email-body'>
            <p>Hello Admin,</p>
            <p>You have received a new enquiry. Below are the details:</p>
            <table>
                <tr>
                    <td><strong>Name:</strong></td>
                    <td>$name</td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>$emailid</td>
                </tr>
                <tr>
                    <td><strong>Subject:</strong></td>
                    <td>$subject</td>
                </tr>
                <tr>
                    <td><strong>Message:</strong></td>
                    <td>$message1</td>
                </tr>
            </table>
            <p style='margin-top: 20px; text-align: center;'>
                Thank You for reaching out!!!
            </p>
        </div>
        <div class='email-footer'>📧 This is an automated message. Please do not reply.</div>
    </div>
</body>
</html>
";

// SMTP configuration
$mail = new PHPMailer(true);

try {
    // SMTP Server Settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->setFrom('heehehe359@gmail.com', 'Cynox Global Contact');
    $mail->Password = 'bpqx ktiw ubon oahd'; // Use an App Password for security
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    // Sender and Recipient Details
    $mail->setFrom('heehehe359@gmail.com', 'CynoxGlobal');
    $mail->addAddress('heehehe359@gmail.com');     
    $mail->addReplyTo($emailid, $name); // Allowing admin to reply directly

    // Email Content
    $mail->isHTML(true);
    $mail->Subject = '📩 New Enquiry from Website';
    $mail->Body = $message;

    // Send Email
    $mail->send();
    
    // Redirect to the thank-you page
    header('Location: index.php');
    exit();

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
