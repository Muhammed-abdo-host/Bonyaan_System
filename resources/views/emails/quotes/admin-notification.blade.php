<!doctype html>
<html lang="en">
<body style="font-family: Arial, sans-serif; color: #1f2937;">
    <h2>New quote request #{{ $lead->id }}</h2>

    <ul>
        <li><strong>Name:</strong> {{ $lead->name }}</li>
        <li><strong>Email:</strong> {{ $lead->email }}</li>
        <li><strong>Phone:</strong> {{ $lead->phone }}</li>
        <li><strong>Location:</strong> {{ $lead->location }}</li>
        <li><strong>Project type:</strong> {{ $lead->building_type }}</li>
        <li><strong>Attachments:</strong> {{ $lead->attachments->count() }}</li>
    </ul>

    @if ($lead->notes)
        <p><strong>Notes:</strong><br>{{ $lead->notes }}</p>
    @endif
</body>
</html>