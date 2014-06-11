<?php
/**
 * System_model : class model to handle system setting 
 * @since: 2014-4-3
 */
class System_model extends CI_Model{
	
	
	/**
	 * home page banner
	 *
	 * @author Jason Hu
	 * @since  2014-5-27
	 */
	function get_banner_list() {
		$sql = 'SELECT id, title, image_url, link, sort, create_time
			FROM '.BANNER.' ORDER BY sort';
		$rs = $this->db->query($sql);
		if ($rs->row_array()) {
			return $rs->result_array();
		}else{
			return NULL;
		}
	}
	
	
	/**
	 * get banner detail info
	 *
	 * @author Jason Hu
	 * @since  2014-5-27
	 */
	public function banner_detail($bannerid){
		$rs = $this->db->get_where(BANNER, array('id' => $bannerid));
        if ($rs->num_rows() > 0) {
            return $rs->row_array();
        } else {
            return NULL;
        }
    }
	
	/**
	 * insert_banner : insert banner
	 * @param array $fields
	 * 
	 * @author Jason Hu
	 * @since  2014-5-27
	 */
	public function insert_banner($fields){
        $this->db->insert(BANNER, $fields);
    }
	/**
	 * insert_banner : insert banner
	 * @param string $banner_id
	 * @param array $fields
	 * 
	 * @author Jason Hu
	 * @since  2014-5-27
	 */
	public function update_banner($banner_id, $fields){
        $this->db->update(BANNER, $fields, array('id'=>$banner_id));
    }
	/**
	 * delete banner
	 *
	 * @author Jason Hu
	 * @since  2014-5-27
	 */
	public function banner_del($bannerid){
        $this->db->delete(BANNER, array('id'=>$bannerid));
    }
    
	/**
	 * batchDel: delete multi banner
	 * @param array $aBannerId table pk in array
	 * @return boolean
	 *
	 * @author Jason Hu
	 * @since  2014-5-27
	 */
	function batchDel($aBannerId) {
 		$this->db->where_in('id', $aBannerId); 
 		return $this->db->delete(BANNER); 
	}
}