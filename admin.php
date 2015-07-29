<?php 
	/**
	* BoZoN admin page:
	* allows upload / delete / filter files
	* @author: Bronco (bronco@warriordudimanche.net)
	**/

	include ('auto_restrict.php'); # Admin only!
	include('core.php');
	$message='';



	######################################################################
	# $_GET DATA
	######################################################################

	# subfolder path
	if (!empty($_GET['path']) && trim($_GET['path'])!==false){
		$_SESSION['current_path']=str_replace('//','/',$_GET['path']);
		header('location:admin.php');
	}

	# purge ids via get var
	if (!empty($_GET['purge']) && trim($_GET['purge']!==false)){
		purgeIDs();
	}
	# search/filter
	if (!empty($_GET['filter'])){
		$_SESSION['filter']=$_GET['filter'];
	}else{
		$_SESSION['filter']='';
	}

	# file mode
	if (!empty($_GET['mode'])){
		$_SESSION['mode']=$_GET['mode'];
	}elseif (empty($_SESSION['mode'])){
		$_SESSION['mode']='view';
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
			$basename=basename($_GET['url']);
			$filename=addslash_if_needed($_SESSION['current_path']).$basename;			
			if(is_file($filename)){
				$newfilename=uniqid().'_'.$basename;
				$filename=addslash_if_needed($_SESSION['current_path']).$newfilename;
			}		
			file_put_contents($filename,$content);
			addID($filename);
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
			if(is_file($newfile) || is_dir($newfile)){
				$newfile=$path.rename_item(basename($newfile));
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

		header('location:admin.php');
	}

	######################################################################
	# $_POST DATA
	######################################################################
	# Move file folder
	if (!empty($_POST['file'])&&!empty($_POST['destination'])){
		if (is_file($_POST['file']) || is_dir($_POST['file'])){
			$file=stripslashes($_POST['file']);
			$destination = addslash_if_needed($_POST['destination']).basename($file);
			# if file/folder exists in destination folder, change name
			if(is_file($destination) || is_dir($destination)){
				$destination=addslash_if_needed($_POST['destination']).rename_item(basename($file));
			} 
			# move file
			rename($file,$destination);
			# change path in id
			$id=file2id($file);
			$ids=unstore($_SESSION['id_file']);
			$ids[$id]=$destination;
			store($_SESSION['id_file'],$ids);
			header('location:admin.php');
		}
	}


	if ($_FILES){include('auto_dropzone.php');exit();}

?>
<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" charset="UTF-8">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
	    <meta name="google" content="noimageindex">
		<meta charset="utf-8" />
		<link rel="shortcut icon" type="/image/png" href="img/bozonlogo2.png">
		<link rel="stylesheet" type="text/css" href="style.css">
		<!--[if IE]><script> document.createElement("article");document.createElement("aside");document.createElement("section");document.createElement("footer");</script> <![endif]-->

		<title>BoZoN: <?php e('Drag, drop, share.');?></title>
	</head>

	<body id="body" class="admin <?php echo $_SESSION['mode'];?>" >

	<header><div class="overlay">
		
		<p class="logo"><strong>BoZoN</strong>: <?php e('Drag, drop, share.');?></p>

	<nav id="menu">
		<div id="menu_icon" >&nbsp;</div>
		<div style="clear:both"></div>
		<div class="lang">
			<?php  
				foreach ($lang as $l=>$content){
					if ($_SESSION['language']==$l){$class=' class="active" ';}else{$class='';}
					echo '<a '.$class.' href="admin.php?lang='.$l.'&token='.returnToken().'">'.$l.'</a>';
				}
			?>
		</div>
		<div class="menucontent">
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
			<div class="buttongroup">
				<a class="button" href="?mode=view&token=<?php newToken(true);?>"> <?php e('Manage files'); ?> <img src="img/file.png"/></a>
				<!--<a class="button" href="?mode=links&token=<?php newToken(true);?>"> <?php e('Manage links'); ?> <img src="img/link.png"/></a>-->
				<a class="button" href="?mode=move&token=<?php newToken(true);?>">  <?php e('Move files'); ?>  <img src="img/movefiles.png"/></a>
				<hr/>
				<br/>
				<a class="button red" href="admin.php?deconnexion"><?php e('Logout'); ?> <img src="img/logout.png"/></a>
			</div>
		</div>

		
		
	</nav>

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
		<?php if (!isset($_SESSION['mode']) || $_SESSION['mode']=='view'){ ?>
			<div class="w33"><img src="img/bozondd.png"/><p>1 <?php e('Drag the file you want to share to upload it on the server');?></p></div>
			<div class="w33"><img src="img/bozoncc.png"/><p>2 <?php e('Copy the file\'s link (right click on it)');?></p></div>
			<div class="w33"><img src="img/bozonsh.png"/><p>3 <?php e('Share the link with your buddies...');?></p></div>
		<?php }else if ($_SESSION['mode']=='move'){ ?>
			<div class="w50"><p><img src="img/unknown.png"/><?php e('Move a file by clicking on it and choosing the destination folder in the list');?></p></div>
			<div class="w50"><p><img src="img/folder.png"/><?php e('Move a folder by clicking on the move icon and choosing the destination folder in the list');?></p></div>

		<?php }else if ($_SESSION['mode']=='links'){ ?>


		<?php } ?>
		</div>
		<div style="clear:both"></div>
		<div class="credits">Bozon v<?php echo VERSION;?> - <?php e('tiny file sharing app, coded with love and php by ');?> <a href="http://warriordudimanche.net">Bronco</a> - <a href="admin.php?deconnexion"><?php e('Logout'); ?></a></div>
		<a href="https://github.com/broncowdd/BoZoN" class="github" title="<?php e('fork me on github');?>">&nbsp;</a>
	</footer>

<script>
	menu=document.getElementById('menu');
	menu_icon=document.getElementById('menu_icon');
	body=document.getElementById('body');
	cl='open';

	// block closing menu by clicking on it
	menu.addEventListener('click', function(event){
        if(event.preventDefault) { event.preventDefault(); }
        if(event.stopPropagation) { event.stopPropagation(); }
		return false;
	});

	// menu appears and vanish
	menu_icon.addEventListener('click', function(event){
		if (menu.classList) {
		    menu.classList.toggle(cl)
		} else {
		    var classes = menu.className.split(' ')
		    var existingIndex = classes.indexOf(cl)
		    if (existingIndex >= 0)
		      classes.splice(existingIndex, 1)
		    else
		      classes.push(cl);
		    menu.className = classes.join(' ')
		}
        if(event.preventDefault) { event.preventDefault(); }
        if(event.stopPropagation) { event.stopPropagation(); }
		return false;
	});
	// close menu on clicking outside
	body.addEventListener('click', function(event){
		if (menu.classList) {
		   menu.classList.remove(cl);
		} else {
		   var classes = el.className.split(' ')
		    var existingIndex = classes.indexOf(cl)
		    if (existingIndex >= 0){ classes.splice(existingIndex, 1);}		    
		    el.className = classes.join(' ')
		}
        
		return false;
	});

	/*function remove_class(){
		if (menu.classList) {
		    if (menu.classList.contains(cl){menu.classList.remove(cl);}
		}/* else {
		    var classes = el.className.split(' ')
		    var existingIndex = classes.indexOf(cl)
		    if (existingIndex >= 0){ classes.splice(existingIndex, 1);}		    
		    el.className = classes.join(' ')
		}
		return false;
	}
	function toggle_class(){		
			if (menu.classList) {
			    menu.classList.toggle(cl)
			} else {
			    var classes = menu.className.split(' ')
			    var existingIndex = classes.indexOf(cl)
			    if (existingIndex >= 0)
			      classes.splice(existingIndex, 1)
			    else
			      classes.push(cl);
			    menu.className = classes.join(' ')
			}
            if(event.preventDefault) { event.preventDefault(); }
            if(event.stopPropagation) { event.stopPropagation(); }
			return false;
		}*/
</script>
	</body>
</html>