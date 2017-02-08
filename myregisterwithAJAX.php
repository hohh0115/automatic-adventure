<?php 
session_start();
error_reporting(E_ALL ^ E_NOTICE);
if( isset($_SESSION['user'])!=""){
  header("Location: index.php");
}
require_once 'productupload/sqlconnect.class.php';
$db = new sqlconnect;
if (isset($_POST['singupBtn'])) {
  $username = trim($_POST['username']);
  $username = strip_tags($username);
  $username = htmlspecialchars($username);
  $username = mysqli_real_escape_string($db->conn, $username);
  
  $useremail = trim($_POST['useremail']);
  $useremail = strip_tags($useremail);
  $useremail = htmlspecialchars($useremail);
  $useremail = mysqli_real_escape_string($db->conn, $useremail);
  
  $password = trim($_POST['userpassword']);
  $password = strip_tags($password);
  $password = htmlspecialchars($password);
  $password = mysqli_real_escape_string($db->conn, $password);

  $checkpass = trim($_POST['checkpass']);
  $checkpass = strip_tags($checkpass);
  $checkpass = htmlspecialchars($checkpass);
  $checkpass = mysqli_real_escape_string($db->conn, $checkpass);

  $password = hash('sha256', $password);

  $sql = "INSERT INTO users (username, useremail, userpassword) VALUES ('$username', '$useremail', '$password')";
  $result = mysqli_query($db->conn, $sql);
  if ($result) {
      $type = "success";
      $message = "註冊成功";
    }else {
      $type = "danger";
      $message = "出了些小狀況，可能晚點試試?";
    }
}
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sign Up System</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="stylesheets/mylogin.css">
  </head>
  <body>

    <div class="container">
      <div class="row">
      <div class="col-sm-6 col-md-4 col-md-offset-4">
        <div class="panel panel-default topmargin">
          <div class="panel-heading">
            <strong> 會員註冊 </strong>
          </div>
          <div class="panel-body">
            <form id="register_form" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" autocomplete="off">
              <fieldset>
                <div class="row">
                  <div class="center-block">
                  <?php
                    if ( isset($message) ) { //如果登入成功，顯示以下
                  ?>
                    <div class="form-group">
                      <div class="alert alert-<?php echo ($type=="success") ? "success" : $type; ?>">
                      <span class="glyphicon glyphicon-info-sign"></span> <?php echo $message; ?>
                      <?php if ($type=="success") {
                        echo "<p><strong>三秒後跳至登入畫面</strong></p>";
                        header( "refresh:3;url=mylogin.php" );
                      } ?>
                      </div>
                    </div>
                  <?php
                    }
                  ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-md-10 col-md-offset-1">
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span> 
                        <input class="form-control" placeholder="會員名稱" name="username" type="text" id="username" autofocus>
                      </div>
                      <span class="glyphicon" id="namemsg" style="margin-left: 40px;"></span>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-envelope"></i>
                        </span> 
                        <input class="form-control" placeholder="電子信箱" name="useremail" type="text" id="useremail">
                      </div>
                      <span class="glyphicon" id="emailmsg" style="margin-left: 40px;"></span>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-lock"></i>
                        </span>
                        <input class="form-control" placeholder="密碼開頭請用英文字母" name="userpassword" type="password" value="" id="userpassword">
                      </div>
                      <span class="glyphicon" id="passwordmsg" style="margin-left: 40px;"></span>
                    </div>
                      <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-lock"></i>
                        </span> 
                        <input class="form-control" placeholder="密碼再確認" name="checkpass" type="password" value="" id="retype_password">
                      </div>
                      <span class="glyphicon" id="retype_password_msg" style="margin-left: 40px;"></span>
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-lg btn-primary btn-block" name="singupBtn" value="確定註冊" id="singupBtn">
                    </div>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
          <?php
            if ( isset($message) ) {
          ?>
            <div class="panel-footer ">
            <hr>
            <p style="text-align:center;"><a href="#" onClick="">&nbsp;&nbsp;直接跳至登入頁面</a></p>
            </div>
          <?php
            } else {
          ?>   
            <div class="panel-footer ">
            <p style="text-align:center;">已經是會員了嗎? <a href="mylogin.php" onClick="">&nbsp;按我登入</a></p>
            <hr>
            <p style="text-align:center;"><a href="index.php" onClick="">&nbsp;回首頁</a></p>
            </div> 
          <?php
            }
          ?>
        </div>
      </div>
    </div>
  </div>

      <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="javascript/ajaxValidation.js"></script>
  </body>
</html>
