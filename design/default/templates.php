<?php
/**
* BoZoN templates file
* contains all bozon's html parts
* Do not change the #CODE parts !
* @author: Bronco (bronco@warriordudimanche.net)
**/
$token='';
if (function_exists('returnToken')){$token=returnToken();}
$tooltip_close=e('Delete this file',false);
$tooltip_link=e('Get the share link',false);
$tooltip_rename=e('Rename this file (share link will not change)',false);
$tooltip_lock=e('Put a password on this share',false);
$tooltip_burn=e('Turn this share into a burn after access share',false);
$tooltip_renew=e('Regen the share link',false);
$tooltip_zipfolder=e('Download a zip from this folder',false);

$templates=array(
	# lightboxes
	'move_lightbox'=>'
		<div class="lightbox" id="selecttarget">
			<figure>
				<a href="#" class="closemsg"></a>
				<figcaption>
					<h1>'.e('Move file or folder',false).'</h1>
				    <form action="admin.php" method="post">
						<label>'.e('Move',false).':</label><input type="text" value="" name="file" id="filename" disabled="true"/>
						<input type="hidden" value="" name="file" id="filename_hidden"/>
						<label>'.e('To',false).':</label>#LIST_FILES_SELECT
						<input type="hidden" name="token" value="#TOKEN"/>
						<br/>
						<input type="submit" value="ok" class="button"/>
				    </form>
				</figcaption>
			</figure>
		</div>
	',
	'password_lightbox'=>'
		<div class="lightbox" id="locked" onmousemove="document.getElementById(\'password\').focus();">
			<figure>
				<a href="#" class="closemsg"></a>
				<figcaption>
					<h1>'.e('Lock access',false).'</h1>
				    <form action="admin.php" method="post"><br/>
						'.e('Please give a password to lock access to this file',false).'
						<input type="text"  value="" name="password" id="password"/>
						<input type="hidden" value="" name="id" id="ID_hidden"/>
						<input type="hidden" name="token" value="'.$token.'"/>
						<br/>
						<input type="submit" value="ok" class="button"/>
				    </form>
				</figcaption>
			</figure>
		</div>
	',
'rename_lightbox'=>'
		<div class="lightbox" id="rename_box" onmousemove="document.getElementById(\'FILE_Rename\').focus();">
			<figure>
				<a href="#" class="closemsg"></a>
				<figcaption>
					<h1>'.e('Rename',false).'</h1>
				    <form action="admin.php" method="get"><br/>
						'.e('Rename this file ?',false).'
						<input type="text"  value="" name="newname" id="FILE_Rename" onFocus="this.select();" autofocus="true" />
						<input type="submit" value="ok" class="button" />
						<input type="hidden" value="" name="id" id="ID_Rename"/>
						<input type="hidden" name="token" value="'.$token.'"/>
						
				    </form>
				</figcaption>
			</figure>
		</div>
	',
	'delete_lightbox'=>'
		<div class="lightbox" id="delete_box">
			<figure>
				<a href="#" class="closemsg"></a>
				<figcaption>
					<h1>'.e('Delete',false).'</h1>
				    <form action="admin.php" method="get"><br/>
						'.e('Delete this file ?',false).'
						<input type="hidden" value="" name="del" id="ID_Delete"/>
						<input type="hidden" name="token" value="'.$token.'"/>
						<br/>
						<input type="submit" value="'.e('Yes',false).'" class="button" />
				    </form>
				</figcaption>
			</figure>
		</div>
	',

	'link_lightbox'=>'
		<div class="lightbox" id="link_box">
			<figure>
				<a href="#" class="closemsg"></a>
				<figcaption>
					<h1>'.e('Share link',false).'</h1>
				    <form onSubmit="return false;"><br/>
						'.e('Copy this share link',false).'
						<textarea name="link" value="" id="link" onFocus="this.select();" autofocus="true" ></textarea>						
						
					</form>
				</figcaption>
			</figure>
		</div>
	',


# LIST
	# VIEW PAGE files & folders
	'view_image_list'=>'
		<li class="#EXTENSION #CLASS" title="#TITLE">
			<div class="buttons">
				<a class="close" title="'.$tooltip_close.'" onclick="suppr(\'#ID\');" href="#delete_box">&nbsp;</a>
				<a class="rename" title="'.$tooltip_rename.'" onclick="put_file_and_id(\'#ID\',\'#SLASHEDNAME\');"  href="#rename_box">&nbsp;</a>
				<a class="link" title="'.$tooltip_link.'" onclick="put_link(\'#ID\');" href="#link_box">&nbsp;</a>
				#ICONE_VISU
			</div>
			<a href="index.php?f=#ID" download="#FICHIER" >
				<img src="index.php?f=#ID&thumbs" style="background:transparent;"/>
				<em>#NAME</em> <em>[ #SIZE ko ]</em>
			</a>
		</li>
	',
	'view_file_list'=>'
		<li class="#EXTENSION #CLASS" title="#TITLE">
			<div class="buttons">
				<a class="close" title="'.$tooltip_close.'" onclick="suppr(\'#ID\');" href="#delete_box">&nbsp;</a>
				<a class="rename" title="'.$tooltip_rename.'" onclick="put_file_and_id(\'#ID\',\'#SLASHEDNAME\');"  href="#rename_box">&nbsp;</a>
				<a class="link" title="'.$tooltip_link.'" onclick="put_link(\'#ID\');" href="#link_box">&nbsp;</a>
				#ICONE_VISU
			</div>
			<a href="index.php?f=#ID" download="#FICHIER" >
				<img src="design/'.$_SESSION['theme'].'/img/ghost.png" class="#EXTENSION"/>
				<em>#NAME</em> <em>[ #SIZE ko ]</em>
			</a>
		</li>
	',
	'view_folder_list'=>'
		<li class="folder #CLASS" title="#TITLE">
			<div class="buttons">
				<a class="close" title="'.$tooltip_close.'" onclick="suppr(\'#ID\');" href="#delete_box">&nbsp;</a>
				<a class="rename" title="'.$tooltip_rename.'" onclick="put_file_and_id(\'#ID\',\'#SLASHEDNAME\');"  href="#rename_box">&nbsp;</a>
				<a class="link" title="'.$tooltip_link.'" onclick="put_link(\'#ID\');" href="#link_box">&nbsp;</a>
				<a class="zipfolder" title="'.$tooltip_zipfolder.'" href="admin.php?zipfolder=#ID&token='.$token.'">&nbsp;</a>
			</div>
			<a href="admin.php?path=#FICHIER&token=#TOKEN" >
				<img src="design/'.$_SESSION['theme'].'/img/folder.png" style="background:transparent;"/>
				<em>#NAME</em> <em class="over">[ #SIZE ]</em>
			</a>
		</li>
	',

	# MOVE PAGE files & folders
	'move_image_list'=>'
		<li class="#EXTENSION #CLASS" title="#TITLE">							
			<a href="#selecttarget" onclick="put_file(\'#SLASHEDFICHIER\')">
				<img src="index.php?f=#ID&thumbs" style="background:transparent;"/>
				<em>#NAME</em> <em>[ #SIZE ko ]</em>
			</a>
		</li>
	',
	'move_file_list'=>'
		<li class="#EXTENSION #CLASS" title="#TITLE">	
			<a href="#selecttarget" onclick="put_file(\'#SLASHEDFICHIER\')">
				<img class="#EXTENSION" src="design/'.$_SESSION['theme'].'/img/ghost.png"/>
				<em>#NAME</em> <em>[ #SIZE ko ]</em>
			</a>
		</li>
	',
	'move_folder_list'=>'
		<li class="folder #CLASS" title="#TITLE">
			<div class="buttons">
				<a class="movefolder" href="#selecttarget" title="'.e('Move this file to another directory',false).'" onclick="put_file(\'#SLASHEDFICHIER\')">&nbsp;</a>
			</div>
			<a href="admin.php?path=#FICHIER&token=#TOKEN" >
				<img src="design/'.$_SESSION['theme'].'/img/folder.png" style="background:transparent;"/>
				<em>#NAME</em>
			</a>
		</li>',

	# LINKS PAGE files & folders
	'links_image_list'=>'
		<li class="#EXTENSION #CLASS" title="#TITLE">
			<div class="buttons">
				<a class="locked" title="'.$tooltip_lock.'" href="#locked" onclick="put_id(\'#ID\')">&nbsp;</a>
				<a class="burn" title="'.$tooltip_burn.'" href="admin.php?burn=#ID&token=#TOKEN">&nbsp;</a>
				<a class="renew" title="'.$tooltip_renew.'" href="admin.php?renew=#ID&token=#TOKEN">&nbsp;</a>
			</div>
			<a href="index.php?f=#ID" download="#NAME">
				<img src="index.php?f=#ID&thumbs" style="background:transparent;"/>
				<em>#NAME</em> <em>[ #SIZE ko ]</em>
			</a>
		</li>
	',
	'links_file_list'=>'
		<li class="#EXTENSION #CLASS">						
			<div class="buttons" title="#TITLE">
				<a class="locked" title="'.$tooltip_lock.'" href="#locked" onclick="put_id(\'#ID\')">&nbsp;</a>
				<a class="burn" title="'.$tooltip_burn.'" href="admin.php?burn=#ID&token=#TOKEN">&nbsp;</a>
				<a class="renew" title="'.$tooltip_renew.'" href="admin.php?renew=#ID&token=#TOKEN">&nbsp;</a>
			</div>
			<a href="index.php?f=#ID" download="#NAME">
				<img class="#EXTENSION" src="design/'.$_SESSION['theme'].'/img/ghost.png"/>
				<em>#NAME</em> <em>[ #SIZE ko ]</em>
			</a>
		</li>
	',
	'links_folder_list'=>'
		<li class="folder #CLASS" title="#TITLE">
			<div class="buttons">
				<a class="locked" title="'.$tooltip_lock.'" href="#locked" onclick="put_id(\'#ID\')">&nbsp;</a>
				<a class="burn" title="'.$tooltip_burn.'" href="admin.php?burn=#ID&token=#TOKEN">&nbsp;</a>
				<a class="renew" title="'.$tooltip_renew.'" href="admin.php?renew=#ID&token=#TOKEN">&nbsp;</a>
			</div>
			<a href="admin.php?path=#FICHIER&token=#TOKEN" >
				<img src="design/'.$_SESSION['theme'].'/img/folder.png" style="background:transparent;"/>
				<em>#NAME</em> <em class="over">[ #SIZE ]</em>
			</a>
		</li>
	',
# ICONS
	# VIEW PAGE files & folders
	'view_image_icon'=>'
		<li class="#EXTENSION #CLASS" title="#TITLE">
			<div class="buttons">
				<a class="close" title="'.$tooltip_close.'" onclick="suppr(\'#ID\');" href="#delete_box">&nbsp;</a>
				<a class="rename" title="'.$tooltip_rename.'" onclick="put_file_and_id(\'#ID\',\'#SLASHEDNAME\');"  href="#rename_box">&nbsp;</a>
				<a class="link" title="'.$tooltip_link.'" onclick="put_link(\'#ID\');" href="#link_box">&nbsp;</a>
				#ICONE_VISU
			</div>
			<a href="index.php?f=#ID" download="#FICHIER" >
				<img src="index.php?f=#ID&thumbs" style="background:transparent;"/>
				<em>#SIZE ko</em><em>#NAME</em>
			</a>
		</li>
	',
	'view_file_icon'=>'
		<li class="#EXTENSION #CLASS" title="#TITLE">
			<div class="buttons">
				<a class="close" title="'.$tooltip_close.'" onclick="suppr(\'#ID\');" href="#delete_box">&nbsp;</a>
				<a class="rename" title="'.$tooltip_rename.'" onclick="put_file_and_id(\'#ID\',\'#SLASHEDNAME\');"  href="#rename_box">&nbsp;</a>
				<a class="link" title="'.$tooltip_link.'" onclick="put_link(\'#ID\');" href="#link_box">&nbsp;</a>
				#ICONE_VISU
			</div>
			<a href="index.php?f=#ID" download="#FICHIER" >
				<img src="design/'.$_SESSION['theme'].'/img/ghost.png" class="#EXTENSION"/>
				<em>#SIZE ko</em><em>#NAME</em>
			</a>
		</li>
	',
	'view_folder_icon'=>'
		<li class="folder #CLASS" title="#TITLE">
			<div class="buttons">
				<a class="close" title="'.$tooltip_close.'" onclick="suppr(\'#ID\');" href="#delete_box">&nbsp;</a>
				<a class="rename" title="'.$tooltip_rename.'" onclick="put_file_and_id(\'#ID\',\'#SLASHEDNAME\');"  href="#rename_box">&nbsp;</a>
				<a class="link" title="'.$tooltip_link.'" onclick="put_link(\'#ID\');" href="#link_box">&nbsp;</a>
				<a class="zipfolder" title="'.$tooltip_zipfolder.'" href="admin.php?zipfolder=#ID&token='.$token.'">&nbsp;</a>
			</div>
			<a href="admin.php?path=#FICHIER&token=#TOKEN" >
				<img src="design/'.$_SESSION['theme'].'/img/folder.png" style="background:transparent;"/>
				<em class="over">#SIZE</em><em>#NAME</em>
			</a>
		</li>
	',

	# MOVE PAGE files & folders 
	'move_image_icon'=>'
		<li class="#EXTENSION #CLASS" title="#TITLE">							
			<a href="#selecttarget" onclick="put_file(\'#SLASHEDFICHIER\')">
				<img src="index.php?f=#ID&thumbs" style="background:transparent;"/>
				<em>#SIZE ko</em><em>#NAME</em>
			</a>
		</li>
	',
	'move_file_icon'=>'
		<li class="#EXTENSION #CLASS" title="#TITLE">	
			<a href="#selecttarget" onclick="put_file(\'#SLASHEDFICHIER\')">
				<img class="#EXTENSION" src="design/'.$_SESSION['theme'].'/img/ghost.png"/>
				<em>#SIZE ko</em><em>#NAME</em>
			</a>
		</li>
	',
	'move_folder_icon'=>'
		<li class="folder #CLASS" title="#TITLE">
			<div class="buttons">
				<a class="movefolder" href="#selecttarget" title="'.e('Move this file to another directory',false).'" onclick="put_file(\'#SLASHEDFICHIER\')">&nbsp;</a>
			</div>
			<a href="admin.php?path=#FICHIER&token=#TOKEN" >
				<img src="design/'.$_SESSION['theme'].'/img/folder.png" style="background:transparent;"/>
				<em>#NAME</em>
			</a>
		</li>',

	# LINKS PAGE files & folders
	'links_image_icon'=>'
		<li class="#EXTENSION #CLASS" title="#TITLE">
			<div class="buttons">
				<a class="locked" title="'.$tooltip_lock.'" href="#locked" onclick="put_id(\'#ID\')">&nbsp;</a>
				<a class="burn" title="'.$tooltip_burn.'" href="admin.php?burn=#ID&token=#TOKEN">&nbsp;</a>
				<a class="renew" title="'.$tooltip_renew.'" href="admin.php?renew=#ID&token=#TOKEN">&nbsp;</a>
			</div>
			<a href="index.php?f=#ID" download="#NAME">
				<img src="index.php?f=#ID&thumbs" style="background:transparent;"/>
				<em>#SIZE ko</em><em>#NAME</em>
			</a>
		</li>
	',
	'links_file_icon'=>'
		<li class="#EXTENSION #CLASS">						
			<div class="buttons" title="#TITLE">
				<a class="locked" title="'.$tooltip_lock.'" href="#locked" onclick="put_id(\'#ID\')">&nbsp;</a>
				<a class="burn" title="'.$tooltip_burn.'" href="admin.php?burn=#ID&token=#TOKEN">&nbsp;</a>
				<a class="renew" title="'.$tooltip_renew.'" href="admin.php?renew=#ID&token=#TOKEN">&nbsp;</a>
			</div>
			<a href="index.php?f=#ID" download="#NAME">
				<img class="#EXTENSION" src="design/'.$_SESSION['theme'].'/img/ghost.png"/>
				<em>#SIZE ko</em><em>#NAME</em>
			</a>
		</li>
	',
	'links_folder_icon'=>'
		<li class="folder #CLASS" title="#TITLE">
			<div class="buttons">
				<a class="locked" title="'.$tooltip_lock.'" href="#locked" onclick="put_id(\'#ID\')">&nbsp;</a>
				<a class="burn" title="'.$tooltip_burn.'" href="admin.php?burn=#ID&token=#TOKEN">&nbsp;</a>
				<a class="renew" title="'.$tooltip_renew.'" href="admin.php?renew=#ID&token=#TOKEN">&nbsp;</a>
			</div>
			<a href="admin.php?path=#FICHIER&token=#TOKEN" >
				<img src="design/'.$_SESSION['theme'].'/img/folder.png" style="background:transparent;"/>
				<em class="over">#SIZE</em><em>#NAME</em>
			</a>
		</li>
	',



	);
?>
