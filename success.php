<!DOCTYPE html>
<html>
<head>
    <title>Registration Successful</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f5f9f7;
            font-family: Arial, sans-serif;
        }
        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
        }
        .checkmark {
            font-size: 100px;
            color: green;
        }
        h1 {
            margin-top: 20px;
            color: #333;
        }
        p {
            color: #666;
        }
        .btn {
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #0a3d62;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="checkmark">&#10004;</div>
        <h1>Registration Successful!</h1>
        <p>Thank you for registering. You can now proceed to login.</p>
        <a href="login" class="btn">Go to Login</a>
    </div>

</body>
</html>
