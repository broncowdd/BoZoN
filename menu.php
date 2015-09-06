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
				<a class="button" href="stats.php">  <?php e('Access log file'); ?>  <img src="design/<?php echo $_SESSION['theme'];?>/img/movefiles.png"/></a>
				
				<hr/>
				<br/>
				<a class="button red" href="admin.php?deconnexion"><?php e('Logout'); ?> <img src="design/<?php echo $_SESSION['theme'];?>/img/logout.png"/></a>
			</div>
		</div>

		
		
	</nav>