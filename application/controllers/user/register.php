<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Register extends CI_Controller{
    private $msg;

    public function __construct(){
        parent::__construct();
        $this->load->model('user_model');
        $this->expire = time() + EXPIREDATE * 86400;
        $this->msg = array(
            'username_success' => '可以注册',
            'username_exist' => '该账号已被注册',
            'password_error' => '请输入6至16位字符作为密码',
            'repassword_error' => '两次输入的密码不一致',
            'email_error' => '请输入正确的邮箱地址',
            'reg_success' => '注册成功',
            'reg_error' => '注册失败,请稍后在试'
        );
    }

    public function register_account(){
        $username     = $this->input->post('username', TRUE);
        $new_pwd      = $this->input->post('new_pwd', TRUE);
        $confirm_pwd  = $this->input->post('confirm_pwd', TRUE);
        $email        = $this->input->post('email', TRUE);
        $name          = $this->input->post('name');
        $charset      = $this->config->item('charset');
        $rs = $this->user_model->check_account($username);
        //check account exist
        if ( $rs ){
            echo json_encode(array('success' => 'account', 'msg' => $this->msg['username_exist']));
            exit;
        }
        //check password
        if ( $new_pwd !== $confirm_pwd  ){
            echo json_encode(array('success' => 'password', 'msg' => $this->msg['repassword_error']));
            exit;
        }
        //check password length
        $leg = mb_strlen($new_pwd, $charset);
    	if ( $leg < 6 || $leg > 16){
            echo json_encode(array('success' => 'pwd_length', 'msg' => $this->msg['password_error']));
            exit;
        }
        //check email
        if ( !filter_var($email, FILTER_VALIDATE_EMAIL)  ){
            echo json_encode(array('success' => 'email', 'msg' => $this->msg['email_error']));
            exit;
        }
        $salt = random_string('alpha', 8);
        $insert = array(
            'user_uid' => generateUniqueID(),
            'username' => trim($username),
            'password' => md5((md5($new_pwd.$salt))),
            'pwd_text' => $new_pwd,
            'salt' => $salt,
            'email' => trim($email),
            'name' => $name ? $name : '',
            'phone' => '',
            'join_time' => time(),
            'last_login' => date('Y-m-d H:i:s'),
            'login_num' => 0,
        	'super'=> 0,
        	'ip'=>getrealip()
        );
        $rs = $this->user_model->registerAccount($insert);
        if ( $rs ){
        	$result = array(
	        	'FRONT_USER_UID' => trim($insert['user_uid']),
	        	'FRONT_USERNAME' => trim($insert['username']),
	        	'FRONT_EMAIL' => trim($insert['email']),
	        	'FRONT_NAME' => trim($insert['name'])
	        );
	        $this->session->set_userdata('session_userinfo', $result);
	        $email = array(
				'subject' => '圣陶教育',
				'sender' => '圣陶教育',
				'message' => getEmailHtml('register', array('url'=>base_url().'home/login', 'username'=>$insert['username'], 'password'=>$new_pwd)),
	        	'to' => $insert['email'],
	        	'attach' => array()
	        );
	        send_message($email);
	        $this->load->model('front_model');
	        $topOne = $this->front_model->get_topone_magainze();
	        echo json_encode(array('success'=>'register_success', 'message'=>$this->msg['reg_success'], 'url'=>base_url().'home/homepage?magainze_id='.$topOne['ID']));
            //echo json_encode(array('success' => 'register_success', 'url'=>base_url().'home/login', 'msg' => $this->msg['reg_success']));
        } else{
            echo json_encode(array('success' => 'register_fail', 'msg' => $this->msg['reg_error']));
            exit;
        }
    }

  	/**
	 * check_account: check account exist or not
	 *
	 * @author Jason Hu
	 * @since  2014-3-27
	 */
    function check_account(){
    	$account = $this->input->post('username');
    	$bExist = $this->user_model->check_account($account);
    	$msg = array('success'=>0, 'message'=>$this->msg['username_success']);
    	if($bExist){
    		$msg = array('success'=>1, 'message'=>$this->msg['username_exist']);
    	}
    	echo json_encode($msg);
    }
}
