<?php
	/**
	* BoZoN admin page:
	* allows upload / delete / filter files
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	if (!function_exists('newToken')){require_once('core/auto_restrict.php');} # Admin only!
	//include('core/GET_POST_admin_data.php');
?>




		<div style="clear:both"></div>

	<?php echo $message;?>

	<div id="content">
		
			<div class="column window">
				<header>
					<h1>
						<?php 
							if ($_SESSION['mode']=='links'){e('Manage links');}						
							elseif ($_SESSION['mode']=='move') {e('Move files');}
							else{e('Manage files');}
						?>
					</h1>
					<div id="layout">
						<?php 
							if (empty($_GET['f'])){
								/* you can change the generated link using another pattern as argument (keep the # tags !): 
								'<a class="#LAYOUT btn" href="index.php?p=#PAGE&aspect=#LAYOUT&token=#TOKEN">&nbsp;</a>'*/
								make_layout_link(); 
							}

						?>
						<a class="new_folder btn" title="<?php e('Create a subfolder in this folder');?>" href="#New_folder_box">&nbsp;</a>
						<a class="download_url btn" title="<?php e('Paste a file\'s URL to get it on this server');?>" href="#download_box">&nbsp;</a>
						<?php make_mode_link(); ?>
					</div> 
					<div class="fil_ariane btn">
						<a class="home" href="index.php?p=admin&path=/&token=<?php echo returnToken(true);?>"><em><?php e('Root');?>:</em>&nbsp;</a>
						<?php 
							$ariane=explode('/',$_SESSION['current_path']);
							$chemin='';
							foreach($ariane as $nb=>$folder){
								if (!empty($folder)){
									$chemin.=$folder;
									echo '<a class="ariane_item" href="index.php?p=admin&path='.$chemin.'&token='.returnToken(true).'">'.$folder.'</a>';
									$chemin.='/';
								}
							}
						?>
					</div>
				</header>
				<ul class="<?php echo $_SESSION['aspect'];?>" id="liste">

					<h1><?php if (!empty($_SESSION['filter'])){echo $_SESSION['filter'];}?></h1>
					<?php include('core/listfiles.php');?>
				</ul>
			</div>
	</div>
		<?php if ($_SESSION['mode']=='move'){ ?>
			<div class="w1000">
				<div class="w50"><p><img src="<?php echo THEME_PATH;?>/img/unknown.png"/><?php e('Move a file by clicking on it and choosing the destination folder in the list');?></p></div>
				<div class="w50"><p><img src="<?php echo THEME_PATH;?>/img/folder.png"/><?php e('Move a folder by clicking on the move icon and choosing the destination folder in the list');?></p></div>
			</div><div style="clear:both"></div>
		<?php } ?>
	

