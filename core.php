<?php 
	/**
	* BoZoN core part:
	* Sets Constants, language, directories, htaccess and bozon's behaviour (files to download and files to echo)
	* @author: Bronco (bronco@warriordudimanche.net)
	**/

	require_once('lang.php');
	// INIT
	$default_language='fr'; // change this if you want another language by default (see in lang.php)
	if (!empty($_GET['lang'])){$default_language=strip_tags($_GET['lang']);}
	define('ID_FILE','id.txt');
	define('UPLOAD_PATH','uploads/');
	define('LANGUAGE',$default_language);

	if (!is_dir(UPLOAD_PATH)){ mkdir(UPLOAD_PATH); }
	if (!is_file(UPLOAD_PATH.'index.html')){ file_put_contents(UPLOAD_PATH.'index.html',' '); }
	if (!is_dir('thumbs/')){mkdir('thumbs/');}
	if (!is_file('thumbs/index.html')){file_put_contents('thumbs/index.html',' ');}

	if (!file_exists(ID_FILE)){$ids=array();store(ID_FILE,$ids);}
	if (!is_file(UPLOAD_PATH.'.htaccess')){
		file_put_contents(UPLOAD_PATH.'.htaccess', 
			'<Files .htaccess>
	order allow,deny
	deny from all
</Files>
Options All -Indexes
RemoveHandler .php .phtml .php3 .php4 .php5
RemoveType .php .phtml .php3 .php4 .php5
php_flag engine off
		');
	}
	if (!is_file('.htaccess')){
		file_put_contents('.htaccess', 
			'<Files .htaccess>
				order allow,deny
				deny from all
				</Files>

				<Files '.ID_FILE.'>
					require valid-user
				</Files>
		');
	}

	$behaviour['FILES_TO_ECHO']=array('txt','js','html','php','htm','shtml','shtm','css');
	$behaviour['FILES_TO_RETURN']=array('jpg','jpeg','gif','png','pdf','swf','mp3','mp4','avi','svg');
 	$auto_dropzone['destination_filepath']=UPLOAD_PATH;
	$auto_thumb['default_width']='64';
	$auto_thumb['default_height']='64';
	$auto_thumb['dont_try_to_resize_thumbs_files']=true;

	$ids=unstore(ID_FILE);
	function is_in($ext,$type){global $behaviour;if (!empty($behaviour[$type])){return array_search($ext,$behaviour[$type]);}}
	function store($file,$datas){file_put_contents($file,serialize($datas));}
	function unstore($file){return unserialize(file_get_contents($file));}
	function id2file($id){
		global $ids;
		if (isset($ids[$id])){return UPLOAD_PATH.$ids[$id];}else{return false;}
	}

	function kill_thumb_if_exists($f){
		global $auto_thumb;
		$filename=pathinfo($f,PATHINFO_FILENAME);
		$ext=pathinfo($f,PATHINFO_EXTENSION);
		$thumbname='thumbs/'.$filename.'_THUMB__'.$auto_thumb['default_width'].'x'.$auto_thumb['default_height'].'.'.$ext;
		if (is_file($thumbname)){unlink($thumbname);}else{return false;}
	}
	function only_alphanum_and_dot($string){return preg_replace('#[^a-zA-Z0-9\. _]#','',$string);}
	function remote_file_exists($url){if(@fclose(@fopen($url, 'r'))){return true;}else {return false;}}
	function file_curl_contents($url,$pretend=true){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Charset: UTF-8'));
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		if (!ini_get("safe_mode") && !ini_get('open_basedir') ) {curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);}
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		if ($pretend){curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:29.0) Gecko/20100101 Firefox/29.0');}    
		//curl_setopt($ch, CURLOPT_REFERER, random_referer());// notez le referer "custom"
		$data = curl_exec($ch);
		$response_headers = curl_getinfo($ch);
		// Google seems to be sending ISO encoded page + htmlentities, why??
		//if($response_headers['content_type'] == 'text/html; charset=ISO-8859-1') $data = html_entity_decode(iconv('ISO-8859-1', 'UTF-8//TRANSLIT', $data)); 
		curl_close($ch);
		return $data;
	}
	
?>