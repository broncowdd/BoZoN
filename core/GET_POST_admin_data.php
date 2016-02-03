<?php
	/**
	* BoZoN GET/POST page:
	* handles the GET & POST data
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
 	
 	# avoid user control: only admin
	if (!function_exists('newToken')||!is_admin_connected()){exit;}	

	######################################################################
	# $_GET DATA
	######################################################################
	
	# unzip: convert zip file to folder
	if (!empty($_GET['unzip']) && trim($_GET['unzip'])!==false){
		$id=$_GET['unzip'];
		$path=id2file($id);
		unzip($path,dirname($path));
		header('location:index.php?p=admin&token='.returnToken());
		exit;
	}	

	# renew file id
	if (!empty($_GET['renew']) && trim($_GET['renew'])!==false&&is_owner($_GET['renew'])){
		$old_id=$_GET['renew'];
		$path=id2file($old_id);
		unset($ids[$old_id]);
		addID($path,$ids);
		header('location:index.php?p=admin&token='.returnToken());
		exit;
	}	

	# create burn after acces state
	if (!empty($_GET['burn']) && trim($_GET['burn'])!==false&&is_owner($_GET['burn'])){
		$id_to_burn=$_GET['burn'];
		$path=id2file($id_to_burn);
		unset($ids[$id_to_burn]);
		if ($id_to_burn[0]!='*'){
			$ids['*'.$id_to_burn]=$path;
		}else{
			$ids[str_replace('*','',$id_to_burn)]=$path;
		}
		store($ids);
		header('location:index.php?p=admin&token='.returnToken());
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
		header('location:index.php?p=admin&token='.returnToken());
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
			foreach (array($_SESSION['upload_root_path'].$_SESSION['upload_user_path'], 'thumbs/'.$_SESSION['upload_user_path']) as $root_folder) {
				$complete=$root_folder.addslash_if_needed($_SESSION['current_path']).$folder;
				if (is_dir($complete)){
					# Folder already exists, rename
					$folder=rename_item($folder);
					$complete=$root_folder.$_SESSION['current_path'].'/'.$folder;
				}
				mkdir($complete, 0744, true);
			}
			addID($_SESSION['current_path'].'/'.$folder);
			header('location:index.php?p=admin&token='.returnToken());
			exit;
		}
		
	}
	
	# get file from url
	if (!empty($_GET['url'])&&$_GET['url']!=''){
		if ($content=file_curl_contents($_GET['url'])){
			$basename=basename($_GET['url']);
			$filename=$_SESSION['upload_root_path'].$_SESSION['upload_user_path'].$_SESSION['current_path'].'/'.$basename;			
			if(is_file($filename)){
				$newfilename=uniqid().'_'.$basename;
				$filename=$_SESSION['upload_root_path'].$_SESSION['upload_user_path'].$_SESSION['current_path'].'/'.$newfilename;
			}		
			file_put_contents($filename,$content);
			addID($filename);
			header('location:index.php?p=admin&token='.returnToken());
			exit;
		}else{$message.='<div class="error">'.e('Problem accessing remote file.',false).'</div>';}
	}

	# delete file/folder
	if (!empty($_GET['del'])&&$_GET['del']!=''){
		$f=id2file($_GET['del']);
		if(is_file($f)){
			# delete file
			unlink($f);
			$thumbfilename=get_thumbs_name($f);
			if (is_file($thumbfilename)){unlink($thumbfilename);}
			unset($ids[$_GET['del']]);
			store($ids);
		}else if (is_dir($f)){
			# delete dir
			rrmdir($f);
			rrmdir('thumbs/'.$f);
			# remove all vanished sub files & folders from id file
			purgeIDs();
		}
		
		header('location:index.php?p=admin&token='.returnToken());
		exit;
	}

	# rename file/folder
	if (!empty($_GET['id'])&&!empty($_GET['newname'])&&is_owner($_GET['id'])){
		$oldfile=id2file($_GET['id']);
		$path=dirname($oldfile).'/';
		$newfile=$path.only_alphanum_and_dot($_GET['newname']);
		
		if ($newfile!=basename($oldfile) && check_path($newfile)){		
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
			rename(get_thumbs_name($oldfile),get_thumbs_name($newfile));
			$ids[$_GET['id']]=$newfile;
			store($ids);
		}

		header('location:index.php?p=admin&token='.returnToken());
		exit;
	}

	# zip and download a folder
	if (!empty($_GET['zipfolder'])){
		$folder=id2file($_GET['zipfolder']);
		if (!is_dir('private/temp')){mkdir('private/temp');}
		$zipfile='private/temp/'.basename($folder).'.zip';
		zip($folder,$zipfile);
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
			if (is_file($_SESSION['upload_root_path'].$_SESSION['upload_user_path'].$file) || is_dir($_SESSION['upload_root_path'].$_SESSION['upload_user_path'].$file)){
				$file=stripslashes($file);
				$destination = addslash_if_needed($destination).basename($file);
				# if file/folder exists in destination folder, change name
				if(is_file($_SESSION['upload_root_path'].$_SESSION['upload_user_path'].$destination) || is_dir($_SESSION['upload_root_path'].$_SESSION['upload_user_path'].$destination)){
					$destination=addslash_if_needed($destination).rename_item(basename($file));
				} 
				# move file
				rename($_SESSION['upload_root_path'].$_SESSION['upload_user_path'].$file,$_SESSION['upload_root_path'].$_SESSION['upload_user_path'].$destination);
				if (!is_dir(dirname('thumbs/'.$destination))){
					mkdir(dirname('thumbs/'.$destination),0744, true);
				}
				rename(get_thumbs_name($file),get_thumbs_name($destination));
				# change path in id
				$id=file2id($file);
				$ids=unstore();
				$ids[$id]=$destination;
				store($ids);
			}
		}
		header('location:index.php?p=admin&token='.returnToken());
		exit;
	}

	# Lock folder with password
	if (!empty($_POST['password'])&&!empty($_POST['id'])&&is_owner($_POST['id'])){
		$id=$_POST['id'];
		$file=id2file($id);
		$password=blur_password($_POST['password']);
		# turn normal share id into password hashed id
		$ids=unstore();
		unset($ids[$id]);
		$ids[$password.$id]=$file;
		store($ids);

		header('location:index.php?p=admin&token='.returnToken());
		exit;
	}

	# Handle folder share with users
	if (!empty($_GET['users'])&&!empty($_GET['share'])&&is_owner($_GET['share'])){
		$folder_id=$_GET['share'];
		$users=$auto_restrict['users'];
		unset($users[$_SESSION['login']]);
		$shared_with=load_folder_share();
		$sent=array_flip($_GET['users']);
		foreach ($users as $login=>$data){
			if (isset($sent[$login])){
				# User checked: add share
				$shared_with[$login][$folder_id]=array('folder'=>id2file($folder_id),'from'=>$_SESSION['login']);
			}else{
				# User not checked: remove share if exists
				if (isset($shared_with[$login][$folder_id])){unset($shared_with[$login][$folder_id]);}
			}
		}
		save_folder_share($shared_with);
		header('location:index.php?p=admin&token='.returnToken());
		exit;
	}


	if ($_FILES){include('core/auto_dropzone.php');exit();}



?>