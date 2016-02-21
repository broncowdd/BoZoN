<?php 
  /**
  * BoZoN index page:
  * joins all bozon parts and handles requests
  * @author: Bronco (bronco@warriordudimanche.net)
  **/
require 'core/core.php';
require 'core/commands_GET_vars.php'; // handle no html content requests

if(is_admin_connected()){
  // if admin is connected, use auto_restrict
  require_once 'core/auto_restrict.php';
  $token=returnToken();
  
  // refresh list files ajax request
  if(isset($_GET['refresh'])){
    include 'core/listfiles.php';
    exit;
  }
  
  if(empty($_GET['p']) && !empty($_GET) || count($_GET)>2 || !empty($_POST))
    include 'core/GET_POST_admin_data.php';
  
  if(!empty($_FILES)){
    include 'core/auto_dropzone.php';
    exit();
  }

}else $token='';

if(!empty($_GET['p'])) $page=$_GET['p'];
else $page='';
if(!empty($_GET['lang'])){
  $_SESSION['language']=$_GET['lang'];
  header('location:index.php?p='.$page.'&token='.$token);
}

if(!empty($_GET['aspect'])){
  $_SESSION['aspect']=$_GET['aspect'];
  header('location:index.php?p='.$page.'&token='.$token);
}

require THEME_PATH.'/header.php';
  // users list request
  if(isset($_GET['users_list']))
    generate_users_formlist(e('Users list',false),e('Check users to delete account and files',false)); // auto_restrict function
  
	// page request
  elseif(!empty($page)&&is_file(THEME_PATH.$page.'.php'))
    // request for a specific page
    include THEME_PATH.$page.'.php';
    
  else
    // no page request -> home
    include THEME_PATH.'home.php';
  
require THEME_PATH.'/footer.php';
?>
