<?php 
	/**
	* BoZoN list files script:
	* just list the files in the upload directory (with the filter if needed) 
	* @author: Bronco (bronco@warriordudimanche.net)
	**/

if (!function_exists('store')){include('core.php');}
// Configuration

function auto_thumb($img,$width=null,$height=null,$add_to_thumb_filename='_THUMB_',$crop_image=true){
	### VERSION MODIFIEE POUR BOZON ###
	// initialisation
	$DONT_RESIZE_THUMBS=true;
	global $auto_thumb;
	if (!$width){$width=$auto_thumb['default_width'];}
	if (!$height){$height=$auto_thumb['default_height'];}

	$recadrageX=0;$recadrageY=0;
	$motif='#\.(jpe?g|png|gif)#i'; // Merci à JéromeJ pour la correction  ! 
	$rempl=$add_to_thumb_filename.'_'.$width.'x'.$height.'.$1';
	$thumb_name='thumbs/'.basename(preg_replace($motif,$rempl,$img));
	// sortie prématurée:
	if (!file_exists($img)){return 'auto_thumb ERROR: '.$img.' doesn\'t exists';}
	if (file_exists($thumb_name)){return $thumb_name;} // miniature déjà créée
	if ($add_to_thumb_filename!='' && preg_match($add_to_thumb_filename,$img) && $DONT_RESIZE_THUMBS){return false;} // on cherche à traiter un fichier miniature (rangez un peu !)

	// redimensionnement en fonction du ratio
	$taille = getimagesize($img);
	$src_width=$taille[0];
	$src_height=$taille[1];
	if (!$crop_image){ 
		// sans recadrage: on conserve les proportions
		if ($src_width<$src_height){
			// portrait
			$ratio=$src_height/$src_width;
			$width=$height/$ratio;
		}else if ($src_width>$src_height){
			// paysage
			$ratio=$src_width/$src_height;
			$height=$width/$ratio;
		}
	}else{
		// avec recadrage: on produit une image aux dimensions définies mais coupée
		if ($src_width<$src_height){
			// portrait
			$recadrageY=round(($src_height-$src_width)/2);
			$src_height=$src_width;
		}else if ($src_width>$src_height){
			// paysage
			$recadrageX=round(($src_width-$src_height)/2);
			$src_width=$src_height;
		}
	}



	// en fonction de l'extension
	$fichier = pathinfo($img);
	$extension=str_ireplace('jpg','jpeg',$fichier['extension']);
	
	
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
	
	imagecopyresampled($thumb,$src,0,0,$recadrageX,$recadrageY,$width,$height,$src_width,$src_height);
	imagepng($thumb, $thumb_name);
	imagedestroy($thumb);
	
	return $thumb_name;
}
if (empty($mask)){$mask='*';}else{$mask='*'.$mask.'*';}
$liste=glob(UPLOAD_PATH.$mask);
//if ($index=array_search('index.html', $liste)){unset($liste[$index]);}

//$ids=unstore(ID_FILE);
$save=false;
if (count($liste)>0){
	$files=array_flip($ids);
	foreach ($liste as $fichier){
		$nom=basename($fichier);
		if ($nom!='index.html'&&empty($files[$nom])){
			// generates the file ID if not present
			$id=uniqid(true);
			$ids[$id]=$nom;
			$save=true;
		}
		if ($nom!='index.html'&&!empty($files[$nom])){
			$taille=round(filesize($fichier)/1024,2);
			$id=$files[$nom];
			$extension=strtolower(pathinfo($fichier,PATHINFO_EXTENSION));
			if ($extension=='gif'||$extension=='jpg'||$extension=='jpeg'||$extension=='png'){
				echo '
					<li class="'.$extension.'">
						<div class="buttons">
							<a class="close" href="#" onclick="d(\''.$id.'\');">&nbsp;</a>
							<a class="rename" href="#" onclick="r(\''.$id.'\',\''.pathinfo($nom,PATHINFO_FILENAME).'\');">R</a>
						</div>
						<a href="index.php?f='.$id.'" >
							<img src="'.auto_thumb($fichier,64,64).'" style="background:transparent;"/>
							<em>'.$taille.' ko</em><em>'.$nom.'</em>
						</a>
					</li>';
			}else{
				echo '
					<li class="'.$extension.'">						
						<div class="buttons">
							<a class="close" href="#" onclick="d(\''.$id.'\');">&nbsp;</a>
							<a class="rename" href="#" onclick="r(\''.$id.'\',\''.pathinfo($nom,PATHINFO_FILENAME).'\');">R</a>
						</div>
						<a href="index.php?f='.$id.'">
							<img class="'.$extension.'" src="img/ghost.png"/>
							<em>'.$taille.' ko</em><em>'.$nom.'</em>
						</a>
					</li>';
			}
			
		}
	}

	if ($save){store(ID_FILE,$ids);} // save in case of new files
}else{e('No file on the server');}


?>

<script>
	function d(id){
		if (confirm("<?php e('Delete this file ?');?>")){
			document.location.href="admin.php?del="+id+'&token=<?php newToken(true);?>';
		}
	}
	function r(id,filename){
		if (newname=prompt("<?php e('Rename this file ?');?>",filename)){
			if (newname!=filename){
				document.location.href="admin.php?ren="+id+"&newname="+newname+"&token=<?php newToken(true);?>";
			}
		}
	}
</script>