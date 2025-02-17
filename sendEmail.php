<?php
error_reporting(0);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// Read JSON input data
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->name) || !isset($data->email) || !isset($data->phone) || !isset($data->user_message)) {
    echo json_encode(["success" => false, "message" => "Incomplete form data."]);
    exit;
}

$name = htmlspecialchars($data->name);
$email = filter_var($data->email, FILTER_VALIDATE_EMAIL);
$phone = htmlspecialchars($data->phone);
$user_message = htmlspecialchars($data->user_message);

if (!$email) {
    echo json_encode(["success" => false, "message" => "Invalid email address."]);
    exit;
}

// Email configuration for admin
$admin_email = "info@inspirespraycoat.com";
$admin_subject = "New Request";
$admin_message = "
<html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 20px auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
            .header { background-color: rgb(0, 31, 63); padding: 20px; text-align: center; color: #ffffff; border-radius: 8px 8px 0 0; }
            .content { padding: 20px; color: #333333; }
            .footer { text-align: center; font-size: 12px; margin-top: 10px; color: #777777; }
            .button { display: inline-block; padding: 10px 20px; margin-top: 10px; background-color: #ec4621; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Inspirespraycoat</h2>
            </div>
            <div class='content'>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone:</strong> $phone</p>
                <p><strong>Message:</strong> $user_message</p>
                <a href='mailto:$email' class='button'>Reply to $name</a>
            </div>
            <div class='footer'>
                <p>&copy; Inspirespraycoat. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: InspireSprayCoat <no-reply@inspirespraycoat.com>" . "\r\n";

$mail_admin = mail($admin_email, $admin_subject, $admin_message, $headers);

// Confirmation email to user
$user_subject = "Thank You for Your Enquiry! 🎨✨";
$user_message = "
<html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 20px auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: center; }
            .header { background-color: rgb(0, 31, 63); padding: 20px; color: #ffffff; border-radius: 8px 8px 0 0; }
            .content { padding: 20px; color: #333333; }
            .footer { font-size: 12px; margin-top: 10px; color: #777777; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Thank You for Your Enquiry! 🎨✨</h2>
            </div>
            <div class='content'>
                <p>We’ve received your request for our UPVC Spraying services and will be in touch shortly to discuss your needs.</p>
                <p>Our team is excited to help transform your space!</p>
                <p>If you have any additional details or questions, feel free to reach out.</p>
                <p>Looking forward to working with you!</p>
                <p>📩 info@inspirespraycoat.com</p>
                <p>🌐 <a href='https://www.inspirespraycoat.com'>www.inspirespraycoat.com</a></p>
                <p>📞 0203 050 8956</p>
            </div>
            <div class='footer'>
                <p>&copy; Inspirespraycoat. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
";

$mail_user = mail($email, $user_subject, $user_message, $headers);

if ($mail_admin && $mail_user) {
    echo json_encode(["success" => true, "message" => "Emails sent successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to send one or both emails. Check server mail settings."]);
}
?>
