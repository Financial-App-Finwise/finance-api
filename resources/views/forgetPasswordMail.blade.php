<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinWise Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        header {
            background-color: #3498db;
            padding: 20px;
            color: #fff;
        }

        h1 {
            color: #3498db;
        }

        .verification-code {
            font-size: 24px;
            color: #27ae60;
            margin: 10px 0;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Forgot Password</h1>
    </header>

    <main>
        <p>Dear User,</p>
        <p>We received a request to reset the password for your account at FinWise.</p>
        <p>To proceed with the password reset, please use this code:</p>
        <p class="verification-code">{{$data['code']}}</p>
        <p>If you didn't request a password reset, you can safely ignore this email.</p>
        <p>If you have any questions or need assistance, feel free to contact our support team.</p>
        <p>Thank you for using FinWise!</p>
    </main>

</body>
</html>
