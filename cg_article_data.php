<?php
/**
 * 文章数据模型类
 *
 * @copyright  2012-2013 Bei Jing Demon.
 * @since      File available since Release 1.0 -- 2013-6-19 下午01:50:24
 * @author     gaorunqiao<goen88@163.com>
 * 
 */
class cg_article_data {

  var $link;
	var $total;
	var $table;

	function cg_article_data($link) {
		$this->link = $link;
		$this->total = 0;
		$this->table = "cg_article";
	}

	function insert_a_row($row_rec) {
		$dd = new database_data ( $this->link );
		$sql_ins = $dd->_get_insert_sql_by_one_row ( $this->table, $row_rec );
		//$res_ins = mysql_query($sql_ins,$this->link);
		//exit($sql_ins);
		$raid = $dd->_insert_one_row ( $this->table, $sql_ins );
		return $raid;
	}

	function update_a_row_by_raid($row_rec, $raid) {
		$dd = new database_data ( $this->link );
		//$sql_update = $dd->_get_update_sql_by_one_row($this->table,$row_rec,$where_cond);
		$sql_update = $dd->_get_update_sql_by_one_row ( $row_rec );
		//$res_ins = mysql_query($sql_ins,$this->link);
		$sql_up = "update " . $this->table . " set " . $sql_update . " where raid=" . $raid;
		//echo "sql_up:".$sql_up."<br/>";
		$dd->_update_one_row ( $this->table, $sql_up );
	}
	
	function delete_a_row_by_raid($raid) {
		$sql_delete = "delete from " . $this->table . " where raid=" . $raid;
		$dd = new database_data ( $this->link );
		$dd->_delete_one_row ( $this->table, $sql_delete );
	}
	
	function select_a_row_by_raid($raid) {
		$sql_sel = "select * from " . $this->table . " where raid='" . $raid . "'";
		$dd = new database_data ( $this->link );
		$row_sel = $dd->_select_one_row ( $sql_sel );
		return $row_sel;
	}
	
	function select_more_row_by_page($cond, $begin, $limit) {
		$sql_sel = "select * from " . $this->table . " where field='" . $cond . "' order by id desc limit " . $begin . "," . $limit;
		$dd = new database_data ( $this->link );
		$arr_sel = $dd->_select_multi_row ( $sql_sel );
		return $arr_sel;
	}
	
	function select_all_row_by_cond($cond) {
		$sql_sel = "select * from " . $this->table . " where field=" . $cond . " order by pid desc";
		$dd = new database_data ( $this->link );
		$arr_sel = $dd->_select_multi_row ( $sql_sel );
		return $arr_sel;
	}
	
	function select_all_row_by_page($whrArray, $begin, $limit, $order = 'order by raid desc') {
		$sql_sel = "select * from " . $this->table;
		
		if (! empty ( $whrArray )) {
			$sql_sel .= " where ";
			$whereArr = "";
			if (isset ( $whrArray ['raid'] ))
				$whereArr [] = " raid={$whrArray['raid']} ";
			if (isset ( $whrArray ['rcid'] ))
				$whereArr [] = " rcid={$whrArray['rcid']} ";
			if (isset ( $whrArray ['flag'] ))
				$whereArr [] = " flag={$whrArray['flag']} ";
			if (isset ( $whrArray ['keyword'] ))
				$whereArr [] = " (arti_title like '%{$whrArray['keyword']}%' or arti_brief like '%{$whrArray['keyword']}%' or arti_content like '%{$whrArray['keyword']}%')  ";
			if (isset ( $whrArray ['arti_title'] ))
				$whereArr [] = " arti_title like '%{$whrArray['arti_title']}%' ";
			if (isset ( $whrArray ['startTime'] ))
				$whereArr [] = " create_time>='{$whrArray['startTime']}' ";
			if (isset ( $whrArray ['endTime'] ))
				$whereArr [] = " create_time<'{$whrArray['endTime']}' ";
			$sql_sel .= implode ( " and ", $whereArr );
		}
		$sql_sel .= " $order limit $begin,$limit ";
		//echo $sql_sel;
		$dd = new database_data ( $this->link );
		$arr_sel = $dd->_select_multi_row ( $sql_sel );
		return $arr_sel;
	}
	
	function select_a_sum_by_cond($cond) {
		$sql_sel = "select count(*) as sum from " . $this->table . " where field='" . $cond . "'";
		$dd = new database_data ( $this->link );
		$sum_sel = $dd->_select_sum_row ( $sql_sel );
		return $sum_sel;
	}
	
	function select_a_sum($whrArray) {
		$sql_sel = "select count(*) as sum from " . $this->table . "";
		if (! empty ( $whrArray )) {
			$sql_sel .= " where ";
			$whereArr = "";
			if (isset ( $whrArray ['raid'] ))
				$whereArr [] = " raid={$whrArray['raid']} ";
			if (isset ( $whrArray ['rcid'] ))
				$whereArr [] = " rcid={$whrArray['rcid']} ";
			if (isset ( $whrArray ['flag'] ))
				$whereArr [] = " flag={$whrArray['flag']} ";
			if (isset ( $whrArray ['keyword'] ))
				$whereArr [] = " (arti_title='{$whrArray['keyword']}' or arti_brief='{$whrArray['keyword']}' or arti_content='{$whrArray['keyword']}')  ";
			if (isset ( $whrArray ['arti_title'] ))
				$whereArr [] = " arti_title='{$whrArray['arti_title']}' ";
			if (isset ( $whrArray ['startTime'] ))
				$whereArr [] = " create_time>='{$whrArray['startTime']}' ";
			if (isset ( $whrArray ['endTime'] ))
				$whereArr [] = " create_time<'{$whrArray['endTime']}' ";
			$sql_sel .= implode ( " and ", $whereArr );
		}
		$dd = new database_data ( $this->link );
		$sum_sel = $dd->_select_sum_row ( $sql_sel );
		return $sum_sel;
	}
}
?>
