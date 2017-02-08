<?php 
session_start();
error_reporting(E_ALL ^ E_NOTICE);
if( isset($_SESSION['user']) != "" ){
  header("Location: index.php");
}
require_once 'productupload/sqlconnect.class.php';
$db = new sqlconnect;
$error = false ;
if (isset($_POST['submitBtn'])) {
  $useremail = trim($_POST['useremail']);
  $useremail = strip_tags($useremail);
  $useremail = htmlspecialchars($useremail);
  $useremail = mysqli_real_escape_string($db->conn, $useremail);

  $password = trim($_POST['userpassword']);
  $password = strip_tags($password);
  $password = htmlspecialchars($password);
  $password = mysqli_real_escape_string($db->conn, $password);

  if (empty($useremail)) {
    $error = true;
    $emailError = "請填入電子信箱!";
  } else if ( !filter_var($useremail,FILTER_VALIDATE_EMAIL) ) {
    $error = true;
    $emailError = "請填入正確格式的電子信箱!";
  }

  if (empty($password)) {
    $error = true;
    $passwordError = "請填入會員密碼!";
  } else if (strlen($password) < 6){
    $error = true;
    $passwordError = "密碼最少有六個字符!";
  }
  if (!$error) {
    $password = hash('sha256', $password);
    $sql = "SELECT * FROM users WHERE useremail='$useremail'" ;
    $result = mysqli_query($db->conn, $sql);
    $count = mysqli_num_rows($result);
    $rows = mysqli_fetch_assoc($result);
    if ($count == 1 && $rows['userpassword'] == $password) {
      $_SESSION['user'] = $rows['userid'];
      $type = "success";
      $message ="登入成功，三秒後跳至登入前頁面。";
      header("refresh:3;url=". $_SESSION['position']);
    } else {
      $type = "danger";
      $message = "登入失敗，是否輸入錯誤?";
    }
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

    <title>Signin Template for Bootstrap</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- Custom styles for this template -->
    <link href="stylesheets/mylogin.css" type="text/css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
    <div class="row">
      <div class="col-sm-6 col-md-4 col-md-offset-4">
        <div class="panel panel-default topmargin">
          <div class="panel-heading">
            <strong> 會員登錄 </strong>
          </div>
          <div class="panel-body">
            <form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ;?>" method="POST" autocomplete="off">
              <fieldset>
                <div class="row">
                  <div class="center-block">
                    <?php 
                      if (isset($message)) { 
                      //如果登入成功，顯示以下
                    ?>
                    <div class="form-group">
                      <div class="alert alert-<?php echo $type=="success" ? "success" : "$type" ;?>">
                        <span class="glyphicon glyphicon-info-sign"></span>
                      <?php echo $message; ?>
                      </div>
                    </div>
                    <?php 
                      }
                    ?>         
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-md-10 col-md-offset-1 ">
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span> 
                        <input class="form-control" placeholder="電子信箱" name="useremail" type="text" autofocus>
                      </div>
                        <span class="text-danger"><?php echo $emailError; ?></span>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-lock"></i>
                        </span>
                        <input class="form-control" placeholder="會員密碼" name="userpassword" type="password" value="">
                      </div>
                        <span class="text-danger"><?php echo $passwordError; ?> </span>
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-lg btn-primary btn-block" name="submitBtn" value="登入">
                    </div>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
          <?php
            if ( isset($message) && $type == "success" ) {
          ?>
            <div class="panel-footer ">
            <p style="text-align:center;"><a href="index.php" onClick="">&nbsp;直接跳至首頁</a></p>
            </div>
          <?php
            } else { 
          ?>
            <div class="panel-footer ">
            <p style="text-align:center;">還不是會員嗎? <a href="myregisterwithAJAX.php" onClick="">&nbsp;按我註冊</a></p>
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
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="https://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
