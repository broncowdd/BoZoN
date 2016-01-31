<?php 
	/**
	* BoZoN index page:
	* joins all bozon parts and handles requests
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
if (is_file('import.php')){header('location: import.php');}
require('core/core.php');


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

# share request
if (!empty($_GET['f'])){
	require('core/share.php');	
	exit;
}

# Try to login or logout ? => auto_restrict
if (!empty($_POST['pass'])&&!empty($_POST['login'])||isset($_GET['logout'])||isset($_GET['deconnexion'])){
	require('core/auto_restrict.php');
	exit;
}

if (is_admin_connected()){
	# if admin is connected, use auto_restrict
	require_once('core/auto_restrict.php');
	$token=returnToken();
	
	# refresh list files ajax request
	if(isset($_GET['refresh'])){
		include('core/listfiles.php');
		exit;
	}
	if (empty($_GET['p'])&&!empty($_GET)||count($_GET)>2||!empty($_POST)){include('core/GET_POST_admin_data.php');}
	if (!empty($_FILES)){
		include('core/auto_dropzone.php');
		exit();
	}

}else{$token='';}

if (!empty($_GET['p'])){$page=$_GET['p'];}else{$page='';}
if (!empty($_GET['lang'])){$_SESSION['language']=$_GET['lang'];header('location:index.php?p='.$page.'&token='.$token);}
if (!empty($_GET['aspect'])){$_SESSION['aspect']=$_GET['aspect'];header('location:index.php?p='.$page.'&token='.$token);}
	


	
require(THEME_PATH.'/header.php');
	# users list request
	if (isset($_GET['users_list'])){
		echo '<div class="w1000">';
		generate_users_formlist(e('Users list',false),e('Check users to delete account and files',false));// auto_restrict function
		echo '</div>';
	}
	# page request
	elseif (!empty($page)&&is_file(THEME_PATH.$page.'.php')){
		# request for a specific page
		include(THEME_PATH.$page.'.php');
	}else{
		# no page request -> home
		include(THEME_PATH.'home.php');
	}
	
require(THEME_PATH.'/footer.php');
?>