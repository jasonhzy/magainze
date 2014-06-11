<?php
/**
 * Magainze_model : class model for magainze
 * @since: 2014-04-01
 */
class Magainze_model extends CI_Model{

	/**
	 * get_magainze_list:  for all magainze list
	 * @param array $params : for search params
	 *
	 * @author Jason Hu
	 * @since  2014-04-01
	 */
	function get_magainze_list($params = array()){
		try {
			$magainze = array();
			$pagesize = $params['per_page'];
			$pagenum = $params['page_num'];
			$formula = $pagesize * ($pagenum - 1);
			$sql = 'SELECT TOP '.$pagesize.' id AS ID, name AS NAME, join_time AS JOIN_TIME, cover_url AS COVER_URL, 
				is_recommend AS RECOMMEND, is_verify AS VERIFY, is_publish as PUBLISH, remark  FROM '.MAGAINZE_LIST.'   
				WHERE id not in( 
					SELECT TOP '.$formula.' id FROM '.MAGAINZE_LIST;
			$sql .= ' ORDER BY join_time DESC, name'; 
			$sql .= ')';
			if(isset($params['search_field']) && $params['field_content']){
				$sql .= ' AND '.$params['search_field'].' LIKE ' . $this->db->escape('%'.$params['field_content'].'%'); 
			}
			switch ($params['page_type']) {
				case 'verify_page':
					if($params['verify']!=''){
						$sql .= ' AND is_verify = '.$params['verify']; 
					}else {
						$sql .= ' AND is_verify <>0' ;
					}
					break;
				case 'publish_page':
					$sql .= ' AND is_verify = 1' ;
					if($params['publish']!=''){
						$sql .= ' AND is_publish = '.$params['publish']; 
					}
					break;
				case 'index_page':
					if($params['verify']!=''){
						$sql .= ' AND is_verify = '.$params['verify']; 
					}
					break;
			}
			$sql .= ' ORDER BY join_time DESC, name'; 
			$rs = $this->db->query($sql);
			//pr($this->db->last_query());
			return $rs->result_array ();
		} catch (Exception $e) {
			die($e);
		}
	}
	
	/**
	 * get_magainze_count: get magainze count when to pagination
	 * @param array $params
	 * @return array
	 * 
	 * @author Jason Hu
	 * @since  2014-4-1
	 */
	function get_magainze_count($params) {
		try {
			$sql = 'SELECT COUNT(*) AS TOTAL FROM '.MAGAINZE_LIST.' WHERE 1=1';
			if(isset($params['search_field']) && $params['field_content']){
				$sql .= ' AND '.$params['search_field'].' LIKE ' . $this->db->escape('%'.$params['field_content'].'%'); 
			}
			switch ($params['page_type']) {
				case 'verify_page':
					if($params['verify']!=''){
						$sql .= ' AND is_verify = '.$params['verify']; 
					}else {
						$sql .= ' AND is_verify <>0' ;
					}
					break;
				case 'publish_page':
					$sql .= ' AND is_verify = 1' ;
					if($params['publish']!=''){
						$sql .= ' AND is_publish = '.$params['publish']; 
					}
					break;
				case 'index_page':
					if($params['verify']!=''){
						$sql .= ' AND is_verify = '.$params['verify']; 
					}
					break;
			}
			$rs = $this->db->query($sql);
			return $rs->row()->TOTAL;
		} catch (Exception $e) {
			die($e);
		}
	}
	/**
	 * get_magainze_total: get all magainze count for managinze management page
	 * @param array $params
	 * @return array
	 * 
	 * @author Jason Hu
	 * @since  2014-4-3
	 */
	function get_magainze_total($params) {
		try {
			$sql = 'SELECT COUNT(*) AS TOTAL FROM '.MAGAINZE_LIST.' WHERE 1=1';
			if(isset($params['search_field']) && $params['field_content']){
				$sql .= ' AND '.$params['search_field'].' LIKE ' . $this->db->escape('%'.$params['field_content'].'%'); 
			}
			$rs = $this->db->query($sql);
			return $rs->row()->TOTAL;
		} catch (Exception $e) {
			die($e);
		}
	}
	
	
	/**
	 * insert_member: insert member
	 * @param array $fields table fields
	 *
	 * @author Jason Hu
	 * @since  2014-3-31
	 */
	function insert_magainze($fields) {
		return $this->db->insert(MAGAINZE_LIST, $fields);
	}
	
	/**
	 * update_member: modify member
	 * @param string $user_uid  table pk
	 * @param array $fields table fields
	 *
	 * @author Jason Hu
	 * @since  2014-3-31
	 */
	function update_magainze($magainze_id, $fields) {
		$this->db->where ( 'id', $magainze_id );
		return $this->db->update ( MAGAINZE_LIST, $fields );
	}
	
	
	/**
     * verify_magainze: verify magainze change is_verify = 1
     *
     * @author Jason Hu
     * @since  2014-04-01
     */
    function verify_magainze($magainze_id, $verify) {
    	$this->db->where ( 'id', $magainze_id );
		return $this->db->update ( MAGAINZE_LIST, array('is_verify'=>$verify) );
    }
    
	/**
     * publish_magainze: publish magainze change is_publish = 0/1
     *
     * @author Jason Hu
     * @since  2014-04-01
     */
    function publish_magainze($magainze_id, $publish) {
    	$this->db->where ( 'id', $magainze_id );
		return $this->db->update ( MAGAINZE_LIST, array('is_publish'=>$publish) );
    }
    
	/**
	 * del_member: delete member
	 * @param string $user_uid table pk
	 * @return boolean
	 *
	 * @author Jason Hu
	 * @since  2014-3-19
	 */
	public  function del_magainze($magainze_id){
		$this->db->delete(MAGAINZE_ARTICLE, array('magainze_id'=>$magainze_id));
        return $this->db->delete(MAGAINZE_LIST, array('id'=>$magainze_id));
    }
    
   
	
	/**
	 * getMemberById: get member info by id when to modify
	 * @param string $user_uid table pk
	 *
	 * @author Jason Hu
	 * @since  2014-4-1
	 */
	function getMagainzeById($user_uid) {
		$sql = '';
		$rs = $this->db->query($sql);
		$row = $rs->row_array();
		return $row;
	}
	
	
 	/**
	 * batchDel: delete multi magainze
	 * @param array $aUserUid table pk in array
	 * @return boolean
	 *
	 * @author Jason Hu
	 * @since  2014-3-19
	 */
	function batchDel($aIds) {
 		$this->db->where_in('magainze_id', $aIds); 
		$this->db->delete(MAGAINZE_ARTICLE);
 		$this->db->where_in('id', $aIds); 
 		return $this->db->delete(MAGAINZE_LIST); 
	}
	
	/**
	 * get_category_article: get category articles
	 *
	 * @author Jason Hu
	 * @since  2014-4-11
	 */
	function get_category_article() {
		$sql = "SELECT article_category.id AS CATEGORY_ID, article_category.name AS CATEGORY_NAME, 
						article.id AS ARTICLE_ID, article.heading AS HEADING
			FROM article_category
			LEFT JOIN article ON (article_category.id = article.category AND is_publish = '1')
			WHERE article_category.id <> 'category_contents'
			ORDER BY article_category.[position]";
		$rs = $this->db->query($sql);
		$article = array();
		if($rs->num_rows()>0){
			foreach ($rs->result_array() as $v) {
				$article[$v['CATEGORY_ID']]['name'] = $v['CATEGORY_NAME'];
				if($v['ARTICLE_ID']){
					$article[$v['CATEGORY_ID']]['item'][] = $v; 
				}
			}
		}
		return $article;
	}
	
	/**
	 * add_magainze : add magainze and article
	 * @param array $insert
	 * @param array $article
	 *
	 * @author Jason Hu
	 * @since  2014-4-11
	 */
	function add_magainze($insert, $article) {
		$this->db->insert(MAGAINZE_LIST, $insert); 
		if ($article) {
			$sql = "INSERT INTO ".MAGAINZE_ARTICLE.'(id, article_id, magainze_id, join_time) VALUES';
			foreach ($article as $v) {
				$sql .= '('.$this->db->escape(generateUniqueID()).', '.$this->db->escape($v).', '.$this->db->escape($insert['id']).', '.$this->db->escape(date('Y-m-d H:i:s')).'),';
			}
			$sql = trim($sql, ',');
			$this->db->query($sql);
		}
	}
	
	/**
	 * get_magainze_detail : get magainze detail for edit
	 * @param string $magainze_id
	 * 
	 * @author Jason Hu
	 * @since  2014-4-11
	 */
	function get_magainze_detail($magainze_id) {
		$sql = 'SELECT '.ARTICLE_CATEGORY.'.id AS category, '.ARTICLE_CATEGORY.'.name, magainze_id, article_id, magaine_name, heading, cover_url, is_recommend, magainze_remark
			FROM '.ARTICLE_CATEGORY.' 
			LEFT JOIN (
				select '.MAGAINZE_LIST.'.id as magainze_id, cover_url, '.MAGAINZE_LIST.'.is_recommend, '.MAGAINZE_LIST.'.name as magaine_name, '.MAGAINZE_LIST.'.remark AS magainze_remark,
					'.ARTICLE_LIST.'.id as article_id, '.ARTICLE_LIST.'.heading, '.ARTICLE_LIST.'.category
				FROM '.MAGAINZE_LIST.'
				INNER JOIN '.MAGAINZE_ARTICLE.' ON '.MAGAINZE_LIST.'.id = '.MAGAINZE_ARTICLE.'.magainze_id
				INNER JOIN '.ARTICLE_LIST.' ON '.ARTICLE_LIST.'.id = '.MAGAINZE_ARTICLE.'.article_id
				WHERE '.MAGAINZE_LIST.'.id = '.$this->db->escape($magainze_id).'
			) article_detail ON article_detail.category = '.ARTICLE_CATEGORY.'.id
			ORDER BY '.ARTICLE_CATEGORY.'.position';
		$rs = $this->db->query($sql);
		$magainze = array();
		$magainze_info = array();
		$category = '';
		foreach ($rs->result_array() as $key=>$value) {
			if($key>0){
				$magainze[$value['category']]['ID'] = $value['category'];
				$magainze[$value['category']]['NAME'] = $value['name'];
				if ($value['article_id']) {
					$remark = '';
					$year='';
					$periods='';
					$total_period='';
					if (trim($value['magainze_remark'])) {
						$remark = explode(',', $value['magainze_remark']);
					}
					if($remark && count($remark)>=3){
						$year = $remark[0];
						$periods = $remark[1];
						$total_period = $remark[2];
					}
					$magainze_info = array(
						'ID'=>$value['magainze_id'], 'NAME'=>$value['magaine_name'], 'COVER_URL'=>$value['cover_url'],
						'RECOMMEND'=>$value['is_recommend'], 'YEAR'=>$year, 'PERIODS'=>$periods, 'TOTAL_PERIODS'=>$total_period 
					);
					$magainze[$value['category']]['ARTICLE'][] = array('CATEGORY'=>$value['category'], 'ARTICLE_ID'=>$value['article_id'], 'HEADING'=>$value['heading']);
				}else{
					$magainze[$value['category']]['ARTICLE'][] = array();
				}
			};
		}
		$object = new stdClass();
		$object->detail = $magainze;
		$object->magainze_info = $magainze_info;
		return $object;
	}
	
	/**
	 * get_magainze_by_id : get magainze detail info by id
	 *
	 * @author Jason Hu
	 * @since  2014-4-14
	 */
	function get_magainze_by_id($magainze_id) {
		$magainze_info = array();
		$sql = 'SELECT id, is_recommend, cover_url, name, remark
			FROM magainze
			WHERE id = '.$this->db->escape($magainze_id);
		$rs = $this->db->query($sql);
		if ($row = $rs->row_array()) {
			$remark = '';
			$year='';
			$periods='';
			$total_period='';
			if (trim($row['remark'])) {
				$remark = explode(',', $row['remark']);
			}
			if($remark && count($remark)>=3){
				$year = $remark[0];
				$periods = $remark[1];
				$total_period = $remark[2];
			}
			$magainze_info = array(
				'ID'=>$row['id'], 'NAME'=>$row['name'], 'COVER_URL'=>$row['cover_url'],
				'RECOMMEND'=>$row['is_recommend'], 'YEAR'=>$year, 'PERIODS'=>$periods, 'TOTAL_PERIODS'=>$total_period 
			);
		};
		return $magainze_info;
	}
	
	/**
	 * add_magainze : add magainze and article
	 * @param array $insert
	 * @param array $article
	 * @param string $magainze_id
	 *
	 * @author Jason Hu
	 * @since  2014-4-14
	 */
	function edit_magainze($magainze_id, $update, $article) {
		$this->db->update(MAGAINZE_LIST, $update, array('id' => $magainze_id));
		$bDelete = $this->db->update(MAGAINZE_LIST, $update, array('id' => $magainze_id));
		$bDelete = $this->db->delete(MAGAINZE_ARTICLE, array('magainze_id' => $magainze_id)); ;
		if($bDelete && $article){
			$sql = "INSERT INTO ".MAGAINZE_ARTICLE.'(id, article_id, magainze_id, join_time) VALUES';
			foreach ($article as $v) {
				$sql .= '('.$this->db->escape(generateUniqueID()).', '.$this->db->escape($v).', '.$this->db->escape($magainze_id).', '.$this->db->escape(date('Y-m-d H:i:s')).'),';
			}
			$sql = trim($sql, ',');
			$this->db->query($sql);
		}
	}
	
	
}