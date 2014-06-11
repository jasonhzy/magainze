<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Article: class for setting
 *
 * @author Jason Hu
 * @since  2014/04/09
 */
class Bookshelf extends CI_Controller {
    
	/**
     * __construct: Constructors to load model 
     */
	function __construct(){
        parent::__construct();
        $this->load->model('front_model');
    }

    /**
     *
     * @author Jason Hu
     * @since  2014-4-9
     */
	public function index(){
		$data['years'] = $this->front_model->getAllYear();
		$year = '';
		if (isset($_REQUEST['year'])) {
			$year = $_REQUEST['year'];
		}else{
			if (count($data['years'])>0) {
				$year = $data['years'][0]['DAY_YEAR'];
			}
		}
		$data['magainze'] = $this->front_model->get_topfive_magainze();
		$data['bookshelf'] = $this->front_model->get_magainzes($year); //get is_publish = 1
		$data['year'] = $year;
		$data['title'] = '圣陶教育@第一线 - 书架';
		$this->load->view('front/bookshelf', $data);
	}
	
	/**
	 * del_bookshelf : delete bookshelf
	 *
	 * @author Jason Hu
	 * @since  2014-4-9
	 */
	function del_bookshelf() {
		$year = isset($_REQUEST['year']) ? $_REQUEST['year'] : '';
		$this->front_model->del_bookshelf();
		redirect(base_url().'front/bookshelf/index?year='.$year);
	}
}
