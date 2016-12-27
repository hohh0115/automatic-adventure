<?php 
	error_reporting(E_ALL ^ E_NOTICE);
	require_once 'productupload/sqlconnect.class.php';
	$db = new sqlconnect;
	$GLOBALS['sqlconnect'] = $db;
	//下列的值來自於ajaxValidation.js的Ajax
	$username = $_POST['username'];
	$useremail = $_POST['useremail'];
	$userpassword = $_POST['userpassword'];
	$retype_password = $_POST['retype_password'];
	//如果哪個值有被傳送過來(isset)，則用那個函式
	if (isset($username)) {
		ajaxUserName($username);
	}
	if (isset($useremail)) {
		ajaxUserEmail($useremail);
	}
	if (isset($userpassword) && !isset($retype_password)) {
		checkUserPass($userpassword);
	}
	if (isset($userpassword) && isset($retype_password)) {
		check_retype_password($userpassword,$retype_password);
	}
	
	function ajaxUserName($name) {
    	$namelength = strlen($name);
    	$usersql = "SELECT useremail FROM users WHERE username='$name'";
    	$result = mysqli_query($GLOBALS['sqlconnect']->conn, $usersql);
    	$counts = mysqli_num_rows($result);

    	if ($namelength < 3 && $namelength > 0) {
    		echo json_encode(array("status"=>"false","text"=>"長度太短囉"));
    	} elseif ($namelength > 10) {
    		echo json_encode(array("status"=>"false","text"=>"太長了...❤"));
    	} elseif ($counts > 0) {
			echo json_encode(array("status"=>"false","text"=>"此名稱已經被使用了"));
		} else { //為了愛心效果，故意設定為special
			echo json_encode(array("status"=>"special","text"=>"如果是你...我可以唷...❤"));
		}  
	}

	function ajaxUserEmail($email){
		$emailValid = filter_var($email,FILTER_VALIDATE_EMAIL);

		$sql = "SELECT useremail FROM users WHERE useremail='$email'";
		$result = mysqli_query($GLOBALS['sqlconnect']->conn, $sql); 
		$counts = mysqli_num_rows($result);
		if (!$emailValid){
	  		echo json_encode(array("status"=>"false","text"=>"格式不正確喔"));
	  	} elseif ($counts > 0) {
		    echo json_encode(array("status"=>"false","text"=>"已經被註冊過了"));
		} else {
	  		echo json_encode(array("status"=>"true","text"=>"可以使用"));
	  	}
	}

	function checkUserPass($password){
		if (strlen($password) < 6 && strlen($password) > 0) {
			echo json_encode(array("status"=>"false","text"=>"長度太短囉"));
		} elseif (strlen($password) > 10) {
    		echo json_encode(array("status"=>"false","text"=>"太長了...❤..."));
    	} elseif (!preg_match("/^[a-zA-Z]/", $password)){
			echo json_encode(array("status"=>"false","text"=>"密碼開頭請用英文字母"));
		} else {
			echo json_encode(array("status"=>"true","text"=>"通過驗證"));
		}

	}
	function check_retype_password($password,$retype_password){
		if ($password == $retype_password) {
			echo json_encode(array("status"=>"true","text"=>"兩次輸入一樣"));
		} else {
			echo json_encode(array("status"=>"false","text"=>"兩次輸入內容不同"));
		}
	}
 ?>