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
  <meta name="msapplication-TileImage" content="<?php echo THEME_PATH; ?>favicon.png">
  <meta name="msapplication-TileColor" content="#2c4aff">
  <link rel="apple-touch-icon" href="<?php echo THEME_PATH; ?>favicon.png">
  <link rel="shortcut icon" type="image/png" href="<?php echo THEME_PATH; ?>favicon.png">
  <link rel="stylesheet" type="text/css" href="<?php echo THEME_PATH; ?>css/style.php">
  <script src="core/js/VanillaJS.js"></script>
  <script src="core/js/lightbox.js"></script> 
  <?php 
    #########################################
    # hide functions if libs are not installed
    #########################################
    $hide='';
    if (!$_SESSION['zip']){$hide.='#zip_selection, .zipfolder{display:none!important}'; }
    if (!$_SESSION['curl']){$hide.='#download_url{display:none!important}'; }
    if (!empty($hide)){echo "\n<style>\n$hide\n</style>";}

    $connected=is_user_connected();
  ?>
</head>

<body class="<?php body_classes();?>">
<?php /* add the lightbox */ echo $templates['lightbox']; ?>
<header <?php if ($connected){echo 'ondragenter="removeClass(\'#upload\',\'hidden\')"';}?>>
  <div id="top_bar" >
    <span id="icons">
      <?php 
        if (!isset($_GET['f'])){ 
          
        }
 
        if (empty($_GET['f'])){

            if ($connected){echo '<a class="home" href="index.php?p=admin&token='.TOKEN.'" title="'.e('Home',false).'"><span class="icon-home" ></span></a>';}
            if (is_allowed('change status rights')){echo '<a class="profiles_rights" href="index.php?p=edit_profiles&token='.TOKEN.'" class="edit_profile_link" title="'.e('Edit profiles rights',false).'"><span class="icon-block" ></span></a>';}
            if (is_allowed('config page')){echo '<a class="config_page" href="index.php?p=config&token='.TOKEN.'" class="config_page_link" title="'.e('Configure Bozon',false).'"><span class="icon-cog-alt" ></span></a>';}
            if (is_allowed('users page')){generate_users_list_link(e('Users list',false));}
            if (is_allowed('add user')){generate_new_users_link(e('New user',false));}
            if (is_allowed('acces logfile')){echo '<a class="log_file" href="index.php?p=stats&token='.TOKEN.'" class="log_link" title="'.e('Access log file',false).'"><span class="icon-info-circled" ></span></a>';}
            if ($connected){generate_new_password_link(e('Change password',false));}
            if (is_allowed('regen ID base')){echo '<a href="index.php?regen&token='.TOKEN.'" id="regen_button" title="'.e('Rebuild base',false).'"><span class="icon-renew" ></span></a>';}
            if (is_allowed('markdown editor')){echo '<a href="index.php?p=editor&token='.TOKEN.'" id="editor_button" title="'.e('Text editor',false).'"><span class="icon-doc-text-inv" ></span></a>';}
            if (is_allowed('upload')){echo '<a href="#" id="upload_button" onclick="toggleClass(\'#upload\',\'hidden\')" ondragenter="toggleClass(\'#upload\',\'hidden\')" title="'.e('Click or dragover to reveal dropzone',false).'"><span class="icon-upload-cloud" ></span> '.e('Upload',false).'</a>';}
        }
      ?>
    </span>
    <div class="right">
      <div id="lang">
        <?php make_lang_link(); ?>
      </div>  
   
     <div id="connect">
        <?php
          if (empty($_GET['f'])){
            /* you can add labels if you want like make_connect_link('Admin','Logout','Connection') */
            make_connect_link('&nbsp;','&nbsp;',e('Connect',false));
          }
        ?>
        </div> 
     
        <?php if (is_user_connected()&&!empty($page)&&empty($_GET['f'])){  ?>


          <div id="search" >
            <form action="index.php" method="get" class="searchform">
              <input type="text" class="npt" name="filter" value="<?php if (!empty($_SESSION['filter'])){echo $_SESSION['filter'];} ?>" title="<?php e('Search in the uploaded files'); ?>" placeholder="<?php e('Filter'); ?>"/>
              <input type="hidden" value="admin" name="p"/>
              <?php newToken();?>
            </form>
          </div>
        <?php } ?> 
      </div> 
  <div style="clear:both"></div>
</div>
  <?php

    if (!is_user_connected()||!empty($_GET['f'])){ ?>
      <p id="logo" href="index.php">BoZoN</p>
      <h2 class="slogan"><?php e('Drag, drop, share.');?></h2>
  <?php 
    }else{    
      if (is_allowed('upload')){include('core/auto_dropzone.php');}
    }
  ?>


    <div id="title_page">
      <?php 
      if (!empty($_GET['p'])){
        if ($_GET['p']=='editor'){e('Markdown editor'); }
        elseif ($_GET['p']=='stats'){e('Access log'); }
        elseif ($_GET['p']=='login'&&isset($_GET['change_password'])){e('Change password'); }
        elseif ($_GET['p']=='login'&&isset($_GET['newuser'])){e('Create an account'); }
        elseif ($_GET['p']=='login'){e('Please, login'); }
        elseif ($_GET['p']=='users'){e('Users profiles'); }
        elseif ($_GET['p']=='edit_profiles'){e('Configure profiles rights'); }
        elseif ($_GET['p']=='config'){e('Configure Bozon'); }
        elseif (conf('mode')=='links'){e('Manage links');}           
        else{e('Manage files');}
      }
       
      ?>
    </div> 


</header>
