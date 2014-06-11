<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forget extends CI_Controller
{
    private $msg;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->msg = array(
        	'email_not_exist' => '该邮箱不存在',
        	'modify_pwd_error' => '密码修改失败',
        	'modify_pwd_success' => '密码修改成功,请重新登录'
        );
    }
    
    /**
     * get_pwd : get user info by email
     *
     * @author Jason Hu
     * @since  2014-4-10
     */
    function get_pwd() {
    	$email = $_REQUEST['email'];
    	$user = $this->user_model->getUserInfo('email', $email);
    	if(!$user){
    		echo json_encode(array('success'=>0, 'msg'=>$this->msg['email_not_exist']));
    		exit;
    	}
    	$url = base_url().'home/reset_pwd?user_uid='.trim($user['USER_UID']).'&salt='.trim($user['SALT']);
    	$emailinfo = array(
			'subject' => '圣陶教育',
			'sender' => '圣陶教育',
			'message' => getEmailHtml('forget', array('url'=>$url)),
        	'to' => $email,
        	'attach' => array()
        );
        send_message($emailinfo);
        $data['email'] = $email;
        $data['email_url'] = getEmailHostByEmail($email);
        echo json_encode(array('success'=>1, 'url'=>base_url().'home/forget_tip?email='.$data['email'].'&email_url='.$data['email_url']));
    }
    
    
    /**
     * reset_pwd : reset password
     *
     * @author Jason Hu
     * @since  2014-4-10
     */
    function reset_pwd() {
    	$data['user_uid'] = $_REQUEST['user_uid'];
    	$data['new_pwd'] = $_REQUEST['new_pwd'];
    	$data['salt'] = $_REQUEST['salt'];
    	$rs = $this->user_model->reset_pwd($data);
    	if($rs){
    		echo json_encode(array('success'=>1, 'msg'=>$this->msg['modify_pwd_success'], 'url'=>base_url().'home/login'));
    	}else{
    		echo json_encode(array('success'=>0, 'msg'=>$this->msg['modify_pwd_error']));
    	}
    }

}