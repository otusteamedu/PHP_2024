<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Statement Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input[type="date"] {
            padding: 6px;
        }
        .form-group button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Bank Statement Generator</h2>
    <form action="/bank/statement/generate" method="POST">
        <div class="form-group">
            <label for="client-name">Client Name</label>
            <input type="text" id="client-name" name="clientName" required>
        </div>
        <div class="form-group">
            <label for="account-number">Account Number</label>
            <input type="text" id="account-number" name="accountNumber" required>
        </div>
        <div class="form-group">
            <label for="start-date">Start Date</label>
            <input type="date" id="start-date" name="startDate" required>
        </div>
        <div class="form-group">
            <label for="end-date">End Date</label>
            <input type="date" id="end-date" name="endDate" required>
        </div>
        <div class="form-group">
            <button type="submit">Generate Statement</button>
        </div>
    </form>
</div>

</body>
</html>
