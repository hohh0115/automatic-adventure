<?php 
/**
*	1.總紀錄數 
*	2.每頁顯示多少紀錄 為兩個最重要方向
*	3.把顯示列分割成一塊一塊處理
*
*
*	
*/
class Page
{
	private $total;//總紀錄數 
	private $nums;//每頁顯示多少紀錄
	private $pages; //共需要幾頁 (總紀錄數/每頁應顯示多少紀錄)
	public $cpage; //當前是第幾頁
	private $uri; //當前的url 用於網址欄位居多
	public function __construct($total, $nums)
	{
		$this -> total = $total;
		$this -> nums = $nums;
		$this -> pages = $this -> getPages();
		$this -> cpage = !empty($_GET['page']) ? $_GET['page'] : 1; //如果網址欄的頁數不為空就回傳那個頁數給「顯示用」來顯示匹配的頁數。
		$this -> uri = $this -> getUri();  //處理網址列
	}
	//分割網址列
	private function getUri(){
		$this -> uri = $_SERVER["REQUEST_URI"]; 
		$this -> uri = parse_url($this -> uri);
		$this -> uri = $this -> uri['path'];
		return $this->uri;
	}

	//共多少頁?總紀錄數/每頁顯示多少紀錄
	private function getPages(){
		return ceil($this->total/$this->nums);
	}

	public function first(){
		//如果是第一頁就不需要顯示 首頁 上一頁 了
		$prev = $this->cpage - 1;
		if ($this->cpage > 1) {
			return '<a href="'.$this->uri.'?page=1">首頁</a> <a href="'.$this->uri.'?page='.$prev.'">上一頁</a>';
		} else {
			return "";
		}
	}
	private function last(){
			if ($this->cpage < $this->pages) {
				$next = $this->cpage + 1;
				return '<a href="'.$this->uri.'?page='.$next.'">下一頁</a> <a href="'.$this->uri.'?page='.$this->pages.'">末頁</a>';
			} 
			else { //如果使用者在末頁時，就沒有必要顯示 下一頁 末頁 了	
				return "";
			}
		}

	private function flist(){
		$listPages ="";
		$listNums = 4; //當前頁面前後共要顯示幾頁的頁碼
		//當前頁面之前的頁數
		for ($i=$listNums; $i >= 1  ; $i--) { 
			$countpages = $this->cpage - $i;
			if ($countpages >= 1) {
				$listPages .= '&nbsp<a href="'.$this->uri.'?page='.$countpages.'">'.$countpages.'</a>&nbsp';
			}  //這裡不需要加上break 因為會先扯到cpage=4之前的頁碼顯現問題(4開始減)(如果cpage=5還是可以顯現)。如果加上break，會顯示不出來因為判斷式的關係，硬要加可能得從判斷式下手。
		}
		//顯示當前頁數
		if ($this->cpage > 1) {
			$listPages .= "&nbsp;".$this->cpage."&nbsp";  //切記 .= 的使用 如果沒用的話 這邊的賦值會直接蓋過前一段的值 整個function是累計上去的---$listPages是從前面開始累計。
		}
		//當前頁面之後的頁數
		for ($i=1; $i <= $listNums; $i++) { 
			$countpages = $this->cpage + $i; //列出當前頁面後的頁碼
			if ($countpages <= $this->pages) { //如果在總頁面數許可的情況下
				$listPages .= '&nbsp<a href="'.$this->uri.'?page='.$countpages.'">'.$countpages.'</a>&nbsp';
			//var_dump($listPages);
			} else {  //每一次判斷句都會重新檢視是否有無超過總頁數，如果超過就break整個迴圈，再return值出去。
				break;
			}	
		}
		return $listPages;
	}
	private function start(){
		return ($this->cpage-1) * $this->nums + 1;
	}
	private function end(){
		return min($this->cpage * $this->nums, $this->total); //this-total一定比較少。目前狀況是說紀錄數沒有到那一頁滿，顯然地總紀錄數小於所有頁碼裡面包含的紀錄。共10頁1頁10紀錄總共可塞100個紀錄，但現實只有95個紀錄。
	}
	private function currnums(){
		return $this->end()-$this->start() + 1;  //函式的值加減
	}
	// 顯示用
	function fpage(){

		$fpage = "";
		$pages['0'] = "共{$this->total}條紀錄&nbsp;";
		$pages['1'] = "&nbsp;本頁顯示".$this->currnums()."條紀錄&nbsp;";
		$pages['2'] = "&nbsp;從".$this->start()."-".$this->end()."條&nbsp;";
		$pages['3'] = "&nbsp;".$this->cpage."/".$this->pages."&nbsp;";
		$pages['4'] = "&nbsp;".$this->first()."&nbsp;";
		$pages['5'] = "&nbsp;".$this->flist()."&nbsp;";
		$pages['6'] = "&nbsp;".$this->last()."&nbsp;";
		
		$arr = func_get_args();   //傳入參數來決定多少訊息要顯示(如上表)。func_get_args傳回陣列，裡面包含傳入函式的參數

		if (count($arr) < 1) {  //這個是沒有傳入任何參數(使用者沒有決定)的預設情況
			$arr = array(0,1,2,3,4,5,6);
		}

		foreach ($arr as $n) {
		  	$fpage .= $pages[$n];   //陣列搭配陣列元素項目來顯示。
		  }  
		  return $fpage;
	}
}

 ?>