<?php

 /*
 * pr : print string, array or object 
 * @param  $a  string array or object
 * 
 * @author Jason Hu
 * @since 2013-03-26 
 */
 if ( ! function_exists( 'pr' ) ) {
	function pr($a) {
		header("content-type:text/html; charset=utf-8");
		echo '<pre>';
		print_r($a);die;
	}
 }
 
/**
 * Generate random number
 * @access public
 * @return int
 * 
 * @author Jason Hu
 * @since 2013-03-26
 */
if (! function_exists ( 'generateUniqueID' )) {
	function generateUniqueID() {
		do {
			$sUID = str_replace ( '.', '0', uniqid ( rand ( 0, 999999999 ), true ) );
		} while ( strlen ( $sUID ) != 32 );
		return $sUID;
	}
}
 /*
 * my_cus_substr : characters interception
 * @param       String  $str   original text
 * @param       Int     $len
 * @param       Bool    $flag   true: add '...'/false: not add
 * @return      String
 */
 if ( ! function_exists( 'my_cus_substr' ) ) { 
 	function my_cus_substr( $str, $len, $flag = TRUE) { 
 		if(mb_strlen($str) < $len) return $str; 
 		$i = 0; 
 		$tlen = 0; 
 		$tstr = ''; 
 		while ( $tlen < $len ) { 
 			$tlen++; 
 			$chr = mb_substr( $str, $i, 1, 'utf8' ); 
 			if ( $tlen > $len ) break; 
 			$tstr .= $chr; 
 			$i++; 
 		} 
 		if ( $tstr != $str && $flag ) { 
 			$tstr .= '...'; 
 		} 
 		return $tstr; 
 	} 
 }
 
 if ( !function_exists ( 'getrealip' ) ) { 
 	function getrealip() { 
 		$onlineip = ''; 
 		if (getenv ( 'HTTP_CLIENT_IP' ) && strcasecmp ( getenv ( 'HTTP_CLIENT_IP' ), 'unknown' )) { 
 			$onlineip = getenv ( 'HTTP_CLIENT_IP' ); 
 		} elseif (getenv ( 'HTTP_X_FORWARDED_FOR' ) && strcasecmp ( getenv ( 'HTTP_X_FORWARDED_FOR' ), 'unknown' )) { 
 			$onlineip = getenv ( 'HTTP_X_FORWARDED_FOR' ); 
 		} elseif (getenv ( 'REMOTE_ADDR' ) && strcasecmp ( getenv ( 'REMOTE_ADDR' ), 'unknown' )) { 
 			$onlineip = getenv ( 'REMOTE_ADDR' ); 
 		} elseif (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], 'unknown' )) { 
 			$onlineip = $_SERVER ['REMOTE_ADDR']; 
 		} 
 		return $onlineip; 
 	} 
 } 
 
 
 if( !function_exists( 'getEmailHostByEmail' ) ) { 
 	function getEmailHostByEmail($email) { 
 		$domain = substr ( $email, strrpos ( $email, "@" ) + 1 ); 
 		switch ( $domain ) { 
 			case 'me.com': 
 				$emailHost = 'https://www.icloud.com/'; 
 				break; 
 			case 'yahoo.com.cn': 
 			case 'yahoo.cn': 
 				$emailHost = 'http://mail.cn.yahoo.com/'; 
 				break; 
 			default: 
 			$emailHost = "http://mail." . $domain; 
 			break; 
 		} 
 		return $emailHost; 
 	} 
 } 
 

 /**
  * check_email: check email valid or invalid
  * @param string $value email 
  * @return boolean
  *
  * @author Jason Hu
  * @since  2014-3-27
  */
  if ( !function_exists( 'check_email') ) { 
 	function check_email ( $value ) { 
 		return ;
 		if ( preg_match('/^[\.\-_A-Za-z0-9]+@([\-_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/', $value) ) { 
 			return TRUE; 
 		} else { 
 			return FALSE; 
 		} 
 	} 
 } 
 
 
 if ( !function_exists( 'getEmailHtml' ) ) { 
 	function getEmailHtml($type, $params = array()) { 
 		switch ($type) {
 			case 'register':
	 			$content = "<html>
	 				<body><strong>尊敬的中国杂志网用户{$params['username']},您好</strong><br/><br/>
	 				恭喜您成为中国杂志网会员,请牢记您的用户名和密码：<br> 
	 				用户名：  {$params['username']} <br/>密码：{$params['password']}<br/><br/>
	 				中国杂志网客户服务部<br/>
	 				------------------------<br/>
	 				杂志订阅,发表了论文-中国杂志网</body></html>";
	 			break;
 			case 'forget':
		 		$content = "<html><body><strong>
		 			尊敬的用户：</strong><br>&nbsp;<br>您好！您于".date('Y年m月d日 H:i')."提交找回密码请求，请点击下面的链接修改密码。<br> &nbsp;<br />
		 			<a href=\"{$params['url']}\">{$params['url']}</a><br/><br/>
		 			中国杂志网客户服务部<br/>
	 				------------------------<br/>
	 				杂志订阅,发表了论文-中国杂志网</body></html>";
	 			break;
 			default:
 				break;
 		}
 		return $content; 
 	} 
 } 
 
 	/**
	 * send_message : send message 
	 * @param array $params:
     * 	'protocol' => 'smtp/mail/sendmail',
		'smtp_host' => like smtp.163.com,smtp.sina.com...
		'smtp_port' => 25,
		'smtp_user' => username,
		'smtp_pass' => password,
		'smtp_from' => sender email
	 *
	 * @author Jason Hu
	 * @since  2014-4-4
	 */
 if ( !function_exists( 'send_message' ) ) { 
	function send_message($params = array()) {
		$ci = &get_instance(); 
    	try {
    		$email = array(
    			'protocol' => 'smtp',
				'smtp_host' => 'smtp.163.com',
				'smtp_port' => 25,
				'smtp_user' => 'h07061108@163.com',
				'smtp_pass' => '07061108',
				'smtp_from' => 'h07061108@163.com'
    		);
			$config['protocol']  = $email['protocol'];
			$config['smtp_host'] = $email['smtp_host'];
			$config['smtp_port'] = $email['smtp_port'];
			$config['smtp_user'] = $email['smtp_user'];
			$config['smtp_pass'] = $email['smtp_pass'];
			$config['smtp_from'] = $email['smtp_from'];
			$config['mailtype']  = 'html';
			$config['validate']  = true;
			$config['priority']  = 1;
			$config['crlf']      = "\r\n";
			$config['charset']   = 'utf-8';
			$config['wordwrap']  = TRUE;
			$ci->email->initialize($config);
			$ci->email->from($config['smtp_from'], $params['sender']);
			$ci->email->to($params['to']);
			$ci->email->subject($params['subject']);
			$ci->email->message($params['message']);
			if (isset($params['attach']) && $params['attach']) {
				foreach ($params['attach'] as $attch) {
					$ci->email->attach($attch);
				}
			}
			if(!$ci->email->send()){
				echo json_encode(array('success' => '0', 'msg' => '邮件发送失败'));
				exit;
			}
    	} catch (Exception $e) {
    		echo json_encode(array('success' => '0', 'msg' => $e->getMessage()));
    		exit;
    	}
    }
 }
 

