<?php
/**
* BoZoN templates file
* This file handles loading templates and inserting data in it
* Do not change the #CODE parts !
* @author: Bronco (bronco@warriordudimanche.net)
**/

if (function_exists('returnToken')){$token=returnToken();}

$replacement=array(
	'#tooltip_close'=>e('Delete this file',false),
	'#tooltip_link'=>e('Get the share link',false),
	'#tooltip_rename'=>e('Rename this file (share link will not change)',false),
	'#tooltip_lock'=>e('Put a password on this share',false),
	'#tooltip_burn'=>e('Turn this share into a burn after access share',false),
	'#tooltip_renew'=>e('Regen the share link',false),
	'#Move_file_or_folder'=>e('Move file or folder',false),
	'#Move'=>e('Move',false),
	'#To'=>e('To',false),
	'#Lock_access'=>e('Lock access',false),
	'#Please_give_a_password'=>e('Please give a password to lock access to this file',false),
	'#Rename_file'=>e('Rename this file ?',false),
	'#Rename'=>e('Rename this file ?',false),
	'#Delete_file'=>e('Delete this file ?',false),
	'#Delete'=>e('Delete',false),
	'#Share_link'=>e('Share link',false),
	'#Copy_link'=>e('Copy this share link',false),
	'#theme'=>$_SESSION['theme'],
	'#YES'=>e('Yes',false),
	'#Move_to'=>e('Move this file to another directory',false),
);
if (!empty($token)){
	$replacement['#TOKEN']=$token;
}
function load_templates($tpl_array=null){
	global $replacement;
	$k=array_keys($replacement);
	$r=array_values($replacement);
	if (empty($tpl_array)){
		$tpl_array=_glob('design/'.$_SESSION['theme'].'/templates/',$pattern='html');
	}
	foreach($tpl_array as $key=>$tpl){
		$tpl=basename($tpl);
		$tpl_name=substr($tpl,0,strlen($tpl)-5);
		$path='design/'.$_SESSION['theme'].'/templates/';
		$templates[$tpl_name]=str_replace($k,$r,file_get_contents($path.$tpl));
	}
	return $templates;
}

$templates=load_templates();



?>
