<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Join HLP Meeting</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0;">

    <div class="container py-5">
        <!-- Header Section -->
        <div class="text-center mb-4">
            <img src="https://hindtechlearningpoint.com/assets/images/logo_white_transparent.png" alt="Company Logo" style="max-width: 200px;">
        </div>

        <!-- Email Body -->
        <div class="card shadow border-0" style="border-radius: 8px;">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4" style="color: #007bff;">Join the HLP Google Meet Now</h3>
                <p class="card-text">
                    Dear {{ $recipientName }},
                </p>
                <p>
                    The <strong>HLP Meeting</strong> is live on Google Meet, and we’re excited to have you join us!
                </p>

                <div class="text-center my-4">
                    <a href="{{ $meetingLink }}" class="btn btn-primary btn-lg" style="border-radius: 50px;">Join the Google Meet</a>
                </div>

                <p>
                    If you encounter any issues accessing the meeting, feel free to reach out at 
                    <a href="mailto:hindtechlearningpointlko@gmail.com">hindtechlearningpointlko@gmail.com</a>.
                </p>

                <p class="mb-0">Looking forward to your participation.</p>

                <p class="mt-4">
                    Best regards,<br>
                    <strong>HLP</strong><br>
                    Team Leader
                </p>
            </div>
        </div>

        <!-- Footer Section -->
        <footer class="text-center mt-4">
            <p style="font-size: 0.9rem; color: #6c757d;">
                &copy; 2020 Hindtech IT Solutions. All rights reserved.
            </p>
        </footer>
    </div>

</body>
</html>
