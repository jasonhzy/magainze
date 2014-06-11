<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Home: class for front
 *
 * @author Jason Hu
 * @since  2014/03/26
 */
class Home extends CI_Controller{
	
	private $msg;
	private $pagesize = 15;
	private $expire;
	
	function __construct(){
	 	parent::__construct();
	 	$this->expire = time() + EXPIREDATE * 86400;
	 	$this->load->model('front_model');
	 	$this->load->model('base_model');
	 	$this->load->helper('form');
	 	$this->msg = array(
	 		'index_title'=>'杂志首页',
	 		'login_title'=>'登录',
	 		'register_title'=>'注册',
	 		'forget_title'=>'忘记密码'
	 	);
	}
	
	public function index(){
		$data['title'] = $this->msg['index_title'];
		$userinfo = $this->base_model->check_valid(); 
		$user_uid = isset($userinfo['FRONT_USER_UID']) ? $userinfo['FRONT_USER_UID']:"";
		if (!$user_uid) {
			$data['logined'] = '1';
		}else{
			$data['logined'] = '0';
		}
		$data['title'] = '圣陶教育@第一线 - 首页';
		$data['magainze'] = $this->front_model->get_topfive_magainze();
		$data['banner'] = $this->front_model->get_banner_list();
		$this->load->view('home', $data);
	}
	
	//user login
	public function login(){
		$data['title'] = $this->msg['login_title'];
		$data['magainze'] = $this->front_model->get_topfive_magainze();
		$data['callback'] = isset($_REQUEST['callback']) ? $_REQUEST['callback'] : '';
		$data['title'] = '圣陶教育@第一线 - 登录';
		$data['redirect'] = $this->session->flashdata('redirect');
		$this->load->view('front/login', $data);
	}
	//register user
	public function register(){
		$data['title'] = $this->msg['register_title'];
		$data['magainze'] = $this->front_model->get_topfive_magainze();
		$data['title'] = '圣陶教育@第一线 - 注册';
		$this->load->view('front/register', $data);
	}
	//find password
	public function forget(){
		$data['title'] = $this->msg['forget_title'];
		$data['magainze'] = $this->front_model->get_topfive_magainze();
		$data['title'] = '圣陶教育@第一线 - 找回密码';
		$this->load->view('front/forget', $data);
	}
	
	public function login_info(){
		$userinfo = $this->base_model->check_valid(); 
		$user_uid = isset($userinfo['FRONT_USER_UID']) ? $userinfo['FRONT_USER_UID']:"";
		if (!$user_uid) {
			$this->session->set_flashdata('redirect', base_url().'home/login_info');
			redirect(base_url().'home/login');
		}else{
			$data['username'] = $userinfo['FRONT_USERNAME'];
			$data['email'] = $userinfo['FRONT_EMAIL'];
			$data['magainze'] = $this->front_model->get_topfive_magainze();
			$data['title'] = '圣陶教育@第一线 - 账户管理';
			$this->load->view('front/login_info', $data);
		}
	}
	
	//forget password tooltip
	public function forget_tip(){
		$data['magainze'] = $this->front_model->get_topfive_magainze();
		$data['email'] = $_REQUEST['email'];
        $data['email_url'] = $_REQUEST['email_url'];
        $data['title'] = '圣陶教育@第一线 - 提示';
		$this->load->view('front/forget_tip', $data);
	}
	
	//reset pawd
	public function reset_pwd(){
		$data['user_uid'] = $_REQUEST['user_uid'];
        $data['salt'] = $_REQUEST['salt'];
		$data['magainze'] = $this->front_model->get_topfive_magainze();
		$data['title'] = '圣陶教育@第一线 - 修改密码';
		$this->load->view('front/reset_pwd', $data);
	}
	
	
	
	public function read_history(){
		$userinfo = $this->base_model->check_valid(); 
		$user_uid = isset($userinfo['FRONT_USER_UID']) ? $userinfo['FRONT_USER_UID']:"";
		if (!$user_uid) {
			$this->session->set_flashdata('redirect', base_url().'home/read_history');
			redirect(base_url().'home/login');
		}else{
			//back to contents
			$this->load->model('front_model');
	        $topOne = $this->front_model->get_topone_magainze();
			$data['url'] = base_url().'home/homepage?magainze_id='.$topOne['ID'];
			$data['magainze'] = $this->front_model->get_topfive_magainze();
			
			$params['user_uid'] = $user_uid;
			
			$strParams = '';
			if($params['user_uid']){
				$strParams .= '&user_uid='.$user_uid;
			}
	    	//init pagination
			$this->load->library('hpages');
			$config['page_query_string'] = TRUE;
			$config['use_page_numbers'] = TRUE;
		    $config['base_url'] = 'home/read_history?id=history'.$strParams;
			$config['per_page'] = $this->pagesize;
			$config['uri_segment'] = 1;
			$config['num_links'] = 3;
			$config['first_link'] = '首页';
			$config['last_link'] = '末页';
			$config['next_link'] = '下一页';
			$config['prev_link'] = '上一页';
			$config['underline_uri_seg'] = 0;
			$config['total_rows'] = $this->front_model->get_history_count($params); 
			$this->hpages->init($config);
			
			//page size/page num
		    $params['per_page'] = $config['per_page'];
		    $params['page_num'] = isset($_REQUEST['per_page']) ? ($_REQUEST['per_page'] ? $_REQUEST['per_page'] : 1) : 1;
			$data['history'] = $this->front_model->get_history_list($params); 
			$data['title'] = '圣陶教育@第一线 - 阅读记录';
			$this->load->view('front/read_history', $data);
		}
	}
	
	public function func_setting(){
		$userinfo = $this->base_model->check_valid(); 
		$uid = isset($userinfo['FRONT_USER_UID']) ? $userinfo['FRONT_USER_UID']:"";
		if (!$uid) {
			$this->session->set_flashdata('redirect', base_url().'home/func_setting');
			redirect(base_url().'home/login');
		}else{
			$data['magainze'] = $this->front_model->get_topfive_magainze();
			$cts =$this->base_model->getInfoById(CONTENT,array('value'=>$uid, 'type'=>'FONT_SIZE'));
			$fontsize = empty($cts) ? DEFAULT_FONT_SIZE : $cts['flag'];
			setcookie ( 'fontSize', $fontsize, $this->expire, "/", $_SERVER['HTTP_HOST']);
			$data['title'] = '圣陶教育@第一线 - 功能设置';
			$this->load->view('front/func_setting', $data);
		}
	}
	
	public function about_us(){
		$data['magainze'] = $this->front_model->get_topfive_magainze();
		$data['title'] = '圣陶教育@第一线 - 关于我们';
		$this->load->view('front/about_us', $data);
	}
	
	function homepage() {
		$this->load->model('article_model');
		$param['magainze_id'] =  isset($_REQUEST['magainze_id']) ? $_REQUEST['magainze_id'] : '';
		$data['category'] = $this->article_model->get_article_category();
		$data['magainze'] = $this->front_model->get_topfive_magainze();
		
		
		$data['cover_url'] = '/static/images/front/contentimg.png';
		$data['desc'] = '';
		
		if ($data['magainze']) {
			foreach ($data['magainze'] as $v) {
				if ($v['ID'] == $param['magainze_id']) {
					$data['cover_url'] = $v['COVER_URL'];
					$str = '';
					if (trim($v['REMARK'])) {
						$desc = explode(',', $v['REMARK']);
						$str = count($desc)>=3 ? $desc[0].'年/'.$desc[1].'期/总第'.$desc[2].'期' : '';
					}
					$data['desc'] = $str;
					break;
				}
			}
		}
		$data['article'] = $this->front_model->get_category_article($param);
		$aContents = array();
		if($data['article']){
			foreach ($data['article'] as $article) {
				if($article){
					foreach ($article as $key=>$v) {
						$aContents [] = $v;
					}
				}
			}
		}
		$data['contents'] = $aContents;
		$data['magainze_id'] = $param['magainze_id'];
		$data['title'] = '圣陶教育@第一线 - 目录';
		$data['is_article'] = '1';
		$this->load->view('front/homepage', $data);
	}
	
}
?>