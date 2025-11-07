<?php
require_once 'config/config.php';
require_once 'config/pdo_db.php';
require_once 'Models/User.php';

      

// instantiate customer
$user = new User();

$secret_key = 'sk_test_2a40659bb0836b3790fa17b516b979326c62d7b2';


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
 
    
        
     
   $Usersdata = [
        'email' => $email,
        'FullName' => $_SESSION['FullName'],
        'organization' => $_SESSION['org'],
        'password' => $_SESSION['pswd'],
        'admin' => '1'
     ];    
        
//    if organization admin exist do not register
    $user->addUserAdmin($Usersdata);
    
    $newExpiry = date('Y-m-d', strtotime('+30 days'));
    $sql = mysqli_query($connection, "UPDATE user SET subscription_expiry = '{$newExpiry}' WHERE organization = '{$organization}'");  

    
    // Redirect to receipt page with query parameters
    header("Location: receipt?ref={$ref}&email={$email}&amount={$amount}&time={$time}&fullname={$fullname}");
    exit;
} else {
    echo "Payment failed or not verified.";
}
?>
