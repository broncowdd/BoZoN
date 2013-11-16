<?php 
	// gestion des fichiers envoyés
	

	$ds = DIRECTORY_SEPARATOR; 
	if (!empty($_FILES)) {
		include('core.php');
	    $tempFile = $_FILES['file']['tmp_name'];              
	    $targetPath = dirname( __FILE__ ) . $ds. UPLOAD_PATH;  
	    $targetFile =  $targetPath.strtolower($_FILES['file']['name']);
	    move_uploaded_file($tempFile,$targetFile);
	    $ids[uniqid()]=strtolower($_FILES['file']['name']);
	    store(ID_FILE,$ids);

	}else {
		//affichage du formulaire
		echo '<div class="cadre" title="Drop files here or click"><form action="upload.php" class="mydropzone" id="Dropzone"></form></div>';

		$INCLUDE_JS=true;
	}
	
?>

