<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Search: class for search article
 *
 * @author Jason Hu
 * @since  2014/04/09
 */
class Search extends CI_Controller {
    
	private $pagesize = 4;//page size
	
	/**
     * __construct: Constructors to load model 
     */
	function __construct(){
        parent::__construct();
        $this->load->model('front_model');
    }

    /**
     * index: load article search page
     *
     * @author Jason Hu
     * @since  2014-4-8
     */
    function index() {
    	
    	//parameter for search or order 
		$params['keyword'] = isset($_REQUEST['keyword']) ? trim($_REQUEST['keyword']) : '';
    	
    	$strParams = '';
    	if($params['keyword']){
			$strParams .= '&keyword='.$params['keyword'];
		}
    	//init pagination
		$this->load->library('hpages');
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
	    $config['base_url'] = 'front/search/index?id=search'.$strParams;
		$config['per_page'] = $this->pagesize;
		$config['uri_segment'] = 1;
		$config['num_links'] = 3;
		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$config['underline_uri_seg'] = 0;
		$config['total_rows'] = $this->front_model->get_article_count($params); 
		$this->hpages->init($config);
		
		//page size/page num
	    $params['per_page'] = $config['per_page'];
	    $params['page_num'] = isset($_REQUEST['per_page']) ? ($_REQUEST['per_page'] ? $_REQUEST['per_page'] : 1) : 1;
    	
	    $data['keyword'] =  $params['keyword'];
	    $data['num'] =  $config['total_rows'] ? ($config['total_rows']<$config['per_page'] ? $config['total_rows'] : $config['per_page'] ) : 0;
	    $data['total'] =  $config['total_rows'];
	    
	    $data['article'] = $this->front_model->get_article_list($params);
    	$data['magainze'] = $this->front_model->get_topfive_magainze();
    	
    	$data['title'] = '圣陶教育@第一线 - 搜索';
    	$this->load->view('front/search', $data);
    }
}
