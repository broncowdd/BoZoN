<?php

define('EXIF_ORIENTATION_TOP',1);
define('EXIF_ORIENTATION_BOTTOM',3);
define('EXIF_ORIENTATION_RIGHT',6);
define('EXIF_ORIENTATION_LEFT',8);

function get_rotation_angle($exif_orientation){
	if (EXIF_ORIENTATION_BOTTOM == $exif_orientation){return 180;}
	if (EXIF_ORIENTATION_RIGHT == $exif_orientation){return 270;}
	if (EXIF_ORIENTATION_LEFT == $exif_orientation){return 90;}
	return 0;
}
function auto_thumb($img,$width=null,$height=null,$add_to_thumb_filename='_THUMB_',$crop_image=true){
	### VERSION MODIFIEE POUR BOZON ###
	// initialisation
	if (!getimagesize($img)){return false;}
	$DONT_RESIZE_THUMBS=true;
	global $auto_thumb;
	if (!$width){$width=$auto_thumb['default_width'];}
	if (!$height){$height=$auto_thumb['default_height'];}
	$recadrageX=0;$recadrageY=0;
	$motif='#\.(jpe?g|png|gif)#i';
	$rempl=$add_to_thumb_filename.$width.'x'.$height.'.$1';		
	$thumb_name='thumbs/'.preg_replace($motif,$rempl,$img);
	if (!file_exists($img)){return 'auto_thumb ERROR: '.$img.' doesn\'t exists';}
	if (file_exists($thumb_name)){return $thumb_name;} // miniature déjà créée
	if ($add_to_thumb_filename!='' && preg_match($add_to_thumb_filename,$img) && $DONT_RESIZE_THUMBS){return false;} // on cherche à traiter un fichier miniature (rangez un peu !)
	if(!is_dir(dirname($thumb_name))){ mkdir(dirname($thumb_name), 0755, true); }

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
	if (!$src  = $fonction($img)){return false;}
	
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
	
	// gestion de la rotation
	@$exif = exif_read_data($img);
	if ($exif && array_key_exists('Orientation', $exif)) {
		$orientation = $exif['Orientation'];
		$angle = get_rotation_angle($orientation);
		$thumb = imagerotate($thumb, $angle, 0);
	}
	imagepng($thumb, $thumb_name);
	imagedestroy($thumb);
	
	return $thumb_name;
}


?>