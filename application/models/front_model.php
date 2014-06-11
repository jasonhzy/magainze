<?php
/**
 * Front_model : class model for front
 * @since: 2014-04-01
 */
class Front_model extends CI_Model{
	
	private $type =  'FONT_SIZE';
	
	/**
	 * get_topfive_magainze: get latest five magainzes
	 *
	 * @author Jason Hu
	 * @since  2014-4-10
	 */
	function get_topfive_magainze() {
		$sql = 'SELECT id AS ID, name AS NAME, cover_url AS COVER_URL, remark AS REMARK
			FROM ( SELECT TOP 5 id, name, join_time, cover_url, remark FROM '.MAGAINZE_LIST.' WHERE is_publish = 1 ORDER BY join_time DESC ) TOPFIVE
			ORDER BY join_time';
		$rs = $this->db->query($sql);
		if($rs->num_rows()>0){
			return $rs->result_array();
		}else{
			return NULL;
		}
	}
	/**
	 * get_topfive_magainze: get latest one magainze
	 *
	 * @author Jason Hu
	 * @since  2014-4-10
	 */
	function get_topone_magainze() {
		$sql = 'SELECT TOP 1 id  AS ID, name  AS NAME, join_time, cover_url FROM '.MAGAINZE_LIST.' WHERE is_publish = 1 ORDER BY join_time DESC';
		$rs = $this->db->query($sql);
		if($rs->num_rows()>0){
			return $rs->row_array();
		}else{
			return NULL;
		}
	}
	
	
	/**
	 * set_font: save font size
	 * @param int $fontsize 
	 *
	 * @author Jason Hu
	 * @since  2014-4-8
	 */
	function set_font($fontsize = DEFAULT_FONT_SIZE, $magainze_id = '') {
		$rs = $this->db->get_where(CONTENT, array('type' => $this->type));
		$result = $rs->row_array();
		if ($result) {
			$this->db->update(CONTENT, array('value' => $magainze_id, 'flag' => $fontsize), array('type' => $this->type));
		}else{
			$data = array(
				'id' => generateUniqueID(),
				'type' => $this->type ,
				'parent' => '' ,
				'value' => $magainze_id ,
				'flag' => $fontsize ,
				'position' => 0 
	        );
			$this->db->insert(CONTENT, $data); 
		}
	}
	
	
	/**
	 * get_font: get font size
	 * @param string $magainze_id magainze id
	 * @return string
	 *
	 * @author Jason Hu
	 * @since  2014-4-8
	 */
	function get_font($user_uid = '') {
		$update = array('type' => $this->type);
		if ($user_uid) {
			$update = array('value' => $user_uid, 'type' => $this->type);
		}
		$rs = $this->db->get_where(CONTENT, $update);
		return $rs->row() && $rs->row()->flag ? $rs->row()->flag : DEFAULT_FONT_SIZE;
	}
	
	/**
	 * get_banner_list: get banner list
	 * @return array
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
	
	/***************************************article*************************************************/
	
	/**
	 * get_category_article: get article for every category base on magainze
	 * @return array
	 *
	 * @author Jason Hu
	 * @since  2014-4-8
	 */
	function get_category_article($param=array()){
		try {
			$article = array();
			$sql = 'SELECT  '.ARTICLE_CATEGORY.'.id AS CATEGORY_ID, article_id AS ARTICLE_ID, heading AS HEADING, magainze_id AS MAGAINZE_ID
				FROM '.ARTICLE_CATEGORY.' 
				LEFT JOIN ( 
					SELECT '.ARTICLE_LIST.'.id AS article_id, '.ARTICLE_LIST.'.heading, '.ARTICLE_LIST.'.category, '.MAGAINZE_ARTICLE.'.magainze_id
					FROM '.MAGAINZE_ARTICLE.'
					INNER JOIN '.ARTICLE_LIST.' ON  '.ARTICLE_LIST.'.id = '.MAGAINZE_ARTICLE.'.article_id WHERE 1=1';
			if(isset($param['magainze_id'])){
				$sql .= ' AND '. MAGAINZE_ARTICLE . '.magainze_id = '.$this->db->escape($param['magainze_id']);
			}
			$sql .= ') table_article
				ON table_article.category = '.ARTICLE_CATEGORY.'.id  ORDER BY '.ARTICLE_CATEGORY.'.position';
			$rs = $this->db->query($sql);
			//pr($this->db->last_query());
			foreach ($rs->result_array() as $key => $row) {
				if ($key>0) {
					$res['ARTICLE_ID'] = $row['ARTICLE_ID'] ? $row['ARTICLE_ID'] : '';
					$res['HEADING'] = $res['ARTICLE_ID'] ? $row['HEADING'] : '';
					$article[$row['CATEGORY_ID']][] = $res;
				}
			} 
			return $article;
		} catch (Exception $e) {
			die($e);
		}
	}
	
	/**
	 * get_article_detail: get article for every category
	 * @return array
	 *
	 * @author Jason Hu
	 * @since  2014-4-8
	 */
	function get_article_detail($params= array()){
		try {
			$sql = 'SELECT '.ARTICLE_LIST.'.id AS article_id, '.ARTICLE_LIST.'.name AS article_name, heading, author, content, style_type AS type, bg_url, 
				profile, profile_height, profile_space,  content, content_space, '.ARTICLE_CATEGORY.'.name as category, keywords';
			if (isset($params['user_uid'])) {
				$sql .=	', ISNULL(is_love, 0) AS is_love';
			}
			$sql .=	' FROM '.ARTICLE_LIST.' INNER JOIN '.ARTICLE_CATEGORY.' on '.ARTICLE_CATEGORY.'.id = '.ARTICLE_LIST.'.category';
			if (isset($params['user_uid'])) {
				$sql .=	' LEFT JOIN '.BOOKMARKS.' ON ('.BOOKMARKS.'.article_id = '.ARTICLE_LIST.'.id AND '.BOOKMARKS.'.user_uid = '.$this->db->escape($params['user_uid']).')';
			}
			$sql .=	' WHERE 1=1';
			if (isset($params['article_id'])) {
				$sql .= ' AND '.ARTICLE_LIST.'.id = '.$this->db->escape($params['article_id']);
			}
			$rs = $this->db->query($sql);
			//pr($this->db->last_query());
			if($rs->num_rows()>0){
				return $rs->row_array();
			}else{
				return NULL;
			}
		} catch (Exception $e) {
			die($e);
		}
	}
	
	
	/**
	 * add_read_history: add read history
	 * @param array $param
	 *
	 * @author Jason Hu
	 * @since  2014-4-9
	 */
	function add_read_history($param=array()) {
		$rs = $this->db->get_where(READ_HISTORY, array('article_id' => $param['article_id'], 'user_uid'=>$param['user_uid']));
		if($rs->row()){
			$this->db->update(READ_HISTORY, array('read_num'=>$rs->row()->read_num + 1), array('id' =>$rs->row()->id));
		}else{
			$insert = array(
				'id'=>generateUniqueID(),
				'article_id'=>$param['article_id'],
				'user_uid'=>$param['user_uid'],
				'read_num'=>1
			);
			$this->db->insert(READ_HISTORY, $insert);
		}
	}
	
	/***************************************bookmarks***************************************************/
	
	
	/**
	 * get_bookmarks : get bookmarks
	 * @param $user_uid
	 *
	 * @author Jason Hu
	 * @since  2014-4-8
	 */
	function get_bookmarks($user_uid) {
		$sql = 'SELECT '.BOOKMARKS.'.id as ID, article_id as ARTICLE_ID, heading as HEADING, 
			image_url AS IMAGE_URL FROM '.BOOKMARKS.'
			INNER JOIN '.ARTICLE_LIST.' ON '.ARTICLE_LIST.'.id = '.BOOKMARKS.'.article_id
			WHERE '.BOOKMARKS.'.user_uid = '.$this->db->escape($user_uid).' AND is_mark = 1
			ORDER BY '.BOOKMARKS.'.join_time';
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			return $rs->result_array();
		}else{
			return NULL;
		}
	}
	
	/**
	 * add_bookmarks: add bookmarks for article
	 * @return int 
	 *
	 * @author Jason Hu
	 * @since  2014-4-8
	 */
	function add_bookmarks($article_id, $login_user_uid) {
		$rs = $this->db->get_where(BOOKMARKS, array('user_uid' => $login_user_uid, 'article_id'=>$article_id));
		$result = $rs->row_array();
		if ($result) {
			switch ($result['is_mark']) {
				case '1':
					return 0; 
					break;
				default:
					$this->db->update(BOOKMARKS, array('is_mark'=>1), array('id'=>$result['id']));
					return 1; 
					break;
			}
		}else{
			$data = array(
				'id' => generateUniqueID(),
				'user_uid' => $login_user_uid ,
				'article_id' => $article_id ,
				'is_love' => '0' ,
				'is_mark' => '1' ,
				'join_time' => date('Y-m-d H:i:s')
	        );
			if($this->db->insert(BOOKMARKS, $data)){
				return 1; 
			}else{
				return 2; 
			}
		}
	}
	
	/**
	 * del_bookmarks : delete bookmarks
	 *
	 * @author Jason Hu
	 * @since  2014-4-8
	 */
	function del_bookmarks(){
		$this->db->delete(BOOKMARKS, array('id' => $_REQUEST['bookmarks_id'])); 
	}
	
	/**
	 * add_love : when user logined, to set love or not love article
	 *
	 * @author Jason Hu
	 * @since  2014-4-17
	 */
	function add_love($article_id, $login_user_uid, $is_love=0) {
		$rs = $this->db->get_where(BOOKMARKS, array('user_uid' => $login_user_uid, 'article_id'=>$article_id));
		$result = $rs->row_array();
		if ($result) {
			$this->db->update(BOOKMARKS, array('is_love'=>$is_love), array('id'=>$result['id']));
		}else{
			$data = array(
				'id' => generateUniqueID(),
				'user_uid' => $login_user_uid ,
				'article_id' => $article_id ,
				'is_love' => $is_love,
				'is_mark' => '0' ,
				'join_time' => date('Y-m-d H:i:s')
	        );
			$this->db->insert(BOOKMARKS, $data);
		}
	}
	
	
	function get_article_magainze_id($bookmark_id='') {
		$sql = 'SELECT '.BOOKMARKS.'.article_id, '.MAGAINZE_ARTICLE.'.magainze_id
			FROM '.BOOKMARKS.'
			INNER JOIN '.MAGAINZE_ARTICLE.' ON '.MAGAINZE_ARTICLE.'.article_id = '.BOOKMARKS.'.article_id
			WHERE '.BOOKMARKS.'.id = '.$this->db->escape($bookmark_id);
		$rs = $this->db->query($sql);
		if ($rs->num_rows()) {
			return $rs->row_array();
		}else{
			return NULL;
		}
	}
	
	/***************************************bookshelf***************************************************/
	
	/**
	 * get_magainzes : get all magainzes
	 * @param $user_uid
	 *
	 * @author Jason Hu
	 * @since  2014-4-9
	 */
	function getAllYear() {
		$sql = 'SELECT DISTINCT DATEPART(Year, join_time) AS DAY_YEAR FROM '.MAGAINZE_LIST.' ORDER BY DAY_YEAR DESC;';
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			return $rs->result_array();
		}else{
			return NULL;
		}
	}
	
	/**
	 * get_magainzes : get all magainzes
	 * @param $user_uid
	 *
	 * @author Jason Hu
	 * @since  2014-4-9
	 */
	function get_magainzes($max_year = '') {
		$sql = 'SELECT id AS ID, cover_url AS IMAGE_URL, name AS TITLE, join_time  AS TIME
			FROM  '.MAGAINZE_LIST.'
			WHERE status = 1 AND is_publish = 1';
		if ($max_year) {
			$sql .= ' AND DATEPART(Year, join_time) = '.$this->db->escape($max_year);
		}
		$sql .= ' ORDER BY join_time DESC';
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			return $rs->result_array();
		}else{
			return NULL;
		}
	}
	
	
	/**
	 * del_bookshelf : delete bookshelf, but only change status=0 
	 *
	 * @author Jason Hu
	 * @since  2014-4-9
	 */
	function del_bookshelf(){
		$this->db->update(MAGAINZE_LIST, array('status' => 0), array('id' => $_REQUEST['magainze_id']));
	}
	
	
	/***************************************search page**************************************************/
	
	/**
	 * get_article_list:  get article list for search
	 * @param array $params : for search params
	 *
	 * @author Jason Hu
	 * @since  2014-04-09
	 */
	function get_article_list($params = array()){
		try {
			$pagesize = $params['per_page'];
			$pagenum = $params['page_num'];
			$formula = $pagesize * ($pagenum - 1);
			
			$sql = 'SELECT TOP '.$pagesize.' id AS ID, name AS NAME, heading AS HEAD, subheading AS SUBHEAD,
				author AS AUTHOR, keywords AS KEYWORDS, content AS CONTENT, image_url AS IMAGE_URL,
				is_recommend AS RECOMMEND, is_verify AS VERIFY, is_publish as PUBLISH, join_time AS JOIN_TIME,
				position AS POSITION, category AS CATEGORY, remark FROM '.ARTICLE_LIST.'   
				WHERE id not in( 
					SELECT TOP '.$formula.' id FROM '.ARTICLE_LIST.'
				)';
			if($params['keyword']){
				$sql .= ' AND heading LIKE ' . $this->db->escape('%'.$params['keyword'].'%'); 
			}
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
			if($params['keyword']){
				$sql .= ' AND heading LIKE ' . $this->db->escape('%'.$params['keyword'].'%'); 
			}
			$rs = $this->db->query($sql);
			//pr($this->db->last_query());
			return $rs->row()->TOTAL;
		} catch (Exception $e) {
			die($e);
		}
	}
	
	/***********************************read history******************************************************/
	
	/**
	 * get_article_list:  get article list for search
	 * @param array $params : for search params
	 *
	 * @author Jason Hu
	 * @since  2014-04-09
	 */
	function get_history_list($params = array()){
		try {
			$pagesize = $params['per_page'];
			$pagenum = $params['page_num'];
			$formula = $pagesize * ($pagenum - 1);
			
			$sql = 'SELECT TOP '.$pagesize.' '.READ_HISTORY.'.id AS HISTORY_ID, '.ARTICLE_LIST.'.id AS ARTICLE_ID,
				heading AS HEADING, name AS NAME FROM '.READ_HISTORY.'
				INNER JOIN '.ARTICLE_LIST.' ON '.READ_HISTORY.'.article_id = '.ARTICLE_LIST.'.id
				WHERE 1=1';
			if($params['user_uid']){
				$sql .= ' AND user_uid = ' . $this->db->escape($params['user_uid']); 
				$sql .= ' AND '.READ_HISTORY.'.id NOT IN( 
						SELECT TOP '.$formula.' id FROM '.READ_HISTORY.' WHERE user_uid = '.$this->db->escape($params['user_uid']).'
					)'; 
			}else{
				$sql .= ' AND '.READ_HISTORY.'.id NOT IN( SELECT TOP '.$formula.' id FROM '.READ_HISTORY.')'; 
			}
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
	function get_history_count($params) {
		try {
			$sql = 'SELECT COUNT(*) AS TOTAL FROM '.READ_HISTORY.' WHERE 1=1';
			if($params['user_uid']){
				$sql .= ' AND user_uid = ' . $this->db->escape($params['user_uid']); 
			}
			$rs = $this->db->query($sql);
			//pr($this->db->last_query());
			return $rs->row()->TOTAL;
		} catch (Exception $e) {
			die($e);
		}
	}
	
	
}