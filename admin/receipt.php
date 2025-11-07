<?php
$ref = $_GET['ref'] ?? 'Unknown';
$email = $_GET['email'] ?? 'Not provided';
$amount = $_GET['amount'] ?? '0';
$time = $_GET['time'] ?? 'Unknown time';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>
    <style>
        body {
            background: #f2f4f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .receipt {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
            position: relative;
        }
        .logo {
            max-width: 120px;
            margin-bottom: 20px;
        }
        .receipt h2 {
            color: #0a3d62;
            margin-bottom: 20px;
            font-size: 28px;
        }
        .receipt p {
            font-size: 16px;
            margin: 8px 0;
            color: #333;
        }
        .status-success {
            color: #28a745;
            font-weight: bold;
            margin-top: 20px;
            font-size: 18px;
        }
        .btns {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        .btn-home, .btn-download {
            padding: 12px 20px;
            background-color: #0a3d62;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
            font-size: 14px;
        }
        .btn-home:hover, .btn-download:hover {
            background-color: #0652DD;
        }
    </style>
</head>
<body>
    <div class="receipt" id="receipt-content">
        <img src="your_logo.png" alt="Company Logo" class="logo">
        <h2>Payment Receipt</h2>
        <p><strong>Reference:</strong> <?php echo htmlspecialchars($ref); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Amount Paid:</strong> ₦<?php echo htmlspecialchars($amount); ?></p>
        <p><strong>Payment Time:</strong> <?php echo htmlspecialchars($time); ?></p>
        <p class="status-success">Payment Successful</p>
        <div class="btns">
            <a href="pay.php" class="btn-home">Make Another Payment</a>
            <a href="#" class="btn-download" onclick="downloadPDF()">Download PDF</a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.setFontSize(18);
            doc.text("Payment Receipt", 70, 20);
            doc.setFontSize(12);
            doc.text("Reference: <?php echo htmlspecialchars($ref); ?>", 20, 40);
            doc.text("Email: <?php echo htmlspecialchars($email); ?>", 20, 50);
            doc.text("Amount Paid: ₦<?php echo htmlspecialchars($amount); ?>", 20, 60);
            doc.text("Payment Time: <?php echo htmlspecialchars($time); ?>", 20, 70);
            doc.text("Status: Payment Successful", 20, 80);
            doc.save("payment_receipt_<?php echo htmlspecialchars($ref); ?>.pdf");
        }
    </script>
</body>
</html>
