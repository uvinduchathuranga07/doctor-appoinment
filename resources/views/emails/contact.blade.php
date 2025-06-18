<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Contact Email</title>
    <style>
        /* Basic reset */
        body, html {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px 30px;
            border-radius: 8px;
            border: 1px solid #e2e2e2;
        }

        h1 {
            margin-top: 0;
            color: #444;
        }

        .info-block {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }

        .info-value {
            margin: 0;
            color: #333;
        }

        .divider {
            border-top: 1px solid #e2e2e2;
            margin: 20px 0;
        }

        .footer-text {
            text-align: center;
            font-size: 0.9rem;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>New Contact Submission</h1>
        
        <div class="info-block">
            <div class="info-label">Name:</div>
            <p class="info-value">{{ $formData['name'] }}</p>
        </div>
        
        <div class="info-block">
            <div class="info-label">Email:</div>
            <p class="info-value">{{ $formData['email'] }}</p>
        </div>
        
        <div class="info-block">
            <div class="info-label">Phone:</div>
            <p class="info-value">{{ $formData['phone'] }}</p>
        </div>
        
        <div class="info-block">
            <div class="info-label">Enquiry:</div>
            <p class="info-value">{{ $formData['enquiry'] }}</p>
        </div>

        <div class="divider"></div>

        <div class="footer-text">
            This email was sent automatically. If you have any questions, please reply to this email or contact us directly.
        </div>
    </div>
</body>
</html>
