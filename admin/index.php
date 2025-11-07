
<?php 
require_once("../resources/Config.php");

require_once('../config/pdo_db.php');
require_once('../Models/User.php');

?>

<?php $page = 'index'; include(TEMPLATE_FRONT . DS . "admin_header.php");


$user_id = $_SESSION['ID'];
$organization = $_SESSION['organization'];
$result = mysqli_query($connection, "SELECT * FROM user WHERE organization = '{$organization}'");
$row = mysqli_fetch_array($result); 
$expiryDate = $row['subscription_expiry']; 
$daysLeft = (strtotime($expiryDate) - time()) / (60 * 60 * 24);

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
  body {
     background-color: <?php echo $_SESSION['theme']; ?>;
     font-family: Arial; padding: 20px; 
/*      background: #f4f4f4;*/
        }

</style>
  <div class="main-wrapper">

        <div class="page-wrapper">
            <div class="content">

 <a href="export-present" id="export-to-excel" class="btn btn-primary btn-rounded"><i class="fa fa-upload"></i> Export Database</a> 

        
<form action="" method="post">
<div class="table-responsive">  

<?php $date = date('F j, Y', strtotime('sunday last week')); ?>
<div style="text-align: center; color: white; font-size: 24px"><span><?php echo 'Users'?></span></div>
                    <table class="table table-border table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Full Name</th> 
                                        <th></th>
                                        <th>Email</th>
                                        <th></th>
                                        <th>Organization</th> 
                                        <th></th>
                                        
                                    </tr>
                                </thead>        
<?php
            
 if($_SERVER['REQUEST_URI'] == "/refactored_avatar/admin/index" || $_SERVER['REQUEST_URI'] == "/refactored_avatar/admin/index" || $_SERVER['REQUEST_URI'] == "/refactored_avatar/admin/index.php" || $_SERVER['REQUEST_URI'] == "/refactored_avatar/admin/index.php"){         
 ?>
       
       <?php if ($daysLeft < 0): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border: 1px solid #f5c6cb; margin-bottom: 20px;">
            Your subscription has expired. <a href="pay.php">Renew now</a> to regain access.
        </div>
    <?php elseif ($daysLeft <= 3): ?>
        <div style="background-color: #fff3cd; color: #856404; padding: 15px; border: 1px solid #ffeeba; margin-bottom: 20px;">
            Your subscription will expire in <?php echo ceil($daysLeft); ?> day(s). <a href="pay.php">Please renew to continue enjoying services.</a>.
        </div>
    <?php endif; ?>
    
    <input type="text" name="searchKeyword" placeholder="Enter your search keyword" id="search">
    <div class="tilting"></div>
                                 <tbody id="output">
                                    <tr>


<!-- HTML form for the search bar -->


<?php
$organizationName = $_SESSION['organization'];

$user = new User;
$admin = "admin";

$rows = $user->countorganization($organizationName);
if ($rows <= 0) {
//$limit = pagination(1);  
}else{
//$limit = pagination($rows);  
$limit = "3";  
}

$result = $user->Getusers($organizationName,$limit);

foreach($result as $row) {

$fullname = ucwords($row->FullName);
$email = ucwords($row->email);
$organization = $row->organization;
    
$encoded_id = base64_encode($user_id);

?>
                                <td><a href='report?user=<?php echo $encoded_id; ?>'><?php echo $fullname ?></a></td>
                                
                                    <td><a href='?'></a></td>
                                         <!-- style="margin-left: 28px;" -->
                                 <td> <span > <?php echo $email ?></span></td>

                                    <td></td>                            
                                    <td><span > <?php echo $organization ?></span></td>                            
                                    <td></td>                            
                      
                                    </tr>
                 <?php } ?>       

                             
                                
                                </tbody>    
       

<?php 
                
 }
?>
    


                            </table>




                        </div>

                        </form>

                <?php if(isset($_SESSION['page'])){echo $_SESSION['page'];} ?>


            </div>


</div>

</div>
      


    <div class="sidebar-overlay" data-reff=""></div>                    
    

<?php #include(TEMPLATE_FRONT . DS . "footer.php") ?>

<?php #include(TEMPLATE_FRONT . DS . "footer.php") ?>
    <script src="../assets/js/jquery-3.2.1.min.js"></script>
	<script src="../assets/js/popper.min.js"></script>
     <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.js"></script> 
   <script src="../assets/js/app.js"></script>
<!-- JavaScript/jQuery code for AJAX request -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


  $(document).ready(function(){
    $("#search").keypress(function(){
        var search = $("#search").val();
      $.ajax({
        type:'POST',
        url:'search.php',
        data:{
          name:$("#search").val(),

        },
        success:function(data){
          $("#output").html(data);
          $(".tilting").html('<a href="export?data='+ encodeURIComponent(search) +'" class="btn btn-primary"><i class="fa fa-upload"></i> Export Searched Query</a>');
          // $(".tilting").html("http://localhost/Office-Attendance/public/admin/export" + data);


        }
      });
    });
  });

</script>
<script type="text/javascript">
$(document).ready(function(){

jQuery('#export-to-excel').bind('click', function(){

var target = $(this).attr('id');
// alert(target);
switch(target){
    case  'export-to-excel' :
    $('#hidden-type').val(target);
    $('#export-form').submit();
    break;
}

});
    });

</script>
  


 

