<?php 
$page_title = "leaderboard";
include 'navigation.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>onlinemall</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="stylesheets/_leaderboard.css">
</head>
<body>
  <div class="container">
    <?php include '_sidenav.php'; ?>
    <!-- Carousel -->
    <?php include '_myCarousel.php'; ?>
        <div class="col-xs-12 col-lg-8 col-sm-9"></div> 
          <h2 class="chart">專輯排行榜<small>依照滾石雜誌榜單排序，唯跳過同演出者的較低順位專輯。</small></h2>
          <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>專輯名稱</th>
                  <th>出版年份</th>
                  <th>演出者</th>
                </tr>
              </thead>
              <?php 
              $result = mysqli_query($db->conn, CATEGORY);
              while ($rows = mysqli_fetch_assoc($result)) { 
              $year = explode(" ", $rows['releaseddate']); 
              ?>
              <tbody>
                <tr>
                  <th scope="row"><?php echo $rows['ranking']; ?></th>
                  <td class="albumname"><?php echo '<a href="_content.php?viewalbum&productid='.$rows['productid'].'">'.$rows['productname'].'</a>'; ?></td>
                  <td><?php echo $year[2]; ?></td>
                  <td><?php echo $rows['singer']; ?></td>
                </tr>
              </tbody>
            <?php
            }  
              ?>
            </table>
        <div class="col-xs-6 col-lg-4">
          <!--
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
          -->
        </div><!--/.col-xs-6.col-lg-4-->
      </div><!--/.col-xs-12.col-sm-10-->
    </div> <!--/row-offcanvas-->
      <footer class="downfooter">
        <p class="float-xs-right"><a href="#">Back to top</a></p>
        <p class="text-muted">About Music Company.轉載必究.營業時間：週二至週日 1100~21:00.</p>
      </footer>
  </div> <!--/container-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://getbootstrap.com/examples/offcanvas/offcanvas.js"></script>
</body>
</html>
