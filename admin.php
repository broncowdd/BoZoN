<?php 
	/**
	* BoZoN admin page:
	* allows upload / delete / filter files
	* @author: Bronco (bronco@warriordudimanche.net)
	**/

	include ('auto_restrict.php'); # Admin only!
	include('core.php');
	$message='';

	# search/filter
	if (!empty($_GET['filter'])){$mask=$_GET['filter'];}else{$mask='';}
	

	# get file from url
	if (!empty($_GET['url'])&&$_GET['url']!=''){
		if (remote_file_exists($_GET['url'])){
			$filename=UPLOAD_PATH.pathinfo($_GET['url'],PATHINFO_FILENAME);
			$extension=pathinfo($_GET['url'],PATHINFO_EXTENSION);
			if(is_file($filename.'.'.$extension)){
				$filename=$filename.'_'.uniqid();
			}
			$content=file_curl_contents($_GET['url']);
			file_put_contents($filename.'.'.$extension,$content);

			if (!empty($mask)){$mask='?filter='.$mask;}
			header('location:admin.php'.$mask);
		}else{$message.='<div class="error">'.e('Problem accessing remote file.',false).'</div>';}
	}
	# delete file
	if (!empty($_GET['del'])&&$_GET['del']!=''){
		$f=id2file($_GET['del']);
		if(is_file($f)){
			unlink($f); 
			unset($ids[$_GET['del']]);
			store(ID_FILE,$ids);
			kill_thumb_if_exists($f);
		}
		if (!empty($mask)){$mask='?filter='.$mask;}
		header('location:admin.php'.$mask);
	}
	# rename file
	if (!empty($_GET['ren'])&&!empty($_GET['newname'])){
		$oldfile=id2file($_GET['ren']);
		$extension=pathinfo($oldfile,PATHINFO_EXTENSION);
		$_GET['newname']=only_alphanum_and_dot($_GET['newname']);
		$newfile=$_GET['newname'].'.'.$extension;
		if(is_file($oldfile) && $newfile!=basename($oldfile)){				
			# if newname exists, change newname
			if(is_file(UPLOAD_PATH.$newfile)){
				$newfile=$_GET['newname'].'_'.uniqid().'.'.$extension;
			}
			rename($oldfile,UPLOAD_PATH.$newfile); 
			$ids[$_GET['ren']]=$newfile;
			store(ID_FILE,$ids);
			kill_thumb_if_exists($oldfile);
			kill_thumb_if_exists($newfile);
		}
		if (!empty($mask)){$mask='?filter='.$mask;}
		header('location:admin.php'.$mask);
	}

	if ($_FILES){include('auto_dropzone.php');exit();}

?>
<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" charset="UTF-8">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta charset="utf-8" />
		<link rel="shortcut icon" type="/image/png" href="img/bozonlogo2.png">
		<link rel="stylesheet" type="text/css" href="style.css">
		<!--[if IE]><script> document.createElement("article");document.createElement("aside");document.createElement("section");document.createElement("footer");</script> <![endif]-->

		<title>BoZoN: <?php e('Drag, drop, share.');?></title>
	</head>

	<body>
	<header><div class="overlay">
		<div class="lang">
			<?php  
				foreach ($lang as $l=>$content){
					echo '<a href="admin.php?lang='.$l.'">'.$l.'</a>';
				}
			?>
		</div>
		<p class="logo"><strong>BoZoN</strong>: <?php e('Drag, drop, share.');?></p>
		<div class="headerforms">
		<form action="#" method="get" class="searchform">
			<label><?php e('Type to filter the list');?></label>
			<input type="text" name="filter" value="<?php echo $mask; ?>" title="<?php e('Search in the uploaded files'); ?>" placeholder="<?php e('Filter'); ?>"/>
			<input type="submit" value="ok"/>
			<input type="hidden" value="<?php echo LANGUAGE;?>" name="lang"/>
			<?php newToken();?>
		</form>
		<br/>
		<form action="#" method="get">
			<label><?php e('Paste a file\'s URL to get it on this server');?></label>
			<input type="text" name="url" placeholder="http://www.url.com/file.jpg" width="50"/>
			<?php newToken();?>
			<input type="submit" value="ok"/>
		</form>
		</div>
		<div style="clear:both"></div>
		</div>
	</header>
	<?php echo $message;?>
	<table>
		<tr>
			
			<?php include('auto_dropzone.php');?>

			<td>
				<ul class="list" id="liste">

					<h1><?php echo $mask;?></h1>
					<?php include('listfiles.php');?>
				</ul>
			</td>
		</tr>
	</table>
	<footer>
		<div class="w1000">
			<div class="w33"><img src="img/bozondd.png"/><p>1 <?php e('Drag the file you want to share to upload it on the server');?></p></div>
			<div class="w33"><img src="img/bozoncc.png"/><p>2 <?php e('Copy the file\'s link (right click on it)');?></p></div>
			<div class="w33"><img src="img/bozonsh.png"/><p>3 <?php e('Share the link with your buddies...');?></p></div>
		</div>
		<div style="clear:both"></div>
		<div class="credits">Bozon v1.3 - <?php e('tiny file sharing app, coded with love and php by ');?> <a href="http://warriordudimanche.net">Bronco</a> - <a href="admin.php?deconnexion"><?php e('Logout'); ?></a></div>
	</footer>


	</body>
</html>