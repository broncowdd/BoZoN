<?php 
	/**
	* BoZoN user part:
	* simply handles the get link.
	* @author: Bronco (bronco@warriordudimanche.net)
	**/

	include('core.php');
	if (!empty($_GET['f'])){
		$f=id2file($_GET['f']);
		
		if (is_file($f)){
			$type=mime_content_type($f);
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
<head>
	<title>BoZoN: <?php e('Drag, drop, share.');?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta charset="utf-8" />
	<link rel="shortcut icon" type="/image/png" href="img/bozonlogo2.png">
		
	<style>
	*{-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;}
	body{background:url(img/noise.png) #aaa;}
	.logo{
		color:rgba(0,0,0,0.2);width:100%;height:100%;min-height:100%;
		text-align:center;background:url(img/bozonlogo2.png) no-repeat center center;
		vertical-align: bottom;
		text-align:center;
		font-family: Consolas, monaco, monospace;
	}
	</style>
</head>
<body>
<div class="logo">BoZoN: <?php e('Drag, drop, share.');?> - www.warriordudimanche.net</div>
</body>