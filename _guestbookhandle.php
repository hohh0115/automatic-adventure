<?php 
require_once 'productupload/sqlconnect.class.php';
$db = new sqlconnect;
$tbl_name = "guestbook";
if (!isset($_POST['submitbtn'])) {
	header("Location:_guestbook.php");
}
if (isset($_POST['submitbtn'])) {
	$name = $_GET['user'];
	$comment = $_POST['comment'];
	$datetime=date("Y-m-d h:i:sa"); //date time
	$commentsql = "INSERT INTO $tbl_name(name,comment,datetime) VALUES('$name', '$comment', '$datetime')";
	$commentres = mysqli_query($db->conn, $commentsql);
	header("Location:_guestbook.php");
}
?>
