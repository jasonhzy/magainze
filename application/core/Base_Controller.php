<?php
/**
 * Created by JetBrains PhpStorm.
 * User: think
 * Date: 13-6-8
 * Time: 下午9:42
 * To change this template use File | Settings | File Templates.
 */
class Base_Controller extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
}

class AdminBase extends Base_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        if (!isset($_COOKIE['username'])) {
            echo "<script>window.top.location='/admin/login';</script>";
        }
    }
}

class HomeBase extends Base_Controller {
    protected $menus = array();
    protected $left_cat = array();
    protected $breadcrumb = array();
    protected $leaf_name = "";
    protected $islist = 1;
    protected $username = "";

    function __construct()
    {
        parent::__construct();
        // $result = $this->category_model->getMenu();
        // if ($id < 0) {
        //     $getFirstId = isset($result[0]['id']) ? $result[0]['id'] : -1;
        //     $id = $getFirstId;
        // }
        // $l_result = $this->category_model->getLCat($id);
        // $breadcrumb = $this->category_model->getBreadcrumb($id);
        // $leaf_name_res = $this->category_model->getBreadcrumb($leaf_id);
        // $this->leaf_name = isset($leaf_name_res[1]) ? $leaf_name_res[1] : "";
        // $this->islist = isset($leaf_name_res[6]) ? $leaf_name_res[6] : "";
        // $this->left_cat = $l_result;
        // $this->breadcrumb = $breadcrumb;
        // $this->menus = $result;
        if (isset($_COOKIE['fusername'])) {
            $this->username = $_COOKIE['fusername'];
        } elseif (isset($_SESSION['fusername'])) {
            $this->username = $_SESSION['fusername'];
        }
    }
}