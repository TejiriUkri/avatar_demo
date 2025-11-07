<?php require_once("resources/Config.php"); ?>
<?php 
    if(isset($_GET['name'])){
        $_SESSION['FullName'] = base64_decode($_GET['name']);
        $_SESSION['pswd'] = base64_decode($_GET['psd']);
        $_SESSION['org'] = base64_decode($_GET['Org']);
        $_SESSION['email'] = base64_decode($_GET['email']);    
    }

        
?>

    <style>
        body {
/*            background: #f2f4f7;*/
            background-color: #f2f4f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .payment-form {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 150%;
            max-width: 500px;
            text-align: center;
        }
        .logo {
            max-width: 120px;
            margin-bottom: 20px;
        }
        .payment-form h2 {
            color: #0a3d62;
            margin-bottom: 20px;
            font-size: 28px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }
        input[type="email"], input[type="text"] {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        button {
            padding: 14px;
            background-color: #0a3d62;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #0652DD;
        }
        .note {
            font-size: 12px;
            color: #777;
            margin-top: 10px;
        }
    </style>

 <div class="payment-form">
        <h2>Make a Payment</h2>
    <form id="paymentForm" method="POST" onsubmit="return validateForm()">
        <input type="email" id="email" placeholder="Enter your email" value="<?php echo $_SESSION['email']; ?>" /><br>
        <input type="text" id="amount" placeholder="10 dollars" value="10" required /><br><br>
       
        <button type="submit">Pay Now</button>
    </form>
</div>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
      const paymentForm = document.getElementById('paymentForm');
      paymentForm.addEventListener("submit", payWithPaystack, false);
        
   
      function payWithPaystack(e) {
        e.preventDefault();
        let handler = PaystackPop.setup({
          key: 'pk_test_85da1417daf0e308e1c97c190439b3bacb66653d', // Replace with your LIVE PUBLIC KEY
          email: document.getElementById("email").value,
          amount: document.getElementById("amount").value * 160500, // Amount in dollars

          currency: 'NGN',
          callback: function(response) {
            // Redirect to verify.php with reference
            window.location.href = "verify.php?reference=" + response.reference;
          },
          onClose: function() {
            alert('Transaction canceled.');
          },
        });
        handler.openIframe();
      }
       
        
           function validateForm() {
            const rawAmount = amountInput.value.replace(/[^\d]/g, '');
            if (parseInt(rawAmount) <= 0 || isNaN(rawAmount)) {
                alert('Please enter a valid amount greater than ₦0.');
                return false;
            }
            amountInput.value = rawAmount;
            return true;
        }    
    </script>

 <script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
     <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script> 
   <script src="assets/js/app.js"></script>