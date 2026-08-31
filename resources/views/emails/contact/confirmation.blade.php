<!doctype html>
<html lang="en">
<body style="font-family: Arial, sans-serif; color: #1f2937;">
    <h2>Hello {{ $contactMessage->name }},</h2>

    <p>Thank you for contacting Bonyaan. We received your message.</p>

    <p>Our team will review your inquiry and contact you shortly.</p>

    <p><strong>Subject:</strong> {{ $contactMessage->subject }}</p>

    <p>Best regards,<br>Bonyaan Team</p>
</body>
</html>