<?php 
	/**
	* BoZoN index page:
	* joins all bozon parts and handles requests
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
#########################################################################################
# Secure process by Timo ( http://lehollandaisvolant.net/?mode=links&id=20160319122329 )
#########################################################################################
if (basename($_SERVER['SCRIPT_NAME']) === 'index.php' and strpos(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 'index.php') === FALSE ) {
	$var_request_URI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH).'index.php';
} else {
	$var_request_URI = $_SERVER['REQUEST_URI'];
}
if (parse_url($var_request_URI, PHP_URL_PATH) !== $_SERVER['SCRIPT_NAME']) {
	header('Location: '.$_SERVER['SCRIPT_NAME']);
}
#########################################################################################

require('core/core.php');
require('core/commands_GET_vars.php');# handle no html content requests
#########################################################################################
require(THEME_PATH.'/header.php');
#########################################################################################
if (!empty($message)){echo '<div class="info" onclick="addClass(this,\'hidden\');" title="'.e('Click to remove',false).'">'.$message.'</div>';}
# page request
if (!empty($page)&&is_file(THEME_PATH.$page.'.php')){
	# request for a specific page
	include(THEME_PATH.$page.'.php');
}else{
	# no page request -> home
	include(THEME_PATH.'home.php');
}
#########################################################################################
require(THEME_PATH.'/footer.php');
$_SESSION['ERRORS']='';
?>