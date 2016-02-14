<?php
	/**
	* BoZoN commands GET vars part:
	* Here we handle the GET data for commands WITHOUT <header> <Body> <footer>
	* like thumbnails request, users list, login/logout request, public share file/folder request...
	* @author: Bronco (bronco@warriordudimanche.net)
	**/


	# thumbnail request
	if(isset($_GET['thumbs'])&&!empty($_GET['f'])){
		$f=get_thumbs_name(id2file($_GET['f']));
		$type=_mime_content_type($f);
		header('Content-type: '.$type.'; charset=utf-8');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($f));
		readfile($f);
		exit;
	}
	if(isset($_GET['gthumbs'])&&!empty($_GET['f'])){
		$f=get_thumbs_name_gallery(id2file($_GET['f']));
		$type=_mime_content_type($f);
		header('Content-type: '.$type.'; charset=utf-8');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($f));
		readfile($f);
		exit;
	}

	# public share request
	if (!empty($_GET['f'])){
		require('core/share.php');	
		exit;
	}

	# users share list request
	if (isset($_GET['users_share_list'])){
		$shared_id=$_GET['users_share_list'];
		require('core/auto_restrict.php');
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

	# Try to login or logout ? => auto_restrict
	if (!empty($_POST['pass'])&&!empty($_POST['login'])||isset($_GET['logout'])||isset($_GET['deconnexion'])){
		require('core/auto_restrict.php');
		exit;
	}

	# ask for rss stats 
	if (isset($_GET['statrss'])&&!empty($_GET['key'])&&hash_user($_GET['key'])){
		$rss=array('infos'=>'','items'=>'');
		$rss['infos']=array(
			'title'=>'BoZoN - stats',
			'description'=>e('Rss feed of stats',false),
			//'guid'=>$_SESSION['home'].'?f='.$id,
			'link'=>htmlentities($_SESSION['home']),
		);

		include('core/Array2feed.php');
		$stats=load($_SESSION['stats_file']);
		for ($index=0;$index<$_SESSION['stats_max_lines'];$index++){
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
?>
