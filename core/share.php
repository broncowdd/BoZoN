<?php
	/**
	* BoZoN share page:
	* handles a user share request
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
		require_once('core/markdown.php');
		$id=strip_tags($_GET['f']);
		$f=id2file($id); # complete filepath including profile folder

		$qrcode='
		<script src="core/js/qr.js"></script>
		<script>
		    function qrcode() {		    	
		    	qr=document.getElementById("qrcode");
		    	id=qr.getAttribute("data-src");
		    	var data = "'.$_SESSION["home"].'?f="+id;
		    	var options = {ecclevel:"M"};
		    	var url = QRCode.generatePNG(data, options);
		    	qr.src = url;
		    	return false;
		    }
    	</script>
		';
		$m3u='


		';
		if(!empty($f)){
			if (!is_user_connected()){$_SESSION['config']=load_config();}
			set_time_limit (0);
			store_access_stat($f,$id);
			$call_qrcode='<img id="qrcode" data-src="'.$id.'" src=""/><script>qrcode();</script>';
		
			# password mode
			if (isset($_POST['password'])){
				# the file id is a md5 password.original id
				$blured=blur_password($_POST['password']);
				$sub_id=str_replace($blured,'',$id); # here we try to recover the original id to compare 
			}
			if (strlen($id)>23 && empty($_POST['password'])){
				require(THEME_PATH.'/header.php');
				echo '
				<div id="lock">					
					<p id="message"><img src="'.THEME_PATH.'/img/home/locked.png"/>'.e('This share is protected, please type the correct password:',false).'</p>
					<form action="index.php?f='.$id.'" method="post">
						<input type="password" name="password" class="npt"/>
						<input type="submit" value="Ok" class="btn"/>
					</form>
				</div>
				';
				require(THEME_PATH.'/footer.php');
			}else if(empty($_POST['password'])||!empty($_POST['password']) && $blured.$sub_id==$id){	
				# normal mode or access granted
				if ($f && is_file($f)){
	
					# file request => return file according to $behaviour var (see core.php)
					$type=_mime_content_type($f);
					$ext=strtolower(pathinfo($f,PATHINFO_EXTENSION));
					if ($ext=='md'&&!isset($_GET['view'])){
						//include('core/markdown.php');
						require(THEME_PATH.'/header_markdown.php');	
						echo $qrcode;
						echo  parse(url2link(file_get_contents($f)));
						echo $call_qrcode;
						require(THEME_PATH.'/footer_markdown.php');
						
					}else if ($ext=='m3u'){
						require(THEME_PATH.'/header.php');	
						echo $qrcode;
						echo str_replace('index.php?f='.$id,'#m3u_link',$templates['dialog_share']);
						echo $call_qrcode;
						require(THEME_PATH.'/footer.php');
						
					}else if (is_in($ext,'FILES_TO_ECHO')!==false&&!isset($_GET['view'])){		
						require(THEME_PATH.'/header.php');
						echo $qrcode;		
						echo '<pre>'.htmlspecialchars(file_get_contents($f)).'</pre>';
						echo $call_qrcode;
						require(THEME_PATH.'/footer.php');						
					}else if (is_in($ext,'FILES_TO_RETURN')!==false||$type=='text/plain'&&empty($ext)){
						header('Content-type: '.$type.'; charset=utf-8');
						header('Content-Disposition: attachment; filename="'._basename($f).'"');
						header('Content-Transfer-Encoding: binary');
						header('Content-Length: '.filesize($f));
						readfile($f);
					}else{
						header('Content-type: '.$type);
						header('Content-Transfer-Encoding: binary');
						header('Content-Length: '.filesize($f));
						# lance le téléchargement des fichiers non affichables
						header('Content-Disposition: attachment; filename="'._basename($f).'"');
						readfile($f);
					}	
					# burn access ?
					burned($id);	
					exit();	
				
				}else if ($f && is_dir($f)){
					# folder request: return the folder & subfolders tree 					
					$tree=tree($f,return_owner($id),false,true);
					if (!isset($_GET['rss'])&&!isset($_GET['json'])){ # no html, header etc for rss feed & json data
						require(THEME_PATH.'/header.php');
						echo $qrcode;
						echo '<div id="share">';
						draw_tree($tree);
						echo '</div>';
						echo '
						<div class="feeds">'.$call_qrcode;
						if (conf('allow_shared_folder_RSS_feed')||conf('allow_shared_folder_JSON_feed')){
							echo '<br/>'.e('This page in',false);
						}
						if (conf('allow_shared_folder_RSS_feed')){
							echo ' <a href="'.$_SESSION['home'].'?f='.$id.'&rss" class="rss btn">RSS</a>';
						}
						if (conf('allow_shared_folder_JSON_feed')){
							echo '<a href="'.$_SESSION['home'].'?f='.$id.'&json" class="json btn blue">Json</a>';
						}
						if (conf('allow_shared_folder_download')){
							echo '<br/>
							<a class="zipfolder" href="index.php?zipfolder='.$id.'" title ="zip"><span class="icon-download-cloud"></span> '.e('Download a zip from this folder',false).'</a>';
						}
						echo '</div>';
						require(THEME_PATH.'/footer.php');
					}else{
						# json format of a shared folder (but not for a locked one)
						if (isset($_GET['json']) && !empty($tree)  && strlen($id)<=23){
							$upload_path_size=strlen($_SESSION['upload_root_path']);
							foreach ($tree as $branch){
								$id_tree[file2id($branch)]=$branch;
							}
							# burn access ?
							burned($id);
							exit(json_encode($id_tree)); 
						}

						# RSS format of a shared folder (but not for a locked one)
						if (isset($_GET['rss']) && !empty($tree)  && strlen($id)<=23){
							$rss=array('infos'=>'','items'=>'');
							$rss['infos']=array(
								'title'=>_basename($f),
								'description'=>e('Rss feed of ',false)._basename($f),
								//'guid'=>$_SESSION['home'].'?f='.$id,
								'link'=>htmlentities($_SESSION['home'].'?f='.$id.'&rss'),
							);

							include('core/Array2feed.php');
							$upload_path_size=strlen($_SESSION['upload_root_path']);
							foreach ($tree as $branch){
								$id_branch=file2id($branch);
								$rss['items'][]=array(
									'title'=>_basename($branch),
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
					# burn access ?
					burned($id);
					exit();	
				}else{ 
					require(THEME_PATH.'/header.php');
					echo '<div class="error">
						<br/>
						'.e('This link is no longer available, sorry.',false).'
						<br/>
					</div>';
					require(THEME_PATH.'/footer.php');
				}

				
			}

		}else{ 
			require(THEME_PATH.'/header.php');
			echo '<div class="link_error">
				<br/>
				'.e('This link is no longer available, sorry.',false).'
				<br/>
			</div>';
			require(THEME_PATH.'/footer.php');
		}	
	


?>
