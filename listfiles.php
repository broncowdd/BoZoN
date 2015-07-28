<?php 
	/**
	* BoZoN list files script:
	* just list the files in the upload current path (with the filter if needed) 
	* @author: Bronco (bronco@warriordudimanche.net)
	**/

if (!function_exists('store')){
	if (!session_id()){session_start();}
	include('core.php');
	include('auto_restrict.php');
}
include("auto_thumb.php");

// Configuration
if (empty($_SESSION['mode'])){$mode='view';}else{$mode=$_SESSION['mode'];}
if (empty($_SESSION['filter'])){$mask='*';}else{$mask='*'.$_SESSION['filter'].'*';}
$liste=_glob(addslash_if_needed($_SESSION['current_path']),$mask);
if ($mode=='move'){
	# Prépare folder tree 
	$select_folder='<select name="destination" class="folder_list button"><option value="">'.e('Choose a folder',false).'</option>';
	$folders_list=tree($_SESSION['upload_path'],false);
	foreach($folders_list as $folder){
		$select_folder.='<option value="'.$folder.'">'.$folder.'</option>';
	}
	$select_folder.='</select>';
	# Add dialogbox to the page
	echo '
		<div class="lightbox" id="selecttarget">
			<figure>
				<a href="#" class="closemsg"></a>
				<figcaption>
					<h1>'.e('Move file or folder',false).'</h1>
				    <form action="admin.php" method="post">
						'.e('Move',false).':<input type="text" value="" name="file" id="filename" disabled="true"/>
						<input type="hidden" value="" name="file" id="filename_hidden"/>
						'.e('To',false).':'.$select_folder;

						newToken();
	echo '
						<br/>

						<input type="submit" value="ok" class="button"/>
				    </form>
				</figcaption>
			</figure>
		</div>
	';
}

$save=false;
if (count($liste)>0){
	$files=array_flip($ids);
	$folderlist='';
	$filelist='';
	foreach ($liste as $fichier){
		$nom=basename($fichier);
		if ($nom!='index.html'&&empty($files[$fichier])){
			// generates the file ID if not present
			$id=uniqid(true);
			$ids[$id]=$fichier;
			$save=true;
		}
		
		if ($nom!='index.html'&&!empty($files[$fichier])){
			$taille=round(filesize($fichier)/1024,2);
			$id=$files[$fichier];
			$extension=strtolower(pathinfo($fichier,PATHINFO_EXTENSION));


			# Manage files mode (normal mode)
			if ($mode=='view'){
				if (visualizeIcon($extension)){
					$icone_visu='<a class="visu" href="index.php?f='.$id.'" target="_BLANK">&nbsp;</a>';
				}else{$icone_visu='';}
				if (is_dir($fichier)){
					# Item is a folder
					$taille=count(_glob($fichier.'/'));
					$folderlist.= '
						<li class="folder">
							<div class="buttons">
								<a class="close"  onclick="d(\''.$id.'\');">&nbsp;</a>
								<a class="rename" onclick="r(\''.$id.'\',\''.$nom.'\');">&nbsp;</a>
								<a class="link"  onclick="l(\''.$id.'\');">&nbsp;</a>
							</div>
							<a href="admin.php?path='.$fichier.'&token='.returnToken(true).'" >
								<img src="img/folder.png" style="background:transparent;"/>
								<em class="over">'.$taille.'</em><em>'.$nom.'</em>
							</a>
						</li>';
				}elseif ($extension=='gif'||$extension=='jpg'||$extension=='jpeg'||$extension=='png'){
					# Item is a picture
					$filelist.= '
						<li class="'.$extension.'">
							<div class="buttons">
								<a class="close"  onclick="d(\''.$id.'\');">&nbsp;</a>
								<a class="rename"  onclick="r(\''.$id.'\',\''.$nom.'\');">&nbsp;</a>
								<a class="link"  onclick="l(\''.$id.'\');">&nbsp;</a>
								'.$icone_visu.'
							</div>
							<a href="index.php?f='.$id.'" download="'.$nom.'">
								<img src="'.auto_thumb($fichier,64,64).'" style="background:transparent;"/>
								<em>'.$taille.' ko</em><em>'.$nom.'</em>
							</a>
						</li>';
				}else {
					# all other types
					$filelist.= '
						<li class="'.$extension.'">						
							<div class="buttons">
								<a class="close"  onclick="d(\''.$id.'\');">&nbsp;</a>
								<a class="rename"  onclick="r(\''.$id.'\',\''.$nom.'\');">&nbsp;</a>
								<a class="link"  onclick="l(\''.$id.'\');">&nbsp;</a>
								'.$icone_visu.'
							</div>
							<a href="index.php?f='.$id.'" download="'.$nom.'">
								<img class="'.$extension.'" src="img/ghost.png"/>
								<em>'.$taille.' ko</em><em>'.$nom.'</em>
							</a>
						</li>';
				}

			# Move files mode
			}elseif ($mode='move'){
				if (is_dir($fichier)){
					# Item is a folder					
					$folderlist.= '
						<li class="folder">
							<a href="admin.php?path='.$fichier.'&token='.returnToken(true).'" >
								<img src="img/folder.png" style="background:transparent;"/>
								<a href="#selecttarget" onclick="put_file(\''.addslashes($fichier).'\')">'.e('Move',false).'</a><em>'.$nom.'</em>
							</a>
						</li>';
				}elseif ($extension=='gif'||$extension=='jpg'||$extension=='jpeg'||$extension=='png'){
					# Item is a picture
					$filelist.= '
						<li class="'.$extension.'">							
							<a href="#selecttarget" onclick="put_file(\''.addslashes($fichier).'\')">
								<img src="'.auto_thumb($fichier,64,64).'" style="background:transparent;"/>
								<em>'.$taille.' ko</em><em>'.$nom.'</em>
							</a>
						</li>';
				}else {
					# all other types
					$filelist.= '
						<li class="'.$extension.'">	
							<a href="#selecttarget" onclick="put_file(\''.addslashes($fichier).'\')">
								<img class="'.$extension.'" src="img/ghost.png"/>
								<em>'.$taille.' ko</em><em>'.$nom.'</em>
							</a>
						</li>';
				}
			# Manage links mode 
			}elseif($mode='links'){

			}



			
		}
	}
	echo $folderlist.$filelist;
	if ($save){store($_SESSION['id_file'],$ids);} // save in case of new files
}else{e('No file on the server');}


?>

<script>

	function d(id){
		if (confirm("<?php e('Delete this file ?');?>")){
			document.location.href="admin.php?del="+id+'&token=<?php newToken(true);?>';
		}

	}
	function l(id){
		prompt("<?php e('Copy this share link');?>","<?php echo $_SESSION['home']; ?>index.php?f="+id);
	}
	function r(id,filename){
		if (newname=prompt("<?php e('Rename this file ?');?>",filename)){
			if (newname!=filename){
				document.location.href="admin.php?ren="+id+"&newname="+newname+"&token=<?php newToken(true);?>";
			}
		}
	}
	function put_file(fichier){
		document.getElementById('filename').value=fichier;
		document.getElementById('filename_hidden').value=fichier;
	}
</script>