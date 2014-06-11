<?php
/**
 * Magainze: Controller for magainze 
 *
 * @author Jason Hu
 * @since  2014/04/01
 */
class Magainze extends CI_Controller {
	
	private $pagesize = 3;
	private $msg;
	const LIMIT_SIZE = 2097152;
	
	function __construct() {
		parent::__construct ();
		$this->load->model('magainze_model');
        $this->load->helper('form');
		$this->msg = array(
			'index_title' => '杂志管理',
			'verify_title' => '杂志审核',
			'publish_title' => '杂志发布',
			'mutil_del_success' => '批量删除成功',
			'mutil_del_failed' => '批量删除失败'
		);
	}

    function index(){
        //parameter for search or order 
		$params['search_field'] = isset($_REQUEST['search_field']) ? $_REQUEST['search_field'] : '';
		$params['field_content'] = isset($_REQUEST['field_content']) ? $_REQUEST['field_content'] : '';
	    $params['verify'] = isset($_REQUEST['verify']) ? trim($_REQUEST['verify']) : '';
    	//pagination search params
    	$strParams = '';
    	if(isset($params['search_field'])){
			$strParams .= '&search_field='.$params['search_field'];
		}
		if(isset($params['field_content']) && $params['field_content']){
			$strParams .= '&field_content='.$params['field_content'];
		}
		if($params['verify']!=''){
			$strParams .= '&verify='.$params['verify'];
		}
		$params['page_type'] = 'index_page';
	    //init pagination
		$this->load->library('hpages');
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
	    $config['base_url'] = 'admin/magainze/index?id=magainze'.$strParams;
		$config['per_page'] = $this->pagesize;
		$config['uri_segment'] = 1;
		$config['num_links'] = 3;
		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$config['underline_uri_seg'] = 1;
		$config['total_rows'] = $this->magainze_model->get_magainze_count($params); 
		$this->hpages->init($config);
	    //page size/page num
	    $params['per_page'] = $config['per_page'];
	    $params['page_num'] = isset($_REQUEST['per_page']) ? ($_REQUEST['per_page'] ? $_REQUEST['per_page'] : 1) : 1;
	    
	    $data['magainze'] = $this->magainze_model->get_magainze_list($params);
	    $data['title'] = $this->msg['index_title'];
	    $data['total'] = $config['total_rows'];
	    $data['search_field'] = $params['search_field'];
    	$data['field_content'] = $params['field_content'];
    	$data['verify'] = $params['verify'];
    	$data['magainze_total'] = $this->magainze_model->get_magainze_total($params); 
    	
        $this->load->view('admin/magainze/magainze_list', $data);
    }
    
    /**
     * verify_magainze: verify magainze change is_verify = 1
     *
     * @author Jason Hu
     * @since  2014-04-01
     */
    function verify_magainze() {
    	$this->magainze_model->verify_magainze($_REQUEST['verify_id'], $_REQUEST['verify']);
    	switch ($_REQUEST['page_type']) {
			case 'verify_page':
		    	redirect(base_url().'admin/magainze/verify?verify='.($_REQUEST['verify'] == 1 ? '2' : '1'));
				break;
			case 'publish_page':
		    	redirect(base_url().'admin/magainze/publish?verify='.($_REQUEST['verify'] == 1 ? '2' : '1'));
				break;
			case 'index_page':
			default:
		    	redirect(base_url().'admin/magainze/index?verify=0');
				break;
		}
    }
    
	/**
     * delete_magainze: delete magainze
     *
     * @author Jason Hu
     * @since  2014-04-01
     */
    function delete_magainze() {
    	$this->magainze_model->del_magainze($_REQUEST['delete_id']);
    	redirect(base_url().'admin/magainze/index');
    }
    
    
	/**
     * batchDel: delete super member
     *
     * @author Jason Hu
     * @since  2014-3-31
     */
    function batchDel() {
    	$ids = $this->input->post('ids',TRUE);
        $id_arr = explode(',', $ids);
	    if($this->magainze_model->batchDel($id_arr)){
		    echo json_encode(array('success'=>1, 'msg'=>$this->msg['mutil_del_success'], 'url'=>base_url().'admin/magainze/index'));
        }else{
        	echo json_encode(array('success'=>0, 'msg'=>$this->msg['mutil_del_failed']));
        }
    }
    
    /*******************************************verify page************************************************************/
	function verify(){
        //parameter for search or order 
		$params['search_field'] = isset($_REQUEST['search_field']) ? $_REQUEST['search_field'] : '';
		$params['field_content'] = isset($_REQUEST['field_content']) ? $_REQUEST['field_content'] : '';
	    $params['verify'] = isset($_REQUEST['verify']) ? trim($_REQUEST['verify']) : '';
    	//pagination search params
    	$strParams = '';
    	if(isset($params['search_field'])){
			$strParams .= '&search_field='.$params['search_field'];
		}
		if(isset($params['field_content']) && $params['field_content']){
			$strParams .= '&field_content='.$params['field_content'];
		}
		if($params['verify']!=''){
			$strParams .= '&verify='.$params['verify'];
		}
		$params['page_type'] = 'verify_page';
	    //init pagination
		$this->load->library('hpages');
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
	    $config['base_url'] = 'admin/magainze/verify?id=magainze'.$strParams;
		$config['per_page'] = $this->pagesize;
		$config['uri_segment'] = 1;
		$config['num_links'] = 3;
		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$config['underline_uri_seg'] = 1;
		$config['total_rows'] = $this->magainze_model->get_magainze_count($params); 
		$this->hpages->init($config);
	    //page size/page num
	    $params['per_page'] = $config['per_page'];
	    $params['page_num'] = isset($_REQUEST['per_page']) ? ($_REQUEST['per_page'] ? $_REQUEST['per_page'] : 1) : 1;
	    
	    $data['magainze'] = $this->magainze_model->get_magainze_list($params);
	    $data['title'] = $this->msg['verify_title'];
	    $data['total'] = $config['total_rows'];
	    $data['search_field'] = $params['search_field'];
    	$data['field_content'] = $params['field_content'];
    	$data['verify'] = $params['verify'];
    	$data['magainze_total'] = $this->magainze_model->get_magainze_total($params); 
    	
        $this->load->view('admin/magainze/magainze_verify', $data);
    }
    
    /**********************************publish page***************************************************/
    
	function publish(){
        //parameter for search or order 
		$params['search_field'] = isset($_REQUEST['search_field']) ? $_REQUEST['search_field'] : '';
		$params['field_content'] = isset($_REQUEST['field_content']) ? $_REQUEST['field_content'] : '';
	    $params['publish'] = isset($_REQUEST['publish']) ? trim($_REQUEST['publish']) : '';
		$params['verify']= '1';
    	//pagination search params
    	$strParams = '';
    	if(isset($params['search_field'])){
			$strParams .= '&search_field='.$params['search_field'];
		}
		if(isset($params['field_content']) && $params['field_content']){
			$strParams .= '&field_content='.$params['field_content'];
		}
		if($params['publish']!=''){
			$strParams .= '&publish='.$params['publish'];
		}
		$params['page_type'] = 'publish_page';
	    //init pagination
		$this->load->library('hpages');
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
	    $config['base_url'] = 'admin/magainze/publish?id=magainze'.$strParams;
		$config['per_page'] = $this->pagesize;
		$config['uri_segment'] = 1;
		$config['num_links'] = 3;
		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$config['underline_uri_seg'] = 1;
		$config['total_rows'] = $this->magainze_model->get_magainze_count($params); 
		$this->hpages->init($config);
	    //page size/page num
	    $params['per_page'] = $config['per_page'];
	    $params['page_num'] = isset($_REQUEST['per_page']) ? ($_REQUEST['per_page'] ? $_REQUEST['per_page'] : 1) : 1;
	    
	    $data['magainze'] = $this->magainze_model->get_magainze_list($params);
	    $data['title'] = $this->msg['publish_title'];
	    $data['total'] = $config['total_rows'];
	    $data['search_field'] = $params['search_field'];
    	$data['field_content'] = $params['field_content'];
    	$data['publish'] = $params['publish'];
    	$data['magainze_total'] = $this->magainze_model->get_magainze_total($params); 
    	
        $this->load->view('admin/magainze/magainze_publish', $data);
    }
    
	/**
     * publish_magainze: publish magainze change publish=0/1
     *
     * @author Jason Hu
     * @since  2014-04-01
     */
    function publish_magainze() {
    	$this->magainze_model->publish_magainze($_REQUEST['publish_id'], $_REQUEST['publish']);
    	switch ($_REQUEST['page_type']) {
			case 'verify_page':
		    	redirect(base_url().'admin/magainze/verify?publish='.$_REQUEST['publish']);
				break;
			case 'publish_page':
		    	redirect(base_url().'admin/magainze/publish?publish='.($_REQUEST['publish'] == 1 ? '0' : '1'));
				break;
			case 'index_page':
			default:
		    	redirect(base_url().'admin/magainze/index?publish='.$_REQUEST['publish']);
				break;
		}
    }
    
    
    /**
     * magainze_add: load add magainze page
     *
     * @author Jason Hu
     * @since  2014-4-3
     */
    function magainze_add() {
    	$this->load->model('article_model');
		$data['category'] = $this->article_model->get_article_category();
		$data['category_article'] = $this->magainze_model->get_category_article();
		
		$aYear = array();
		$curYear = date('Y');
		
		for ($index = 5; $index >= 1; $index--) {
			array_push($aYear, $curYear - $index);
		}
		for ($index = 0; $index <= 5; $index++) {
			array_push($aYear, $curYear + $index);
		}
		$data['year'] = $aYear;
    	$this->load->view('admin/magainze/magainze_add', $data);
    }
    
    
    /**
     * add_magainze : the function for add magainze to db
     *
     * @author Jason Hu
     * @since  2014-4-11
     */
    function add_magainze() {
    	$magainze_id = generateUniqueID();
    	
    	$year = trim($this->input->post('magainze_year')) ? trim($this->input->post('magainze_year')) : '';
	    $periods= trim($this->input->post('magainze_periods')) ? trim($this->input->post('magainze_periods')) : '' ;
	    $total_periods = trim($this->input->post('total_periods')) ? trim($this->input->post('total_periods')) : '';
	    $remark = $year.','.$periods.','.$total_periods;
	    
    	//handle image to save uploaded picture
        $path = "/upload/".date('Y')."/".date('m').'/';
        if(!is_dir(BASEPATH . '../' . $path)){
           	mkdir(BASEPATH . '../' . $path, 0777, true);
        }
        $config ['upload_path'] = './upload/' . date ( 'Y' ) . '/' . date ( 'm' );
		$config ['allowed_types'] = 'gif|jpg|png';
		$config ['max_size'] = self::LIMIT_SIZE;
		$config ['max_width'] = '1024';
		$config ['encrypt_name'] = true;
		$config ['max_height'] = '768';
		$config ['file_name']  = time(); 
		$this->load->library ( 'upload', $config );
		$this->upload->initialize ( $config );
		$imageUrl = '';
		if ($this->upload->do_upload ('image_url')) {
			$image_data = $this->upload->data ();
			$imageUrl = $path . $image_data['file_name'];
		}else{
			die($this->upload->display_errors());
		}
    	$insert = array(
    		'id'=>$magainze_id,
    		'name'=>trim($this->input->post('magainze_name')),
		    'is_recommend'=>$this->input->post('is_recommend'),
    		'cover_url'=>$imageUrl,
    		'is_verify'=> '0',
    		'is_publish'=>'0',
    		'join_time'=>date('Y-m-d H:i:s'),
    		'status'=>1,
    		'remark'=>$remark
    	);
    	$this->load->model('article_model');
    	$category = $this->article_model->get_article_category();
    	$article_ids = array();
    	foreach ($category as $v) {
    		$article = trim($this->input->post('tag_'.$v['ID'])) ? trim($this->input->post('tag_'.$v['ID'])) : '' ; 
    		if ($article) {
	    		$article_ids = array_merge($article_ids , explode(',', $article));
    		}
    	}
    	$this->magainze_model->add_magainze($insert, $article_ids);
    	redirect(base_url().'admin/magainze/index');
    	
    }
    
    /**
     * magainze_add: add magainze 
     *
     * @author Jason Hu
     * @since  2014-4-3
     */
    function magainze_edit() {
    	$this->load->model('article_model');
		$data['category'] = $this->article_model->get_article_category();
		$data['category_article'] = $this->magainze_model->get_category_article();
		
		$aYear = array();
		$curYear = date('Y');
		
		for ($index = 5; $index >= 1; $index--) {
			array_push($aYear, $curYear - $index);
		}
		for ($index = 0; $index <= 5; $index++) {
			array_push($aYear, $curYear + $index);
		}
		$data['year'] = $aYear;
		$data['magainze_article'] = $this->magainze_model->get_magainze_detail($_REQUEST['modify_id'])->detail;
		$data['magainze'] = $this->magainze_model->get_magainze_detail($_REQUEST['modify_id'])->magainze_info;
    	if(!$data['magainze']){
    		$data['magainze'] = $this->magainze_model->get_magainze_by_id($_REQUEST['modify_id']);
    	}
		$this->load->view('admin/magainze/magainze_edit', $data);
    }
    
    
    /**
     * edit_magainze : edit magainze
     *
     * @author Jason Hu
     * @since  2014-4-14
     */
    function edit_magainze() {
    	$magainze_id = $this->input->post('magainze_id');
    	
    	$year = trim($this->input->post('magainze_year')) ? trim($this->input->post('magainze_year')) : '';
	    $periods= trim($this->input->post('magainze_periods')) ? trim($this->input->post('magainze_periods')) : '' ;
	    $total_periods = trim($this->input->post('total_periods')) ? trim($this->input->post('total_periods')) : '';
	    $remark = $year.','.$periods.','.$total_periods;
	    
    	//handle image to save uploaded picture
        $path = "/upload/".date('Y')."/".date('m').'/';
        if(!is_dir(BASEPATH . '../' . $path)){
           	mkdir(BASEPATH . '../' . $path, 0777, true);
        }
        $config ['upload_path'] = './upload/' . date ( 'Y' ) . '/' . date ( 'm' );
		$config ['allowed_types'] = 'gif|jpg|png';
		$config ['max_size'] = self::LIMIT_SIZE;
		$config ['max_width'] = '1024';
		$config ['encrypt_name'] = true;
		$config ['max_height'] = '768';
		$config ['file_name']  = time(); 
		$this->load->library ( 'upload', $config );
		$this->upload->initialize ( $config );
		$imageUrl = '';
		if (!$this->upload->do_upload ('image_url')) {
			$imageUrl = $this->input->post('upload_url') ? $this->input->post('upload_url') : '';
		}else{
			$image_data = $this->upload->data ();
			$imageUrl = $path . $image_data['file_name'];
		}
    	$update = array(
    		'name'=>trim($this->input->post('magainze_name')),
		    'is_recommend'=>$this->input->post('is_recommend'),
    		'cover_url'=>$imageUrl,
    		'remark'=>$remark
    	);
    	$this->load->model('article_model');
    	$category = $this->article_model->get_article_category();
    	$article_ids = array();
    	foreach ($category as $v) {
    		$article = trim($this->input->post('tag_'.$v['ID'])) ? trim($this->input->post('tag_'.$v['ID'])) : '' ; 
    		if ($article) {
	    		$article_ids = array_merge($article_ids , explode(',', $article));
    		}
    	}
    	$this->magainze_model->edit_magainze($magainze_id, $update, $article_ids);
    	redirect(base_url().'admin/magainze/index');
    }
    
}
?>
