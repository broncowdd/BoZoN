<?php 
	if (!function_exists('returnToken')){exit;}	
?>

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
			<a href="admin.php?aspect=icon&token=<?php newToken(true);?>" title=" <?php e('Icons'); ?>"><img src="design/<?php echo $_SESSION['theme'];?>/img/34.png"/></a>
			<a href="admin.php?aspect=list&token=<?php newToken(true);?>" title=" <?php e('List');  ?>"><img src="design/<?php echo $_SESSION['theme'];?>/img/35.png"/></a>
		
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
				<input type="text" name="newfolder" value="" title="<?php e('Create a subfolder in this folder'); ?>" placeholder="<?php e('New_folder'); ?>"/>
				<input type="submit" value="ok"/>
				<?php newToken();?>
			</form>
			<div class="buttongroup">

				<a class="button" href="admin.php?mode=view&token=<?php newToken(true);?>"> <?php e('Manage files'); ?> <img src="design/<?php echo $_SESSION['theme'];?>/img/folder16.png"/></a>
				<a class="button green" href="admin.php?mode=links&token=<?php newToken(true);?>"> <?php e('Manage links'); ?> <img src="design/<?php echo $_SESSION['theme'];?>/img/link.png"/></a>
				<a class="button sanguine" href="admin.php?mode=move&token=<?php newToken(true);?>">  <?php e('Move files'); ?>  <img src="design/<?php echo $_SESSION['theme'];?>/img/movefiles.png"/></a>
				<hr/>
				<a class="button" href="stats.php">  <?php e('Access log file'); ?>  <img src="design/<?php echo $_SESSION['theme'];?>/img/info.png"/></a>
				<form action="#" method="get" class="themeform">
					<label><?php e('Change theme');?></label>
					<select name="theme" class="button">
						<?php 
							$themes=_glob('design/');
							foreach ($themes as $theme){
								$theme=basename($theme);
								if ($theme==$_SESSION['theme']){$selected=' selected ';}else{$selected='';}
								echo '<option value="'.$theme.'" '.$selected.'>'.$theme.'</option>';
							}
						?>
						
					</select>
					<input type="submit" value="ok"/>
					<?php newToken();?>
				</form>
				<hr/>
				<br/>
				<a class="button red" href="admin.php?deconnexion"><?php e('Logout'); ?> <img src="design/<?php echo $_SESSION['theme'];?>/img/logout.png"/></a>
			</div>
		</div>

		
		
	</nav>