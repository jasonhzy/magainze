<?php
/**
 * Member_model : class model for public function
 * @since: 2014-03-26
 */
class Member_model extends CI_Model{

	/**
	 * get_super_admin:  super member list
	 * @param array $params : for search params
	 *
	 * @author Jason Hu
	 * @since  2014-3-31
	 */
	function get_super_admin($params = array()){
		try {
			$member = array();
			$sql = 'SELECT user_uid, username, name, email, phone, join_time, last_login, login_num, super, ip 
				FROM '.ADMIN_USERS.' WHERE super=1';
			if(isset($params['search_field']) && $params['field_content']){
				$sql .= ' AND '.$params['search_field'].' LIKE ' . $this->db->escape('%'.$params['field_content'].'%'); 
			}
			if(isset($params['sort_field'])){
				$sql .= ' ORDER BY '.$params['sort_field']; 
			}else{
				$sql .= ' ORDER BY username'; 
			}
			$rs = $this->db->query($sql);
			foreach ( $rs->result_array () as $row ) {
				$row['join_time'] = date('Y-m-d', $row['join_time']);
				$row['last_login'] = date('Y-m-d', $row['last_login']);
				$member[] = $row;
			}
			return $member;
		} catch (Exception $e) {
			die($e);
		}
	}
	
	/**
	 * get_member_list:  for all member list
	 * @param array $params : for search params
	 *
	 * @author Jason Hu
	 * @since  2014-3-31
	 */
	function get_member_list($params = array()){
		try {
			$member = array();
			$pagesize = $params['per_page'];
			$pagenum = $params['page_num'];
			$formula = $pagesize * ($pagenum - 1);
			$sql = 'SELECT TOP '.$pagesize.' user_uid, username, name, email, phone, join_time, last_login, login_num, super, ip  FROM '.ADMIN_USERS.'   
				WHERE user_uid not in(
					SELECT TOP '.$formula.' user_uid FROM '.ADMIN_USERS.'  ORDER BY super DESC';
			if(isset($params['sort_field']) && $params['sort_field']){
				$sql .= ', '.$params['sort_field']; 
			}
			$sql .= ')';
			if(isset($params['search_field']) && $params['field_content']){
				$sql .= ' AND '.$params['search_field'].' LIKE ' . $this->db->escape('%'.$params['field_content'].'%'); 
			}
			$sql .= ' ORDER BY super DESC'; 
			if(isset($params['sort_field']) && $params['sort_field']){
				$sql .= ', '.$params['sort_field']; 
			}
			$rs = $this->db->query($sql);
			//pr($this->db->last_query());
			foreach ( $rs->result_array () as $row ) {
				$row['join_time'] = date('Y-m-d', $row['join_time']);
				$row['last_login'] = date('Y-m-d', $row['last_login']);
				$member[] = $row;
			}
			return $member;
		} catch (Exception $e) {
			die($e);
		}
	}
	
	/**
	 * get_member_count: get member count when to pagination
	 * @param array $params
	 * @return array
	 * 
	 * @author Jason Hu
	 * @since  2014-4-1
	 */
	function get_member_count($params) {
		try {
			$sql = 'SELECT COUNT(*) AS TOTAL FROM '.ADMIN_USERS.' WHERE 1=1';
			if(isset($params['search_field']) && $params['field_content']){
				$sql .= ' AND '.$params['search_field'].' LIKE ' . $this->db->escape('%'.$params['field_content'].'%'); 
			}
			$rs = $this->db->query($sql);
			//pr($this->db->last_query());
			return $rs->row()->TOTAL;
		} catch (Exception $e) {
			die($e);
		}
	}
	
	
	/**
     * checkIsExist: check account is exist or not 
     * @param string $username
     * @return string
     *
     * @author Jason Hu
     * @since  2014-3-18
     */
    public function checkIsExist($user_uid, $username) {
    	if($user_uid){
			$sql = 'SELECT COUNT(*) AS TOTAL FROM '.ADMIN_USERS.' WHERE 
				username = '.$this->db->escape($username) . ' AND user_uid != ' .$this->db->escape($user_uid);
    	}else{
			$sql = 'SELECT COUNT(*) AS TOTAL FROM '.ADMIN_USERS.' WHERE username = '.$this->db->escape($username);
    	}
		$rs = $this->db->query($sql);
		$row = $rs->row_array();
		if ($row['TOTAL'] > 0 ) {
			return 'false';
		} else {
			return 'true';
		}
	}
	
	/**
	 * insert_member: insert member
	 * @param array $fields table fields
	 *
	 * @author Jason Hu
	 * @since  2014-3-31
	 */
	function insert_member($fields) {
		return $this->db->insert(ADMIN_USERS, $fields);
	}
	
	/**
	 * update_member: modify member
	 * @param string $user_uid  table pk
	 * @param array $fields table fields
	 *
	 * @author Jason Hu
	 * @since  2014-3-31
	 */
	function update_member($user_uid, $fields) {
		$this->db->where ( 'user_uid', $user_uid );
		return $this->db->update ( ADMIN_USERS, $fields );
	}
	
	/**
	 * del_member: delete member
	 * @param string $user_uid table pk
	 * @return boolean
	 *
	 * @author Jason Hu
	 * @since  2014-3-19
	 */
	public  function del_member($user_uid){
        return $this->db->delete(ADMIN_USERS, array('user_uid'=>$user_uid));
    }
    
    /**
	 * del_member: delete multi members
	 * @param array $aUserUid table pk in array
	 * @return boolean
	 *
	 * @author Jason Hu
	 * @since  2014-3-19
	 */
	function batchDel($aUserUid) {
 		$this->db->where_in('user_uid', $aUserUid); 
 		return $this->db->delete(ADMIN_USERS); 
	}
	
	/**
	 * getMemberById: get member info by id when to modify
	 * @param string $user_uid table pk
	 *
	 * @author Jason Hu
	 * @since  2014-4-1
	 */
	function getMemberById($user_uid) {
		$sql = 'SELECT user_uid, username, pwd_text as password, name, sex, email, phone, fax, super  
			FROM '.ADMIN_USERS.' WHERE user_uid = '.$this->db->escape($user_uid);
		$rs = $this->db->query($sql);
		$row = $rs->row_array();
		if($row){
			$row['password'] =  trim($row['password']);
		}
		return $row;
	}
	
	
	 /**
     * change_to_super: change member to super
     *
     * @author Jason Hu
     * @since  2014-4-2
     */
    function change_to_super($user_uid) {
        $sql = 'UPDATE '.ADMIN_USERS.' SET super = ? WHERE user_uid = ?'; 
        $this->db->query($sql, array(1, $user_uid));
	}
	
	
	function get_salt($user_uid) {
		$sql = 'SELECT user_uid, username, pwd_text, salt
			FROM '.ADMIN_USERS.' WHERE user_uid = '.$this->db->escape($user_uid);
		$rs = $this->db->query($sql);
		$row = $rs->row_array();
		if($row){
			return $row;
		}else{
			return NULL;
		}
	}
}