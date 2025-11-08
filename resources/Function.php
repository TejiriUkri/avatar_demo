<?php


function redirect($url=''){
if(!empty($url)){
    echo '<script>location.href="'.$url.'"</script>';    
}

}


// function redirect($location){
    
//     header("Location: $location ");
// }


function encryptId($id){

$key = 'qkerjduewe334&&sdeekrdndfHF*^dffdOew';
// $encrypt_key = base64_decode($key);
// $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
// $id = openssl_encrypt($id,'aes-256-cbc',$encrypt_key, 0, $iv);
// return base64_encode($id);
$msg_encrypt = base64_encode(openssl_encrypt($id, 'aes-128-cbc', $key, 0, '5555555555555555'));

return $msg_encrypt;

}

function decryptId($id, $msg_encrypt){

$key = 'qkerjduewe334&&sdeekrdndfHF*^dffdOew';

// $encrypt_key = base64_decode($key);
// list($encrypt_data, $iv) = array_pad(explode('::', base64_decode($id), 2), 2, null);
// return openssl_decrypt($encrypt_data, 'aes-256-cbc', $encrypt_key, 0, $iv);
$msg_decrypted = openssl_decrypt(base64_decode($msg_encrypt), 'aes-128-cbc', $key, 0, '5555555555555555');

return $msg_decrypted;

}

function email_exists($email){
    
global $connection;
    
$query = mysqli_query($connection, "SELECT email FROM users WHERE email = '{$email}' "); 
confirm($query); 
    if(mysqli_num_rows($query) > 0){
        
        return true;
        
    }else{
        
        return false;
    }
    
    
}




function confirm($result){
    
global $connection;
    
    if(!$result){
        
        die("QUERY FAILED " . mysqli_error($connection));
    }
    
}

function display_message(){
    
    if(isset($_SESSION['message'])){
        
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function set_message($msg){

if(!empty($msg)){
    
 $_SESSION['message'] = $msg;
} else{
    
$msg = "";
    
}   
    
    
}





