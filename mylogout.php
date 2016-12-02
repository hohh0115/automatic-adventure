<?php
 session_start();

 $link = $_SESSION['position']; 
 $ifincar =explode("/", $link);//如果在cart.php登出，請跳轉至首頁

 if (!isset($_SESSION['user'])) {
  header('Location: index.php'); 
 } else if(isset($_SESSION['user'])!="") {
  header('Location: index.php');
 }

 if (isset($_GET['logout'])) {
  unset($_SESSION['user']);
  //session_destroy(); 不用刪掉所有的session 所以註解掉 我要保留購物車的商品
  if ($ifincar[3] == "cart.php") {
  	header('Location: index.php');  
  	exit;
  } else {
  	header('Location: '.$link);
  	exit;
  }
 }
 ?>