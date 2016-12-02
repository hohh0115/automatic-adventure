<?php
/*
由 webforce cart v.1.2 修改 (http://webforce.co.nz/cart)
---------------------------------------------------------
織夢平台2005 - 分享是成長的開始
http://www.e-dreamer.idv.tw
*/
class edCart {
	public $total = 0; 
	public $deliverfee = 0; //修改，運費
	public $grandtotal = 0; //加上了運費後的總合費用
	public $itemcount = 0;
	public $items = array(); //儲存productid 用於get_contents();
	public $itemprices = array();/*商品價格*/
	public $itemqtys = array();/*消費者選取的數量*/
	public $iteminfo = array();/*商品訊息*/
	public $itempic = array();	/*商品照片*/
	public $countsum = 0; //商品數量總計
	//function cart() {} // 宣告函數

	function get_contents(){ // 取得購物車內容
		$items = array();
		foreach($this->items as $tmp_item){
		    $item = FALSE;
			$item['id'] = $tmp_item;
			$item['qty'] = $this->itemqtys[$tmp_item];
			$item['price'] = $this->itemprices[$tmp_item];
			$item['info'] = $this->iteminfo[$tmp_item];
			$item['pic'] = $this->itempic[$tmp_item];
			$item['subtotal'] = $item['qty'] * $item['price'];/*總價格*/
			$items[] = $item;
		}
		return $items;  /*傳出一個陣列*/
	}
	//add_item($_GET['productid'],1,$_GET['price'],$_GET['name'],isset($_GET['pic'])?$_GET['pic']:'')
	//A=Add&productid='.$rows['productid'].'&name='.$rows['productname'].'&price='.$rows['productprice'].'"
	function add_item($itemid,$qty=1,$price = FALSE, $info = FALSE, $pic = FALSE){ // 新增至購物車 跟 addtocart.php 最有關聯
		//if(!$price){
			//$price = ed_get_price($itemid,$qty);
		//}
		//if(!$info){
			//$info = ed_get_info($itemid);
		//}
		if(isset($this->itemqtys[$itemid]) && $this->itemqtys[$itemid] > 0){ 
			$this->itemqtys[$itemid] = $qty + $this->itemqtys[$itemid];
			$this->_update_total();
		} else {
			$this->items[]=$itemid; //儲存productid 用於get_contents();
			/*
			  public 'items' => 
			    array (size=3)
			      0 => string '4' (length=1)
			      1 => string '5' (length=1)
			      2 => string '3' (length=1)
      		*/
			$this->itemqtys[$itemid] = $qty;
			/*  public 'itemqtys' => 
			    array (size=3)
			      4 => int 8
			      5 => int 1
			      3 => int 6
			*/
			$this->itemprices[$itemid] = $price;
			/*
			 public 'itemprices' => 
			    array (size=3)
			      4 => string '123243' (length=6)
			      5 => string '3900' (length=4)
			      3 => string '12445' (length=5)
			*/
			$this->iteminfo[$itemid] = $info; //就是$_GET['name']=$rows['productname'](往上看一下傳入的資訊)
			$this->itempic[$itemid] = $pic;	
			/*
			  public 'iteminfo' => 
			    array (size=3)
			      4 => string 'What's Going On' (length=15)
			      5 => string 'Sgt. Pepper's Lonely Hearts Club Band' (length=37)
			      3 => string 'Low' (length=3)
      		*/		
		}
		$this->_update_total();
		$this->countsum();
	} 
	function edit_item($itemid,$qty){ // 更新購物車數量
		if($qty < 1) {
			$this->del_item($itemid);
		} else {
			$this->itemqtys[$itemid] = $qty;
		}
		$this->_update_total();
		$this->countsum();
	} 


	function del_item($itemid){ // 移除購物車
		$ti = array();
		$this->itemqtys[$itemid] = 0;
		foreach($this->items as $item){
			if($item != $itemid){
				$ti[] = $item;
			}
		}
		$this->items = $ti;
		$this->_update_total();
		$this->countsum();
	} 


	function empty_cart(){ // 清空購物車
		$this->total = 0;
		$this->itemcount = 0;
		$this->items = array();
		$this->itemprices = array();
		$this->itemqtys = array();
		$this->itemdescs = array();
		$this->countsum = 0;
	} 


	function _update_total(){ // 更新購物車的內容
		$this->itemcount = 0;
		$this->total = 0;
		$this->countsum = 0;
		if(sizeof($this->items > 0)){  //sizeof計算陣列中元素的數目
			foreach($this->items as $item) {
				$this->total += ($this->itemprices[$item] * $this->itemqtys[$item]);
				$this->itemcount++;
			}
		}
		$this->grandtotal = $this->total + $this->deliverfee; //計算最後總計
	} 
	function countsum(){
		if (empty($this->itemqtys)){
              $this->countsum = 0;
        } else {
        	foreach ($this->items as $id) {
            $this->countsum += $this->itemqtys[$id];
          }
        }
	}
}
?>