<?php
// flutterwave-callback.php

// Load environment variables or set them directly
$secretKey = 'YOUR_FLUTTERWAVE_SECRET_KEY';

// Verify the webhook signature
function verifyWebhookSignature($signature, $payload) {
    global $secretKey;

    $computedSignature = hash_hmac('sha256', $payload, $secretKey);
    return $computedSignature === $signature;
}

// Read the incoming data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Get the signature from the headers
$signature = isset($_SERVER['HTTP_VERIF_HASH']) ? $_SERVER['HTTP_VERIF_HASH'] : '';

// Verify the signature
if (!verifyWebhookSignature($signature, $input)) {
    http_response_code(403); // Forbidden
    echo "Invalid signature";
    exit;
}

// Process the callback data
if ($data['event'] === 'charge.completed') {
    $transactionId = $data['data']['id'];
    $status = $data['data']['status'];

    if ($status === 'successful') {
        // Handle successful payment logic here
        echo "Payment successful for transaction ID: $transactionId";
    } else {
        echo "Payment failed for transaction ID: $transactionId";
    }
} else {
    echo "Event not handled";
}
?>