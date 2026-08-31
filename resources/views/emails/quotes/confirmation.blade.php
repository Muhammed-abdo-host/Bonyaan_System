<!doctype html>
<html lang="en">
<body style="font-family: Arial, sans-serif; color: #1f2937;">
    <h2>Hello {{ $lead->name }},</h2>

    <p>Thank you for contacting Bonyaan. We received your project proposal request.</p>

    <p>Our engineering team will review your requirements and contact you shortly.</p>

    <h3>Request summary</h3>
    <ul>
        <li><strong>Location:</strong> {{ $lead->location }}</li>
        <li><strong>Project type:</strong> {{ $lead->building_type }}</li>
        <li><strong>Attachments:</strong> {{ $lead->attachments->count() }}</li>
    </ul>

    <p>Best regards,<br>Bonyaan Team</p>
</body>
</html>