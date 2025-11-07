<?php 
session_start();
// Create connection
$conn = mysqli_connect("localhost", "root", "", "avatar");
$date = date('F j, Y', strtotime('sunday last week'));
$organization = $_SESSION['organization'];

if (isset($_POST['name'])) {
	
$sql = "SELECT * FROM user WHERE organization = '{$organization}' AND FullName  LIKE '%".$_POST['name']."%'  ";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)>0){
	while ($row=mysqli_fetch_assoc($result)) {
$fullname = $row['FullName'];
$email = $row['email'];
$organization = $row['organization'];

		echo "	<tr>
		          <td><a href='?'>".$fullname."<a></td>
		          <td></td>
		          <td>".$email."</td>
		          <td></td>
		          <td>".$organization."</td>
                  <td></td>

	
		        </tr>";
	}
}else{
	echo "<tr>
	<td>No result found</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	</tr>";
}


}



?>