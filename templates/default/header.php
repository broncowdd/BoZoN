<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>BoZoN | <?php e('Drag, drop, share.'); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="application-name" content="BoZoN">
<meta name="msapplication-tooltip" content="<?php e('Drag, drop, share.'); ?>">
<meta name="msapplication-TileImage" content="<?php echo THEME_PATH;?>/img/favicon.png">
<meta name="msapplication-TileColor" content="#2c4aff">
<link rel="apple-touch-icon" href="<?php echo THEME_PATH;?>/img/favicon.png">
<link rel="shortcut icon" type="image/png" href="<?php echo THEME_PATH;?>/img/favicon.png">
<link rel="stylesheet" type="text/css" href="<?php echo THEME_PATH;?>style.css">
</head>

<body class="<?php body_classes();?>">
  	<header>
  		<div id="top_bar">
  			<span id="menu">
  				<a class="home" href="index.php" title="<?php e('Home');?>">&nbsp;</a><?php
	  				if (is_admin_connected()&&empty($_GET['f'])){
	  					generate_users_list_link(e('Users list',false));
	  					generate_new_users_link(e('New user',false));
	  					echo '<a class="log_file" href="index.php?p=stats&token='.returnToken().'" class="log_link" title="'.e('Access log file',false).'">&nbsp;</a>';
	  				}
  				?>
  			</span>
	  		<span id="lang">
		      <?php  
		      	/* you can change the generated link using another pattern as argument (keep the # tags !): 
				'<a #CLASS href="index.php?p=#PAGE&lang=#LANG&token=#TOKEN">#LANG</a>'*/
		        make_lang_link();
		      ?>
		    </span>
		    <div style="clear:both"></div>
	    </div>
	    
	    <?php 	if (is_admin_connected()&&!empty($page)&&empty($_GET['f'])){?>
				    <div id="search" >
				    	<form action="index.php" method="get" class="searchform">
							<input type="text" class="npt" name="filter" value="<?php if (!empty($_SESSION['filter'])){echo $_SESSION['filter'];} ?>" title="<?php e('Search in the uploaded files'); ?>" placeholder="<?php e('Filter'); ?>"/>
							<input type="hidden" value="admin" name="p"/>
							<?php newToken();?>
						</form>
				    </div>

	    <?php 	} ?>


	    <div id="connect">
		    <?php if (empty($_GET['f'])){
		    	/* you can add labels if you want like make_connect_link('Admin','Logout','Connection') */
		    	make_connect_link();}
		    ?>
	    </div>
	    
 		<?php 	if (!is_admin_connected()||!empty($_GET['f'])){ ?>
				    <a id="logo" href="index.php">BoZoN</a>
				    <h2 class="slogan"><?php e('Drag, drop, share.');?></h2>
	    <?php 	}else{include('core/auto_dropzone.php');} ?>
    </header>
