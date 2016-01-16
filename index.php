<?php
	/**
	* BoZoN user part:
	* simply handles the get link.
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	set_time_limit(0); # Avoid problems on big files #20 on github
	$message='';$tree=false;$feeds_div='';
	include('core/core.php');
	function burned($id){if (substr($id,0,1)=='*'){removeID($id);}}
	if (!empty($_GET['f'])){
		$id=strip_tags($_GET['f']);
		$f=id2file($id);
		store_access_stat($f,$id);
		if(!empty($f)){
			# password mode
			if (isset($_POST['password'])){
				# the file id is a md5 password.original id
				$blured=blur_password($_POST['password']);
				$sub_id=str_replace($blured,'',$id); # here we trie to recover the original id to compare 
			}
			if (strlen($id)>23 && !isset($_POST['password'])){
				$message= '<div class="lock"><img src="design/'.$default_theme.'/img/locked_big.png"/>
				<form action="index.php?f='.$id.'" method="post">
					<label>'.e('This share is protected, please type the correct password:',false).'</label><br/>
					<input type="password" name="password" class="button red"/>
					<input type="submit" value="Ok" class="button"/>
				</form>
				</div>
				';
			}else if(!isset($_POST['password']) || isset($_POST['password']) && $blured.$sub_id==$id){
				if(isset($_GET['thumbs'])){
					$f=get_thumbs_name($f);
				}else{
					$f=$_SESSION['upload_path'].$f;
				}
				# normal mode or access granted
				if ($f && is_file($f)){
					# file request => return file according to $behaviour var (see core.php)
					$type=_mime_content_type($f);
					$ext=strtolower(pathinfo($f,PATHINFO_EXTENSION));
					if (is_in($ext,'FILES_TO_ECHO')!==false){				
						echo '<pre>'.htmlspecialchars(file_get_contents($f)).'</pre>';
					}
					else if (is_in($ext,'FILES_TO_RETURN')!==false){
						header('Content-type: '.$type.'; charset=utf-8');
						header('Content-Transfer-Encoding: binary');
						header('Content-Length: '.filesize($f));
						readfile($f);
					}
					else{
						header('Content-type: '.$type);
						header('Content-Transfer-Encoding: binary');
						header('Content-Length: '.filesize($f));
						// lance le téléchargement des fichiers non affichables
						header('Content-Disposition: attachment; filename="'.basename($f).'"');
						readfile($f);				
					}		
					# burn access ?
					burned($id);	
					exit();	
				
				}else if ($f && is_dir($f)){
					# folder request: return the folder & subfolders tree 
					$tree=tree($f);
					$feeds_div='<div class="feeds">'.e('This page in',false).' <a href="'.$_SESSION['home'].'?f='.$id.'&rss" class="rss">rss</a><a href="'.$_SESSION['home'].'?f='.$id.'&json" class="json">Json</a></div>';
				}else{ $message='<div class="error">
						<br/>
						'.e('This link is no longer available, sorry.',false).'
						<br/>
					</div>';
				}

				# json format of a shared folder (but not for a locked one)
				if (isset($_GET['json']) && !empty($tree)  && strlen($id)<=23){
					$upload_path_size=strlen($_SESSION['upload_path']);
					foreach ($tree as $branch){
						$id_tree[file2id(substr($branch,$upload_path_size))]=$branch;
					}
					# burn access ?
					burned($id);
					exit(json_encode($id_tree)); 
				}

				# RSS format of a shared folder (but not for a locked one)
				if (isset($_GET['rss']) && !empty($tree)  && strlen($id)<=23){
					$rss=array('infos'=>'','items'=>'');
					$rss['infos']=array(
						'title'=>basename($f),
						'description'=>e('Rss feed of ',false).basename($f),
						//'guid'=>$_SESSION['home'].'?f='.$id,
						'link'=>htmlentities($_SESSION['home'].'?f='.$id.'&rss'),
					);

					include('core/Array2feed.php');
					$upload_path_size=strlen($_SESSION['upload_path']);
					foreach ($tree as $branch){
						$id_branch=file2id(substr($branch,$upload_path_size));
						$rss['items'][]=array(
							'title'=>basename($branch),
							'description'=>'',
							'pubDate'=>makeRSSdate(date("d-m-Y H:i:s.",filemtime($branch))),
							'link'=>$_SESSION['home'].'?f='.$id_branch,
							'guid'=>$_SESSION['home'].'?f='.$id_branch,
						);
					}
					array2feed($rss);
					# burn access ?
					burned($id);
					exit();
				}
			}
		}else{ $message='<div class="error">
				<br/>
				'.e('This link is no longer available, sorry.',false).'
				<br/>
			</div>';
		}	
	}
	
?>
<html>
<head>
	<title>BoZoN: <?php e('Drag, drop, share.');?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="/image/png" href="design/<?php echo $_SESSION['theme'];?>/img/bozonlogo2.png">
	<link rel="stylesheet" type="text/css" href="design/<?php echo $_SESSION['theme'];?>/style.css">
		
</head>
<body class="index">
<header>
	<div class="overlay">
		<p class="logo"></p>
		<div style="clear:both"></div>
	</div>
</header>
<?php
	if (!empty($message)){echo $message;}
	else if ($tree){
		completeID($tree);
		draw_tree($tree);
		# burn access ?
		burned($id);
	}?>
	
	<footer>
	<?php echo $feeds_div;?>
		<span>Bozon v<?php echo VERSION;?> </span> <a href="https://github.com/broncowdd/BoZoN" class="github" title="<?php e('fork me on github');?>">&nbsp;</a>
	</footer>
</body>
</html>