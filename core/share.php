<?php
	/**
	* BoZoN share page:
	* handles a user share request
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	
		$id=strip_tags($_GET['f']);
		$f=id2file($id);

		
		if(!empty($f)){
			set_time_limit (0); 
			store_access_stat($f,$id);
			# password mode
			if (isset($_POST['password'])){
				# the file id is a md5 password.original id
				$blured=blur_password($_POST['password']);
				$sub_id=str_replace($blured,'',$id); # here we try to recover the original id to compare 
			}
			if (strlen($id)>23 && !isset($_POST['password'])){
				require(THEME_PATH.'/header.php');
				echo '<div class="lock"><img src="'.THEME_PATH.'/img/locked_big.png"/>
				<form action="index.php?f='.$id.'" method="post">
					<label>'.e('This share is protected, please type the correct password:',false).'</label><br/>
					<input type="password" name="password" class="npt"/>
					<input type="submit" value="Ok" class="btn red"/>
				</form>
				</div>
				';
				require(THEME_PATH.'/footer.php');
			}else if(!isset($_POST['password']) || isset($_POST['password']) && $blured.$sub_id==$id){
				$f=$_SESSION['upload_path'].$f;
	
				# normal mode or access granted
				if ($f && is_file($f)){
					# file request => return file according to $behaviour var (see core.php)
					$type=_mime_content_type($f);
					$ext=strtolower(pathinfo($f,PATHINFO_EXTENSION));
					if (is_in($ext,'FILES_TO_ECHO')!==false){		
						require(THEME_PATH.'/header.php');		
						echo '<pre>'.htmlspecialchars(file_get_contents($f)).'</pre>';
						require(THEME_PATH.'/footer.php');
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
					if (!isset($_GET['rss'])&&!isset($_GET['json'])){ # no html, header etc for rss feed & json data
						require(THEME_PATH.'/header.php');
						draw_tree($tree);
						echo '<div class="feeds">'.e('This page in',false).' <a href="'.$_SESSION['home'].'?f='.$id.'&rss" class="rss btn orange">rss</a> <a href="'.$_SESSION['home'].'?f='.$id.'&json" class="json btn blue">Json</a></div>';
						require(THEME_PATH.'/footer.php');
					}
					
				}else{ 
					require(THEME_PATH.'/header.php');
					echo '<div class="error">
						<br/>
						'.e('This link is no longer available, sorry.',false).'
						<br/>
					</div>';
					require(THEME_PATH.'/footer.php');
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
		}else{ 
			require(THEME_PATH.'/header.php');
			echo '<div class="error">
				<br/>
				'.e('This link is no longer available, sorry.',false).'
				<br/>
			</div>';
			require(THEME_PATH.'/footer.php');
		}	
	


?>
