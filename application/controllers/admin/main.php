<?php
header("Content-Type:text/html; charset=utf-8");
/**
 * Frameset: class for manage backstage 
 *
 * @author Jason Hu
 * @since  2014/03/26
 */
class Main extends CI_Controller {
	function __construct() {
		parent::__construct ();
	}

    function index(){
    	if (!$this->session->userdata('user_uid')) {
    		echo '<script>window.top.location.href = "'.base_url().'admin/login'.'";</script>';
    		exit;
			//redirect(base_url().'admin/login');
	    };
        $this->load->view('admin/frame.php');
    }
    
	function top() {
		$data['username'] = $this->session->userdata('username');
		$data['menus'] = $this->base_model->getMenuList('/');
		$this->load->view ( 'admin/top', $data);
	}
	
	function left($menu_id = 'MENU_HOME') {
		$data['menus'] = $this->base_model->getMenuList($menu_id);
		$this->load->view ( 'admin/left', $data);
	}
	
	function right() {
		$data = array(
			//title info
			'username'=>$this->session->userdata('username'),
			'clientIP'=>getrealip(),
			'login_time'=>date('Y-m-d H:i:s'),
			//一周动态
			'persionNum'=>$this->base_model->getWeekAccount(),
			'applyNum'=>0,
			'articleNum'=>$this->base_model->getWeekArticle(),
			//统计信息
			'persionTotalNum'=>$this->base_model->getTotalAccount(),
			'applyTotalNum'=>0,
			'articleTotalNum'=>$this->base_model->getTotalArticle(),
			//系统信息
			'system'=>PHP_OS,//$this->base_model->getOS(),
			'webServer'=>$_SERVER["SERVER_SOFTWARE"],
			'phpVersion'=>PHP_VERSION,
			'installDate'=>date('Y-m-d')
		);
		$this->load->view ( 'admin/right', $data);
	}
}
?>
