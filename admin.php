<?php 
	/**
	* BoZoN admin page:
	* allows upload / delete / filter files
	* @author: Bronco (bronco@warriordudimanche.net)
	**/

	include ('auto_restrict.php'); # Admin only!
	include('core.php');
	$message='';

	# subfolder path
	if (!empty($_GET['path']) && !empty(trim($_GET['path']))){
		$_SESSION['current_path']=str_replace('//','/',$_GET['path']);
		header('location:admin.php');
	}

	# purge ids via get var
	if (!empty($_GET['purge']) && !empty(trim($_GET['purge']))){
		purgeIDs();
	}
	# search/filter
	if (!empty($_GET['filter'])){
		$_SESSION['filter']=$_GET['filter'];
	}else{
		$_SESSION['filter']='';
	}

	# create a new subfolder
	if (!empty($_GET['newfolder'])){
		$folder=$_GET['newfolder'];
		$complete=addslash_if_needed($_SESSION['current_path']).$folder;
		if (is_dir($complete)){
			# Folder already exists, rename
			$folder=rename_item($folder);
			$complete=$_SESSION['current_path'].'/'.$folder;
		}
		mkdir($complete);
		chmod($complete, 0755);
		addID($_SESSION['current_path'].'/'.$folder);

		header('location:admin.php');
	}
	
	# get file from url
	if (!empty($_GET['url'])&&$_GET['url']!=''){
		if ($content=file_curl_contents($_GET['url'])){
			$filename=addslash_if_needed($_SESSION['current_path']).basename($_GET['url']);			
			if(is_file($filename)){
				$filename=uniqid().'_'.$filename;
			}		
			file_put_contents($filename,$content);
			
			header('location:admin.php');
		}else{$message.='<div class="error">'.e('Problem accessing remote file.',false).'</div>';}
	}

	# delete file/folder
	if (!empty($_GET['del'])&&$_GET['del']!=''){
		$f=id2file($_GET['del']);
		if(is_file($f)){
			# delete file
			unlink($f); 
			unset($ids[$_GET['del']]);
			store($_SESSION['id_file'],$ids);
			kill_thumb_if_exists($f);
		}else if (is_dir($f)){
			# delete dir
			rrmdir($f);
			# remove all vanished sub files & folders from id file
			purgeIDs();
		}
		
		header('location:admin.php');
	}

	# rename file/folder
	if (!empty($_GET['ren'])&&!empty($_GET['newname'])){
		$oldfile=id2file($_GET['ren']);
		$path=addslash_if_needed($_SESSION['current_path']);
		$newfile=$path.only_alphanum_and_dot($_GET['newname']);		

		if ($newfile!=basename($oldfile)){		
			# if newname exists, change newname
			if(is_file($_SESSION['current_path'].$newfile)){
				$newfile=$path.pathinfo($newfile,PATHINFO_FILENAME).'_'.uniqid().'.'.pathinfo($newfile,PATHINFO_EXTENSION);
			}
			if (is_dir($oldfile)){
				# for folders, must change the path in all sub items
				foreach($ids as $id=>$path){
					$ids[$id]=str_replace($oldfile, $newfile, $path);
				}
				
			}

			rename($oldfile,$newfile); 
			$ids[$_GET['ren']]=$newfile;
			store($_SESSION['id_file'],$ids);
			kill_thumb_if_exists($oldfile);
			kill_thumb_if_exists($newfile);
		}

		//header('location:admin.php');
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

	<body class="admin">
	<header><div class="overlay">
		<div class="lang">
			<?php  
				
				foreach ($lang as $l=>$content){
					echo '<a href="admin.php?lang='.$l.'&token='.returnToken().'">'.$l.'</a>';
				}
			?>
		</div>
		<p class="logo"><strong>BoZoN</strong>: <?php e('Drag, drop, share.');?></p>
<hr/>
		<div class="headerforms">
			<form action="#" method="get" class="searchform">
				<label><?php e('Type to filter the list');?></label>
				<input type="text" name="filter" value="<?php echo $_SESSION['filter']; ?>" title="<?php e('Search in the uploaded files'); ?>" placeholder="<?php e('Filter'); ?>"/>
				<input type="submit" value="ok"/>
				<?php newToken();?>
			</form>
			<form action="#" method="get">
				<label><?php e('Paste a file\'s URL');?></label>
				<input type="text" name="url" title="<?php e('Paste a file\'s URL to get it on this server');?>" placeholder="http://www.url.com/file.jpg" width="50"/>
				<?php newToken();?>
				<input type="submit" value="ok"/>
			</form>
			<form action="#" method="get" class="searchform">
				<label><?php e('Create a subfolder');?></label>
				<input type="text" name="newfolder" value="" title="<?php e('CReate a subfolder in this folder'); ?>" placeholder="<?php e('New_folder'); ?>"/>
				<input type="submit" value="ok"/>
				<?php newToken();?>
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
				<div class="fil_ariane">
					<a class="home" href="admin.php?path=<?php echo $_SESSION['upload_path'].'&token='.returnToken(true);?>">&nbsp;</a>
					<?php 
						$ariane=explode('/',$_SESSION['current_path']);

						$chemin='';
						unset($ariane[0]);
						foreach($ariane as $nb=>$folder){
							if (!empty($folder)){
								$chemin.=$folder;
								echo '<a class="ariane_item" href="admin.php?path='.$_SESSION['upload_path'].$chemin.'&token='.returnToken(true).'">'.$folder.'</a>';
								$chemin.='/';
							}
						}
					?>
				</div>
				<ul class="list" id="liste">

					<h1><?php echo $_SESSION['filter'];?></h1>
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
		<div class="credits">Bozon v1.4 - <?php e('tiny file sharing app, coded with love and php by ');?> <a href="http://warriordudimanche.net">Bronco</a> - <a href="admin.php?deconnexion"><?php e('Logout'); ?></a></div>
	</footer>


	</body>
</html>