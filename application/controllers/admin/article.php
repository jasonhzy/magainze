<?php
/**
 * Article: Controller for article 
 *
 * @author Jason Hu
 * @since  2014/04/01
 */
class Article extends CI_Controller {
	
	private $pagesize = 10;
	private $msg;
	const LIMIT_SIZE = 2097152;
	
	function __construct() {
		parent::__construct ();
		$this->load->model('article_model');
        $this->load->helper('form');
		$this->msg = array(
			'index_title' => '文章管理',
			'verify_title' => '文章审核',
			'publish_title' => '文章发布',
			'mutil_del_success' => '批量删除成功',
			'mutil_del_failed' => '批量删除失败'
		);
	}

    function index(){
        //parameter for search or order 
		$params['category_name'] = isset($_REQUEST['category_name']) ? trim($_REQUEST['category_name']) : '';
		$params['article_name'] = isset($_REQUEST['article_name']) ? trim($_REQUEST['article_name']) : '';
    	$params['verify'] = isset($_REQUEST['verify']) ? trim($_REQUEST['verify']) : '';
		//pagination search params
    	$strParams = '';
    	if($params['category_name']){
			$strParams .= '&category_name='.$params['category_name'];
		}
		if($params['article_name']){
			$strParams .= '&article_name='.$params['article_name'];
		}
		if($params['verify']!=''){
			$strParams .= '&verify='.$params['verify'];
		}
		$params['page_type'] = 'index_page';
	    //init pagination
		$this->load->library('hpages');
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
	    $config['base_url'] = 'admin/article/index?id=article'.$strParams;
		$config['per_page'] = $this->pagesize;
		$config['uri_segment'] = 1;
		$config['num_links'] = 3;
		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$config['underline_uri_seg'] = 1;
		$config['total_rows'] = $this->article_model->get_article_count($params); 
		$this->hpages->init($config);
	    //page size/page num
	    $params['per_page'] = $config['per_page'];
	    $params['page_num'] = isset($_REQUEST['per_page']) ? ($_REQUEST['per_page'] ? $_REQUEST['per_page'] : 1) : 1;
	    
	    $data['article'] = $this->article_model->get_article_list($params);
	    $data['title'] = $this->msg['index_title'];
	    $data['total'] = $config['total_rows'];
	    
	    $data['page_num'] = $params['page_num'];
	    $data['article_name'] = $params['article_name'];
	    $data['category_name'] = $params['category_name'];
	    $data['verify'] = $params['verify'];
	    $data['article_total'] = $this->article_model->get_article_total($params);
	    $data['category'] = $this->article_model->get_article_category();
        $this->load->view('admin/article/article_list', $data);
    }
    
    
	/**
     * modify_article: finish add/update article
     *
     * @author Jason Hu
     * @since  2014-04-02
     */
	function modify_article() {
		try {
			$data['page_num'] = isset($_REQUEST['page_num']) ? $_REQUEST['page_num'] : '';
			$data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
			$data['category'] = $this->article_model->get_article_category();
			$modify_id = $this->input->get('modify_id');
			$add_id = $this->input->post('add_id');
			$article_id = $this->input->post('article_id');
	        if(!empty($add_id)){
	        	$position = $this->article_model->get_max_position();
	        	
	        	//handle image to save uploaded picture
	            $path = "/upload/".date('Y')."/".date('m').'/';
	        	if(!is_dir(BASEPATH . '../' . $path)){
		           	mkdir(BASEPATH . '../' . $path, 0777, true);
	        	}
	        	$upload_path = './upload/' . date ( 'Y' ) . '/' . date ( 'm' );
				$allowed_types = 'gif|jpg|png|jpeg';
				$encrypt_name = true;
				$max_size = self::LIMIT_SIZE;
				
				$config ['upload_path'] = $upload_path;
				$config ['allowed_types'] = $allowed_types;
				$config ['encrypt_name'] = $encrypt_name;
				$config ['max_size'] = $max_size;
				$config ['max_width'] = '1024';
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
				
				$bg_config ['upload_path'] = $upload_path;
				$bg_config ['allowed_types'] = $allowed_types;
				$bg_config ['encrypt_name'] = $encrypt_name;
	        	$bg_config ['max_size'] = $max_size;
				$bg_config ['max_width'] = '1000';
				$bg_config ['max_height'] = '1415';
				$bg_config ['file_name']  = time(); 
				$this->load->library ( 'upload', $bg_config );
				$this->upload->initialize ( $bg_config );
				$bg_image = '';
				if (!$this->upload->do_upload ('bg_image')) {
					$bg_image = $this->input->post('bg_upload') ? $this->input->post('bg_upload') : '';
				}else{
					$bg_image_data = $this->upload->data ();
					$bg_image = $path . $bg_image_data['file_name'];
				}
				
				$type = $this->input->post('templates');
				switch ($type) {
					case '1':
						$profile_height = '';
						$profile_space = '';
						$profile = '';
						break;
					case '2':
						$profile_height = $_POST['profile_height'];
						$profile_space = $_POST['profile_up'].','.$_POST['profile_down'].','.$_POST['profile_left'].','.$_POST['profile_right'];
						$profile = $_POST['profile'];
						break;
					default:
						break;
				}
				$content_space = $_POST['content_up'].','.$_POST['content_down'].','.$_POST['content_left'].','.$_POST['content_right'];
				
		        $fields = array(
					'id'=>generateUniqueID(),
		        	'name'=>$this->input->post('name'),
		        	'heading'=>$this->input->post('heading'),
		        	'subheading'=>$this->input->post('subheading'),
		        	'author'=>$this->input->post('author'),
		        	'keywords'=>$this->input->post('keywords'),
		        	'content'=>$this->input->post('content'),
		        	'image_url'=>$imageUrl,
		        	'bg_url'=>$bg_image,
		        	'is_recommend'=>$this->input->post('is_recommend'),
		        	'is_verify'=>0,
		        	'is_publish'=>0,
		        	'join_time'=>date('Y-m-d H:i:s'),
		        	'style_type' => $type, 
					'profile' => $profile,
					'profile_height' => $profile_height,
					'profile_space' => $profile_space,
					'content_space' => $content_space,
		        	'position'=> '',
		        	'category'=>$this->input->post('category')
				);
		        if(empty($article_id)){
					$this->article_model->insert_article($fields);
				}else{
					unset($fields['id']);
					unset($fields['join_time']);
					unset($fields['position']);
					$fields['is_verify'] = $this->input->post('is_verify');
					$fields['is_publish'] = $this->input->post('is_publish');
					$this->article_model->update_article($article_id, $fields);
				}
				redirect(base_url().'admin/article/index?id=article&per_page='.$data['page_num']);
	        }
	        if(!empty($modify_id)){
	        	$data['list'] = $this->article_model->getArticleById($modify_id);
	        }
	    	$this->load->view('admin/article/article_modify', $data);
		} catch (Exception $e) {
			die($e);
		}
    }
    
    /**
     * verify_article: verify article change is_verify = 1
     *
     * @author Jason Hu
     * @since  2014-04-01
     */
    function verify_article() {
    	$this->article_model->verify_article($_REQUEST['verify_id'], $_REQUEST['verify']);
    	switch ($_REQUEST['page_type']) {
			case 'verify_page':
		    	redirect(base_url().'admin/article/verify?verify='.($_REQUEST['verify'] == 1 ? '2' : '1'));
				break;
			case 'publish_page':
		    	redirect(base_url().'admin/article/publish?verify='.($_REQUEST['verify'] == 1 ? '2' : '1'));
				break;
			case 'index_page':
			default:
		    	redirect(base_url().'admin/article/index?verify=0');
				break;
		}
    }
    
	/**
     * delete_article: delete article
     *
     * @author Jason Hu
     * @since  2014-04-01
     */
    function delete_article() {
    	$this->article_model->del_article($_REQUEST['delete_id']);
    	redirect(base_url().'admin/article/index');
    }
    
    
	/**
     * batchDel: delete multi article
     *
     * @author Jason Hu
     * @since  2014-3-31
     */
    function batchDel() {
    	$ids = $this->input->post('ids',TRUE);
        $id_arr = explode(',', $ids);
	    if($this->article_model->batchDel($id_arr)){
		    echo json_encode(array('success'=>1, 'msg'=>$this->msg['mutil_del_success'], 'url'=>base_url().'admin/article/index'));
        }else{
        	echo json_encode(array('success'=>0, 'msg'=>$this->msg['mutil_del_failed']));
        }
    }
    
    /************************************************verify page*******************************************************/
    
	function verify(){
        //parameter for search or order 
		$params['category_name'] = isset($_REQUEST['category_name']) ? trim($_REQUEST['category_name']) : '';
		$params['article_name'] = isset($_REQUEST['article_name']) ? trim($_REQUEST['article_name']) : '';
    	$params['verify'] = isset($_REQUEST['verify']) ? trim($_REQUEST['verify']) : '';
		//pagination search params
    	$strParams = '';
    	if($params['category_name']){
			$strParams .= '&category_name='.$params['category_name'];
		}
		if($params['article_name']){
			$strParams .= '&article_name='.$params['article_name'];
		}
		if($params['verify']!=''){
			$strParams .= '&verify='.$params['verify'];
		}
		
		$params['page_type'] = 'verify_page';
		
	    //init pagination
		$this->load->library('hpages');
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
	    $config['base_url'] = 'admin/article/verify?id=article'.$strParams;
		$config['per_page'] = $this->pagesize;
		$config['uri_segment'] = 1;
		$config['num_links'] = 3;
		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$config['underline_uri_seg'] = 1;
		$config['total_rows'] = $this->article_model->get_article_count($params); 
		$this->hpages->init($config);
	    //page size/page num
	    $params['per_page'] = $config['per_page'];
	    $params['page_num'] = isset($_REQUEST['per_page']) ? ($_REQUEST['per_page'] ? $_REQUEST['per_page'] : 1) : 1;
	    
	    $data['article'] = $this->article_model->get_article_list($params);
	    $data['title'] = $this->msg['verify_title'];
	    $data['total'] = $config['total_rows'];
	    
	    $data['article_name'] = $params['article_name'];
	    $data['category_name'] = $params['category_name'];
	    $data['verify'] = $params['verify'];
	    
	    $data['category'] = $this->article_model->get_article_category();
        $this->load->view('admin/article/article_verify', $data);
    }
    
    
 /************************************************verify page*******************************************************/
    
	function publish(){
        //parameter for search or order 
		$params['category_name'] = isset($_REQUEST['category_name']) ? trim($_REQUEST['category_name']) : '';
		$params['article_name'] = isset($_REQUEST['article_name']) ? trim($_REQUEST['article_name']) : '';
    	$params['publish'] = isset($_REQUEST['publish']) ? trim($_REQUEST['publish']) : '';
    	$params['verify'] = '1';
		//pagination search params
    	$strParams = '';
    	if($params['category_name']){
			$strParams .= '&category_name='.$params['category_name'];
		}
		if($params['article_name']){
			$strParams .= '&article_name='.$params['article_name'];
		}
		if($params['publish']!=''){
			$strParams .= '&publish='.$params['publish'];
		}
		
		$params['page_type'] = 'publish_page';
		
	    //init pagination
		$this->load->library('hpages');
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
	    $config['base_url'] = 'admin/article/publish?id=article'.$strParams;
		$config['per_page'] = $this->pagesize;
		$config['uri_segment'] = 1;
		$config['num_links'] = 3;
		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$config['underline_uri_seg'] = 1;
		$config['total_rows'] = $this->article_model->get_article_count($params); 
		$this->hpages->init($config);
	    //page size/page num
	    $params['per_page'] = $config['per_page'];
	    $params['page_num'] = isset($_REQUEST['per_page']) ? ($_REQUEST['per_page'] ? $_REQUEST['per_page'] : 1) : 1;
	    
	    $data['article'] = $this->article_model->get_article_list($params);
	    $data['title'] = $this->msg['publish_title'];
	    $data['total'] = $config['total_rows'];
	    
	    $data['article_name'] = $params['article_name'];
	    $data['category_name'] = $params['category_name'];
	    $data['publish'] = $params['publish'];
	    
	    $data['category'] = $this->article_model->get_article_category();
        $this->load->view('admin/article/article_publish', $data);
    }
    
 	/**
     * verify_article: verify article change is_verify = 1
     *
     * @author Jason Hu
     * @since  2014-04-01
     */
    function publish_article() {
    	$this->article_model->publish_article($_REQUEST['publish_id'], $_REQUEST['publish']);
    	switch ($_REQUEST['page_type']) {
			case 'verify_page':
		    	redirect(base_url().'admin/article/verify');
				break;
			case 'publish_page':
		    	redirect(base_url().'admin/article/publish');
				break;
			case 'index_page':
			default:
		    	redirect(base_url().'admin/article/index');
				break;
		}
    }
    
}
?>
