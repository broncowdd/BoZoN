<?php
	/**
	* BoZoN admin page:
	* allows upload / delete / filter files
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	$message='';
	include ('core/auto_restrict.php'); # Admin only!
	include('core/core.php');




	######################################################################
	# $_GET DATA
	######################################################################

	# unzip: convert zip file to folder
	if (!empty($_GET['unzip']) && trim($_GET['unzip'])!==false){
		$id=$_GET['unzip'];
		$path=id2file($id);
		unzip($_SESSION['upload_path'].$path,$_SESSION['upload_path'].dirname($path));
		header('location:admin.php');
		exit;
	}	

	# renew file id
	if (!empty($_GET['renew']) && trim($_GET['renew'])!==false){
		$old_id=$_GET['renew'];
		$path=id2file($old_id);
		unset($ids[$old_id]);
		addID($path);
		header('location:admin.php');
		exit;
	}	

	# create burn after acces state
	if (!empty($_GET['burn']) && trim($_GET['burn'])!==false){
		$id_to_burn=$_GET['burn'];
		$path=id2file($id_to_burn);

		unset($ids[$id_to_burn]);

		if (substr($id_to_burn,0,1)!='*'){
			$ids['*'.$id_to_burn]=$path;
		}else{
			$ids[str_replace('*','',$id_to_burn)]=$path;
		}
		
		store($ids);
		header('location:admin.php');
		exit;
	}	


	# subfolder path
	if (!empty($_GET['path']) && trim($_GET['path'])!==false){
		$path=$_GET['path'];
		if($path=='/'){
			$path='';
		}
		if(check_path($path)){
			$_SESSION['current_path']=$path;
		}
		header('location:admin.php');
		exit;
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
		if(check_path($folder)){
			foreach (array($_SESSION['upload_path'], 'thumbs/') as $root_folder) {
				$complete=$root_folder.addslash_if_needed($_SESSION['current_path']).$folder;
				if (is_dir($complete)){
					# Folder already exists, rename
					$folder=rename_item($folder);
					$complete=$root_folder.$_SESSION['current_path'].'/'.$folder;
				}
				mkdir($complete, 0755, true);
			}
			addID($_SESSION['current_path'].'/'.$folder);
		}
		header('location:admin.php');
		exit;
	}
	
	# get file from url
	if (!empty($_GET['url'])&&$_GET['url']!=''){
		if ($content=file_curl_contents($_GET['url'])){
			$basename=basename($_GET['url']);
			$filename=addslash_if_needed($_SESSION['current_path']).$basename;			
			if(is_file($_SESSION['upload_path'].$filename)){
				$newfilename=uniqid().'_'.$basename;
				$filename=addslash_if_needed($_SESSION['current_path']).$newfilename;
			}		
			file_put_contents($_SESSION['upload_path'].$filename,$content);
			addID($filename);
			header('location:admin.php');
			exit;
		}else{$message.='<div class="error">'.e('Problem accessing remote file.',false).'</div>';}
	}

	# delete file/folder
	if (!empty($_GET['del'])&&$_GET['del']!=''){
		$f=id2file($_GET['del']);
		if(is_file($_SESSION['upload_path'].$f)){
			# delete file
			unlink($_SESSION['upload_path'].$f);
			$thumbfilename=get_thumbs_name($f);
			if (is_file($thumbfilename)){unlink($thumbfilename);}
			unset($ids[$_GET['del']]);
			store();
		}else if (is_dir($_SESSION['upload_path'].$f)){
			# delete dir
			rrmdir($_SESSION['upload_path'].$f);
			rrmdir('thumbs/'.$f);
			# remove all vanished sub files & folders from id file
			purgeIDs();
		}
		
		header('location:admin.php');
		exit;
	}

	# rename file/folder
	if (!empty($_GET['id'])&&!empty($_GET['newname'])){
		$oldfile=id2file($_GET['id']);
		if ($_SESSION['current_path']!=''){$path=addslash_if_needed($_SESSION['current_path']);}
		else{$path='';}
		$newfile=$path.only_alphanum_and_dot($_GET['newname']);
		
		if ($newfile!=basename($oldfile) && check_path($newfile)){		
			# if newname exists, change newname
			if(is_file($_SESSION['upload_path'].$newfile) || is_dir($_SESSION['upload_path'].$newfile)){
				$newfile=$path.rename_item(basename($newfile));
			}
			
			if (is_dir($_SESSION['upload_path'].$oldfile)){
				# for folders, must change the path in all sub items
				foreach($ids as $id=>$path){
					$ids[$id]=str_replace($oldfile, $newfile, $path);
				}
				
			}

			rename($_SESSION['upload_path'].$oldfile,$_SESSION['upload_path'].$newfile); 
			rename(get_thumbs_name($oldfile),get_thumbs_name($newfile));
			$ids[$_GET['id']]=$newfile;
			store();
		}

		header('location:admin.php');
		exit;
	}

	# zip and download a folder
	if (!empty($_GET['zipfolder'])){
		$folder=id2file($_GET['zipfolder']);
		if (!is_dir('private/temp')){mkdir('private/temp');}
		$zipfile='private/temp/'.basename($folder).'.zip';
		

		zip($_SESSION['upload_path'].$folder,$zipfile);
		header('location: '.$zipfile);
		exit;
	}

	######################################################################
	# $_POST DATA
	######################################################################
	# Move file folder
	if (!empty($_POST['file'])&&!empty($_POST['destination'])){
		$file=$_POST['file'];
		if($file=='/'){	$file=''; }
		$destination=$_POST['destination'];
		if($destination=='/'){	$destination=''; }
		if (check_path($file) && check_path($destination)){
			if (is_file($_SESSION['upload_path'].$file) || is_dir($_SESSION['upload_path'].$file)){
				$file=stripslashes($file);
				$destination = addslash_if_needed($destination).basename($file);
				# if file/folder exists in destination folder, change name
				if(is_file($_SESSION['upload_path'].$destination) || is_dir($_SESSION['upload_path'].$destination)){
					$destination=addslash_if_needed($destination).rename_item(basename($file));
				} 
				# move file
				rename($_SESSION['upload_path'].$file,$_SESSION['upload_path'].$destination);
				if (!is_dir(dirname('thumbs/'.$destination))){
					mkdir(dirname('thumbs/'.$destination),0744, true);
				}
				rename(get_thumbs_name($file),get_thumbs_name($destination));
				# change path in id
				$id=file2id($file);
				$ids=unstore();
				$ids[$id]=$destination;
				store();
			}
		}
		header('location:admin.php');
		exit;
	}

	# Lock folder with password
	if (!empty($_POST['password'])&&!empty($_POST['id'])){
		$id=$_POST['id'];
		$file=id2file($id);
		$password=blur_password($_POST['password']);
		# turn normal share id into password hashed id
		$ids=unstore();
		unset($ids[$id]);
		$ids[$password.$id]=$file;
		store();
		header('location:admin.php');
		exit;
	}



	if ($_FILES){include('core/auto_dropzone.php');exit();}

  include('themes/'.$default_theme.'/admin.php');
?>
