<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

function showResponse($message, $type = 'success') {
    $color = $type === 'success' ? '#4CAF50' : '#f44336'; // green or red
    echo "
    <div style='
        margin: 50px auto;
        max-width: 500px;
        padding: 20px;
        text-align: center;
        background-color: rgba(0, 0, 0, 0.85);
        color: white;
        border-left: 6px solid $color;
        border-radius: 10px;
        font-family: Arial, sans-serif;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
    '>
        <h2 style='color: $color;'>" . ($type === 'success' ? '✅ Success' : '❌ Error') . "</h2>
        <p style='font-size: 16px;'>$message</p>
        <a href='index.html' style='
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: $color;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        '>Go Back</a>
    </div>
    ";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'saiharsha0501@gmail.com';
        $mail->Password = 'wqrvbpigypluukjz'; // App password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email setup
        $mail->setFrom($_POST['email'], $_POST['name']);
        $mail->addAddress('saiharsha0501@gmail.com', 'Website Owner');

        $mail->isHTML(true);
        $mail->Subject = htmlspecialchars($_POST['subject']);
        $mail->Body    = '
            <h3>Contact Form Submission</h3>
            <p><strong>Name:</strong> ' . htmlspecialchars($_POST['name']) . '</p>
            <p><strong>Email:</strong> ' . htmlspecialchars($_POST['email']) . '</p>
            <p><strong>Subject:</strong> ' . htmlspecialchars($_POST['subject']) . '</p>
            <p><strong>Message:</strong><br>' . nl2br(htmlspecialchars($_POST['message'])) . '</p>
        ';

        $mail->send();
        showResponse("Your message was sent successfully!");
    } catch (Exception $e) {
        showResponse("Message could not be sent. Mailer Error: {$mail->ErrorInfo}", 'error');
    }
}
?>
