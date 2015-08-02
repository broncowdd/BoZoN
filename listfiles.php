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
						<label>'.e('Move',false).':</label><input type="text" value="" name="file" id="filename" disabled="true"/>
						<input type="hidden" value="" name="file" id="filename_hidden"/>
						<label>'.e('To',false).':</label>'.$select_folder;

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
if ($mode=='links'){
	# Add dialogbox to the page
	echo '
		<div class="lightbox" id="locked">
			<figure>
				<a href="#" class="closemsg"></a>
				<figcaption>
					<h1>'.e('Lock access',false).'</h1>
				    <form action="admin.php" method="post"><br/>
						<label>'.e('Please give a password to lock access to this file',false).'</label>
						<input type="text"  value="" name="password"/>
						<input type="hidden" value="" name="id" id="ID_hidden"/>
						';

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
			$files[$fichier]=$id;
			$save=true;
		}
		
		if ($nom!='index.html'&&!empty($files[$fichier])){
			$taille=round(filesize($fichier)/1024,2);
			$id=$files[$fichier];
			$class='';$title='';
			if (substr($id, 0,1)=='*'){
				# add class burn id after access 
				$class='burn';
				$title=e('The user can access this only one time', false);
			}else
			if (strlen($id)>strlen(uniqid(true))){
				# add class password protected 
				$class='locked';
				$title=e('The user can access this only with the password', false);
			}
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
						<li class="folder '.$class.'" title="'.$title.'">
							<div class="buttons">
								<a class="close"  onclick="d(\''.$id.'\');">&nbsp;</a>
								<a class="rename" onclick="r(\''.$id.'\',\''.addslashes($nom).'\');">&nbsp;</a>
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
						<li class="'.$extension.' '.$class.'" title="'.$title.'">
							<div class="buttons">
								<a class="close"  onclick="d(\''.$id.'\');">&nbsp;</a>
								<a class="rename"  onclick="r(\''.$id.'\',\''.addslashes($nom).'\');">&nbsp;</a>
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
						<li class="'.$extension.' '.$class.'" title="'.$title.'">						
							<div class="buttons">
								<a class="close"  onclick="d(\''.$id.'\');">&nbsp;</a>
								<a class="rename"  onclick="r(\''.$id.'\',\''.addslashes($nom).'\');">&nbsp;</a>
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
			}elseif ($mode=='move'){
				if (is_dir($fichier)){
					# Item is a folder					
					$folderlist.= '
						<li class="folder '.$class.'" title="'.$title.'">
							<div class="buttons">
								<a class="movefolder" href="#selecttarget" onclick="put_file(\''.addslashes($fichier).'\')">&nbsp;</a>
							</div>
							<a href="admin.php?path='.$fichier.'&token='.returnToken(true).'" >
								<img src="img/folder.png" style="background:transparent;"/>
								<em>'.$nom.'</em>
							</a>
						</li>';
				}elseif ($extension=='gif'||$extension=='jpg'||$extension=='jpeg'||$extension=='png'){
					# Item is a picture
					$filelist.= '
						<li class="'.$extension.' '.$class.'" title="'.$title.'">							
							<a href="#selecttarget" onclick="put_file(\''.addslashes($fichier).'\')">
								<img src="'.auto_thumb($fichier,64,64).'" style="background:transparent;"/>
								<em>'.$taille.' ko</em><em>'.$nom.'</em>
							</a>
						</li>';
				}else {
					# all other types
					$filelist.= '
						<li class="'.$extension.' '.$class.'" title="'.$title.'">	
							<a href="#selecttarget" onclick="put_file(\''.addslashes($fichier).'\')">
								<img class="'.$extension.'" src="img/ghost.png"/>
								<em>'.$taille.' ko</em><em>'.$nom.'</em>
							</a>
						</li>';
				}
			# Manage links mode 
			}elseif($mode=='links'){
				if (is_dir($fichier)){
					# Item is a folder
					$taille=count(_glob($fichier.'/'));
					$folderlist.= '
						<li class="folder '.$class.'" title="'.$title.'">
							<div class="buttons">
								<a class="locked"  href="#locked" onclick="put_id(\''.$id.'\')">&nbsp;</a>
								<a class="burn" href="admin.php?burn='.$id.'&token='.returnToken().'">&nbsp;</a>
								<a class="renew" href="admin.php?renew='.$id.'&token='.returnToken().'">&nbsp;</a>
							</div>
							<a href="admin.php?path='.$fichier.'&token='.returnToken(true).'" >
								<img src="img/folder.png" style="background:transparent;"/>
								<em class="over">'.$taille.'</em><em>'.$nom.'</em>
							</a>
						</li>';
				}elseif ($extension=='gif'||$extension=='jpg'||$extension=='jpeg'||$extension=='png'){
					# Item is a picture
					$filelist.= '
						<li class="'.$extension.' '.$class.'" title="'.$title.'">
							<div class="buttons">
								<a class="locked"  href="#locked" onclick="put_id(\''.$id.'\')">&nbsp;</a>
								<a class="burn" href="admin.php?burn='.$id.'&token='.returnToken().'">&nbsp;</a>
								<a class="renew" href="admin.php?renew='.$id.'&token='.returnToken().'">&nbsp;</a>
							</div>
							<a href="index.php?f='.$id.'" download="'.$nom.'">
								<img src="'.auto_thumb($fichier,64,64).'" style="background:transparent;"/>
								<em>'.$taille.' ko</em><em>'.$nom.'</em>
							</a>
						</li>';
				}else {
					# all other types
					$filelist.= '
						<li class="'.$extension.' '.$class.'">						
							<div class="buttons" title="'.$title.'">
								<a class="locked"  href="#locked" onclick="put_id(\''.$id.'\')">&nbsp;</a>
								<a class="burn" href="admin.php?burn='.$id.'&token='.returnToken().'">&nbsp;</a>
								<a class="renew" href="admin.php?renew='.$id.'&token='.returnToken().'">&nbsp;</a>
							</div>
							<a href="index.php?f='.$id.'" download="'.$nom.'">
								<img class="'.$extension.'" src="img/ghost.png"/>
								<em>'.$taille.' ko</em><em>'.$nom.'</em>
							</a>
						</li>';
				}
			}



			
		}
	}
	echo $folderlist.$filelist;
	if ($save){store();} // save in case of new files
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
	function put_id(id){
		document.getElementById('ID_hidden').value=id;
	}
</script>