<?php 
error_reporting(E_ALL ^ E_NOTICE);
//連結購物車
require_once('EDcart.php');
session_start();
$cart =& $_SESSION['edCart']; 
if(!is_object($cart)) $cart = new edCart(); 
//連結資料庫
require_once 'productupload/sqlconnect.class.php';
$db = new sqlconnect;
$_SESSION['position'] = $_SERVER['REQUEST_URI']; //儲存登入前頁面
?> 
<style type="text/css">
      @media (width: 768px) {
      .setting {
           margin-bottom: 50px;
      }
    </style>
<!--導覽列-->
<div class="setting">
  <nav class="navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">About Music</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class = " <?php echo $page_title == "index" ? "active" : ""; ?> "><a href="index.php">首頁</a></li>
          <li class = " <?php echo $page_title == "leaderboard" ? "active" : ""; ?> "><a href="_leaderboard.php">專輯排行榜</a></li>
          <li class = " <?php echo $page_title == "storeinfo" ? "active" : ""; ?> "><a href="_storeInfo.php">店家資訊</a></li>
          <li class = " <?php echo $page_title == "guestbook" ? "active" : ""; ?> "><a href="_guestbook.php"><span class='glyphicon glyphicon-comment'></span>  留言給我們</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
      <?php
        function generateRandomString($length = 10) {
          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength = strlen($characters);
          $randomString = '';
          for ($i = 0; $i < $length; $i++) {
              $randomString .= $characters[rand(0, $charactersLength - 1)];
          }
          return $randomString;
        }
        ?>
        <?php
        if (isset($_SESSION['user'])) { //會員登入後導覽列的改變
            $usersql = 'SELECT * FROM users WHERE userid ='.$_SESSION['user'];
            $res = mysqli_query($db->conn,$usersql);
            $userrows = mysqli_fetch_assoc($res); ?>
         <li>
          <a>歡迎!&nbsp;&nbsp;&nbsp;<span class='glyphicon glyphicon-user'></span> <?php echo $userrows['username']; ?></a>
         </li>
         <li class = "<?php echo $page_title == "cart" ? "active" : ""; ?>">
          <a href='cart.php'><span class='glyphicon glyphicon-shopping-cart'></span> 購物車 <span class='label label-default label-as-badge' id='comparison-count'><?php echo $cart->countsum ;?></span></a>
         </li>
         <li>
          <a href='mylogout.php?logout'><span class='glyphicon glyphicon-log-out'></span> 登出</a>
         </li>
         <?php
          } else {  
          ?>
          <li>
            <a href="myregister.php?page_title= <?php echo generateRandomString(); ?>"><span class="glyphicon glyphicon-user"></span> 註冊會員</a>
          </li>
          <li>
            <a href="mylogin.php?page_title=<?php echo generateRandomString(); ?>"><span class="glyphicon glyphicon-log-in"></span> 會員登入</a>
          </li>
         <?php
          }
          ?>  
        </ul>
      </div>
    </div>
  </nav>
</div>
<!--導覽列結束-->
