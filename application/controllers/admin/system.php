<?php
/**
 * System: Controller for system setting
 *
 * @author Jason Hu
 * @since  2014/04/03
 */
class System extends CI_Controller {
	
	private $msg;
	const LIMIT_SIZE = 2097152;
	
	function __construct() {
		parent::__construct ();
		$this->load->model('system_model');
		$this->image_name = 'qrcode.png';
		$this->path = BASEPATH.'../static/images/';
		$this->msg = array(
			'mutil_del_success' => '批量删除成功',
			'mutil_del_failed' => '批量删除失败'
		);
	}

    /**
     * system setting
     *
     * @author Jason Hu
     * @since  2014-4-14
     */
    function sys_info() {
    	$this->load->view('admin/system/system_info');
    }
    
	/**
     * system setting
     *
     * @author Jason Hu
     * @since  2014-4-14
     */
    function sys_setting() {
    	$this->load->view('admin/system/system_setting');
    }
    
 	/**
     * system setting
     *
     * @author Jason Hu
     * @since  2014-4-14
     */
    function sys_email() {
    	$this->load->view('admin/system/system_email');
    }
    
	/**
     * system setting
     *
     * @author Jason Hu
     * @since  2014-4-14
     */
    function sys_code() {
    	$this->load->view('admin/system/system_code');
    }
    
	/**
     * template setting 
     *
     * @author Jason Hu
     * @since  2014-4-14
     */
    function sys_temp(){
        $this->load->view('admin/system/system_temp');
    }
    
	/**
     * home page banner
     *
     * @author Jason Hu
     * @since  2014-4-14
     */
    function sys_banner(){
    	$data['banner'] = $this->system_model->get_banner_list();
        $this->load->view('admin/system/system_banner', $data);
    }
    
	function banner_modify(){
		$this->load->helper('form');
		$data['type'] = $_GET['type'];
		$modify_id = $this->input->get('modify_id');
		$add_id = $this->input->post('add_id');
		$banner_id = $this->input->post('banner_id');
        if(!empty($add_id)){
        	//handle image to save uploaded picture
            $path = "/upload/banner/";
        	if(!is_dir(BASEPATH . '../' . $path)){
	           	mkdir(BASEPATH . '../' . $path, 0777, true);
        	}
			$config ['upload_path'] = './upload/banner';
			$config ['allowed_types'] = 'gif|jpg|png|jpeg';
			$config ['encrypt_name'] =  true;
			$config ['max_size'] = self::LIMIT_SIZE;
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
	        $fields = array(
				'id'=>generateUniqueID(),
	        	'title'=>$this->input->post('title'),
	        	'image_url'=>$imageUrl,
	        	'sort'=>$this->input->post('sort'),
	        	'create_time'=>time()
			);
	        if(empty($banner_id)){
				$this->system_model->insert_banner($fields);
			}else{
				unset($fields['id']);
				unset($fields['create_time']);
				$this->system_model->update_banner($banner_id, $fields);
			}
			redirect(base_url().'admin/system/sys_banner');
        }
        if(!empty($modify_id)){
        	$data['list'] = $this->system_model->banner_detail($modify_id);
        }
        $this->load->view('admin/system/banner_modify', $data);
    }
    
    /**
     * banner_del : delete banner
     * @param string $bannerid
     *
     * @author Jason Hu
     * @since  2014-5-27
     */
    function banner_del($bannerid=''){
    	$info = $this->system_model->banner_detail($bannerid);
    	if ( empty($info) ) redirect(base_url().'admin/system/sys_banner');
    	$this->system_model->banner_del($bannerid);
        $url = getcwd().$info['image_url'];
    	if( file_exists($url) ){
            unlink($url);
        }
        redirect(base_url().'admin/system/sys_banner');
    }
    
    /**
     * batchDel : delete multi
     *
     * @author Jason Hu
     * @since  2014-5-27
     */
    function batchDel() {
    	$ids = $this->input->post('ids',TRUE);
        $id_arr = explode(',', $ids);
	    if($this->system_model->batchDel($id_arr)){
		    echo json_encode(array('success'=>1, 'msg'=>$this->msg['mutil_del_success'], 'url'=>base_url().'admin/system/sys_banner'));
        }else{
        	echo json_encode(array('success'=>0, 'msg'=>$this->msg['mutil_del_failed']));
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    function generate_code() {
    	try {
    		$this->load->library('qrcode');
			$errorCorrectionLevel = 'L';//容错级别 
			$matrixPointSize = 6;//生成图片大小 
			//生成二维码图片 
	    	$value = isset($_REQUEST['content']) ? $_REQUEST['content'] : ''; //二维码内容 
			$logo = '';
			QRcode::png($value, $this->path.$this->image_name, $errorCorrectionLevel, $matrixPointSize, 2); 
	    	if($logo) { 
				$QR = $this->path.$this->image_name;
		        $QR = imagecreatefromstring(file_get_contents($QR)); 
		        $logo = imagecreatefromstring(file_get_contents($logo)); 
		        $QR_width = imagesx($QR); 
		        $QR_height = imagesy($QR); 
		        $logo_width = imagesx($logo); 
		        $logo_height = imagesy($logo); 
		        $logo_qr_width = $QR_width / 5; 
		        $scale = $logo_width / $logo_qr_width; 
		        $logo_qr_height = $logo_height / $scale; 
		        $from_width = ($QR_width - $logo_qr_width) / 2; 
		        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height); 
			    header('Content-type: image/png');
			    imagepng($QR, $this->path.$this->image_name); 
			    imagedestroy($QR);
		    } 
		    echo json_encode(array('success'=>1, 'msg'=>'二维码图片已生成，可以下载'));
    	} catch (Exception $e) {
		    echo json_encode(array('success'=>0, 'msg'=>$e->getMessage()));
    	}
    }
    
    
    /**
     * download_code： download code png
     *
     * @author Jason Hu
     * @since  2014-4-14
     */
    function download_code() {
    	if (!file_exists($this->path.$this->image_name)) { //check png exist or not
	        echo "二维码图片不存在";
	        exit; 
	    } else {
	         
	        Header("Content-type: application/octet-stream");
	        Header("Accept-Ranges: bytes");
	        Header("Accept-Length: ".filesize($this->path.$this->image_name));
	        Header("Content-Disposition: attachment; filename=" . $this->image_name);
	        $file = fopen($this->path.$this->image_name, "r"); //open file
	        echo fread($file, filesize($this->path.$this->image_name));
	        fclose($file);
	        exit;
	    } 
    }
}
?>