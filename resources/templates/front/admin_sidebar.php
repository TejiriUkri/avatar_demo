    
     <style>

      

          .toggle-container {
            display: inline-block;
            position: absolute;
            width: 60px;
            height: 34px;
            top:93%;
            right: 10px;  
        }

        .toggle-container input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

    </style>

<?php 
$user_id = $_SESSION['ID'];
$stmt = mysqli_query($connection, "SELECT theme FROM user WHERE user_id = '{$user_id}'");

$row = mysqli_fetch_array($stmt);
$_SESSION['theme'] = $row['theme'];


?>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">Main <?php echo $_SESSION['theme'];?></li>
                        <!-- class="active" -->
                        <!-- <li> -->
                        <li class="<?php if($page =='index'){ echo 'active';}?>"> 
                            <a href="index"><i class="fa fa-home"></i> <span>Dashboard</span></a>
                        </li>     
                        <li class="<?php if($page =='image'){ echo 'active';}?>">
                            <a href="backgroundImage"><i class="fa fa-file-image-o"></i> <span>Change Background Image</span></a>

                        </li>

                        <li class="<?php if($page =='pay'){ echo 'active';}?>">
                            <a href="pay"><i class="fa fa-credit-card"></i> <span>Payment Gateway</span></a>
                        </li>


                        <li class="<?php if($page =='style'){ echo 'active';}?> disabled">
                            <a href="backgroundStyle"><i class="fa fa-picture-o"></i> <span>Background Style</span></a>
                        </li>
      
                    </ul>
                </div>
   <form id="theme-form" action="theme.php" method="POST">
   <label class="toggle-container">
        <input type="checkbox" id="theme-toggle" name="theme" <?php if ($_SESSION['theme'] == 'black') echo 'checked'; ?>>
        <span class="slider"></span>
    </label>
    </form>
    <script>
        // JavaScript for toggling the theme
        document.getElementById('theme-toggle').addEventListener('change', function () {
            const isChecked = this.checked;
            const newTheme = isChecked ? 'black' : 'white';
            const xhr = new XMLHttpRequest();

            // Send the new theme to the server
            xhr.open('POST', 'theme.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Update the background color immediately
                    document.body.style.backgroundColor = newTheme;
                }
            };
            xhr.send('theme=' + newTheme);
            isChecked.submit();
        });
    </script>

                
                
                
            </div>
        </div>