<?php
/**
 * Base_model : class model for public function
 * @since: 2014-03-26
 */
class Base_model extends CI_Model{

	public function check_valid() { 
		$msg = array();
 		$session = $this->session->userdata('session_userinfo'); 
 		if ( $session ) { 
 			$msg = $session; 
 		} else if(get_cookie('cookie_userinfo')){
 			$msg = unserialize(get_cookie('cookie_userinfo')); 
 		}
 		return $msg;
 	}
 	//week account num
 	public function getWeekAccount() {
 		$date = $this->getWeekRange(date('Y-m-d'));
 		$start_timestamp = strtotime($date['now_start'].' 00:00:00');
 		$end_timestamp = strtotime($date['now_end'].' 23:59:59');
 		$rs = $this->db->query('SELECT COUNT(*) AS WEEK_TOTAL FROM '.ADMIN_USERS.' WHERE join_time >= '.$start_timestamp.' AND join_time <='.$end_timestamp);
 		if($rs->num_rows() > 0){
 			return $rs->row()->WEEK_TOTAL;
 		}else{
 		
	 		return 0;
 		}
 	}
 	//total account
 	public function getTotalAccount() {
 		$rs = $this->db->query('SELECT COUNT(*) AS TOTAL FROM '.ADMIN_USERS);
 		if($rs->num_rows() > 0){
 			return $rs->row()->TOTAL;
 		}else{
	 		return 0;
 		}
 	}
 	//total article
 	public function getTotalArticle() {
 		$rs = $this->db->query('SELECT COUNT(*) AS TOTAL FROM '.ARTICLE_LIST);
 		if($rs->num_rows() > 0){
 			return $rs->row()->TOTAL;
 		}else{
	 		return 0;
 		}
 	}
 	//week article num
	public function getWeekArticle() {
 		$date = $this->getWeekRange(date('Y-m-d'));
 		$start_time = strtotime($date['now_start'].' 00:00:00');
 		$end_time = strtotime($date['now_end'].' 23:59:59');
 		$rs = $this->db->query('SELECT COUNT(*) AS WEEK_TOTAL FROM '.ARTICLE_LIST.' WHERE join_time >= '.$start_time.' AND join_time <='.$end_time);
 		//pr($this->db->last_query());
 		if($rs->num_rows() > 0){
 			return $rs->row()->WEEK_TOTAL;
 		}else{
	 		return 0;
 		}
 	}
	
	function getWeekRange($day, $first = 1) {
		$w = date("w", strtotime($day));  //获取当前周的第几天 周日是 0 周一 到周六是 1 -6 
		$d = $w ? $w - $first : 6;  //如果是周日 -6天 
		$date['now_start'] = date("Y-m-d", strtotime("$day -".$d." days")); //本周开始时间
		$date['now_end'] = date("Y-m-d", strtotime("{$date['now_start']} +6 days"));  //本周结束时间
		$date['last_start'] = date('Y-m-d',strtotime("{$date['now_start']} - 7 days"));  //上周开始时间
		$date['last_end'] = date('Y-m-d',strtotime("{$date['now_start']} - 1 days"));  //上周结束时间
		return $date;
	}
 	
	function getMenuList($parent='/'){
		try {
			$aMenu = array();
			$sql = 'SELECT menu_id, menu_title, menu_url, parent, is_used, position, remark
				FROM '.MAGAINZE_MENU.'
				WHERE is_used=0 AND (parent = \''.$parent.'\' OR menu_id=\''.$parent.'\') 
				ORDER BY parent, position';
			$query = $this->db->query($sql);
			//pr($this->db->last_query());
			foreach ( $query->result_array () as $row ) {
				$aRes['menu_id']    = $row['menu_id'];
				$aRes['menu_title'] = $row['menu_title'];
				$aRes['menu_url']   = $row['menu_url'];
				$aRes['category']   = $row['menu_id'] == $parent ? 'title' : 'item';
				$aRes['position']     = $row['position'];
				$aRes['remark']     = $row['remark'];
				$aRes['child']     = $this->get_first_menu($aRes['menu_id']);
				$aMenu[] = $aRes;
			}
			return $aMenu;
		} catch (Exception $e) {
			die($e);
		}
	}
	
	function get_first_menu($parent) {
		$sql = 'SELECT menu_id, menu_title, menu_url, parent, is_used, position, remark
			FROM '.MAGAINZE_MENU.'
			WHERE is_used=0 AND parent = \''.$parent.'\' AND position = 1';
		$rs = $this->db->query($sql);
		if ($rs->row_array()) {
			return $rs->row_array();
		}else{
			return NULL;
		}
	}
	
	public function is_existed($table, $where)
    {   
		$query = $this->db->get_where($table, $where, 1);
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
	public function create($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == 1) {
            $id = $this->db->insert_id();
            if ($id) {
                return $id;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
	public function update($table, $where, $data)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
        if ($this->db->affected_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
	public function getInfoById($table, $where)
    {
        $query = $this->db->get_where($table, $where, 1);
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
	
	
}