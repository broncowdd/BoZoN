<?php
	/**
	* BoZoN commands GET vars part:
	* Here we handle the GET data for commands WITHOUT <header> <Body> <footer>
	* like thumbnails request, users list, login/logout request, public share file/folder request...
	* @author: Bronco (bronco@warriordudimanche.net)
	**/


	# thumbnail request
	if(isset($_GET['thumbs'])&&!empty($_GET['f'])&&$_SESSION['GD']){
		$f=get_thumbs_name(id2file($_GET['f']));
		$type=_mime_content_type($f);
		header('Content-type: '.$type.'; charset=utf-8');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($f));
		readfile($f);
		exit;
	}
	if(isset($_GET['gthumbs'])&&!empty($_GET['f'])&&$_SESSION['GD']){
		$f=get_thumbs_name_gallery(id2file($_GET['f']));
		$type=_mime_content_type($f);
		header('Content-type: '.$type.'; charset=utf-8');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($f));
		readfile($f);
		exit;
	}

	# Cron update request
	if (!empty($_GET['cron_update'])&&$_GET['cron_update']==$cron_security_string){
		$ids=updateIDs($ids);
		exit('Ok');
	}
	
	# export shared file(s) data in json format
	if (isset($_GET['export'])&!empty($_GET['f'])){
		$tree=array();
		if (!empty($ids[$_GET['f']])&&is_dir($ids[$_GET['f']])){
			$content=folder_content($ids[$_GET['f']]);
			foreach($content as $id=>$path){
				# add item type to create folders when import
				$tree[$id]['path']=$path;
				$tree[$id]['url']=ROOT.'index.php?f='.$id;
				if (is_dir($path)){
					$tree[$id]['type']='folder';
				}else{
					$tree[$id]['type']='file';
				}
			}
		}else{
			$tree=array($_GET['f']=>$ids[$_GET['f']]);
		}
		store_access_stat($ids[$_GET['f']],$_GET['f']);
		exit(json_encode($tree));
	}

	# public share request
	if (!empty($_GET['f'])){
		require('core/share.php');	
		exit;
	}

	# Try to login or logout ? => auto_restrict
	if (!empty($_POST['pass'])&&!empty($_POST['login'])||isset($_GET['logout'])||isset($_GET['deconnexion'])){
		require_once('core/auto_restrict.php');
		exit;
	}

	# ask for rss stats 
	if (isset($_GET['statrss'])&&!empty($_GET['key'])&&hash_user($_GET['key'])){
		$rss=array('infos'=>'','items'=>'');
		$rss['infos']=array(
			'title'=>'BoZoN - stats',
			'description'=>e('Rss feed of stats',false),
			'link'=>htmlentities($_SESSION['home']),
		);

		include('core/Array2feed.php');
		$stats=load($_SESSION['stats_file']);
		for ($index=0;$index<conf('stats_max_lines');$index++){
			if (!empty($stats[$index])){
				$rss['items'][]=
				array(
					'title'=>$stats[$index]['file'],
					'description'=>'[ip:'.$stats[$index]['ip'].'] '.'[referrer:'.$stats[$index]['referrer'].'] '.'[host:'.$stats[$index]['host'].'] ',
					'pubDate'=>makeRSSdate($stats[$index]['date']),
					'link'=>$_SESSION['home'].'?f='.$stats[$index]['id'],
					'guid'=>$_SESSION['home'].'?f='.$stats[$index]['id'],
				);
			}
		}
		array2feed($rss);
		exit;
	}


	# ask for json format stats 
	if (isset($_GET['statjson'])&&!empty($_GET['key'])&&hash_user($_GET['key'])){
		$stats=load($_SESSION['stats_file']);
		exit(json_encode($stats));
	}	

	# zip and download a folder from visitor's share page
	if (!empty($_GET['zipfolder'])&&$_SESSION['zip']){
		$folder=id2file($_GET['zipfolder']);
		if (!is_dir($_SESSION['temp_folder'])){mkdir($_SESSION['temp_folder']);}
		$zipfile=$_SESSION['temp_folder'].return_owner($_GET['zipfolder']).'-'._basename($folder).'.zip';
		zip($folder,$zipfile);
		header('Content-type: application/zip');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($zipfile));
		# lance le téléchargement des fichiers non affichables
		header('Content-Disposition: attachment; filename="'._basename($zipfile).'"');
		readfile($zipfile);
		exit;
	}

	if (is_user_connected()){
		# users list request
		if (isset($_GET['users_list'])&&is_allowed('user page')){
			$_GET['p']='users';unset($_GET['users_list']); # To avoid useless changes in auto_restrict
		}
		# if user is connected, use auto_restrict
		require_once('core/auto_restrict.php');
		$token=returnToken();
		
		# complete list files ajax request button «load more»
		if(isset($_GET['async'])){
			include('core/listfiles.php');
			exit;
		}
		if (empty($_GET['p'])&&!empty($_GET)||count($_GET)>2||!empty($_POST)){include('core/GET_POST_admin_data.php');}
		if (!empty($_FILES)){
			include('core/auto_dropzone.php');
			exit();
		}
		
		# users share list request
		if (isset($_GET['users_share_list'])){
			$shared_id=$_GET['users_share_list'];
			require_once('core/auto_restrict.php');
			$shared_with=load_folder_share();
			$users=$auto_restrict['users'];
			unset($users[$_SESSION['login']]);
			foreach($users as $login=>$data){
				# creates a checkbox list of users (if the folder is already shared by logged user, checked)
				if (isset($shared_with[$login][$shared_id]) && $shared_with[$login][$shared_id]['from']==$_SESSION['login']){
					$check=' checked ';$class=' class="shared" ';
				}else{$check='';$class='';}
				echo '<li><input type="checkbox" '.$class.' id="check_'.$login.'" value="'.$login.'" name="users[]"'.$check.'><label for="check_'.$login.'">'.$login.'</label></li>';
			}		
			exit;
		}



	}else{$token='';}
	if (!empty($_GET['p'])){$page=$_GET['p'];}else{$page='';}
	if (!empty($_GET['msg'])){$message=$_GET['msg'];}
	if (!empty($_GET['lang'])){conf('language',$_GET['lang']);header('location:index.php?p='.$page.'&token='.$token);}
	if (!empty($_GET['aspect'])){conf('aspect',$_GET['aspect']);header('location:index.php?p='.$page.'&token='.$token);}
	
?>