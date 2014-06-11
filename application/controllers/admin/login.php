<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Login: class for login
 *
 * @author Jason Hu
 * @since  2014/03/26
 */
class Login extends CI_Controller {
    
	/**
     * __construct: Constructors to load model 
     */
	function __construct(){
        parent::__construct();
        $this->load->model('syslogin_model');
    }

    /**
     * index: function Entrance 
     * 
     * @author Jason Hu
     * @since  2014-3-26
     */
    function index(){
        $this->load->view('admin/login');
    }

    /**
     * signin: login and check
     *
     * @author Jason Hu
     * @since  2014-3-18
     */
    function sys_login(){
        $username = $this->input->post('username', true);
        $username = strip_tags(trim($username));
        $pwd = $this->input->post('pwd', true);
        $user_uid = '';
        $super = '';
        $result = $this->syslogin_model->checkIsExist(strtoupper($username), $pwd, $user_uid, $super);
        if ($result) {
            if ($super == 'superadmin') {
            	$this->session->set_userdata('user_uid', $user_uid);
            	$this->session->set_userdata('username', $username);
            	$this->session->set_userdata('password', $pwd);
           	 	$this->syslogin_model->addLoginNum($user_uid);
            	
                $aMessage['success'] = 2;
           	 	$aMessage['message'] = '登录成功！';
           	 	$aMessage['url'] = base_url().'admin/main';
            } else {
                $this->output->set_header("Content-type: text/html; charset=utf-8");
                $aMessage['success'] = 1;
           	 	$aMessage['message'] = '对不起！您没有权限';
           	 	$aMessage['url'] = base_url().'admin/login';
            }
        } else {
            //wrong usernmae or password
            $this->output->set_header("Content-type: text/html; charset=utf-8");
            $aMessage['success'] = 0;
            $aMessage['message'] = '用户名或密码错误！';
        }
        echo json_encode($aMessage);
    }
    /**
    * logout: function exit system
    *
    * @author Jason Hu
    * @since  2014-3-26
    */
    public function logout(){
    	$this->session->unset_userdata('user_uid');
    	$this->session->unset_userdata('username');
    	$this->session->unset_userdata('password');
        redirect(base_url().'admin/login');
    }
}

?>
