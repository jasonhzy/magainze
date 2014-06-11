<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Member: class for member
 *
 * @author Jason Hu
 * @since  2014/03/28
 */
class Member extends CI_Controller {
    
	private $pagesize = 5;
	private $msg;
	/**
     * __construct: Constructors to load model 
     */
	function __construct(){
        parent::__construct();
        $this->load->model('member_model');
        $this->load->helper('form');
        $this->msg = array(
        	'super_logined'=>'已登录的账户不能被删除',
        	'del_success'=>'删除成功',
        	'del_failed'=>'删除失败',
        	'super_title'=>'管理员列表',
        	'member_title'=>'会员列表',
        	'member_exist'=>'该会员名已被注册'
        );
    }

    /**
     * index: load member view
     * 
     * @author Jason Hu
     * @since  2014-3-28
     */
    function common_member(){
    	//parameter for search or order 
    	$params['search_field'] = isset($_REQUEST['search_field']) ? trim($_REQUEST['search_field']) : '';
    	$params['field_content'] = isset($_REQUEST['field_content']) ? trim($_REQUEST['field_content']) : '';
    	$params['sort_field'] = isset($_REQUEST['sort_field']) ? trim($_REQUEST['sort_field']) : '';
    	
    	//pagination search params
    	$strParams = '';
    	if(isset($params['search_field'])){
			$strParams .= '&search_field='.$params['search_field'];
		}
		if(isset($params['sort_field'])){
			$strParams .= '&sort_field='.$params['sort_field'];
		}
		if(isset($params['field_content']) && $params['field_content']){
			$strParams .= '&field_content='.$params['field_content'];
		}else{
			$strParams = '';
		}
    	//init pagination
    	$this->load->library('hpages');
    	$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		//Note:
		//'?id=1' is extra, no special function, only to handle url model
		//error: http://www.magainze.com/admin/member/common_member?id=1&per_page=3
    	$config['base_url'] = 'admin/member/common_member?id=member'.$strParams;
		$config['per_page'] = $this->pagesize;
		$config['uri_segment'] = 1;
		$config['num_links'] = 3;
		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$config['underline_uri_seg'] = 1;
		$config['total_rows'] = $this->member_model->get_member_count($params); 
		$this->hpages->init($config);
    	//page size/page num
    	$params['per_page'] = $config['per_page'];
    	$params['page_num'] = isset($_REQUEST['per_page']) ? ($_REQUEST['per_page'] ? $_REQUEST['per_page'] : 1) : 1;
    	
    	$data['members'] = $this->member_model->get_member_list($params);
    	$data['title'] = $this->msg['member_title'];
    	$data['is_super'] = 'member';
    	
    	$data['search_field'] = $params['search_field'];
    	$data['field_content'] = $params['field_content'];
    	$data['sort_field'] = $params['sort_field'];
        $this->load->view('admin/member/member', $data);
    }
    /**
     * super_member: load super view
     * 
     * @author Jason Hu
     * @since  2014-3-28
     */
    function super_member(){
    	$data['title'] = $this->msg['super_title'];
    	$data['is_super'] = 'super';
    	$data['members'] = $this->member_model->get_super_admin();
        $this->load->view('admin/member/member', $data);
    }
    
    /**
     * check_member_exist: check member exist or not
     * 
     * @author Jason Hu
     * @since  2014-3-28
     */
    function check_member_exist() {
    	$username = $this->input->get('username');
    	$user_uid = $this->input->get('user_uid');
		echo $this->member_model->checkIsExist($user_uid, $username);
    }
    /**
     * modify_member: finish add/update member
     *
     * @author Jason Hu
     * @since  2014-3-31
     */
	function modify_member() {
		try {
			$data['type'] = $_REQUEST['type']; //deal with add or update
			$data['is_super'] = $_REQUEST['is_super']; //deal with super or member
			switch ($data['is_super']){
				case 'super':
					$data['title'] = $this->msg['super_title'];
					$redirectUrl = 'admin/member/super_member';
					break;
				case 'member':
					$data['title'] = $this->msg['member_title'];
					$redirectUrl = 'admin/member/common_member';
					break;
			}
	    	$modify_id = $this->input->get('modify_id');
			$add_id = $this->input->post('add_id');
			$user_uid = $this->input->post('member_id');
	        if(!empty($add_id)){
	        	$username = $this->input->post('username');
	        	$password = $this->input->post('pwd');
		        $fields = array(
		        	'username'=>$username,
					'name'=>$this->input->post('name'),
					'pwd_text'=> trim($password),
					'email'=>$this->input->post('email'),
					'sex'=>$this->input->post('sex'), //default 0=>'男' 1=>'女'
					'phone'=>$this->input->post('phone'),
					'fax'=>$this->input->post('fax'),
					'last_login'=>date('Y-m-d H:i:s'),
					'super'=>$data['type']=='add' ?  ($data['is_super']=='super' ? '1' : '0') : $this->input->post('super'),
        			'ip'=>getrealip()
				);
		        if(empty($user_uid)){
		        	$salt = random_string('alpha', 8);
		        	$add = array(
		        		'user_uid'=>generateUniqueID(), 
		        		'password'=> md5((md5($password.$salt))),
		        		'join_time'=>time(),
		        		'login_num'=>0
		        	);
		        	$fields = array_merge($fields, $add);
					$this->member_model->insert_member($fields);
				}else{
					$row = $this->member_model->get_salt($user_uid);
					$salt = $row ? $row['salt'] : '';
					$update = array('password'=>md5((md5($password.$salt))));
					$fields = array_merge($fields, $update);
					$this->member_model->update_member($user_uid, $fields);
					
			    	$ses_username = $this->session->userdata('username');
			    	$ses_password = $this->session->userdata('password');
			    	if ($ses_username != $username || $password != $ses_password) {
			    		$this->session->unset_userdata('user_uid');
				    	$this->session->unset_userdata('username');
				    	$this->session->unset_userdata('password');
				    	$url = base_url().'admin/login';
				    	echo "<script>top.location.href='$url'</script>";
				    	exit;
			    	}
				}
				redirect(base_url().$redirectUrl);
	        }
	        if(!empty($modify_id)){
	        	$data['list'] = $this->member_model->getMemberById($modify_id);
	        }
	    	$this->load->view('admin/member/modify_member', $data);
			
		} catch (Exception $e) {
			die($e);
		}
    }
    
    
 	/**
     * member_search: search member
     * 
     * @author Jason Hu
     * @since  2014-3-28
     */
    function member_search(){
    	$data['is_super'] = $_REQUEST['is_super'];
    	
    	$params['search_field'] = $_REQUEST['search_field'];
    	$params['field_content'] = $_REQUEST['field_content'];
    	$params['sort_field'] = $_REQUEST['sort_field'];
    	switch ($data['is_super']){
    		case 'super':
		    	$data['title'] = $this->msg['super_title'];
    			break;
    		case 'member':
		    	$data['title'] = $this->msg['member_title'];
    			break;
    	}
    	$data['members'] = $this->member_model->get_super_admin($params);
        $this->load->view('admin/member/member', $data);
    }
    
    /**
     * delete_member: delete member
     *
     * @author Jason Hu
     * @since  2014-04-01
     */
    function delete_member() {
    	$loginuser = $this->session->userdata('user_uid');
    	$user_uid = $_REQUEST['delete_id'];
    	if ($loginuser == $user_uid) {
    		echo '<script>alert(\'该账号已处于登录状态，不能被删除\');history.back();</script>';
    	}else{
	    	$this->member_model->del_member($user_uid);
	    	redirect(base_url().'admin/member/common_member');
    	}
    }
    
    /**
     * del_super_member: delete super member
     *
     * @author Jason Hu
     * @since  2014-3-31
     */
    function batchDel($is_super='') {
    	$ids = $this->input->post('ids',TRUE);
        $id_arr = explode(',', $ids);
        $count = count($id_arr);
        $loginuser = $this->session->userdata('user_uid');
        $key = array_search($loginuser, $id_arr);
        if($key !== FALSE){
	        unset($id_arr[array_search($loginuser, $id_arr)]);
        }
        $new_count = count($id_arr);
        if ($new_count > 0) {
	        if($this->member_model->batchDel($id_arr)){
		        if( $count > $new_count ){
			        echo json_encode(array('success'=>1, 'msg'=>$this->msg['super_logined'], 'url'=>base_url().'admin/member/super_member'));
		        }else if($count == $new_count){
		            echo json_encode(array('success'=>1, 'msg'=>$this->msg['del_success'], 'url'=>base_url().'admin/member/super_member'));
		        }
	        }else{
	        	echo json_encode(array('success'=>0, 'msg'=>$this->msg['del_failed']));
	        }
        }else{
        	echo json_encode(array('success'=>0, 'msg'=>$this->msg['super_logined']));
        }
    }
    
    
    /**
     * change_to_super: change member to super
     *
     * @author Jason Hu
     * @since  2014-4-2
     */
    function change_to_super() {
    	$user_uid = $this->input->get('user_uid');
    	$this->member_model->change_to_super($user_uid);
    	redirect(base_url().'admin/member/common_member');
    }
}
