
<?php require_once("../resources/Config.php"); ?>

<?php $page = 'style'; include(TEMPLATE_FRONT . DS . "admin_header.php") ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  // Hide the session message after 3 seconds (3000 milliseconds)
  setTimeout(function() {
    $('.session-message').fadeOut('slow', function() {
      // Remove the message element from the DOM
      $(this).remove();
    });
  }, 10000);
});
</script>



   <div class="page-wrapper">

<?php
            
 if($_SERVER['REQUEST_URI'] == "/office-attendance/public/admin/index" || $_SERVER['REQUEST_URI'] == "/Office-Attendance/public/admin/index" || $_SERVER['REQUEST_URI'] == "/Office-Attendance/public/admin/index.php" || $_SERVER['REQUEST_URI'] == "/Office-Attendance/public/admin/index.php"){         
 



                                           
?>

<!-- Display the session message -->
<div class="session-message">
  <?php
  // Check if the session message exists and display it
  if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    // Unset or clear the session message
    unset($_SESSION['message']);
  }
  ?>
</div>

<?php 
 include(TEMPLATE_FRONT . DS . "admin_main.php");
                
 }
?>
    
    </div>

<?php #include(TEMPLATE_FRONT . DS . "footer.php") ?>

<?php #include(TEMPLATE_FRONT . DS . "footer.php") ?>
    <script src="../assets/js/jquery-3.2.1.min.js"></script>
	<script src="../assets/js/popper.min.js"></script>
     <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.js"></script> 
   <script src="../assets/js/app.js"></script>

