<?php require_once("../resources/Config.php"); ?>
<?php $page = 'payment'; include(TEMPLATE_FRONT . DS . "admin_header.php") ?>
<?php
// index.php

// Load environment variables or set them directly
$publicKey = 'FLWPUBK-6bc3f385823bff0e1ed268689bde90ba-X';
$secretKey = 'YOUR_FLUTTERWAVE_SECRET_KEY';

// Function to initiate payment
function initiatePayment($amount, $email, $firstname, $lastname) {
    global $publicKey;

    // Define the payload for the Flutterwave API
    $payload = [
        "amount" => $amount,
        "currency" => "NGN", // Change to desired currency
        "email" => $email,
        "firstname" => $firstname,
        "lastname" => $lastname,
        "tx_ref" => "ref-" . time(), // Unique transaction reference
        "redirect_url" => "http://localhost/flutterwave-callback.php", // URL to redirect after payment
        "payment_options" => "card,banktransfer", // Specify payment methods
        "meta" => [
            [
                "metaname" => "customerid",
                "metavalue" => "uniqueid-123"
            ]
        ],
        "customizations" => [
            "title" => "My Company",
            "description" => "Payment for goods and services",
            "logo" => "https://yourdomain.com/logo.png" // Optional
        ]
    ];

    // Send request to Flutterwave API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.flutterwave.com/v3/payments");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $publicKey
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code == 200) {
        $data = json_decode($response, true);
        if ($data['status'] === 'success') {
            return $data['data']['link']; // Return the payment link
        }
    }

    return false; // Return false on failure
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    $paymentLink = initiatePayment($amount, $email, $firstname, $lastname);

    if ($paymentLink) {
        header("Location: $paymentLink"); // Redirect to Flutterwave payment page
        exit;
    } else {
        echo "Failed to initiate payment.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flutterwave Payment</title>
</head>
    <style>
        form{
            margin:50px 360px;
        }
        label{
            color: #555;
        }
    
    </style>
<body>
    <h1>Make a Payment</h1>
    <form method="POST" action="">
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required><br><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required><br><br>

        <button type="submit">Pay Now</button>
    </form>
</body>
</html>