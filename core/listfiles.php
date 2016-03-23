<?php 
	/**
	* BoZoN list files script:
	* just list the files in the upload current path (with the filter if needed) 
	* @author: Bronco (bronco@warriordudimanche.net)
	**/


start_session();

if (!empty($_SESSION['ERRORS'])){echo '<div class="error">'.strip_tags($_SESSION['ERRORS']).'</div>';unset($_SESSION['ERRORS']);}

# Libs & dependencies
require_once('core/core.php');
require_once('core/auto_restrict.php'); # Connected user only !
include("core/auto_thumb.php");

# Initialisation
if (empty($layout)){$layout=$_SESSION['aspect'];}
if (!isset($shared_folders)){$shared_folders='';}
if (!isset($back_link)){$back_link='';}
$upload_path_size=strlen($_SESSION['upload_root_path'].$_SESSION['upload_user_path']);
if (empty($_SESSION['mode'])){$mode='view';}else{$mode=$_SESSION['mode'];}
if (empty($_SESSION['current_path'])){
	$path_list=$_SESSION['upload_root_path'].$_SESSION['upload_user_path'];
}else{
	$path_list=$_SESSION['upload_root_path'].$_SESSION['upload_user_path'].addslash_if_needed($_SESSION['current_path']);
}

# Building current tree and prepare pagination
if (empty($_SESSION['filter'])){$liste=tree($path_list,null,false,false,$tree);}
else{$liste=tree($path_list,null,false,false,$tree);}
$total_files=count($liste);$from=0;
$max_pages=ceil($total_files/$_SESSION['max_files_per_page']);
if (!empty($_GET['from'])){$from=$_GET['from'];}
$liste=array_slice($liste, $from*$_SESSION['max_files_per_page'],$_SESSION['max_files_per_page']);
$remain=$total_files-(($from+1)*$_SESSION['max_files_per_page']);


if ($allow_folder_size_stat){$size_folder=folder_size($path_list);}

if (count($liste)>0){
	$files=array_flip($ids);	
	$folderlist='';
	$filelist='';

	foreach ($liste as $fichier){
		$nom=_basename($fichier);		
		if ($nom!='index.html'&&!empty($files[$fichier])){			
			$id=$files[$fichier];
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

			# adding view icon if needed
			if (is_in($extension,'FILES_TO_RETURN')!==false){
				if ($extension=='jpg'||$extension=='jpeg'||$extension=='gif'||$extension=='png'||$extension=='svg'){
					if ($use_lightbox){
						$icone_visu='<a class="visu" data-type="lightbox" data-group="lb" href="index.php?f='.$id.'" title="'.e('View this share',false).'" alt="'.$nom.'"><span class="icon-eye" ></span></a>';
					}else{
						$icone_visu='<a class="visu" target="_BLANK" href="index.php?f='.$id.'" title="'.e('View this share',false).'"><span class="icon-eye" ></span></a>';
					}
					if (!$click_on_link_to_download){$target='target="_BLANK"';}else{$target=null;}
				}else{
					$icone_visu='<a class="visu" target="_BLANK" href="index.php?f='.$id.'&amp;view" title="'.e('View this file',false).'"><span class="icon-eye" ></span></a>';
				}
			}else{$icone_visu='';}

			#adding edit icon if needed
			if (is_file($fichier)&&_mime_content_type($fichier)=='text/plain'&&$extension!='js'&&$extension!='php'&&$extension!='sphp'){				
				$icone_edit='<a class="edit" href="index.php?p=editor&overwrite=true&file='.$id.'&token='.TOKEN.'" title="'.e('Edit this file',false).'"><span class="icon-edit" ></span></a>';
			}else{$icone_edit='';}

			# create item for file or folder
			$fichier_short=substr($fichier,$upload_path_size);
			if (is_dir($fichier)){		
				# Item is a folder
				$current_tree=tree($fichier,null,false,false,$tree);
				if (only_type($current_tree,'.jpg .jpeg .gif .png') || only_type($current_tree,'.mp3 .ogg')||only_type($fichier,'.jpg .jpeg .gif .png') || only_type($fichier,'.mp3 .ogg')){
					$icone_visu='<a class="visu" href="index.php?f='.$id.'" title="'.e('View this share',false).'"><span class="icon-eye"></span></a>';
				}			
				if ($allow_folder_size_stat){$taille=folder_size($fichier);}else{$taille='';}
				# no share folder button if there's only one user
				if ($mode=='links'&&count($auto_restrict['users'])>1){
					$icone_share='<a class="usershare" title="'.e('Share this folder with another user',false).'" href="#usershare" data-id="'.$id.'" data-name="'.$fichier_short.'"><span class="icon-users"></span></a>';
				}else{$icone_share='';}
				$array=array(
					'#CLASS'			=> $class,
					'#ID'				=> $id,
					'#FICHIER'			=> $fichier_short,
					'#TOKEN'			=> TOKEN,
					'#SIZE'				=> $taille,
					'#NAME'				=> $nom,
					'#USERSHAREBUTTON'	=> $icone_share,
					'#TITLE'			=> $title,
					'#ICONE_VISU'		=> $icone_visu,
					'#SLASHEDNAME'		=> addslashes($nom),
					'#SLASHEDFICHIER'	=> addslashes($fichier_short),
				);
				$folderlist.= template($mode.'_folder_'.$layout,$array);
				$current_tree='';
			}elseif (is_file($fichier) && $_SESSION['GD'] && ($extension=='gif'||$extension=='jpg'||$extension=='jpeg'||$extension=='png')){
				# Item is a picture
				auto_thumb($fichier,64,64);
				if (empty($target)){$target='download="'.$nom.'"';}
				$array=array(
					'#CLASS'			=> $class,
					'#ID'				=> $id,
					'#FICHIER'			=> $fichier_short,
					'#TOKEN'			=> TOKEN,
					'#SIZE'				=> sizeconvert(filesize($fichier)),
					'#NAME'				=> $nom,
					'#TARGET'			=> $target,
					'#TITLE'			=> $title,
					'#EXTENSION'		=> $extension,
					'#ICONE_VISU'		=> $icone_visu,
					'#SLASHEDNAME'		=> addslashes($nom),
					'#SLASHEDFICHIER'	=> addslashes($fichier_short),
				);
				$filelist.= template($mode.'_image_'.$layout,$array);
			}elseif (is_file($fichier) && $extension=='zip' && $_SESSION['zip']){

				# Item is a zip file=> add change to folder
				$icone_visu='<a class="tofolder" href="index.php?p=admin&unzip='.$id.'&token='.TOKEN.'" title="'.e('Convert this zip file to folder',false).'"><span class="icon-folder-1"></span></a>';
				$array=array(
					'#CLASS'			=> $class,
					'#ID'				=> $id,
					'#FICHIER'			=> $fichier_short,
					'#TOKEN'			=> TOKEN,
					'#SIZE'				=> sizeconvert(filesize($fichier)),
					'#NAME'				=> $nom,
					'#TARGET'			=> 'download="'.$nom.'"',
					'#TITLE'			=> $title,
					'#EXTENSION'		=> $extension,
					'#ICONE_VISU'		=> $icone_visu,
					'#ICONE_EDIT'		=> $icone_edit,
					'#SLASHEDNAME'		=> addslashes($nom),
					'#SLASHEDFICHIER'	=> addslashes($fichier_short),
				);
				$filelist.= template($mode.'_file_'.$layout,$array);
			}elseif (is_file($fichier)){
				chrono('fichier:'.$nom);
				# all other types
				if (empty($target)){$target='download="'.$nom.'"';}
				$array=array(
					'#CLASS'			=> $class,
					'#ID'				=> $id,
					'#FICHIER'			=> $fichier_short,
					'#TOKEN'			=> TOKEN,
					'#SIZE'				=> sizeconvert(filesize($fichier)),
					'#NAME'				=> $nom,
					'#TITLE'			=> $title,
					'#TARGET'			=> $target,
					'#EXTENSION'		=> $extension,
					'#ICONE_VISU'		=> $icone_visu,
					'#ICONE_EDIT'		=> $icone_edit,
					'#SLASHEDNAME'		=> addslashes($nom),
					'#SLASHEDFICHIER'	=> addslashes($fichier_short),
				);
				$filelist.= template($mode.'_file_'.$layout,$array);
				chrono('fichier:'.$nom);

			}
	
		}
	}
	if ($mode=='view'){
		$column='<td class="table_check"></td>';
		$column_header='<th class="table_check sorttable_nosort"><input type="checkbox" id="check_all" title="'.e('Check all',false).'"/></th>';
		$form_header='<form id="multiselect" action="#" method="POST">
		<input type="hidden" name="token" value="'.TOKEN.'"/>
		<input type="hidden" name="multiselect_command" id="multiselect_command" value=""/>';
		$form_footer='</form>';
	}else{
		$column=$form_header=$form_footer=$column_header='';
	}
	if ($layout=='list'&&!isset($_GET['async'])){
		# List layout
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
			</thead>
			<tbody id="async_load">';

			echo $shared_folders.$back_link.$folderlist.$filelist;

			if (!empty($size_folder)){echo '</tbody><tfoot><tr>'.$column.'<td class="table_image"></td><td class="table_filename" style="text-align:right">Total:</td><td id="folder_size">'.$size_folder.'</td><td></td></tr></tfoot>';}
			echo '</table>';
			echo $form_footer;
		
	}elseif ($layout=='icon'&&!isset($_GET['async'])){
		# Icon layout
		echo '<div id="async_load">';
 		echo $shared_folders.$folderlist.$filelist;
		echo '</div>';
		if (!empty($size_folder)){echo '<div id="folder_size">'.e('Foldersize',false).': '.$size_folder.'</div>';}
	}else{ 
		# Ajax load more => content only
		echo $shared_folders.$back_link.$folderlist.$filelist; 
	}
	
    # «Load more» button
    if ($remain>0&&!isset($_GET['async'])){
      if ($remain>$_SESSION['max_files_per_page']){$remain=$_SESSION['max_files_per_page'];}
      $from++;
      echo '<a id="more_button" class="btn" href="index.php?p=admin&from='.$from.'&token='.TOKEN.'" onclick="loadMore(this);return false;" data-from="'.$from.'" data-url="index.php?async&token='.TOKEN.'" data-max="'.$max_pages.'">'.e('Load',false).' '.$remain.' '.e('more',false).'</a>';
    }
}else{echo '<table>'.$shared_folders.'</table><div id="nofile">'.e('No file or folder',false).'</div>';}
chrono('etape2 listfiles.php ');
?>
