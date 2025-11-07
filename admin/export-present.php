<?php 
require_once("../resources/Config.php");
#protectUrl($_SESSION['church'], 'church1'); 

require_once ('../vendor/SimpleXLSXGen.php');

$name = $_SESSION['name'];
// $church = $_SESSION['church']; 

date_default_timezone_set('Africa/Lagos');
    $current_timezone = date_default_timezone_get();

    $current_month = date("F");

// absent individuals for that current month 
// status_month = '{$current_month}' 
$organization = $_SESSION['organization'];
$query = mysqli_query($connection, "SELECT * FROM user WHERE organization = '{$organization}' ");
$cellMemberDB = [
    ['Id', 'Name', 'Email', 'Organization']
];

$id = 0;
if (mysqli_num_rows($query) > 0) {
	foreach ($query as $row){


		$id++;


		$status = 'Present';
		$cellMemberDB = array_merge($cellMemberDB, array(array($id, $row['FullName'], $row['email'], $row['organization']))); 

}

}
$xlsx = Shuchkin\SimpleXLSXGen::fromArray( $cellMemberDB );
// saveAs('books.xlsx'); // or  or $xlsx_content = (string) $xlsx 
$xlsx->downloadAs('Present-Database.xlsx');
