<?php 
	/**
	* BoZoN list files script:
	* just list the files in the upload current path (with the filter if needed) 
	* @author: Bronco (bronco@warriordudimanche.net)
	**/


start_session();
if (!empty($_SESSION['ERRORS'])){echo '<div class="error">'.strip_tags($_SESSION['ERRORS']).'</div>';unset($_SESSION['ERRORS']);}
folder_usage_draw($_SESSION['login'],$mode=3);
$layout=$_SESSION['aspect'];
$shared_folders='';
if (!function_exists('store')){
	include('core/core.php');
	if (!function_exists('newToken')){require_once('core/auto_restrict.php');} # Admin only!
}
include("core/auto_thumb.php");



// Configuration
$upload_path_size=strlen($_SESSION['upload_root_path'].$_SESSION['upload_user_path']);
if (empty($_SESSION['mode'])){$mode='view';}else{$mode=$_SESSION['mode'];}
if (empty($_SESSION['filter'])){$mask='*';}else{$mask='*'.$_SESSION['filter'].'*';}
if (empty($_SESSION['current_path'])){
	$path_list=$_SESSION['upload_root_path'].$_SESSION['upload_user_path'];
	
}else{
	$path_list=$_SESSION['upload_root_path'].$_SESSION['upload_user_path'].addslash_if_needed($_SESSION['current_path']);
}
$liste=_glob($path_list,$mask);
if ($allow_folder_size_stat){$size_folder=folder_size($path_list);}

if ($mode=='links'){
	# Add lock dialogbox to the page
	$array=array(
		'#TOKEN'	=> returnToken()
	);
	echo template('dialog_password',$array);
}
if ($mode=='view'){
	# Add shares from others users 
	$shared_with=load_folder_share();
	if (!empty($shared_with[$_SESSION['login']])){
		$shared_folders.= '<div class="shared_folders">';
		foreach($shared_with[$_SESSION['login']] as $id=>$data){
			$folder=basename($data['folder']);
			$array=array(
				'#CLASS'			=> 'shared_folder',
				'#ID'				=> $id,
				'#FICHIER'			=> $folder,
				'#TOKEN'			=> returnToken(),
				'#NAME'				=> $folder,
				'#FROM'			=> $data['from'],
			);
			$shared_folders.= template($mode.'_shared_folder_'.$layout,$array);
			
		}
		$shared_folders.= '</div>';
		
	}

	# Prepare folder tree 
	$select_folder='<select name="destination" class="folder_list button"><option value="">'.e('Choose a folder',false).'</option>';
	$folders_list=tree($_SESSION['upload_root_path'].$_SESSION['upload_user_path'],false);
	$folders_list[0].='/';
	foreach($folders_list as $folder){
		$folder=substr($folder,$upload_path_size);
		$select_folder.='<option value="'.$folder.'">'.$folder.'</option>';
	}
	$select_folder.='</select>';
	# Add move dialogbox to the page
	$array=array(
			'#LIST_FILES_SELECT'	=> $select_folder,
			'#TOKEN'				=> returnToken(),
		);
	echo template('dialog_move',$array);
}
$save=false;

if (count($liste)>0){
	$files=array_flip($ids);
	$folderlist='';
	$filelist='';


	foreach ($liste as $fichier){
		$nom=_basename($fichier);
		$length_upload_path=strlen($_SESSION['upload_root_path'].$_SESSION['upload_user_path']);
		$nom_racine=substr($fichier, $length_upload_path);
		if ($nom!='index.html'&&empty($files[$fichier])&&empty($files[$nom_racine])){
			# generates the file ID if not present
			$id=uniqid(true);
			$ids[$id]=$fichier;
			$files[$fichier]=$id;
			$save=true;

		}
		if ($nom!='index.html'){
			$taille=sizeconvert(filesize($fichier));
			if (!empty($files[$fichier])){$id=$files[$fichier];}
			else{$id=$files[$nom_racine];}
			$class='';$title='';

			if (substr($id, 0,1)=='*'){
				# add class burn id after access 
				$class='burn';
				$title=e('The user can access this only one time', false);
			}elseif (strlen($id)>strlen(uniqid(true))){
				# add class password protected 
				$class='locked';
				$title=e('The user can access this only with the password', false);
			}

			$extension=strtolower(pathinfo($fichier,PATHINFO_EXTENSION));
			if (visualizeIcon($extension)){
				if(@is_array(getimagesize($fichier))){$type='img';}else{$type='iframe';}
				$icone_visu='<a class="visu" data-type="'.$type.'" data-group="lb" href="index.php?f='.$id.'" title="'.e('View this share',false).'">&nbsp;</a>';
			}elseif($extension=='m3u'){
				$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
				$icone_visu='<a class="visu" title="'.e('View this file',false).'" onclick="" href="#m3u">&nbsp;</a>';
			}elseif($extension=='txt'||$extension=='nfo'||$extension=='md'){
				$icone_visu='<a class="visu"  data-type="iframe" data-group="lb" href="index.php?f='.$id.'&amp;view" title="'.e('View this file',false).'">&nbsp;</a>';
			}else{$icone_visu='';}
			$fichier_short=substr($fichier,$upload_path_size);

			if (is_dir($fichier)){
				# Item is a folder
				if (only_image($fichier) || only_sound($fichier)){$icone_visu='<a class="visu" href="index.php?f='.$id.'" title="'.e('View this share',false).'">&nbsp;</a>';}				
				if (isset($allow_folder_size_stat)&&$allow_folder_size_stat){$taille=folder_size($fichier);}else{$taille='';}
				$array=array(
					'#CLASS'			=> $class,
					'#ID'				=> $id,
					'#FICHIER'			=> $fichier_short,
					'#TOKEN'			=> returnToken(),
					'#SIZE'				=> $taille,
					'#NAME'				=> $nom,
					'#TITLE'			=> $title,
					'#ICONE_VISU'		=> $icone_visu,
					'#SLASHEDNAME'		=> addslashes($nom),
					'#SLASHEDFICHIER'	=> addslashes($fichier_short),
				);
				$folderlist.= template($mode.'_folder_'.$layout,$array);
			}elseif ($extension=='gif'||$extension=='jpg'||$extension=='jpeg'||$extension=='png'){
				# Item is a picture
				auto_thumb($fichier,64,64);
				$array=array(
					'#CLASS'		=> $class,
					'#ID'			=> $id,
					'#FICHIER'		=> $fichier_short,
					'#TOKEN'		=> returnToken(),
					'#SIZE'			=> $taille,
					'#NAME'			=> $nom,
					'#TITLE'		=> $title,
					'#EXTENSION'	=> $extension,
					'#ICONE_VISU'	=> $icone_visu,
					'#SLASHEDNAME'	=> addslashes($nom),
					'#SLASHEDFICHIER'	=> addslashes($fichier_short),
				);
				$filelist.= template($mode.'_image_'.$layout,$array);
			}elseif ($extension=='zip'){
				# Item is a zip file=> add change to folder
				$icone_visu='<a class="tofolder" href="index.php?p=admin&unzip='.$id.'&token='.returnToken().'" title="'.e('Convert this zip file to folder',false).'">&nbsp;</a>';
				$array=array(
					'#CLASS'		=> $class,
					'#ID'			=> $id,
					'#FICHIER'		=> $fichier_short,
					'#TOKEN'		=> returnToken(),
					'#SIZE'			=> $taille,
					'#NAME'			=> $nom,
					'#TITLE'		=> $title,
					'#EXTENSION'	=> $extension,
					'#ICONE_VISU'	=> $icone_visu,
					'#SLASHEDNAME'	=> addslashes($nom),
					'#SLASHEDFICHIER'	=> addslashes($fichier_short),
				);
				$filelist.= template($mode.'_file_'.$layout,$array);
			}else {
				# all other types
				$array=array(
					'#CLASS'		=> $class,
					'#ID'			=> $id,
					'#FICHIER'		=> $fichier_short,
					'#TOKEN'		=> returnToken(),
					'#SIZE'			=> $taille,
					'#NAME'			=> $nom,
					'#TITLE'		=> $title,
					'#EXTENSION'	=> $extension,
					'#ICONE_VISU'	=> $icone_visu,
					'#SLASHEDNAME'	=> addslashes($nom),
					'#SLASHEDFICHIER'	=> addslashes($fichier_short),
				);
				$filelist.= template($mode.'_file_'.$layout,$array);
			}
		
		}
	}
	if ($mode=='view'){
		$column='<td class="table_check"></td>';
		$column_header='<th class="table_check sorttable_nosort"><input type="checkbox" id="check_all" title="'.e('Check all',false).'"/></th>';
		$form_header='<form id="multiselect" action="#" method="POST"><input type="hidden" name="token" value="'.returnToken().'"/>';
		$form_footer='</form>';
	}else{
		$column=$form_header=$form_footer=$column_header='';
	}
	if ($layout=='list'){
		echo $form_header;
		echo '
		<table class="sortable">
		<thead>
			<tr>
				'.$column_header.'
				<th class="table_image sorttable_nosort">&nbsp;</th>
				<th class="table_filename">'.e('Filename',false).'</th>
				<th class="table_filesize">'.e('Filesize',false).'</th>
				<th class="table_buttons sorttable_nosort">&nbsp;</th>
			</tr>
		</thead>';
	}
	echo $shared_folders.$folderlist.$filelist;
	if ($layout=='list'){
		if (!empty($size_folder)){echo '<tfoot><tr>'.$column.'<td class="table_image"></td><td class="table_filename" style="text-align:right">Total:</td><td id="folder_size">'.$size_folder.'</td><td></td></tr></tfoot>';}
		echo '</table>';
		echo $form_footer;
	}elseif (!empty($size_folder)){echo '<div id="folder_size">'.e('Foldersize',false).': '.$size_folder.'</div>';}
	if ($save){store($ids);} // save in case of new files
}else{echo '<div id="nofile">'.e('No file in your personal folder',false).'</div>';}

?>
