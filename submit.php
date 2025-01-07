<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $to = "techxol92@gmail.com"; // Your email to receive form submissions
    $subject = "New Contact Form Submission";

    // HTML Email Template
    $body = "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 20px auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .header {
                background-color: #0e33cb;
                padding: 20px;
                text-align: center;
                color: #ffffff;
                border-radius: 8px 8px 0 0;
            }
            .content {
                padding: 20px;
                color: #333333;
            }
            .footer {
                text-align: center;
                font-size: 12px;
                margin-top: 10px;
                color: #777777;
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                margin-top: 10px;
                background-color: #ec4621;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>New Contact Form Submission</h1>
            </div>
            <div class='content'>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone:</strong> $phone</p>
                <p><strong>Message:</strong> $message</p>
                <a href='mailto:$email' class='button'>Reply to $name</a>
            </div>
            <div class='footer'>
                <p>Received on: " . date("Y-m-d H:i:s") . "</p>
                <p>&copy; Your Company Name. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>";

    // Email Headers
    $headers = "From: no-reply@yourdomain.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Send Email
    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to send email."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
