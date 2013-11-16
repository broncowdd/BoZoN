<?php 
	include ('auto_restrict.php');
	$INCLUDE_JS=false;
	include('core.php');
	if (isset($_GET['del'])&&$_GET['del']!=''){
		$f=UPLOAD_PATH.id2file($_GET['del']);
		if(is_file($f)){unlink($f); header('location: admin.php');}
	}

?>
<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" charset="UTF-8">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta charset="utf-8" />
		<link rel="shortcut icon" type="/image/png" href="img/logoorange64.png">
		<link rel="stylesheet" type="text/css" href="style.css">
		<!--[if IE]><script> document.createElement("article");document.createElement("aside");document.createElement("section");document.createElement("footer");</script> <![endif]-->

		<title>Bozon - Drag, drop & share.</title>
	</head>

	<body>
	<header>
		<p></p>
		<?php include('upload.php');?>
	</header>


<?php include('listfiles.php');?>

	<footer>
		Bozon - mini app de partage de fichier, codée avec amour et php par <a href="http://warriordudimanche.net">Bronco</a> - <a href="admin.php?deconnexion">Deconnexion</a>
	</footer>

<?php if ($INCLUDE_JS){ ?>
	<script src="dropzone.js"></script>
	<script>
		Dropzone.options.myAwesomeDropzone = false;
		var myDropzone = new Dropzone("#Dropzone");
		myDropzone.on("success", function(file) {reload();});

		function reload(){
			file="listfiles.php";target=document.getElementById('liste');
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function(){if (xmlhttp.readyState==4 && xmlhttp.status==200){target.innerHTML=xmlhttp.responseText;}}
			xmlhttp.open("GET",file,false);
			xmlhttp.send();
			
		}

	</script>
<?php } ?>

	</body>
</html>