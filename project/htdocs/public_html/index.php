<!DOCTYPE html>
<html>
<head>
    <title>Bank Statement Request</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .message { margin-top: 20px; padding: 10px; border: 1px solid #28a745; color: #28a745; }
    </style>
</head>
<body>
<h2>Request Bank Statement</h2>
<form method="POST" action="process.php">
    <div class="form-group">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>
    </div>
    <div class="form-group">
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>
    </div>
    <button type="submit">Submit Request</button>
</form>

<?php if (isset($_GET['success'])): ?>
    <div class="message">Your request has been submitted for processing.</div>
<?php endif; ?>
</body>
</html>