<?php 
	/**
	* BoZoN core part:
	* Sets Constants, language, directories, htaccess and bozon's behaviour (files to download and files to echo)
	* @author: Bronco (bronco@warriordudimanche.net)
	**/

	require_once('lang.php');
	# INIT SESSIONS VARS AND ENVIRONMENT

	# Changing language
	$default_language='fr'; // change this if you want another language by default (see in lang.php)
	if (!empty($_GET['lang'])){$_SESSION['language']=strip_tags($_GET['lang']);header('location:admin.php');}
	if (empty($_SESSION['language'])){$_SESSION['language']=$default_language;}
	
	# UPLOAD PATH & ID_FILE
	$default_path='uploads/';
	$default_id_file='id.txt';
	if (empty($_SESSION['home'])){$_SESSION['home'] =addslash_if_needed(dirname(getUrl()));}
	if (empty($_SESSION['upload_path'])){$_SESSION['upload_path']=$default_path;}
	if (empty($_SESSION['id_file'])){$_SESSION['id_file']=$default_id_file;}
	if (!isset($_SESSION['current_path'])){$_SESSION['current_path']=$_SESSION['upload_path'];}
	if (!is_dir($_SESSION['upload_path'])){ mkdir($_SESSION['upload_path']); }
	if (!is_file($_SESSION['upload_path'].'index.html')){ file_put_contents($_SESSION['upload_path'].'index.html',' '); }
	if (!is_dir('thumbs/')){mkdir('thumbs/');}
	if (!is_file('thumbs/index.html')){file_put_contents('thumbs/index.html',' ');}

	if (!file_exists($_SESSION['id_file'])){$ids=array();store($_SESSION['id_file'],$ids);}
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

	

	$behaviour['FILES_TO_ECHO']=array('txt','js','html','php','htm','shtml','shtm','css');
	$behaviour['FILES_TO_RETURN']=array('jpg','jpeg','gif','png','pdf','swf','mp3','mp4','avi','svg');

 	$auto_dropzone['destination_filepath']=$_SESSION['current_path'].'/';
	$auto_thumb['default_width']='64';
	$auto_thumb['default_height']='64';
	$auto_thumb['dont_try_to_resize_thumbs_files']=true;



	$ids=unstore($_SESSION['id_file']);
	# add an item to ID file
	function addID($string){
		$ids=unstore($_SESSION['id_file']);
		$id=uniqid(true);
		$ids[$id]=$string;
		store($_SESSION['id_file'],$ids);
	}
	# remove an id from id file
	function removeID($id){
		$ids=unstore($_SESSION['id_file']);
		if (!empty($ids[$id])){unset ($ids[$id]);}
		store($_SESSION['id_file'],$ids);
	}
	# remove all ids that are not actually linked to a file/folder
	function purgeIDs(){
		$ids=unstore($_SESSION['id_file']);
		foreach($ids as $key=>$val){
			if (!is_file($val) && !is_dir($val)){unset($ids[$key]);}
		}
		store($_SESSION['id_file'],$ids);
	}
	function is_in($ext,$type){global $behaviour;if (!empty($behaviour[$type])){return array_search($ext,$behaviour[$type]);}}
	function store($file,$datas){file_put_contents($file,serialize($datas));}
	function unstore($file){return unserialize(file_get_contents($file));}
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
	if (function_exists('glob')){
		function _glob($path,$pattern='*'){return glob($path.$pattern);}
	}else{
		function _glob($path,$pattern='') {
			# glob function fallback by Cyril MAGUIRE (thx bro' ;-)
		    $liste =  array();
		    $pattern=str_replace('*','',$pattern);
		    if ($handle = opendir($path)) {
		        while (false !== ($file = readdir($handle))) {
		        	if(stripos($file, $pattern)!==false || $pattern=='') {
		                $liste[] = $path.$file;
		            }
		        }
		        closedir($handle);
		    }
		    if (!empty($liste)) {
		        return $liste;
		    } else {
		        return array();
		    }
		}
	}

	function tree($dir='.',$files=true){
        # scann a folder and subfolders and return the tree
        if (!isset($dossiers[0]) || $dossiers[0]!=$dir){$dossiers[0]=$dir;}
        if (!is_dir($dir)&&$files){ return array($dir); }
        elseif (!is_dir($dir)&&!$files){return array();}
        $list=_glob($dir.'/'); 
        
        foreach ($list as $dossier) {
            //$dossiers[]=tree($dossier); 
            $dossiers=array_merge($dossiers,tree($dossier,$files));
        }
        return $dossiers;
    }
	function draw_tree($tree){
		echo '<section><ul class="tree">';
			$root=explode('/',$tree[0]);
			$root=array_search(basename($tree[0]), $root)+1;
			$previous_level=$level=0;
			foreach ($tree as $branch){
				if ($link=file2id($branch)){ 
					$ext='';
					$level=count(explode('/',$branch))-$root;				
					if ($level<0){$level=0;}
					$ext=strtolower(pathinfo($branch,PATHINFO_EXTENSION));
					$folder='';$basename=basename($branch);
					if(is_dir($branch)){
						$folder=' folder';
						echo '<li>'.str_repeat('<span class="vl">  &#9474;  </span>', $level).'</li>';
					}
					if ($level!=$previous_level){
						echo '<li>'.str_repeat('<span class="vl">  &#9474;  </span>', $level).'</li>';
						$previous_level=$level;
					}
		
					echo '<li><span class="vl">'.str_repeat('  &#9474;  ', $level).'  &#9500;  </span><span class="'.$ext.$folder.'"><a href="index.php?f='.$link.'">'.$basename.'</a></span></li>';
				}
				
			}
		echo '</ul></section>';
	}
	
?>