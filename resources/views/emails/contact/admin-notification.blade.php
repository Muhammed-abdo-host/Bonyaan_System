<!doctype html>
<html lang="en">
<body style="font-family: Arial, sans-serif; color: #1f2937;">
    <h2>New contact message #{{ $contactMessage->id }}</h2>

    <ul>
        <li><strong>Name:</strong> {{ $contactMessage->name }}</li>
        <li><strong>Email:</strong> {{ $contactMessage->email }}</li>
        <li><strong>Subject:</strong> {{ $contactMessage->subject }}</li>
    </ul>

    <p><strong>Message:</strong></p>
    <p>{{ $contactMessage->message }}</p>
</body>
</html>