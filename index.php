<?php 
	include('core.php');
	if (isset($_GET['f'])&&$_GET['f']!=''){
		$f=UPLOAD_PATH.id2file($_GET['f']);
		if (is_file($f)){
			$type=mime_content_type ($f);
			$ext=strtolower(pathinfo($f,PATHINFO_EXTENSION));
			if (is_in($ext,'FILES_TO_ECHO')!==false){
				
				echo '<pre>'.htmlspecialchars(file_get_contents($f)).'</pre>';
			}
			else if (is_in($ext,'FILES_TO_RETURN')!==false){
				header('Content-type: '.$type);
				readfile($f);
			}
			else{
				header('Content-type: '.$type);
				// lance le téléchargement des fichiers non affichables
				header('Content-Disposition: attachment; filename="'.$f.'"');
				readfile($f);				
			}
			exit();
			
		}
	}
?>
<body style="background:url(img/noise.png) #333;">
<div style="color:#f90;width:100%;height:100%;min-height:100%;text-align:center;background:url(img/bozon-logo.png) no-repeat center center;">by www.warriordudimanche.net</div>
</body>