<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PriceWatcher</title>
</head>
<body>
<h1>PriceWatcher</h1>
@if(session('success'))
    <p>{{ session('success') }}</p>
@endif
<form method="POST" action="/subscriptions">
    @csrf

    <div>
        <label for="url">OLX URL</label><br>
        <input type="url" id="url" name="url" required>
    </div>

    <br>

    <div>
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" required>
    </div>

    <br>

    <button type="submit">Subscribe</button>
</form>
</body>
</html>
