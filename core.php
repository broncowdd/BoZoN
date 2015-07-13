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
	
	$ids=unstore(ID_FILE);
	function is_in($ext,$type){global $behaviour;if (!empty($behaviour[$type])){return array_search($ext,$behaviour[$type]);}}
	function store($file,$datas){file_put_contents($file,serialize($datas));}
	function unstore($file){return unserialize(file_get_contents($file));}
	function id2file($id){
		global $ids;
		if (isset($ids[$id])){return UPLOAD_PATH.$ids[$id];}else{return false;}
	}
	function e($txt,$echo=true){
		global $lang;
		if (isset($lang[LANGUAGE][$txt])){$t= $lang[LANGUAGE][$txt];}else{$t= $txt;}
		if ($echo){echo $t;}else{return $t;}
	}


?>