<?php
	/**
	* BoZoN GET/POST page:
	* handles the GET & POST data
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
 	
 	# avoid user control: only admin
	if (!function_exists('newToken')||!is_user_connected()){exit;}	

	######################################################################
	# $_GET DATA
	######################################################################

	# import from another instance of bozon
	if (!empty($_GET['import'])&!empty($_GET['p'])&&$_GET['p']=='admin'&&is_allowed('import')){
		$url=$_GET['import'];
		if (strpos($url,'&export')===false){$url.='&export';}
		$files=json_decode(file_curl_contents($url),true);
		if (!$files){
			safe_redirect('index.php?p=admin&token='.TOKEN.'&msg='.e('Problem importing data',false));exit;
		}
		if (is_array($files)){
			foreach ($files as $id=>$data){
				$local_path=array_filter(explode('/',$data['path']));
				unset($local_path[0],$local_path[1]);
				$local_path=$_SESSION['upload_root_path'].$_SESSION['upload_user_path'].$_SESSION['current_path'].implode('/',$local_path);

				if ($data['type']=='file'){
					$content=file_curl_contents($data['url'].'&view');
					if ($content){
						file_put_contents($local_path, $content);
					}
				}elseif ($data['type']=='folder'){
					@mkdir($local_path);
				}
				$tree=add_branch($local_path,addID($local_path));
			}
		}
		safe_redirect('index.php?p=admin&token='.TOKEN.'&msg='.e('Data imported',false));
		exit;
		
	}


	# edit file (for editor page)
	if (!empty($_GET['file'])&!empty($_GET['p'])&&$_GET['p']=='editor'&&is_allowed('markdown editor')){
		$file=id2file($_GET['file']);
		if (!empty($file)&&is_file($file)){
			$editor_content=file_get_contents($file);}else{$editor_content='';$file='';
			if (!is_writable($file)){$msg='<div class="error">'.$file.' '.e('is not writable',false).'</div>';}
		}
	}

	# regen ids base
	if (isset($_GET['regen'])){
		$ids=updateIDs($ids,$_GET['regen']);		
		header('location:index.php?p=admin&token='.TOKEN);
		exit;
	}

	# unzip: convert zip file to folder
	if (!empty($_GET['unzip']) && trim($_GET['unzip'])!==false && $_SESSION['zip']){
		$id=$_GET['unzip'];
		$zipfile=id2file($id);
		$folder=str_ireplace('.zip','',_basename($zipfile));		
		$id=new_folder($folder);
		$destination=id2file($id);
		unzip($zipfile,$destination);	
		$sdi=array_flip($ids);
		$unzipped_content=recursive_glob($destination);
		foreach ($unzipped_content as $item){
			if (empty($sdi[$item])){$ids[uniqid(true)]=$item;}
		}
		store($ids);
		//$ids=updateIDs($ids,$id);
		header('location:index.php?p=admin&token='.TOKEN);
		exit;
	}	

	# renew file id
	if (!empty($_GET['renew']) && trim($_GET['renew'])!==false&&is_owner($_GET['renew'])){
		$old_id=$_GET['renew'];
		$path=id2file($old_id);
		unset($ids[$old_id]);
		$new_id=addID($path,$ids);
		# change in share folder
		
		if (is_dir($path)){
			$shares=load_folder_share();
			$save=false;
			foreach ($shares as $user=>$data){
				if (!empty($data[$old_id])){					
					if (!$remove_item_from_users_share_when_renew_id){
						$shares[$user][$new_id]=$data[$old_id];
					}
					unset($shares[$user][$old_id]);$save=true;
				}
			}
			if ($save){save_folder_share($shares);}
		}
		header('location:index.php?p=admin&token='.TOKEN);
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
		header('location:index.php?p=admin&token='.TOKEN);
		exit;
	}	

	# subfolder path
	if (!empty($_GET['path']) && trim($_GET['path'])!==false){
		$path=$_GET['path'];
		if($path=='/'){
			$path='';
		}
		if(check_path($path)){
			$_SESSION['current_path']=addslash_if_needed($path);
		}
		header('location:index.php?p=admin&token='.TOKEN);
		exit;
	}

	# search/filter
	if (isset($_GET['filter'])){
		$_SESSION['filter']=$_GET['filter'];
	}else{
		$_SESSION['filter']='';
	}

	# file mode
	if (!empty($_GET['mode'])){
		conf('mode',$_GET['mode']);
	}elseif (empty($_SESSION['mode'])){
		conf('mode','view');
	}

	# create a new subfolder
	if (!empty($_GET['newfolder'])&&is_allowed('create folder')){
		$folder=$_GET['newfolder'];
		if(check_path($folder)){
			$tree=add_branch($folder,new_folder($folder)); # $path,$id
			header('location:index.php?p=admin&msg='.$folder.' '.e('created',false).'&token='.TOKEN);
			exit;
		}
		
	}
	
	# get file from url
	if (!empty($_GET['url'])&&$_GET['url']!='' && $_SESSION['curl']){
		if ($content=file_curl_contents($_GET['url'])){
			if (empty($_GET['filename'])){
				$basename=_basename($_GET['url']);
			}else{
				$basename=no_special_char($_GET['filename']);
			}

			$folder_path=addslash_if_needed($_SESSION['upload_root_path'].$_SESSION['upload_user_path'].$_SESSION['current_path']);
			$filename=$folder_path.$basename;			
			if(is_file($filename)){
				$filename=$folder_path.rename_item($filename,$folder_path);
			}
			file_put_contents($filename,$content);
			
			$tree=add_branch($filename,addID($filename));
			header('location:index.php?p=admin&token='.TOKEN);
			exit;
		}else{$message.='<div class="error">'.e('Problem accessing remote file.',false).'</div>';}
	}

	# delete SINGLE file/folder
	if (!empty($_GET['del'])&&$_GET['del']!=''&&is_owner($_GET['del'])&&is_allowed('delete files')){
		$tree=delete_file_or_folder($_GET['del'],$ids,$tree);
		header('location:index.php?p=admin&token='.TOKEN);
		exit;
	}

	# rename file/folder
	if (!empty($_GET['id'])&&!empty($_GET['newname'])&&$_GET['newname']!='.'&&is_owner($_GET['id'])&&is_allowed('rename files')){
		$oldfile=id2file($_GET['id']);
		$path=dirname($oldfile).'/';
		$newfile=$path.no_special_char($_GET['newname']);
		if ($newfile!=$oldfile && check_path($newfile)){		
			# if newname exists, change newname
			if(is_file($newfile) || is_dir($newfile)){
				$newfile=$path.rename_item(_basename($newfile),$path);
			}
			if (is_dir($oldfile)){
				# for folders, must change the path in all sub items
				$old=$oldfile;
				$old.='/';
				foreach($ids as $id=>$path){					
					if (strpos($path,$old)!==false){$ids[$id]=str_replace($old, $newfile.'/', $path);}
				}
				
			};
			$ids[$_GET['id']]=$newfile;
			store($ids);
			rename($oldfile,$newfile); 
			if (is_file(get_thumbs_name($oldfile))){rename(get_thumbs_name($oldfile),get_thumbs_name($newfile));}
			$tree=rename_branch($newfile,$oldfile,$_GET['id'],$_SESSION['login'],$tree);
		}

		header('location:index.php?p=admin&token='.TOKEN);
		exit;
	}

	# zip and download a folder
	if (!empty($_GET['zipfolder']) && $_SESSION['zip']){
		$folder=id2file($_GET['zipfolder']);
		if (!is_dir($_SESSION['temp_folder'])){mkdir($_SESSION['temp_folder']);}
		$zipfile=$_SESSION['temp_folder'].return_owner($_GET['zipfolder']).'-'._basename($folder).'.zip';
		zip($folder,$zipfile);
		header('Content-type: application/zip');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($zipfile));
		# lance le téléchargement des fichiers non affichables
		header('Content-Disposition: attachment; filename="'._basename($zipfile).'"');
		myFread($zipfile);
		exit;
	}


	######################################################################
	# $_POST DATA
	######################################################################
	# Move file folder
	if (!empty($_POST['file'])&&!empty($_POST['destination'])&&is_allowed('move files')){
		# init
		$destination=$to=$_POST['destination'];
		$file=stripslashes($_POST['file']);$me=_basename($file);
		if($destination=='/'){	$destination=''; }
		if($file=='/'){	$file=''; }
		if ($file[0] == '/') { $file = substr($file,1);}
		$file_with_path=$_SESSION['upload_root_path'].$_SESSION['upload_user_path'].$file;
		$destination=$_SESSION['upload_root_path'].$_SESSION['upload_user_path'].$destination;

		if (check_path($file) && check_path($destination)){ 
			if (is_file($file_with_path)){$file=$file_with_path;}
			$file=$file_with_path;
			$file=stripslashes($file);
			$destination_temp = addslash_if_needed($destination)._basename($file);
			# if file/folder exists in destination folder, change name
			if(is_file($destination_temp) || is_dir($destination_temp)){
				$destination_temp=addslash_if_needed($destination).rename_item(_basename($file),$destination);
			}
			$destination=$destination_temp;
			
			if (!is_dir(dirname('thumbs/'.$destination))){
				mkdir(dirname('thumbs/'.$destination),0744, true);
			}
			@rename(get_thumbs_name($file_with_path),get_thumbs_name($destination));

			if (is_file($file_with_path)){				
				# change path in id
				$id=file2id($file_with_path);
				$ids=unstore();
				$ids[$id]=$destination;
				store($ids);
				rename($file_with_path,$destination);
				$tree=rename_branch($destination,$file_with_path,$id,$_SESSION['login'],$tree);
			}elseif(is_dir($file_with_path)){ 
				# change path in id and all files/folders in the moved folder
				$id=file2id($file_with_path);
				$ids=unstore();
				$ids[$id]=$destination;
				$destination=$destination.'/';
				$file=$file.'/';
				foreach($ids as $id=>$path){
					if (strpos($path, $file)!==false){$ids[$id]=str_replace($file,$destination, $path);}
				}
				store($ids);
				rename($file_with_path,$destination);
				$tree=rename_branch($destination,$file_with_path,$id,$_SESSION['login'],$tree);
			}
			
		}

		header('location:index.php?p=admin&msg='.urlencode($me).' '.e('moved to',false).' '.urlencode($to).'&token='.TOKEN);
		exit;
	}

	# Delete multiselection
	if (!empty($_POST['item']) && !empty($_POST['multiselect_command']) && $_POST['multiselect_command']=='delete'&&is_allowed('delete files')){
		foreach ($_POST['item'] as $key => $item) {
			if (is_owner($item)){
				$tree=delete_file_or_folder($item,$ids);
			}
		}
		header('location:index.php?p=admin&token='.TOKEN);
		exit;
	}

	# zip multiselection
	if (!empty($_POST['item']) && !empty($_POST['multiselect_command']) && $_POST['multiselect_command']=='zip' && $_SESSION['zip']){
		$zipfile=$_SESSION['temp_folder'].'Bozon_pack'.date('d-m-Y h-i-s').'.zip';
		$file_list=array();
		foreach ($_POST['item'] as $key => $item) {
			$file_list[]=id2file($item);
		}
		if (!is_dir($_SESSION['temp_folder'])){mkdir($_SESSION['temp_folder']);}
		zip($file_list,$zipfile);
		header('Content-type: application/zip');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($zipfile));
		# lance le téléchargement des fichiers non affichables
		header('Content-Disposition: attachment; filename="'._basename($zipfile).'"');
		readfile($zipfile);
	}

	# Lock folder with password
	if (!empty($_POST['pass'])&&!empty($_POST['id'])&&!empty($_POST['confirm'])&&is_owner($_POST['id'])&&$_POST['confirm']==$_POST['pass']){
		$id=$_POST['id'];
		$file=id2file($id);
		$password=blur_password($_POST['pass']);
		# turn normal share id into password hashed id
		$ids=unstore();
		unset($ids[$id]);
		$ids[$password.$id]=$file;
		store($ids);

		header('location:index.php?p=admin&token='.TOKEN);
		exit;
	}

	# Handle folder share with users
	if (!empty($_POST['share'])&&is_owner($_POST['share'])){
		$folder_id=$_POST['share'];
		$users=$auto_restrict['users'];
		unset($users[$_SESSION['login']]);
		$shared_with=load_folder_share();
		$sent=array_flip($_POST['users']);
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
		header('location:index.php?p=admin&mode=links&token='.TOKEN);
		exit;
	}

	# Handle users rights
	if (isset($_POST['user_right'])&&is_allowed('change status rights')){
		foreach($_POST['user_right'] as $key=>$user_nb){
			$_SESSION['users_rights'][$_POST['user_name'][$key]]=$user_nb;
		}
		save_users_rights($_SESSION['users_rights']);
		header('location:index.php?p=users&token='.TOKEN.'&msg='.e('Changes saved',false));
		exit;
	}

	# Handle superadmin request for users pass change
	if (isset($_POST['user_pass'])&&is_allowed('change passes')){
		foreach($_POST['user_pass'] as $key=>$pass){
			if (!empty($_POST['user_pass'][$key])&&!empty($_POST['user_name'][$key])){
				$auto_restrict['users'][$_POST['user_name'][$key]]['pass'] = hash('sha512', $auto_restrict['users'][$_POST['user_name'][$key]]['salt'].$pass);
			}
		}
		save_users();
		header('location:index.php?p=edit_profiles&token='.TOKEN.'&msg='.e('Changes saved',false));
		exit;
	}

	# Handle profile's rights change
	if (isset($_POST['profile_name'])&&is_allowed('change user status')){
		$rights=array();
		foreach($_POST['profile_name'] as $num=>$profile){
			if (!empty($_POST[$num])){
				foreach($_POST[$num] as $allowed){$rights[$profile][$allowed]=1;}
			}else{$rights[$profile]=array();}
		}
		save($_SESSION['profiles_rights_file'],$rights);
		header('location:index.php?p=edit_profiles&token='.TOKEN.'&msg='.e('Changes saved',false));
		exit;
	}

	# Editor
	if (isset($_POST['editor_content'])&&!empty($_POST['editor_filename'])&&is_allowed('markdown editor')){
		$extension=pathinfo($_POST['editor_filename'],PATHINFO_EXTENSION);
		if (empty($extension)){$_POST['editor_filename'].='.md';}
		$file=no_special_char($_POST['editor_filename']);
		$path=addslash_if_needed($_SESSION['upload_root_path'].$_SESSION['upload_user_path'].$_SESSION['current_path']);
		if (is_file($path.$file)&&!isset($_POST['overwrite'])){$file=rename_item($file,$path);}
		file_put_contents($path.$file, $_POST['editor_content']);
		if (!isset($_POST['overwrite'])){
			$id=addID($path.$file);
			$tree=add_branch($path.$file,$id,$_SESSION['login'],$tree);
		}
		header('location:index.php?p=admin&token='.TOKEN.'&msg='.urlencode($_POST['editor_filename']).' '.e('Changes saved',false));
		exit;
	}

	# Config change
	if (isset($_POST['config'])&&is_allowed('config page')){
		unset($_POST['config']);
		conf(null,$_POST);
		save_config();
	}

	# Erase a user account
	if (isset($_POST['user_key'])&&is_user_admin()){
		foreach($_POST['user_key'] as $user_nb){
			if (isset($auto_restrict['users'][$user_nb])){
				unset($auto_restrict['users'][$user_nb]);
				# ADDED FOR BOZON
				rrmdir($_SESSION['upload_root_path'].$user_nb);
				rrmdir('thumbs/'.$_SESSION['upload_root_path'].$user_nb);
				if (isset($_SESSION['users_right'][$user_nb])){unset($_SESSION['users_right'][$user_nb]);}
			}
		}
		if (!empty($auto_restrict['users'])){
			save_users();
			
		}
		else{
			unlink($auto_restrict['path_to_files'].'/auto_restrict_users.php');
			exit_redirect();
		}
	}

	# Change user status
	if (isset($_POST['users_status'])&&is_user_admin()){
		unset($_POST['users_status']);
		unset($_POST['token']);
		foreach($_POST as $user=>$status){
			if (!empty($user)){$auto_restrict['users'][$user]['status']=$status;}
		}
		save_users();
		$msg=e('Changes saved',false);
		//header('location: index.php?p=users&token='.TOKEN.'&msg='.e('Changes saved',false));
	}


	if ($_FILES&&is_allowed('upload')){include('core/auto_dropzone.php');exit();}
?>
