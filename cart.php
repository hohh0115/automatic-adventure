<?php
//加入購物車Class的宣告
$page_title = "cart";
include 'navigation.php';
if (!isset($_SESSION['user'])) {
  header('Location: index.php'); //假如已登入會員即使從網址列進入也直接跳轉
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>cart</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<link rel="stylesheet" href="stylesheets/cart.css">
</head>
<body>
	<div class="container">
		<?php include '_sidenav.php'; ?>
			<div class="col-xs-12 col-sm-9">
			<?php
				if ($cart->itemcount == 0) {
					echo "<div class='alert alert-danger'>";
				    echo "購物車內<strong>沒有商品!</strong>";
				    echo "</div>";
				} else {  
			?>
				<table class='table table-hover table-responsive table-bordered'>
					<tr style="background-color: #F5FF0F">
						<th class='textAlignLeft'>商品名稱</th>
						<th>單價</th>
						<th>數量</th>
						<th>金額</th>
						<th></th>
					</tr>
			<?php  
					foreach ($cart->get_contents() as $itemvalue) {
				?>
					<tr>
						<td>
							<?php echo '<a href="_content.php?viewalbum&productid='.$itemvalue['id'].'"><i>'.$itemvalue['info'].'</i></a>'; ?>
						</td>
						<td><?php echo $itemvalue['price'];?></td>
						<td><?php echo $itemvalue['qty'];?></td>
						<td><?php echo $itemvalue['subtotal'];?></td>
						<td><a href="<?php echo 'addtocart.php?A=Remove&productid='.$itemvalue['id'] ;?>" class='btn btn-danger'><span class='glyphicon glyphicon-remove-sign'></span> 刪除此項</a></td>
					</tr>
				<?php //end of foreach{}
				}
				?>
					<tr>
					<td></td>
					<td></td>
					<td></td>  
				    <td></td>
				   	<td><a href="<?php echo'addtocart.php?A=Empty&productid='.$itemvalue['id'] ;?>" class='btn btn-danger'><span class='glyphicon glyphicon-remove-sign'></span> 清空購物車</a></td>
				</tr>
				</tr>
				<tr>
					<td></td>
					<td></td>
				   <td><strong>總計金額</strong></td>
				   <td>&#36;<?php echo $cart->total ;?></td>
				    <td>
				    <a id="pop" class="btn btn-success">
				    	<span class='glyphicon glyphicon-arrow-right'></span> 送出訂單
				    </a>
				    </td>
			    </tr>
			    <?php
			 	} //end of else{}
			    ?> 
				</table>
			</div>	
		</div>  <!--end of row offcanvas-->
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://getbootstrap.com/examples/offcanvas/offcanvas.js"></script>
<script>
$('#pop').click(function(){
    $('#myModal .modal-title').html('Oops!');
    $('#myModal .modal-body').html('<p>謝謝你能走到最後一步看到這一段訊息，這個網站只是一個從零開始構建的練習作品而已，在後來主要是由php架構而成，藉由讀取資料庫的內容自動排版生成頁面，盡量減少自己手動新增的狀況，為了讓我自己方便，我還另外還做了一些幫助我上傳資料的小工具。程式碼的部分可能還很雜，將會自己慢慢統整。<br>2016/12/1</p>');
    $('#myModal').modal('show');
});
</script>
</body>
</html>
