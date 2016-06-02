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
	'#tooltip_url'=>e("Paste file's url",false),
	'#paste_bozon_url'=>e('Paste a BoZoN share url',false),
	'#tooltip_link'=>e('Get the share link',false),
	'#tooltip_qrcode'=>e('Get the qrcode of this link',false),
	'#tooltip_rename'=>e('Rename this file (share link will not change)',false),
	'#tooltip_lock'=>e('Put a password on this share',false),
	'#tooltip_burn'=>e('Turn this share into a burn after access share',false),
	'#tooltip_renew'=>e('Regen the share link',false),
	'#tooltip_zipfolder'=>e('Download a zip from this folder',false),
	'#Move_file_or_folder'=>e('Move file or folder',false),
	'#Move_to'=>e('Move to',false),
	'#Move'=>e('Move',false),
	'#To'=>e('To',false),
	'#Lock_access'=>e('Lock access',false),
	'#Please_give_a_password'=>e('Please give a password to lock access to this file',false),
	'#Rename_file'=>e('Rename this file?',false),
	'#Rename_item'=>e('Rename this item?',false),
	'#Rename'=>e('Rename',false),
	'#Delete_item'=>e('Delete this item?',false),
	'#Delete'=>e('Delete',false),
	'#Share_folder'=>e('Share item',false),
	'#Share_link'=>e('Share link',false),
	'#share_text'=>e('Select the users you want to share with',false),
	'#Copy_link'=>e('Copy this share link',false),
	'#theme'=>THEME_PATH,
	'#YES'=>e('Yes',false),
	'#Move_to'=>e('Move this file to another directory',false),
	'#Create_new_folder'=>e('Create a subfolder',false),
	'#Create_folder_title'=>e('Create a subfolder in this folder',false),
	'#New_folder'=>e('New folder',false),
	'#paste_url'=>e('Paste a file\'s URL',false),
	'#paste_url_title'=>e('Paste a file\'s URL to get it on this server',false),
	'#Read_m3u_playlist'=>e('Read m3u playlist',false),
	'#local_filename'=>e('Force local filename (leave empty=no change)',false),
	'#filename'=>e('filename (optionnal)',false),

);
if (!empty($token)){
	$replacement['#TOKEN']=$token;
}
function load_templates($tpl_array=null){
	global $replacement;
	$k=array_keys($replacement);
	$r=array_values($replacement);
	$path=THEME_PATH.'/templates/';
	if (empty($tpl_array)){
		$tpl_array=_glob($path,$pattern='html');
	}
	foreach($tpl_array as $key=>$tpl){
		$tpl=_basename($tpl);
		$tpl_name=substr($tpl,0,strlen($tpl)-5);
		$templates[$tpl_name]=str_replace($k,$r,file_get_contents($path.$tpl));
	}
	return $templates;
}

$templates=load_templates();



?>
