<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{
	
	private $msg;
	private $expire;
	
    public function __construct(){
        parent::__construct();
        $this->expire = time() + EXPIREDATE * 86400;
        $this->msg = array(
            'username_not_exist'   => '该账号不存在',
            'pwd_error'        => '登录失败,密码不正确',
            'super_error'    => '该账户是管理员账户，不能用其登录'
        );
    }

    public function verify(){
    	$this->load->model('user_model');
        $username = $this->input->post('username');
        $pwd = $this->input->post('pwd');
        $autologin = $this->input->post('autologin');
        $salt = '';
        $userinfo = $this->user_model->getUserInfo('username', $username);
        if ( !$userinfo ){
            echo json_encode(array('success'=>0, 'message'=>$this->msg['username_not_exist']));
            exit;
        }
        $currentPwd = md5((md5(trim($pwd.$userinfo['SALT']))));
        if ( $currentPwd !== trim($userinfo['PWD']) ){
            echo json_encode(array('success'=>0, 'message'=>$this->msg['pwd_error']));
            exit;
        }
        if($userinfo['SUPER']==1){
            echo json_encode(array('success'=>0, 'message'=>$this->msg['super_error']));
            exit;
        }
        $result = array(
        	'FRONT_USER_UID' => trim($userinfo['USER_UID']),
        	'FRONT_USERNAME' => trim($userinfo['USERNAME']),
        	'FRONT_EMAIL' => trim($userinfo['EMAIL']),
        	'FRONT_NAME' => trim($userinfo['NAME'])
        );
        if( $autologin ){
        	setcookie('cookie_userinfo', serialize($result), $this->expire, "/" ,$_SERVER['HTTP_HOST']);
        }
        $this->session->set_userdata('session_userinfo', $result);
        $this->user_model->change_login_ip($userinfo['USER_UID']);
        //echo json_encode(array('success'=>1, 'message'=>'登录成功', 'url'=>base_url().'home/about_us'));
        $redirect	= $this->input->post('redirect');
        if ($redirect) {
        	$url = $redirect;
        }else{
	        $this->load->model('front_model');
	        $topOne = $this->front_model->get_topone_magainze();
	        $url = base_url().'home/homepage?magainze_id='.$topOne['ID'];
        }
	    $this->session->set_flashdata('redirect', $url);
        echo json_encode(array('success'=>1, 'message'=>'登录成功', 'url'=>$url));
    }
    
	public function logout(){
        setcookie('cookie_userinfo', '', 0, "/" ,$_SERVER['HTTP_HOST']);
        $this->session->unset_userdata('session_userinfo');
        redirect(base_url());
    }
}