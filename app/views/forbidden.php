<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
            color: #333;
        }
        .forbidden-box {
            text-align: center;
            padding: 40px;
            border-radius: 12px;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 90%;
        }
        .forbidden-box h1 {
            font-size: 5rem;
            font-weight: 700;
            color: #dc3545;
        }
        .forbidden-box h3 {
            font-size: 1.5rem;
            font-weight: 600;
        }
        .forbidden-box p {
            margin: 10px 0 20px;
        }
    </style>
</head>
<body>
    <div class="forbidden-box">
        <h1>403</h1>
        <h3>Access Forbidden</h3>
        <p>You don’t have permission to access this page.</p>
        <a href="javascript:history.back()" class="btn btn-outline-primary">Go Back</a>
        <a href="/" class="btn btn-primary">Go Home</a>
    </div>
</body>
</html>
