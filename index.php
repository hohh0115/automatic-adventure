<!DOCTYPE html>
<html>
<head>
  <title>About Music</title>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/index.css">
</head>
<body>
<?php 
$page_title = "index";
include 'navigation.php'; 
 ?>
<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container headContainer">
        <h1 class="display-3" style="text-align: center;">About Music</h1>
        <blockquote>
          <h2>Play it fuckin' loud!</h2>
          <footer>Bob Dylan</footer>
        </blockquote>
      </div>
    </div>
	<div class="container marketing">
		<h1>專輯一覽</h1>
      		<div class="row">
            <?php 
            $sql = "SELECT * FROM `product` ORDER BY productid";
            $result = mysqli_query($db->conn, $sql); 
            while($rows=mysqli_fetch_array($result)){ //開始重複讀取
            ?>
        <div class="col-lg-4 col-sm-6">
    			<?php
    			if($rows['productimage'] != ""){
    				$pic = $rows['productimage'];
    				echo '<img class="albumcover img-rounded" src="./productupload/uploadedimg/'.$pic.'" alt="Generic placeholder image">';
    			}
    			?>
          	<h2><i><?php echo $rows['productname']; ?></i></h2>
          	<p><?php echo $rows['description']; ?></p>
            <?php 
            if (isset($_SESSION['user'])) {
              echo '<a href="addtocart.php?A=Add&productid='.$rows['productid'].'&name='.$rows['productname'].'&price='.$rows['productprice'].'" class=\'btn btn-warning\'>' ;
              echo '<span class="glyphicon glyphicon-shopping-cart"></span>  加入購物車 &raquo;</a>';
            }
            ?>
            <?php  
          	echo '<p class="detailbtn"><a class="btn btn-default" href="_content.php?viewalbum&productid='.$rows['productid'].'" role="button">詳細介紹 &raquo;</a></p>' ;
            ?>
        </div><!-- /.col-lg-4 -->
<?php 
} //while結束 php結束
 ?> 
        </div> <!--end of row-->

<!-- START THE FEATURETTES -->
      <hr class="featurette-divider">
      <div class="row featurette">
        <div class="col-md-6 col-md-push-3">
          <h1>500 Greatest Albums of All Time</h1>
          <h1><small>It'll blow your mind.</small></h1>
          <p class="lead">美國《滾石》雜誌於2003年11月發行的特刊，2012年榜單再度更新，加入了二十世紀後才發行的專輯，收錄了38張先前未入選的專輯。</p>
          <hr>
          我們以2003年的榜單為準，選出十位不同演出者中，他們最高排名的專輯，這些專輯跟演出者對世界各地流行文化的塑造都貢獻許多，也影響了每一個世代的民眾；在上世紀那戰爭跟意識形態嚴重對立的年代裡，有著對時事針砭的發聲者，也有能一語破的人生中甜苦滋味的觀察家，如此豐富的內容就寫在音律之中，作為傾聽者的我們，不能忘記那風雨飄渺的年代，也不應該遺忘潛藏在歌曲中的豐厚情感。</p>
        </div>
      </div>      
      <!-- /END THE FEATURETTES -->
        <!-- FOOTER -->
        <footer class="downfooter">
        <p class="float-xs-right"><a href="#">Back to top</a></p>
        <p class="text-muted">About Music Company.轉載必究.營業時間：週二至週日 1100~21:00.</p>
        </footer>
	</div><!-- /.container -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>