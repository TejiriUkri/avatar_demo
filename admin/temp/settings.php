<?php
require_once('../config/config.php');
require_once('../config/pdo_db.php');
require_once('../Models/User.php');

$user = new User;
if($rows = $user->Getuser($_SESSION['email'],$_SESSION['pwd'])){
        foreach ($rows as $row){   
             $organization = $row->organization;
        }
}
// Check if user is logged in
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 1) {
    header("Location: ../logout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="Mystyle.css">

</head>
    <?php if($_SESSION['organization'] == $organization){ ?>
        <script>
        // Function to toggle the theme
        function toggleTheme() {
            const currentTheme = localStorage.getItem('theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            // Update localStorage
            localStorage.setItem('theme', newTheme);

            // Reload the page to apply the new theme
            window.location.reload();
        }

        // Apply the saved theme from localStorage when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.body.classList.add(savedTheme + '-mode');
            document.querySelector('.main-content').classList.add(savedTheme + '-mode');

            // Set the toggle switch state based on the saved theme
            const themeSwitch = document.getElementById('theme-switch');
            if (savedTheme === 'dark') {
                themeSwitch.checked = true;
            } else {
                themeSwitch.checked = false;
            }
        });
    </script>
    <?php } ?>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo" onclick="toggleSidebar()">Admin Panel</div>
        <ul>
            <li><a href="index.php"><i class="fa fa-home"></i> <span>Home</span></a></li>
            <li><a href="settings.php"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
            <li><a href="payment.php"><i class="fa fa-credit-card"></i> <span>Payment Gateway</span></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Settings</h1>
        <p>Configure your application settings here.</p>
        <hr>
        <form>
            <label for="username">Username:</label>
            <input type="text" id="username" value="<?php echo htmlspecialchars($_SESSION['organization']); ?>" disabled>
            <br><br>
            <label for="password">Change Password:</label>
            <input type="password" id="password" placeholder="Enter new password">
            <br><br>
            <button type="submit">Save Changes</button>
        </form>
        <hr>
        <div class="theme-toggle">
            <label for="theme-switch">Dark Mode</label>
            <label class="switch">
                <input type="checkbox" id="theme-switch" onchange="toggleTheme()">
                <span class="slider"></span>
            </label>
        </div>
        <a href="../logout.php">Logout</a>
    </div>

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>