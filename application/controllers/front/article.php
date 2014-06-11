<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Article: class for setting
 *
 * @author Jason Hu
 * @since  2014/04/08
 */
class Article extends CI_Controller {
    
	private $font_type = 'FONT_SIZE';
	private $height = 0; //A4 height
	private $width = 0; //A4 width
	
	/**
     * __construct: Constructors to load model 
     */
	function __construct(){
        parent::__construct();
        $this->load->model('front_model');
		$this->load->model('base_model');
		$this->height = 1415;
		$this->width = 1000;
		
    }

    /**
     * content: load article content page
     *
     * @author Jason Hu
     * @since  2014-4-8
     */
    function index() {
//    	$userinfo = $this->base_model->check_valid(); 
//		$uid = isset($userinfo['FRONT_USER_UID']) ? $userinfo['FRONT_USER_UID']:"";
//		if (!$uid) {
//			$this->session->set_flashdata('redirect', base_url().'front/bookmarks/index');
//			redirect(base_url().'home/login');
//			exit;
//		}
    	$param['article_id'] = isset($_REQUEST['article_id']) ? $_REQUEST['article_id'] : '';
    	$param['magainze_id'] = isset($_REQUEST['magainze_id']) ? $_REQUEST['magainze_id'] : '';
    	
    	if(isset($_REQUEST['bookmarks_id'])){
    		$bookmark = $this->front_model->get_article_magainze_id($_REQUEST['bookmarks_id']);
    		$param['article_id'] = $bookmark['article_id'];
    		$param['magainze_id'] = $bookmark['magainze_id'];
    	}
    	
    	if (!$param['magainze_id'] && !isset($_REQUEST['bookmarks_id'])) {
    		//cannot get magainze id by article, because one article can belong to more than one magainze
       		$topOne = $this->front_model->get_topone_magainze();
       		if ($topOne) {
       			$param['magainze_id'] = $topOne['ID'];
       		}
    	}
    	
    	$data['article_id'] = $param['article_id'];
    	$data['magainze_id'] = $param['magainze_id'];
    	$data['is_article'] = '2';
    	$data['magainze'] = $this->front_model->get_topfive_magainze();
    	$data['fontsize'] =  DEFAULT_FONT_SIZE;
    	
		$userinfo = $this->base_model->check_valid(); 
		if($userinfo){
	    	$param['user_uid'] = $userinfo['FRONT_USER_UID'];
	    	$data['fontsize'] = $this->front_model->get_font($param['user_uid']);
	    	$this->front_model->add_read_history($param);
		}
    	$data['article_detail'] = $this->front_model->get_article_detail($param);
    	
    	$content_up = '15';
    	$content_down = '15';
    	$content_left = '15';
    	$content_right = '10';
    	$content_height = '1415';
    	
    	$profile_up = '15';
    	$profile_down = '15';
    	$profile_left = '15';
    	$profile_right = '10';
    	$profile_height = '500';
    	
    	$space = explode(',', $data['article_detail']['content_space']);
    	if(count($space) == 4){
    		$content_up = $space[0];
    		$content_down = $space[1];
    		$content_left = $space[2];
    		$content_right = $space[3];
    	}
    	$view = 'content';
    	switch ($data['article_detail']['type']) {
    		case '1':
	    		$content_height = $this->height - $content_up - $content_down;
	    		$view = 'content_temp_one';
	    		break;
    		case '2':
    			$space = explode(',', $data['article_detail']['profile_space']);
	    		if(count($space) == 4){
	    			$profile_up = $space[0];
	    			$profile_down = $space[1];
	    			$profile_left = $space[2];
	    			$profile_right = $space[3];
	    		}
	    		$profile_height = $data['article_detail']['profile_height'];
	    		$content_height = $this->height - $profile_height - $profile_up - $profile_down - $content_up - $content_down;
	    		$view = 'content_temp_two';
	    		break;
    		default:
    			break;
    	}
    	$data['article_detail']['content_space'] = $content_up.'px '.$content_right.'px '.$content_down.'px '.$content_left.'px';
    	$data['article_detail']['content_height'] = $content_height;
    	$data['article_detail']['profile_space'] = $profile_up.'px '.$profile_right.'px '.$profile_down.'px '.$profile_left.'px';
    	$data['article_detail']['profile_height'] = $profile_height;
    	$data['title'] = '圣陶教育@第一线 - 文章';
    	$data['keywords'] =  $data['article_detail']['keywords'] ? $data['article_detail']['keywords'] : '';
    	$data['desc'] = $data['article_detail']['keywords'] ? $data['article_detail']['keywords'] : '';
    	$this->load->view('front/'.$view, $data);
    }
    
	/**
     * font_setting: set font size
     *
     * @author Jason Hu
     * @since  2014-4-8
     */
    function font_setting() {
		$userinfo = $this->base_model->check_valid(); 
		$uid = isset($userinfo['FRONT_USER_UID']) ? $userinfo['FRONT_USER_UID']:"";
		if (!$uid) {
	    	$this->session->set_flashdata('redirect', base_url().'home/func_setting');
			echo json_encode(array('success'=>false, 'url'=>site_url('home/login')));
			exit;
		}
    	$fontsize = $this->input->post('font_size') ? $this->input->post('font_size') : DEFAULT_FONT_SIZE;
		$re =$this->base_model->is_existed(CONTENT, array('value'=>$uid, 'type'=>$this->font_type));
		setcookie ( 'fontSize', $fontsize, time () + 86400, "/" ,$_SERVER['HTTP_HOST']);
		if($re){	
			$this->base_model->update(CONTENT,array('value'=>$uid, 'type'=>$this->font_type),array('flag'=>$fontsize));
		}else{
			$this->base_model->create(CONTENT,array('id'=>generateUniqueID(), 'type'=>'FONT_SIZE','value'=>$uid, 'flag'=>$fontsize));
		}
		echo json_encode(array('success'=>true, 'message'=>'save successful!'));
    }
}
