<!DOCTYPE html>
<html>
<head>
	<title>guestbook.php</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="stylesheets/guestbook.css">
	<?php 
	$page_title = "guestbook";
	include 'navigation.php';
	include '_page.class.php';
	$name = $userrows['username'];
	$tbl_name = "guestbook";
	?>
</head>
<body>
<div id="wrap">
<div id="main" class="container">
    <div class="row board">
    	<?php if (isset($_SESSION['user'])) {
   		?>
   		<div class="col-sm-4 col-md-4 col-lg-4">
            <div class="panel panel-default">
                <div class="panel-body" id="resizable">         
                    <form accept-charset="UTF-8" <?php echo "action='_guestbookhandle.php?user=".$name."'" ?> method="POST" >
                    	<span class="input-group-addon" style="border-radius: 4px; border-right: solid 1px #ccc;">
                          <i class="glyphicon glyphicon-user"> 
                          <?php echo $name; ?></i>
                        </span>
                        <textarea id="textarea" class="form-control counted" name="comment" placeholder="我有話想說" rows="6" style="margin-bottom:10px; margin-top: 5px;"></textarea>
                        <h6 class="pull-right" id="counter">320 characters remaining</h6>
                        <input type="submit" class="btn btn-lg btn-primary btn-block" name="submitbtn" value="留言" style="margin-top: 20px">
                    </form>
                </div>
            </div>
        </div>
        <?php
        } else {
        ?>
        <div class="col-sm-4 col-md-4 col-lg-4 col-lg-offset-4 btn-info">小提醒：只有會員能在此留言喔</div>
        <?php
        }
        ?>
    	<div class="col-sm-8 col-md-8 col-lg-8 <?php echo isset($_SESSION['user']) ? "": "col-lg-offset-2"; ?>">
    	<?php
    		$pagesql = "SELECT * FROM $tbl_name ORDER BY id";//先查詢所有資料
			$pageresult = mysqli_query($db->conn, $pagesql); //check
			$num_rows = mysqli_num_rows($pageresult);
			$nums = 5;
			$page = new Page($num_rows, $nums);
			$start = ($page->cpage - 1)*$nums;
			$pagesql = "SELECT * FROM `guestbook` ORDER by datetime DESC LIMIT $start, $nums";
			$pageresult = mysqli_query($db->conn, $pagesql);
			while($rows=mysqli_fetch_array($pageresult)){
		?>
    		<table class="table table-bordered table-responsive" style="border:solid; border-color: #FF5454; word-wrap: break-word; word-break: break-all;">
			    <tr>
			    	<td>
				      	<table class="table table-hover">
				      		<tr>
					        	<td class="col-md-2">編號</td>
					        	<td>:</td>
					        	<td><?php echo $rows['id']; ?></td>
					        </tr>
					        <tr>
					        	<td class="col-md-2">會員名稱</td>
					        	<td>:</td>
					        	<td><?php echo $rows['name']; ?></td>
					        </tr>
					        <tr>
					        	<td valign="top">內容</td>
					        	<td valign="top">:</td>
					        	<td><?php echo $rows['comment']; ?></td>
					      	</tr>
					      	<tr>
							<td valign="top">日期 </td>
							<td valign="top">:</td>
							<td><?php echo $rows['datetime']; ?></td>
							</tr>
				    	</table>
					</td>
				</tr>
			</table>
		<?php
		}
		?>
    	</div>
	</div> <!--end of row-->
		<ul class="pagination pull-right">
		<?php 
			echo $page -> fpage(4,5,6); 
		?>
		</ul>
		<footer class="downfooter">
        <p class="float-xs-right"><a href="#">Back to top</a></p>
        <p class="text-muted">About Music Company.轉載必究.營業時間：週二至週日 1100~21:00.</p>
        </footer>
</div> <!--end of container-->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="javascript/charcount.js"></script>
</body>
</html>
