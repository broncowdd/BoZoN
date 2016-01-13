<?php
  include('header.php');
?>
  </header>
  
  
  <div class="overlay">



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

	<?php echo $message;?>

	<div id="content">
		
			
			<?php include('core/auto_dropzone.php');?>

			<div class="column window">

					<h2><?php e('Files list');?></h2>
					<div class="fil_ariane">
						<a class="home" href="admin.php?path=/&token=<?php echo returnToken(true);?>"><em><?php e('Root');?>:</em>&nbsp;</a>
						<?php 
							$ariane=explode('/',$_SESSION['current_path']);
							$chemin='';
							foreach($ariane as $nb=>$folder){
								if (!empty($folder)){
									$chemin.=$folder;
									echo '<a class="ariane_item" href="admin.php?path='.$chemin.'&token='.returnToken(true).'">'.$folder.'</a>';
									$chemin.='/';
								}
							}
						?>
					</div>

				<ul class="<?php echo $_SESSION['aspect'];?>" id="liste">

					<h1><?php echo $_SESSION['filter'];?></h1>
					<?php include('listfiles.php');?>
				</ul>
			</div>
		
	</div>

		<div class="w1000">
		<?php if (!isset($_SESSION['mode']) || $_SESSION['mode']=='view'){ ?>
			<div class="w33"><img src="design/<?php echo $_SESSION['theme'];?>/img/bozondd.png"/><p>1 <?php e('Drag the file you want to share to upload it on the server');?></p></div>
			<div class="w33"><img src="design/<?php echo $_SESSION['theme'];?>/img/bozonsh.png"/><p>2 <?php e('Copy the file\'s link (right click on it)');?></p></div>
			<div class="w33"><img src="design/<?php echo $_SESSION['theme'];?>/img/bozoncc.png"/><p>3 <?php e('Share the link with your buddies...');?></p></div>
		<?php }else if ($_SESSION['mode']=='move'){ ?>
			<div class="w50"><p><img src="design/<?php echo $_SESSION['theme'];?>/img/unknown.png"/><?php e('Move a file by clicking on it and choosing the destination folder in the list');?></p></div>
			<div class="w50"><p><img src="design/<?php echo $_SESSION['theme'];?>/img/folder.png"/><?php e('Move a folder by clicking on the move icon and choosing the destination folder in the list');?></p></div>

		<?php }else if ($_SESSION['mode']=='links'){ ?>
			<div class="w33"><img src="design/<?php echo $_SESSION['theme'];?>/img/locked_big.png"/><p> <?php e('Lock the access to the file/folder with a password');?><br/><small><?php e('If you want to remove the password, just click on Renew button');?></small></p></div>
			<div class="w33"><img src="design/<?php echo $_SESSION['theme'];?>/img/burn_big.png"/><p> <?php e('When burn is on, the user can access the file/folder only once');?></p></div>
			<div class="w33"><img src="design/<?php echo $_SESSION['theme'];?>/img/renew_big.png"/><p> <?php e('Renew the share link of the file/folder (in case of a stolen link for example)');?></p></div>	


		<?php } ?>
		</div>
		<div style="clear:both"></div>
		<div class="credits">Bozon v<?php echo VERSION;?> - <?php e('tiny file sharing app, coded with love and php by ');?> <a href="http://warriordudimanche.net">Bronco</a> - <a href="admin.php?deconnexion"><?php e('Logout'); ?></a></div>
		<a href="https://github.com/broncowdd/BoZoN" class="github" title="<?php e('fork me on github');?>">&nbsp;</a>


<script>
	menu=document.getElementById('menu');
	menu_icon=document.getElementById('menu_icon');
	body=document.getElementById('body');
	cl='open';

	// block closing menu by clicking on it
	menu.addEventListener('click', function(event){
        if(event.stopPropagation) { event.stopPropagation(); }		
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
        
		
	});

</script>

<?php
  include('footer.php');
?>
