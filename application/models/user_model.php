<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
    
	/**
	 * getUserInfo: get user basic info for admin->login
	 * @param string $key table field
	 * @param string $value field value
	 *
	 * @author Jason Hu
	 * @since  2014-3-27
	 */
	public function getUserInfo($key, $value){
		$sql = 'SELECT user_uid AS USER_UID, username AS USERNAME, password AS PWD, 
				salt AS SALT, email AS EMAIL, name AS NAME, super AS SUPER  FROM '.ADMIN_USERS.' 
			WHERE  '.$key.' = '.$this->db->escape($value);
        $rs = $this->db->query($sql);
        if ( $rs->num_rows()>0 ){
            return $rs->row_array();
        }else{
            return null;
        }
    }
    
    /***************************************front function***********************************/
    
	/**
	 * check_account: check account exist or not
	 * @param string $account username
	 *
	 * @author Jason Hu
	 * @since  2014-3-27
	 */
	public function check_account($account){
		$sql = 'SELECT user_uid FROM '.ADMIN_USERS.' WHERE  username = '.$this->db->escape($account);
        $rs = $this->db->query($sql);
	 	if ( $rs->num_rows()>0 ){
            return true;
        }else{
            return false;
        }
    }
    
    public function change_login_ip($user_uid) {
    	$sql = 'UPDATE '.ADMIN_USERS.' SET ip = '.$this->db->escape(getrealip()).'	
			WHERE user_uid = '.$this->db->escape($user_uid);
		$this->db->query($sql);
    }
    
    public function registerAccount($data ) { 
 		return $this->db->insert(ADMIN_USERS, $data); 
 	} 
 	
 	
	/**
     * check_email_exist: check email is exist or not 
     * @param string $username
     * @return string
     *
     * @author Jason Hu
     * @since  2014-04-10
     */
    public function check_email_exist($email) {
		$sql = 'SELECT username, salt, email FROM '.ADMIN_USERS.' WHERE email = '.$this->db->escape($email);
		$rs = $this->db->query($sql);
		return $rs->row_array();
	}
	
	/**
     * reset_pwd: reset password
     * @param array $params
     *
     * @author Jason Hu
     * @since  2014-04-11
     */
	function reset_pwd($params = array()) {
		$pwd = md5((md5($params['new_pwd'].$params['salt'])));
		return $this->db->update(ADMIN_USERS, array('password'=>$pwd, 'pwd_text'=>$params['new_pwd']), array('user_uid'=>$params['user_uid']));
	}
}

?>
