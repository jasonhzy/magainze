<?php
/**
 * Syslogin_model : class model to handle account 
 * @since: 2014-03-26
 */
class Syslogin_model extends CI_Model{

    /**
     * checkIsValid: check account is valid or invalid
     * @param string $username
     * @param string $pwd
     * @param string $salt
     * @return boolean
     *
     * @author Jason Hu
     * @since  2014-3-18
     */
    public function checkIsExist($username, $pwd, &$user_uid, &$super) {
		$username = strtoupper ( $username );
		$this->db->select ( 'user_uid as USER_UID, username AS USERNAME, password AS PWD, salt AS SALT, super AS SUPER' );
		$this->db->where ( array ('username' => $username ) );
		$sql = $this->db->get ( ADMIN_USERS );
		if ($sql->num_rows () > 0 ) {
			$rs = $sql->row_array();
			$password = md5 ( md5 ( $pwd . $rs['SALT'] ) );
			$super = $rs['SUPER'] == '1' ? 'superadmin' : '';
			$user_uid = $rs['USER_UID'];
			if(trim($rs['PWD']) == $password){
				return true;
			}
			return false;
		} else {
			return false;
		}
	}
	
	/**
	 * addLoginNum: when to login, then login_num = login_num + 1 
	 * @param string $user_uid table admin_users pk
	 *
	 * @author Jason Hu
	 * @since  2014-3-26
	 */
	function addLoginNum($user_uid) {
		$sql = 'UPDATE '.ADMIN_USERS.' SET login_num = login_num + 1, last_login = '.$this->db->escape(date('Y-m-d H:i:s')).',
			ip = '.$this->db->escape(getrealip()).'	
			WHERE user_uid = '.$this->db->escape($user_uid);
		$this->db->query($sql);
	}
	
}