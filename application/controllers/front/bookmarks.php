<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Article: class for setting
 *
 * @author Jason Hu
 * @since  2014/04/08
 */
class Bookmarks extends CI_Controller {
    
	private $msg;
	/**
     * __construct: Constructors to load model 
     */
	function __construct(){
        parent::__construct();
        $this->load->model('base_model');
        $this->load->model('front_model');
        $this->msg = array(
        	'mark_exist'=>'已经被添加到书签',
        	'mark_success'=>'成功添加书签',
        	'mark_failed'=>'添加书签失败'
        );
    }

    /**
     *
     * @author Jason Hu
     * @since  2014-4-8
     */
	public function index(){
		$userinfo = $this->base_model->check_valid(); 
		$user_uid = isset($userinfo['FRONT_USER_UID']) ? $userinfo['FRONT_USER_UID']:"";
		if (!$user_uid) {
			$this->session->set_flashdata('redirect', base_url().'front/bookmarks/index');
			redirect(base_url().'home/login');
		}else{
			$data['magainze'] = $this->front_model->get_topfive_magainze();
			$data['bookmarks'] = $this->front_model->get_bookmarks($user_uid);
			$data['title'] = '圣陶教育@第一线 - 书签';
			$this->load->view('front/bookmarks', $data);
		}
	}
	
	/**
	 * add_bookmarks : add bookmarks for current user
	 *
	 * @author Jason Hu
	 * @since  2014-4-8
	 */
	public function add_bookmarks(){
		$article_id = $_REQUEST['article_id'];
		$magainze_id = $_REQUEST['magainze_id'];
		$userinfo = $this->base_model->check_valid(); 
		$user_uid = isset($userinfo['FRONT_USER_UID']) ? $userinfo['FRONT_USER_UID']:"";
		if (!$user_uid) {
			$this->session->set_flashdata('redirect', base_url().'front/article/index?magainze_id='.$magainze_id.'&article_id='.$article_id);
			echo json_encode(array('success'=>0, 'url'=>base_url().'home/login'));
		}else{
			switch ($this->front_model->add_bookmarks($article_id, $user_uid)) {
				case 0:
					echo json_encode(array('success'=>1, 'msg'=>$this->msg['mark_exist']));
					break;
				case 1:
					echo json_encode(array('success'=>1, 'msg'=>$this->msg['mark_success']));
					break;
				default:
					echo json_encode(array('success'=>1, 'msg'=>$this->msg['mark_failed']));
					break;
			}
		}
	}
	
	/**
	 * del_bookmarks : delete bookmarks
	 *
	 * @author Jason Hu
	 * @since  2014-4-8
	 */
	function del_bookmarks() {
		$userinfo = $this->base_model->check_valid(); 
		$user_uid = isset($userinfo['FRONT_USER_UID']) ? $userinfo['FRONT_USER_UID']:"";
		if (!$user_uid) {
			$this->session->set_flashdata('redirect', base_url().'front/bookmarks/index');
			redirect(base_url().'home/login');
		}else{
			$this->front_model->del_bookmarks();
			redirect(base_url().'front/bookmarks/index');
		}
	}
	
	
	/**
	 * add_love : when user logined, to set love or not love article
	 *
	 * @author Jason Hu
	 * @since  2014-4-17
	 */
	function add_love() {
		$article_id = $_REQUEST['article_id'];
		$magainze_id = $_REQUEST['magainze_id'];
		$is_love = $_REQUEST['is_love'];
		$userinfo = $this->base_model->check_valid(); 
		$user_uid = isset($userinfo['FRONT_USER_UID']) ? $userinfo['FRONT_USER_UID']:"";
		if (!$user_uid) {
			$this->session->set_flashdata('redirect', base_url().'front/article/index?magainze_id='.$magainze_id.'&article_id='.$article_id);
			echo json_encode(array('success'=>false, 'url'=>base_url().'home/login'));
		}else{
			$this->front_model->add_love($article_id, $user_uid, $is_love);
			echo json_encode(array('success'=>true, 'msg'=>'save success'));
		}
	}
}
