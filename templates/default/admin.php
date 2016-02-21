<?php
	/**
	* BoZoN admin page:
	* allows upload / delete / filter files
	*   - Bronco (bronco@warriordudimanche.net)
	*   - Eauland (philippe@eauland.com)
	**/
	if (!function_exists('newToken')){require_once('core/auto_restrict.php');} # Admin only!
	//include('core/GET_POST_admin_data.php');

  if(isset($message) && !empty($message)){
    echo '<p id="message">'.$message.'</p>';
  }
?>

<div id="admin">
<script type="text/javascript" src="inc/js/lib/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="inc/js/lightbox.js"></script>
<script type="text/javascript" src="inc/js/qr.js"></script>
  <h1>
  	<?php 
  		if ($_SESSION['mode']=='links'){e('Manage links');}						
  		elseif ($_SESSION['mode']=='move') {e('Move files');}
  		else{e('Manage files');}
  	?>
  </h1>
  <div id="menu">
  	<?php 
  		if (empty($_GET['f'])){
  			/* you can change the generated link using another pattern as argument (keep the # tags !): 
  			'<a id="#MENU" href="index.php?p=#PAGE&aspect=#MENU&token=#TOKEN">&nbsp;</a>'*/
  			make_menu_link(); 
  		}
  	?>
  	<a id="new_folder" title="<?php e('Create a subfolder in this folder');?>" href="#New_folder_box">&nbsp;</a>
  	<a id="download_url" title="<?php e('Paste a file\'s URL to get it on this server');?>" href="#download_box">&nbsp;</a>
  	<?php make_mode_link(); ?>
  </div>

  <div id="fil_ariane">
  	<a class="ariane_home" href="index.php?p=admin&path=/&token=<?php echo returnToken(true);?>">&nbsp;</a>
  	<?php
  		echo '<span>'.e('Path:',false).' /</span>';
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
  
  <?php if (!empty($_SESSION['filter'])){
    echo '<p id="filter">'.e('Filter:',false).' '.$_SESSION['filter'].'</p>';
  }
  ?>
  
  <ul id="list" class="<?php echo $_SESSION['aspect'];?>">
  <?php include('core/listfiles.php');?>
  
  <script>
  	function get(url){	
  		request = new XMLHttpRequest();request.open('GET', url, false);
  		request.send();
  		return request.responseText;
  	}
  	
  	function put_file(fichier){
  		document.getElementById('filename').value=fichier;
  		document.getElementById('filename_hidden').value=fichier;
  	}
  	
  	function put_id(id){document.getElementById('ID_hidden').value=id;}
  	function put_link(id){document.getElementById('link').value="<?php echo $_SESSION['home'];?>?f="+id;}
  	function put_file_and_id(id,file){
  		document.getElementById('FILE_Rename').value=file;
  		document.getElementById('ID_Rename').value=id;
  	}
  	
  	function share(id,file){
  		document.getElementById('ID_folder').innerHTML=file;
  		document.getElementById('ID_share').value=id;
  		document.getElementById('Users_list').innerHTML=get('index.php?users_share_list='+id+'&token=<?php newToken(true);?>');
  
  	}
  	
  	function suppr(id){	document.getElementById('ID_Delete').value=id;}
    
    function qrcode(id) {
    	var data = "<?php echo $_SESSION['home'];?>?f="+id;
    	var options = {ecclevel:'M'};
    	var url = QRCode.generatePNG(data, options);
    	document.getElementById('qrcode_img').src = url;
    	return false;
    }
    
    function downloadImage() {
    	data = document.getElementById('outputimg').src;
    	document.getElementById('outputlink').href = data;
    }
  </script>
  </ul>

<?php if ($_SESSION['mode']=='move'){ ?>
	<div id="move">
  	<ul>
  		<li>
        <span class="img"><img src="<?php echo THEME_PATH; ?>img/admin/move_file.png" alt=""/></span>
        <span class="text"><?php e('Move a file by clicking on it and choosing the destination folder in the list'); ?></span>
      </li>
  		<li>
        <span class="img"><img src="<?php echo THEME_PATH; ?>img/admin/move_folder.png" alt=""/></span>
        <span class="text"><?php e('Move a folder by clicking on the move icon and choosing the destination folder in the list'); ?></span>
      </li>
  	</ul>
	</div>
<?php } ?>
</div>
