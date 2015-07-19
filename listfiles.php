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

if (empty($_SESSION['filter'])){$mask='*';}else{$mask='*'.$_SESSION['filter'].'*';}
$liste=_glob(addslash_if_needed($_SESSION['current_path']),$mask);

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
						</div>
						<a href="index.php?f='.$id.'" >
							<img src="'.auto_thumb($fichier,64,64).'" style="background:transparent;"/>
							<em>'.$taille.' ko</em><em>'.$nom.'</em>
						</a>
					</li>';
			}else {
				# all atoher types
				$filelist.= '
					<li class="'.$extension.'">						
						<div class="buttons">
							<a class="close"  onclick="d(\''.$id.'\');">&nbsp;</a>
							<a class="rename"  onclick="r(\''.$id.'\',\''.$nom.'\');">&nbsp;</a>
							<a class="link"  onclick="l(\''.$id.'\');">&nbsp;</a>
						</div>
						<a href="index.php?f='.$id.'">
							<img class="'.$extension.'" src="img/ghost.png"/>
							<em>'.$taille.' ko</em><em>'.$nom.'</em>
						</a>
					</li>';
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
</script>