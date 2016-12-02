<?php 
define('CATEGORY', 'SELECT productid,singer,category,productname,releaseddate,ranking FROM product ORDER BY ranking'); 
?>
    <div class="row row-offcanvas row-offcanvas-left">
      <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
        <div class="list-group">
          <div class="dropdown">
            <a class="list-group-item">從歌手找專輯：</a>
              <a class="list-group-item" data-toggle="dropdown" href="#">男歌手一覽<span class="caret"></span></a>
              <ul class="dropdown-menu">
              <?php 
              $category = mysqli_query($db->conn, CATEGORY);
              while ($rows = mysqli_fetch_assoc($category)) { 
                if ($rows['category'] == "male") { 
                ?>
                <li><?php echo'<a href="_content.php?viewalbum&productid='.$rows['productid'].'">'.$rows['singer'].'</a>'; ?></li>
              <?php
                }
              }
                ?>
              </ul>
          </div>        
          <div class="dropdown">
            <a class="list-group-item" data-toggle="dropdown" href="#">女歌手一覽<span class="caret"></span></a>
              <ul class="dropdown-menu">
              <?php
              $category = mysqli_query($db->conn, CATEGORY);
              while ($rows = mysqli_fetch_assoc($category)) { 
                if ($rows['category'] == "female") { 
                ?>
                <li><?php echo'<a href="_content.php?viewalbum&productid='.$rows['productid'].'">'.$rows['singer'].'</a>'; ?></li>
              <?php
                }
              }
                ?>
              </ul>
          </div>
          <div class="dropdown">
            <a class="list-group-item" data-toggle="dropdown" href="#">團體區<span class="caret"></span></a>
              <ul class="dropdown-menu">
              <?php 
              $category = mysqli_query($db->conn, CATEGORY);
              while ($rows = mysqli_fetch_assoc($category)) { 
                if ($rows['category'] == "band") { 
                ?>
                <li><?php echo'<a href="_content.php?viewalbum&productid='.$rows['productid'].'">'.$rows['singer'].'</a>'; ?></li>
              <?php
                }
              }
                ?>
              </ul>
          </div>
        </div>
      </div> <!--/.sidebar-offcanvas-->
      <p class="pull-left visible-xs">
        <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">快速導覽</button>
      </p>



