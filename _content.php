<!DOCTYPE html>
<html lang="en">
<head>
  <title>content</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="stylesheets/content.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<?php 
$page_title = "index";
include 'navigation.php';

if (isset($_GET['productid']) == "") {
  header('Location: index.php'); //不會直接進入_content.php
} else {
    $sql = 'SELECT * FROM product WHERE productid = '.$_GET['productid'];
    $result = mysqli_query($db->conn, $sql); 
    $rows = mysqli_fetch_assoc($result);
    if ($_GET['productid'] !== $rows['productid']) {
      header('Location: index.php'); //防範直接更改URL進入不存在的商品頁
    }
  }

 ?>
<body>
  <div class="container maincontent">
    <div class="row">
      <div class="col-lg-10">
      <?php
      $sql = 'SELECT * FROM product WHERE productid = '.$_GET['productid'];
      $result = mysqli_query($db->conn, $sql); 
      while($rows = mysqli_fetch_assoc($result)){ //開始重複讀取
      ?>  
        <ul class="nav nav-tabs">
          <li class="active"><a href="#a" data-toggle="tab" onclick="myfunction('first')">內容簡介</a></li>
          <li><a href="#b" data-toggle="tab" onclick="myfunction('second')">作者介紹</a></li>
          <li><a href="#c" data-toggle="tab" onclick="myfunction('third')">專輯曲目</a></li>
        </ul>
        <img id="img" class="img-rounded img-responsive" <?php echo 'src="http://'.$_SERVER['SERVER_NAME'].'/CodeIgniter-productupload/uploads/files/'.$rows['productimage'].'" alt="">'; ?>
        <div class="tab-content">  
          <div class="tab-pane active" id="a">
            <p><?php echo $rows['description']; ?></p>
            <hr>
            <p><?php echo $rows['fulldescription']; ?></p>
          </div> <!--end of tab-pane-->
          <div class="tab-pane" id="b">
            <p><?php echo $rows['singersdoc']; ?></p>
          </div> <!--end of tab-pane-->
          <div class="tab-pane" id="c">
              <h2>Track Listing</h2>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Title</th>
                    <th>Length</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $songname = explode("`", $rows['songname']); //陣列資料中的字串變成陣列
                    $time = explode("`", $rows['time']);
                    for ($i=0; $i < count($songname); $i++) { 
                      $No = $i + 1;
                      echo "<tr><td>".$No."</td><td>".$songname[$i]."</td><td>".$time[$i]."</td></tr>";
                    }
                    ?>
                    <tr>
                    <td align="right" colspan="2">
                      <div style="width: 7.5em; text-align: left; padding-left: 10px; margin: 0;"><b>Total length:</b></div>
                    </td>
                    <?php //以下開始計算total length
                    $time = explode("`", $rows['time']);
                    $time = array_map('trim', $time);  
                    for ($i=0; $i < count($time); $i++) {
                      $time_part[] = explode(":", $time[$i]);
                      $minute[] = (int)$time_part[$i][0];
                      $second[] = (int)$time_part[$i][1];
                      $total_minute += $minute[$i];
                      $total_second += $second[$i];
                    }
                    $total_minute += (int)($total_second/60);
                    $total_second = $total_second % 60;
                    $total_time = $total_minute.':'.$total_second;
                    echo '<td>'.$total_time.'</td>';?>
                    </tr>
                </tbody>
              </table>
              <h2>隨選專輯曲目試聽</h2>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>曲目名稱</th>
                    <th>來自專輯</th>
                    <th>試聽連結</th>
                  </tr>
                </thead>
                <tbody>
              <?php
              $linksql = "SELECT * FROM hyperlink ORDER BY RAND() LIMIT 5";
              $linkresult = mysqli_query($db->conn, $linksql);
              while($hyperrows= mysqli_fetch_assoc($linkresult)){
              ?>         
                 <tr>
                    <td><?php echo '"'.$hyperrows['songname'].'"' ?></td>
                    <td><i><?php echo '<a href="_content.php?viewalbum&productid='.$hyperrows['productid'].'">'.$hyperrows['albumname'] ?></i></td>
                    <td><button id=<?php echo '"showvideo'.$hyperrows['id'].'"' ?> class="btn btn-xs btn-primary">Live Performace</button></td>
                  </tr>
                  <script>
                  $('#showvideo<?php echo $hyperrows['id'] ?>').click(function(){
                  $('#myModal .modal-title').html('Live Performace');
                  $('#myModal .modal-body').html('<p>It may take some time loading the video</p><div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" width="560" height="315" src="<?php echo $hyperrows['hyperlink'] ?>" frameborder="0" allowfullscreen></iframe></div>');
                  $('#myModal').modal('show');
                  });
                  </script>
              <?php } ?>    
                </tbody>
              </table> 
          </div> <!--end of tab-pane-->
        </div> <!--end of tab-content--> 
      </div>
      <div class="col-lg-2 sidebar">
          <div class="sidebar-module sidebar-module-inset">
            <h4>商品訊息</h4>
            <p>演出者: <?php echo $rows['singer']; ?></p>
            <p>唱片公司: <?php echo '<br>'.$rows['labelcompany']; ?></p>
            <p>發行日期: <br> <?php echo $rows['releaseddate']; ?></p>
            <p>專輯售價: <?php echo $rows['productprice'] ?></p>
            <br>
            <div class="buyGroup">
            <?php  //有登入的會員的情況下
            if (isset($_SESSION['user'])) {
              echo '<a href="addtocart.php?A=Add&productid='.$rows['productid'].'&name='.$rows['productname'].'&price='.$rows['productprice'].'" class="btn btn-warning">' ;
            } else {
              echo '<a id="pop" class="btn btn-warning">';
            }
              echo '<span class="glyphicon glyphicon-shopping-cart"></span>  加入購物車 &raquo;</a>';   
            ?>
            <button type="button" class="btn btn-info btn-space sharebtn" onclick="xxxxfunction()">和大家分享</button>
            </div>
          </div>
      </div> <!--end of sidebar-->
    </div> <!--end of row-->
    <footer class="downfooter">
        <p class="float-xs-right"><a href="#">Back to top</a></p>
        <p class="text-muted">About Music Company.轉載必究.營業時間：週二至週日 1100~21:00.</p>
        </footer>
  </div> <!--end of container-->

<!-- Modals that pop up the video-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-di-->
<script>//Changing Images
  function myfunction(img_tracker){
        if (img_tracker == 'first'){
          img.style.display = "block" ;
          <?php echo 'img.src="http://localhost/CodeIgniter-productupload/uploads/files/'.$rows['productimage'].'";'; ?>
          img.style.width = "300px" ;
        } else if (img_tracker =='second'){
          img.style.display = "block" ;
          <?php echo 'img.src="http://localhost/CodeIgniter-productupload/uploads/files/'.$rows['singerphoto'].'";'; ?>
          img.style.width = "320px" ;
        } else if (img_tracker == 'third') {
          img.style.display = "none" ;
        }
      }
<?php 
}
?>
//Switching Videos
  $('#pop').click(function(){
    $('#myModal .modal-title').html('Oops!');
    $('#myModal .modal-body').html('<p>請先註冊/登入會員，才可使用購物車功能喔!</p>');
    $('#myModal').modal('show');
    });
//Make the video stop when a modal is closed
  $('#myModal').on('hidden.bs.modal', function () {
    $('#myModal .modal-body').html(''); 
  }); 
  </script>
</body>
</html>