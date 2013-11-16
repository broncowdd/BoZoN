<ul class="list" id="liste">
<?php 
if (!function_exists('store')){include('core.php');}
// Configuration
$auto_thumb['default_width']='64';
$auto_thumb['default_height']='64';
$auto_thumb['dont_try_to_resize_thumbs_files']=true;

function auto_thumb($img,$width=null,$height=null,$add_to_thumb_filename='_THUMB_'){
	// initialisation
	global $auto_thumb;
	if (!$width){$width=$auto_thumb['default_width'];}
	if (!$height){$height=$auto_thumb['default_height'];}
	$motif='#\.(jpe?g|png|gif)#i'; // Merci à JéromeJ pour la correction  ! 
	$rempl=$add_to_thumb_filename.'_'.$width.'x'.$height.'.$1';
	$thumb_name='thumbs/'.basename(preg_replace($motif,$rempl,$img));
	// sortie prématurée:
	if (!file_exists($img)){return 'auto_thumb ERROR: '.$img.' doesn\'t exists';}
	if (file_exists($thumb_name)){return $thumb_name;} // miniature déjà créée
	if ($add_to_thumb_filename!='' && preg_match($add_to_thumb_filename,$img) && $auto_thumb['dont_try_to_resize_thumbs_files']){return false;} // on cherche à traiter un fichier miniature (rangez un peu !)
	
	// redimensionnement	
	$taille = getimagesize($img);
	
	// en fonction de l'extension
	$fichier = pathinfo($img);
	$extension=str_replace('jpg','jpeg',$fichier['extension']);
	
	
	$fonction='imagecreatefrom'.$extension;
	$src  = $fonction($img);  // que c'est pratique ça ^^ !
	
	// création image
	$thumb = imagecreatetruecolor($width,$height);
	
	// gestion de la transparence 
	// (voir fonction de Seebz: http://code.seebz.net/p/imagethumb/)
	if( $extension=='png' ){imagealphablending($thumb,false);imagesavealpha($thumb,true);}
	if( $extension=='gif'  && @imagecolortransparent($img)>=0 ){
		$transparent_index = @imagecolortransparent($img);
		$transparent_color = @imagecolorsforindex($img, $transparent_index);
		$transparent_index = imagecolorallocate($thumb, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
		imagefill($thumb, 0, 0, $transparent_index);
		imagecolortransparent($thumb, $transparent_index);
	}
	
	imagecopyresampled($thumb,$src,0,0,0,0,$width,$height,$taille[0],$taille[1]);
	imagepng($thumb, $thumb_name);
	imagedestroy($thumb);
	
	return $thumb_name;
}
	$liste=glob(UPLOAD_PATH.'*.*');
	if (count($liste)>1){
		$files=array_flip($ids);
		foreach ($liste as $fichier){
			$nom=basename($fichier);
			if ($nom!='index.html'&&!empty($files[$nom])){
				$taille=filesize($fichier);
				$id=$files[$nom];
				$extension=strtolower(pathinfo($fichier,PATHINFO_EXTENSION));
				if ($extension=='gif'||$extension=='jpg'||$extension=='jpeg'||$extension=='png'){
					echo '<li class="'.$extension.'"><a class="close" href="#" onclick="d(\''.$id.'\');">x</a><a href="index.php?f='.$id.'" ><img src="" style="background:url('.auto_thumb($fichier,64,64).');"/><em>'.$nom.'</em></a> <em>'.$taille.' ko</em></li>';

				}else{
					echo '<li class="'.$extension.'"><a class="close" href="#" onclick="d(\''.$id.'\');">x</a><a href="index.php?f='.$id.'"><img class="'.$extension.'" src=""/><em>'.$nom.'</em></a> <em>'.$taille.' ko</em></li>';

				}
				
			}
		}
	}else{echo 'Pas de fichiers uploadés...';}


?>
</ul>
<script>
	function d(id){
		if (confirm('Supprimer ce fichier ?')){
			document.location.href="admin.php?del="+id;
		}
	}
</script>