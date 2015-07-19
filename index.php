<?php 
	/**
	* BoZoN user part:
	* simply handles the get link.
	* @author: Bronco (bronco@warriordudimanche.net)
	**/

	include('core.php');
	$tree=false;
	if (!empty($_GET['f'])){
		$f=id2file(strip_tags($_GET['f']));
		if ($f && is_file($f)){
			# file request => return file according to $behaviour var (see core.php)
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
		}else if ($f && is_dir($f)){
			# folder request: return the folder & subfolders tree 
			$tree=tree($f);

		}
	}
?>
<head>
	<title>BoZoN: <?php e('Drag, drop, share.');?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta charset="utf-8" />
	<link rel="shortcut icon" type="/image/png" href="img/bozonlogo2.png">
	<link rel="stylesheet" type="text/css" href="style.css">
		
</head>
<body class="index">
<header>
	<div class="overlay">
		<p class="logo"></p>
		<div style="clear:both"></div>
	</div>
</header>
<?php
	if ($tree){draw_tree($tree);}else{
?>
<div class="logo">BoZoN: <?php e('Drag, drop, share.');?> - www.warriordudimanche.net</div>
<?php } ?>

	<footer>
		Bozon v1.4 - <a href="http://warriordudimanche.net">WDD</a>
	</footer>
</body>