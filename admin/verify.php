<?php
require_once("../resources/Config.php");
$secret_key = 'sk_test_2a40659bb0836b3790fa17b516b979326c62d7b2';
$user_id = $_SESSION['ID'];
$organization = $_SESSION['organization'];

if (!isset($_GET['reference'])) {
    die('No reference supplied');
}

$reference = $_GET['reference'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co/transaction/verify/" . urlencode($reference));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $secret_key",
    "Cache-Control: no-cache"
]);

$response = curl_exec($ch);
$err = curl_error($ch);

curl_close($ch);

if ($err) {
    die("cURL Error: $err");
}


$result = json_decode($response, true);

if ($result['status'] && $result['data']['status'] == 'success') {
    $amount = $result['data']['amount'] / 100;
    $email = $result['data']['customer']['email'] ?? $result['data']['customer_email'] ?? 'unknownemail@example.com';
    $ref = $result['data']['reference'];
    $time = $result['data']['paid_at'];
     
// mysqli_query($connection, "INSERT INTO paymentgateway(user_id,organization,admin_email,paid_at) VALUES('{$user_id}','{$organization}','{$email}','{$time}')");
    
    $newExpiry = date('Y-m-d', strtotime('+30 days'));
    $sql = mysqli_query($connection, "UPDATE user SET subscription_expiry = '{$newExpiry}' WHERE organization = '{$organization}'");  

    
    // Redirect to receipt page with query parameters
    header("Location: receipt.php?ref={$ref}&email={$email}&amount={$amount}&time={$time}");
    exit;
} else {
    echo "Payment failed or not verified.";
}
?>
