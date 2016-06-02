<?php
	/**
	* BoZoN admin page:
	* allows upload / delete / filter files
	* @author: Bronco (bronco@warriordudimanche.net)
	* 
	**/

  require_once('core/auto_restrict.php'); # Connected user only !

  #################################################
?>

<?php 
  # Initialisation
  $layout=conf('aspect');
  $shared_folders=$back_link='';
  if (!conf('mode')){$mode='view';}else{$mode=conf('mode');}
  $upload_path_size=strlen($_SESSION['upload_root_path'].$_SESSION['upload_user_path']);
  $lb_token=TOKEN;
  echo str_replace('#TOKEN',$lb_token,$templates['dialog_link']);
  echo str_replace('#TOKEN',$lb_token,$templates['dialog_rename']);
  echo str_replace('#TOKEN',$lb_token,$templates['dialog_delete']);
  echo str_replace('#TOKEN',$lb_token,$templates['dialog_new_folder']);
  echo str_replace('#TOKEN',$lb_token,$templates['dialog_download_url']);
  echo str_replace('#TOKEN',$lb_token,$templates['dialog_qrcode']);
  echo str_replace('#TOKEN',$lb_token,$templates['dialog_share']);
  echo str_replace('#TOKEN',$lb_token,$templates['dialog_import']);
if ($mode=='links'){
  # Add lock dialogbox to the page
  $array=array(
    '#TOKEN'  => TOKEN
  );
  echo template('dialog_password',$array);
}
if ($mode=='view'){
  # Add shares from others users 
  $shared_with=load_folder_share();
  if (!empty($shared_with[$_SESSION['login']])){
    //$shared_folders.= '<div class="shared_folders">';
    $saveshare=false;
    foreach($shared_with[$_SESSION['login']] as $id=>$data){
      if (is_dir($data['folder'])&&!empty($ids[$id])){
        $folder=_basename($data['folder']);
        $array=array(
          '#CLASS'      => 'shared_folder',
          '#ID'         => $id,
          '#FICHIER'    => $folder,
          '#TOKEN'      => TOKEN,
          '#NAME'       => $folder,
          '#FROM'       => $data['from'],
        );
        $shared_folders.= template($mode.'_shared_folder_'.$layout,$array);
      }elseif (is_file($data['folder'])&&!empty($ids[$id])){
        $file=_basename($data['folder']);
        $extension=strtolower(pathinfo($file,PATHINFO_EXTENSION));
        $array=array(
          '#CLASS'      => 'shared_folder',
          '#ID'         => $id,
          '#FICHIER'    => $file,
          '#TOKEN'      => TOKEN,
          '#NAME'       => $file,
          '#FROM'       => $data['from'],
          '#EXTENSION'  => $extension,
        );
        $shared_folders.= template($mode.'_shared_file_'.$layout,$array);
      }else{
        # remove obsolete shared IDs
        unset($shared_with[$_SESSION['login']][$id]);
        $saveshare=true;
      }
    }
    //$shared_folders.= '</div>';
    save_folder_share($shared_with);
  }

  # Prepare folder tree for move dialog box
  $select_folder='<select name="destination" class="folder_list button"><option value="">'.e('Choose a folder',false).'</option>';
  $folders_list=user_folder_tree();
  if (isset($folders_list[0])){$folders_list[0].='/';}

  foreach($folders_list as $folder){
    $folder=substr($folder,$upload_path_size);
    $select_folder.='<option value="'.$folder.'">'.$folder.'</option>';
  }

  $select_folder.='</select>';
  # Add move dialogbox to the page
  $array=array(
      '#LIST_FILES_SELECT'  => $select_folder,
      '#TOKEN'        => TOKEN,
    );

  $dia=str_replace('#LIST_FILES_SELECT',$select_folder,$templates['dialog_move']);
  $dia=str_replace('#TOKEN',TOKEN,$dia);
  echo $dia;
}

?>


<div id="admin">
    

  <div id="fil_ariane">
    <a class="ariane_home" href="index.php?p=admin&path=/&token=<?php echo TOKEN;?>" title="<?php echo e('Root:',false);?>"><span class="icon-home_folder" ></span></a>/
  	
  	<?php
  		$ariane=array_filter(explode('/',$_SESSION['current_path']));
      $previous_path = $ariane;
      $nb_folders=count($previous_path);
      if ($nb_folders>1){unset($previous_path[$nb_folders-1]);$previous_path = implode('/',$previous_path);}
      elseif($nb_folders=1&&!empty($previous_path[0])){$previous_path='/';}
      else{$previous_path='';}
      
    
      $chemin='';
  		foreach($ariane as $nb=>$folder){
  			if (!empty($folder)){
  				$chemin.=$folder;
  				echo '<a class="ariane_item" href="index.php?p=admin&path='.$chemin.'&token='.TOKEN.'">'.$folder.'</a>';
  				$chemin.='/';
  			}
  		}
      
      if (!empty($previous_path)&&conf('show_back_button')){
        if ($mode=='links'){$columns='<td></td></td><td><td></td>';}else{$columns='<td></td><td></td></td><td><td></td>';}
        $back_button='<a class="back" href="index.php?p=admin&path='.$previous_path.'&token='.TOKEN.'"><span class="icon-left-circle" ></span></a>';
        $back_link='
        <tr class="folder"><td></td><td class="table_filename"><a class="root" href="index.php?p=admin&path=/&token='.TOKEN.'">.</a></td>'.$columns.'</tr>
        <tr class="folder"><td></td><td class="table_filename"><a class="back" href="index.php?p=admin&path='.$previous_path.'&token='.TOKEN.'">..</a></td>'.$columns.'</tr>
        ';
    	 echo $back_button;
      }
    ?>
  </div>
  
  <?php if (!empty($_SESSION['filter'])){
    echo '<p id="filter">'.e('Filter:',false).' '.$_SESSION['filter'].'</p>';
  }
  ?>
  <div id="menu">
    <?php 
      if (empty($_GET['f'])){
        /* you can change the generated link using another pattern as argument (keep the # tags !): 
        '<a id="#MENU" href="index.php?p=#PAGE&aspect=#MENU&token=#TOKEN">&nbsp;</a>'*/
        make_menu_link(); 
      }
    if (is_allowed('create folder')){
    ?>
    <a id="new_folder" title="<?php e('Create a subfolder in this folder');?>" href="#New_folder_box"><span class="icon-folder-add" ></span></a>
    <a id="Import_from_bozon" title="<?php e('Import from another bozon');?>" href="#import_box"><span class="icon-download-cloud" ></span></a>
    <?php }?>

    <a id="download_url" title="<?php e('Paste a file\'s URL to get it on this server');?>" href="#download_box"><span class="icon-globe" ></span></a>
    <?php make_mode_link(); 
    if (is_allowed('delete files')){
    ?>
      <span id="delete_selection" title="<?php e('Delete selected items');?>"><span class="icon-trash" ></span></span>
    <?php } ?>

    <span id="zip_selection" title="<?php e('Zip and download selected items');?>"><span class="icon-download-cloud" ></span></span> 
  </div>

  <div id="list_files" class="<?php echo conf('aspect');?>">    
      <?php 
        include('core/listfiles.php');
      ?>
  </div>
  <script src="core/js/qr.js"></script>
 
  <script>
    p=document.getElementById('password');
    c=document.getElementById('confirm');
    function check(){
      if (p.value!=c.value){c.style.backgroundColor='#edbcba';}
      else{c.style.backgroundColor='#bcedbc';p.style.backgroundColor='#bcedbc'}
    }
    
    function downloadImage() {
    	data = document.getElementById('outputimg').src;
    	document.getElementById('outputlink').href = data;
    }

    function loadMore(button){
      event.preventDefault;
      list=document.getElementById('async_load');
      link=attr(button,'data-url');
      nb=parseInt(attr(button,'data-from'));
      max=parseInt(attr(button,'data-max'));
      text=button.innerHTML;
      button.innerHTML='...';
      addClass(button,'loading');
      if (max>nb){attr(button,'data-from',nb+1);}
      else{remove(button);}
      appendAjax(link+'&from='+nb,'','get',list,function(){button.innerHTML=text;removeClass(button,'loading');});
      
      return false;
    }

    // Click on move button
    on('click','#list_files a.movefolder',function(){
      name=attr(this,"data-name");
      document.getElementById('filename').value=name;
      document.getElementById('filename_hidden').value=name;
    });
    // Click on delete button
    on('click','#list_files a.close',function(){
      fileid=attr(this,"data-id");
      document.getElementById('ID_Delete').value=fileid;
    });
    // Click on rename button
    on('click','#list_files a.rename',function(){
      fileid=attr(this,"data-id");
      name=attr(this,"data-name");
      document.getElementById('FILE_Rename').value=name;
      document.getElementById('ID_Rename').value=fileid;
    });
    // Click on link button
    on('click','#list_files a.link',function(){
      fileid=attr(this,"data-id");
      document.getElementById('link').value="<?php echo $_SESSION['home'];?>?f="+fileid;
    });
    // Click on usershare button
    on('click','#list_files a.usershare',function(){
      fileid=attr(this,"data-id");
      name=attr(this,"data-name");
      document.getElementById('ID_folder').innerHTML=name;
      document.getElementById('ID_share').value=fileid;
      ajax('index.php?users_share_list='+fileid+'&token=<?php echo TOKEN;?>',null,'GET','#Users_list');  
    });
    // Click on locked button
    on('click','#list_files a.locked',function(){
      fileid=attr(this,"data-id");
      document.getElementById('ID_hidden').value=fileid;
    });
    // Click on qrcode button
    on('click','#list_files a.qrcode',function(){
      fileid=attr(this,"data-id");     
      var data = "<?php echo $_SESSION['home'];?>?f="+fileid;
      var options = {ecclevel:'M'};
      var url = QRCode.generatePNG(data, options);
      document.getElementById('qrcode_img').src = url;
      return false;
    });

    // Check for multiselection
    on('click','.table_check input',function(){
      tr=parent(parent(this));
      if (this.checked==true){
        addClass(tr,"checked");
      }else{
        removeClass(tr,"checked");
      }
      if (first(".view .checked")){
        addClass("#delete_selection","show");
        addClass("#zip_selection","show");
      }else{
        removeClass("#delete_selection","show");
        removeClass("#zip_selection","show");
      }
      
    });
    on('click','#delete_selection',function(){
      document.getElementById('multiselect_command').setAttribute("value","delete");
      document.getElementById('multiselect').submit();
    });
    on('click','#zip_selection',function(){
      document.getElementById('multiselect_command').setAttribute("value","zip");
      document.getElementById('multiselect').submit();
    });
    on('click','#check_all',function(){
        checked=this.checked;
        each(".table_check input:not(#check_all)",function(obj){
            tr=parent(parent(obj));
            obj.checked=checked;
            if (checked==true){addClass(tr,"checked");}
            else{removeClass(tr,"checked");}
        });
        if (checked==true){
          addClass("#delete_selection","show");
          addClass("#zip_selection","show");
        }
        else{
          removeClass("#delete_selection","show");
          removeClass("#zip_selection","show");
        }
    });


    
  </script>



</div>
<script src="core/js/sorttable.js"></script>
<script type="text/javascript" src="core/js/scrolltotop.js"></script>