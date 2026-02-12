 <!-- <?php

                use PHPMailer\PHPMailer;
                use PHPMailer\SMTP;
                use PHPMailer\Exception;
                
               
                 
                    
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $subject = $_POST['subject'];
                    $message = $_POST['message'];
                 
                    

$mail = new PHPMailer(true);

try {
  
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'kumarvikash2208@gmail.com';                     //SMTP username
    $mail->Password   = 'ikty rhvp zxpu rccy';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('kumarvikash2208@gmail.com', 'contact form');
    $mail->addAddress('kumarvikash2208@gmail.com', 'Website');     //Add a recipient
   

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

                 
        
       

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure PHPMailer is included

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get form data
$name = $_POST['name'] ?? 'Unknown';
$email = $_POST['email'] ?? 'no-email@example.com';
$subject = $_POST['subject'] ?? 'No Subject';
$message = $_POST['message'] ?? 'No message';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable debug output
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kumarvikash2208@gmail.com'; // Your Gmail
    $mail->Password   = 'ikty rhvp zxpu rccy'; // Use an App Password here
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Sender & Recipient
    $mail->setFrom($email, $name);
    $mail->addAddress('kumarvikash2208@gmail.com', 'Website Admin');

    // Email Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = "<strong>Name:</strong> $name <br> <strong>Email:</strong> $email <br> <strong>Message:</strong> <p>$message</p>";
    $mail->AltBody = "Name: $name\nEmail: $email\nMessage:\n$message";

    // Send email
    if ($mail->send()) {
        echo 'Message has been sent successfully.';
    } else {
        echo 'Message could not be sent. Error: ' . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

        
                    
                
            ?>
         -->