<?php
	/**
	* BoZoN language file:
	* sets all the messages in various languages
	* to add one, simply copy paste the french one and change all the values: the array's keys must stay the same !
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	function e($txt,$echo=true){
		global $lang;
		if (isset($lang[$_SESSION['language']][$txt])){$t= $lang[$_SESSION['language']][$txt];}else{$t= $txt;}
		if ($echo){echo $t;}else{return $t;}
	}
	$lang=array();

	# ENGLISH (by default)
	$lang['en']=array();

  include('locales/es.php');
  include('locales/fr.php');
?>
