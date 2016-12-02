<?php
//加入購物車Class的宣告
require_once('EDcart.php');
session_start();
$cart =& $_SESSION['edCart']; 
if(!is_object($cart)) $cart = new edCart();
/*
array (size=4)
  'A' => string 'Add' (length=3)
  'productid' => string '4' (length=1)
  'name' => string 'What's Going On' (length=15)
  'price' => string '123243' (length=6)
*/
?>
<?php
//執行購物車動作，資料由index.php傳入，這裡就不用再去資料表抓資料。
$DoSomeThing = (isset($_GET['A']) ? $_GET['A'] : "");
var_dump($cart->items);
switch($DoSomeThing){
  case "Add":
  	$cart->add_item($_GET['productid'],1,$_GET['price'],$_GET['name'],isset($_GET['pic'])?$_GET['pic']:'');	 //1代表數量加入1個，另外至少傳入id price name,pic可選可不選
  	//var_dump($cart);
  	/*
  	D:\wamp64\www\shoppingcart\addtocart.php:23:
  object(edCart)[1]
    public 'total' => int 1064514
    public 'deliverfee' => int 0
    public 'grandtotal' => int 1064514
    public 'itemcount' => int 3
    public 'items' => 
      array (size=3)
        0 => string '4' (length=1)
        1 => string '5' (length=1)
        2 => string '3' (length=1)
    public 'itemprices' => 
      array (size=3)
        4 => string '123243' (length=6)
        5 => string '3900' (length=4)
        3 => string '12445' (length=5)
    public 'itemqtys' => 
      array (size=3)
        4 => int 8
        5 => int 1
        3 => int 6
    public 'iteminfo' => 
      array (size=3)
        4 => string 'What's Going On' (length=15)
        5 => string 'Sgt. Pepper's Lonely Hearts Club Band' (length=37)
        3 => string 'Low' (length=3)
    public 'itempic' => 
      array (size=3)
        4 => string '' (length=0)
        5 => string '' (length=0)
        3 => string '' (length=0)
  	*/
  	break;
  case "Remove":
  	$cart->del_item($_GET['productid']);
  	break;
  case "Empty":
  	$cart->empty_cart();
  	break;
  case "Update":
  	for($startNO=0;$startNO < $_GET['itemcount'];$startNO++){
  		$cart->edit_item($_GET['itemid'][$startNO],$_GET['qty'][$startNO]);
  	}
  	break;		
  }
?>
<?php 
header('Location: '.$_SESSION['position']);
?>