<?php
	/**
	* BoZoN core part:
	* Sets Constants, language, directories, htaccess and bozon's behaviour (files to download and files to echo)
	* @author: Bronco (bronco@warriordudimanche.net)
	**/

	require_once('lang.php');
	# INIT SESSIONS VARS AND ENVIRONMENT
	define('VERSION','1.5');
	include('config.php');

	# Current session changing language
	if (!empty($_GET['lang'])){$_SESSION['language']=strip_tags($_GET['lang']);header('location:admin.php');}
	if (empty($_SESSION['language'])){$_SESSION['language']=$default_language;}
	
	# UPLOAD PATH & ID_FILE
	if (empty($_SESSION['home'])){$_SESSION['home'] =addslash_if_needed(dirname(getUrl()));}
	if (empty($_SESSION['upload_path'])){$_SESSION['upload_path']=$default_path;}
	if (empty($_SESSION['id_file'])){$_SESSION['id_file']=$default_id_file;}
	if (!isset($_SESSION['current_path'])){$_SESSION['current_path']=$_SESSION['upload_path'];}
	if (!is_dir($_SESSION['upload_path'])){ mkdir($_SESSION['upload_path']); }
	if (!is_file($_SESSION['upload_path'].'index.html')){ file_put_contents($_SESSION['upload_path'].'index.html',' '); }
	if (!is_file('salt.php')){ file_put_contents('salt.php','<?php define("BOZON_SALT",'.var_export(generate_bozon_salt(),true).'); ?>'); }
	else{include('salt.php');}
	if (!is_dir('thumbs/')){mkdir('thumbs/');}
	if (!is_file('thumbs/index.html')){file_put_contents('thumbs/index.html',' ');}

	if (!file_exists($_SESSION['id_file'])){$ids=array();store();}
	if (!is_file($_SESSION['upload_path'].'.htaccess')){
		file_put_contents($_SESSION['upload_path'].'.htaccess', 
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

				<Files '.$_SESSION['id_file'].'>
					require valid-user
				</Files>
		');
	}

	if (!is_readable($_SESSION['id_file'])){$message.='<div class="error">'.e('Problem accessing ID file: not readable',false).'</div>';}
	if (!is_writable($_SESSION['id_file'])){$message.='<div class="error">'.e('Problem accessing ID file: not writable',false).'</div>';}
	if (!is_readable($_SESSION['current_path'])){$message.='<div class="error">'.e('Problem accessing '.$_SESSION['current_path'].': folder not readable',false).'</div>';}
	if (!is_writable($_SESSION['current_path'])){$message.='<div class="error">'.e('Problem accessing '.$_SESSION['current_path'].': folder not writable',false).'</div>';}

	$behaviour['FILES_TO_ECHO']=array('txt','js','html','php','SECURED_PHP','htm','shtml','shtm','css');
	$behaviour['FILES_TO_RETURN']=/*array();*/array('jpg','jpeg','gif','png','pdf','swf','mp3','mp4','svg');

 	$auto_dropzone['destination_filepath']=$_SESSION['current_path'].'/';
	$auto_thumb['default_width']='64';
	$auto_thumb['default_height']='64';
	$auto_thumb['dont_try_to_resize_thumbs_files']=true;



	$ids=unstore();
	# add an item to ID file
	function addID($string){
		$ids=unstore();
		$id=uniqid(true);
		$ids[$id]=$string;
		store();
	}
	# remove an id from id file
	function removeID($id){
		$ids=unstore();
		if (!empty($ids[$id])){unset ($ids[$id]);}
		store($ids);
	}
	# remove all ids that are not actually linked to a file/folder
	function purgeIDs(){
		$ids=unstore();
		foreach($ids as $key=>$val){
			if (!is_file($val) && !is_dir($val)){unset($ids[$key]);}
		}
		store();
	}
	# complete all missing ids 
	function completeID($array_of_files){
		$ids=unstore();
		$sdi=array_flip($ids);// paths are keys		
		$save=false;
		foreach($array_of_files as $file){
			if (!isset($sdi[$file])){
				$save=true;
				$ids[uniqid(true)]=$file;
			}
		}
		if ($save){
			store($ids);
			echo '<script>location.reload();</script>';
		}
	}	
	function is_in($ext,$type){
		global $behaviour;
		if (!empty($behaviour[$type])){return array_search($ext,$behaviour[$type]);}else{return false;}

	}
	function store($ids=null){
		if (!$ids){global $ids;}
		file_put_contents($_SESSION['id_file'],serialize($ids));
	}
	function unstore(){return unserialize(file_get_contents($_SESSION['id_file']));}
	function id2file($id){
		global $ids;
		if (isset($ids[$id])){return $ids[$id];}else{return false;}
	}
	function file2id($file){
		global $ids;
		$sdi=array_flip($ids);
		if (isset($sdi[$file])){return $sdi[$file];}else{return false;}
	}
	function addslash_if_needed($chaine){
		if (substr($chaine,strlen($chaine)-1,1)!='/'){return $chaine.'/';}else{return $chaine;}
	}
	function rename_item($file){
		$add='_'.uniqid();
		$extension=pathinfo($file,PATHINFO_EXTENSION);
		if (!empty($extension)){
			return str_replace($extension,$add.'.'.$extension,$file);
		}else{ return $file.$add;}
	}
	function kill_thumb_if_exists($f){
		global $auto_thumb;
		$filename=pathinfo($f,PATHINFO_FILENAME);
		$ext=pathinfo($f,PATHINFO_EXTENSION);
		$thumbname='thumbs/'.$filename.'_THUMB__'.$auto_thumb['default_width'].'x'.$auto_thumb['default_height'].'.'.$ext;
		if (is_file($thumbname)){unlink($thumbname);}else{return false;}
	}
	function only_alphanum_and_dot($string){return preg_replace('#[^a-zA-Z0-9\. _]#','',$string);}
	function file_curl_contents($url,$pretend=true){
		# distant version of file_get_contents
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Charset: UTF-8'));
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		if (!ini_get("safe_mode") && !ini_get('open_basedir') ) {curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);}
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		if ($pretend){curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:29.0) Gecko/20100101 Firefox/29.0');}    
		curl_setopt($ch, CURLOPT_REFERER, 'http://noreferer.com');// notez le referer "custom"
		$data = curl_exec($ch);
		$response_headers = curl_getinfo($ch);
		// Google seems to be sending ISO encoded page + htmlentities, why??
		//if($response_headers['content_type'] == 'text/html; charset=ISO-8859-1') $data = html_entity_decode(iconv('ISO-8859-1', 'UTF-8//TRANSLIT', $data)); 
		curl_close($ch);
		return $data;
	}
	function getUrl() {
	 $url = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] : 'https://'.$_SERVER["SERVER_NAME"];
	 //$url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
	 $url .= $_SERVER["REQUEST_URI"];
	 return $url;
	}
	function rrmdir($dir) { 
		# delete a folder and its content
	   if (is_dir($dir)) { 
	     $objects = scandir($dir); 
	     foreach ($objects as $object) { 
	       if ($object != "." && $object != "..") { 
	         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
	       } 
	     } 
	     reset($objects); 
	     rmdir($dir); 
	   } 
	}
	
	function visualizeIcon($extension){
		global $behaviour;
		$array=array_merge(array_flip($behaviour['FILES_TO_RETURN']),array_flip($behaviour['FILES_TO_ECHO']));
		return isset($array[$extension]);
	}
	function generate_bozon_salt($length=512){
		$salt='';
		for($i=1;$i<=$length;$i++){
			$salt.=chr(mt_rand(35,126));
		}
		return $salt;
	}
	function blur_password($pw){
		if (!empty($pw)){return hash('sha512', BOZON_SALT.$pw);}
		return false;
	}
	# to solve some problems on mime detection, fallback
	if (function_exists('mime_content_type')){
		function _mime_content_type($filename) {return mime_content_type($filename);}
	}elseif (function_exists('finfo_file')){
		function _mime_content_type($filename) {return finfo_file( finfo_open( FILEINFO_MIME_TYPE ), $filename );}
	}else{
		function _mime_content_type($filename){
			#inspired by http://stackoverflow.com/questions/8225644/php-mime-type-checking-alternative-way-of-doing-it
		    $mime_types = array(
		        'txt' => 'text/plain',
		        'htm' => 'text/html',
		        'html' => 'text/html',
		        'php' => 'text/html',
		        'css' => 'text/css',
		        'js' => 'application/javascript',
		        'json' => 'application/json',
		        'xml' => 'application/xml',
		        'swf' => 'application/x-shockwave-flash',
		        'flv' => 'video/x-flv',

		        // images
		        'png' => 'image/png',
		        'jpe' => 'image/jpeg',
		        'jpeg' => 'image/jpeg',
		        'jpg' => 'image/jpeg',
		        'gif' => 'image/gif',
		        'bmp' => 'image/bmp',
		        'ico' => 'image/vnd.microsoft.icon',
		        'tiff' => 'image/tiff',
		        'tif' => 'image/tiff',
		        'svg' => 'image/svg+xml',
		        'svgz' => 'image/svg+xml',

		        // archives
		        'zip' => 'application/zip',
		        'rar' => 'application/x-rar-compressed',
		        'exe' => 'application/x-msdownload',
		        'msi' => 'application/x-msdownload',
		        'cab' => 'application/vnd.ms-cab-compressed',

		        // audio/video
		        'mp3' => 'audio/mpeg',
		        'qt' => 'video/quicktime',
		        'mov' => 'video/quicktime',

		        // adobe
		        'pdf' => 'application/pdf',
		        'psd' => 'image/vnd.adobe.photoshop',
		        'ai' => 'application/postscript',
		        'eps' => 'application/postscript',
		        'ps' => 'application/postscript',

		        // ms office
		        'doc' => 'application/msword',
		        'rtf' => 'application/rtf',
		        'xls' => 'application/vnd.ms-excel',
		        'ppt' => 'application/vnd.ms-powerpoint',
		        'docx' => 'application/msword',
		        'xlsx' => 'application/vnd.ms-excel',
		        'pptx' => 'application/vnd.ms-powerpoint',


		        // open office
		        'odt' => 'application/vnd.oasis.opendocument.text',
		        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		    );

		    $ext=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
			if (array_key_exists($ext, $mime_types)) {return $mime_types[$ext];} 
			else {return 'application/octet-stream';}
		}
	}

	function _glob($path,$pattern='') {
		# glob function fallback by Cyril MAGUIRE (thx bro' ;-)
	    $liste =  array();
	    $pattern=str_replace('*','',$pattern);
	    if ($handle = opendir($path)) {
	        while (false !== ($file = readdir($handle))) {
	        	if(stripos($file, $pattern)!==false || $pattern=='' && $file!='.' && $file!='..' && $file!='.htaccess') {
	                $liste[] = $path.$file;
	            }
	        }
	        closedir($handle);
	    }

	    natcasesort($liste);
	    return $liste;
	   
	}
	
	function tree($dir='.',$files=true){
        # scann a folder and subfolders and return the tree
        if (!isset($dossiers[0]) || $dossiers[0]!=$dir){$dossiers[0]=$dir;}
        if (!is_dir($dir)&&$files){ return array($dir); }
        elseif (!is_dir($dir)&&!$files){return array();}
        $list=_glob(addslash_if_needed($dir)); 
        
        foreach ($list as $dossier) {
            //$dossiers[]=tree($dossier); 
            $dossiers=array_merge($dossiers,tree($dossier,$files));
        }
        return $dossiers;
    }
	function draw_tree($tree){
		echo '<section><ul class="tree">';
			$root=explode('/',$tree[0]);$fork='&#9500;';
			$root=array_search(basename($tree[0]), $root)+1;
			$level=0;$tab=str_repeat('&nbsp;',2);
			for ($i=0;$i<count($tree);$i++){
				$branch=$tree[$i];
				if (isset($tree[$i+1])){$next=$tree[$i+1];}else{$next=false;}

				if ($link=file2id($branch)){ 
					$ext='';
					$level=count(explode('/',$branch))-$root;
					if ($next){$next_level=count(explode('/',$next))-$root;}else{$next_level=0;}						
					if ($level<0){$level=0;}
					if ($next_level<0){$next_level=0;}

					$ext=strtolower(pathinfo($branch,PATHINFO_EXTENSION));
					$folder='';$basename=basename($branch);

					if(is_dir($branch)){
						$folder=' folder';
					}
					if ($level>$next_level || !$next){
						$fork='&#9492;';
					}else{$fork='&#9500;';}
					if ($level<$next_level){
						echo '<li>'.str_repeat('<span class="vl">'.$tab.'&#9474;'.$tab.'</span>', $level+1).'</li>';
					}
		
					echo '<li><span class="vl">'.str_repeat($tab.'&#9474;'.$tab, $level).$tab.$fork.$tab.'</span><span class="'.$ext.$folder.'"><a href="index.php?f='.$link.'">'.$basename.'</a></span></li>';
					if ($level>$next_level){echo '<li>'.str_repeat('<span class="vl">'.$tab.'&#9474;'.$tab.'</span>', $level).'</li>';}
						
				}
					
				
			}

		echo '</ul></section>';
	}
	
?>
