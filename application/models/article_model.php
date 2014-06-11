<?php
/**
 * Article_model : class model for article
 * @since: 2014-04-01
 */
class Article_model extends CI_Model{

	/**
	 * get_article_list:  for all article list
	 * @param array $params : for search params
	 *
	 * @author Jason Hu
	 * @since  2014-04-01
	 */
	function get_article_list($params = array()){
		try {
			$article = array();
			$pagesize = $params['per_page'];
			$pagenum = $params['page_num'];
			$formula = $pagesize * ($pagenum - 1);
			
			$sql = 'SELECT TOP '.$pagesize.' id AS ID, name AS NAME, heading AS HEAD, subheading AS SUBHEAD,
				author AS AUTHOR, keywords AS KEYWORDS, content AS CONTENT, image_url AS IMAGE_URL,
				is_recommend AS RECOMMEND, is_verify AS VERIFY, is_publish as PUBLISH, join_time AS JOIN_TIME,
				position AS POSITION, category AS CATEGORY, remark FROM '.ARTICLE_LIST.'   
				WHERE id not in( 
					SELECT TOP '.$formula.' id FROM '.ARTICLE_LIST. ' ORDER BY join_time, name)';
			if($params['category_name']){
				$sql .= ' AND category = ' . $this->db->escape($params['category_name']); 
			}
			if($params['article_name']){
				$sql .= ' AND name LIKE ' . $this->db->escape('%'.$params['article_name'].'%'); 
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
			$sql .= ' ORDER BY join_time, name';
			$rs = $this->db->query($sql);
			//pr($this->db->last_query());
			return $rs->result_array();
		} catch (Exception $e) {
			die($e);
		}
	}
	
	/**
	 * get_article_count: get article count when to pagination
	 * @param array $params
	 * @return array
	 * 
	 * @author Jason Hu
	 * @since  2014-4-1
	 */
	function get_article_count($params) {
		try {
			$sql = 'SELECT COUNT(*) AS TOTAL FROM '.ARTICLE_LIST.' WHERE 1=1';
			if($params['category_name']){
				$sql .= ' AND category = ' . $this->db->escape($params['category_name']); 
			}
			if($params['article_name']){
				$sql .= ' AND name LIKE ' . $this->db->escape('%'.$params['article_name'].'%'); 
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
			//pr($this->db->last_query());
			return $rs->row()->TOTAL;
		} catch (Exception $e) {
			die($e);
		}
	}
	/**
	 * get_article_total: get all article count for article management page 
	 * @param array $params
	 * @return array
	 * 
	 * @author Jason Hu
	 * @since  2014-4-3
	 */
	function get_article_total($params) {
		try {
			$sql = 'SELECT COUNT(*) AS TOTAL FROM '.ARTICLE_LIST.' WHERE 1=1';
			if($params['category_name']){
				$sql .= ' AND category = ' . $this->db->escape($params['category_name']); 
			}
			if($params['article_name']){
				$sql .= ' AND name LIKE ' . $this->db->escape('%'.$params['article_name'].'%'); 
			}
			$rs = $this->db->query($sql);
			//pr($this->db->last_query());
			return $rs->row()->TOTAL;
		} catch (Exception $e) {
			die($e);
		}
	}
	
	
	/**
	 * get_article_category: get article category
	 *
	 * @author Jason Hu
	 * @since  2014-4-2
	 */
	function get_article_category() {
		try {
			$sql = 'SELECT id AS ID, name AS NAME, position AS POSITION FROM '.ARTICLE_CATEGORY.' ORDER BY position'; 
			$rs = $this->db->query($sql);
			//pr($this->db->last_query());
			if ($rs->num_rows() > 0){
				return $rs->result_array();
			}else{
				return array();
			}
		} catch (Exception $e) {
			die($e);
		}
	}
	
	
	function get_max_position() {
		$sql = 'SELECT MAX(position) AS MAX_POS FROM '.ARTICLE_CATEGORY; 
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0){
			return $rs->row()->MAX_POS;
		}else{
			return 0;
		}
	}
	
	
	
	/**
	 * insert_member: insert member
	 * @param array $fields table fields
	 *
	 * @author Jason Hu
	 * @since  2014-3-31
	 */
	function insert_article($fields) {
		return $this->db->insert(ARTICLE_LIST, $fields);
	}
	
	/**
	 * update_member: modify member
	 * @param string $user_uid  table pk
	 * @param array $fields table fields
	 *
	 * @author Jason Hu
	 * @since  2014-3-31
	 */
	function update_article($user_uid, $fields) {
		$this->db->where ( 'id', $user_uid );
		return $this->db->update ( ARTICLE_LIST, $fields );
	}
	
	
	/**
     * verify_article: verify article change is_verify = 1/2
     *
     * @author Jason Hu
     * @since  2014-04-01
     */
    function verify_article($article_id, $verify) {
    	$this->db->where ( 'id', $article_id );
		return $this->db->update ( ARTICLE_LIST, array('is_verify'=>$verify) );
    }
    
	/**
     * publish_article: publish article change is_publish_article = 0/1
     *
     * @author Jason Hu
     * @since  2014-04-01
     */
    function publish_article($article_id, $publish) {
    	$this->db->where ( 'id', $article_id );
		return $this->db->update ( ARTICLE_LIST, array('is_publish'=>$publish) );
    }
	
	/**
	 * del_member: delete member
	 * @param string $user_uid table pk
	 * @return boolean
	 *
	 * @author Jason Hu
	 * @since  2014-3-19
	 */
	public  function del_article($user_uid){
        return $this->db->delete(ARTICLE_LIST, array('id'=>$user_uid));
    }
    
   
	
	/**
	 * getMemberById: get member info by id when to modify
	 * @param string $user_uid table pk
	 *
	 * @author Jason Hu
	 * @since  2014-4-1
	 */
	function getArticleById($article_uid) {
		$sql = 'SELECT id AS ID, name AS NAME, heading AS HEAD, subheading AS SUBHEAD,
				author AS AUTHOR, keywords AS KEYWORDS, content AS CONTENT, image_url AS IMAGE_URL,
				bg_url AS BG_IMAGE, is_recommend AS RECOMMEND, is_verify AS VERIFY, is_publish as PUBLISH,
				style_type AS TYPE, profile_height AS PROFILE_HEIGHT, profile_space AS PROFILE_SPACE, 
				content_space  AS CONTENT_SPACE, profile AS PROFILE, 
				category AS CATEGORY FROM '.ARTICLE_LIST . ' WHERE id = '.$this->db->escape($article_uid) ;
		$rs = $this->db->query($sql);
		$row = $rs->row_array();
		return $row;
	}
	
	
 	/**
	 * batchDel: delete multi article
	 * @param array $aUserUid table pk in array
	 * @return boolean
	 *
	 * @author Jason Hu
	 * @since  2014-3-19
	 */
	function batchDel($aUserUid) {
 		$this->db->where_in('id', $aUserUid); 
 		return $this->db->delete(ARTICLE_LIST); 
	}
}