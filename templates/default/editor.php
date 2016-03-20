<?php
	/**
	* BoZoN editor page:
	* edit and create markdown files
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	require_once('core/auto_restrict.php'); # Connected user only !
	require_once('core/markdown.php'); 
	if (!is_allowed('markdown editor')){safe_redirect('index.php?p=admin&token='.TOKEN);}
	if (isset($_GET['overwrite'])){$overwrite='<input type="hidden" name="overwrite" value="1"/>';}else{$overwrite='';}
?>

<div style="clear:both"></div>

<div id="editor_page">
	
	<h1><?php e('Path:');echo ' '.$_SESSION['upload_user_path'].$_SESSION['current_path'];?></h1>
	<div class="tab_space">
		<form action="#" method="POST" id="editor_form">
		<ul class="tabs">
			<li class="btn active" data-target=".editor_tab"><span class="icon-pencil"></span> <?php e('Write');?></li>
			<li class="btn" data-target=".result_tab" id="see"><span class="icon-eye"></span> <?php e('See');?></li>
			<li class="btn" data-target=".help_tab"><span class="icon-help-circled"></span> <?php e('Help');?></li>
		</ul>
		<div class="dialog"><figure><figcaption>
			
		    <div class="editor_tab">
				<input type="text" class="npt" name="editor_filename" class="npt" value="<?php if (isset($file)){echo _basename($file);}?>" required placeholder="<?php e('Filename');?>"/>
			    <textarea name="editor_content" id="raw" class="npt"><?php if (isset($editor_content)){echo $editor_content;}?></textarea>
			    <input type="submit" class="btn" value="<?php e('Save');?>"/>
		    </div>
		    <input type="hidden" name="token" value="<?php newToken(TRUE);?>"/>
		    <?php echo $overwrite;?>
		    <div class="result_tab hidden"><div id="visu" class="markdown"></div></div>
		    <div class="help_tab hidden"><?php echo nl2br(str_replace(' ','&nbsp;',e('markdown_help',false)));?></div>
		    

		</figcaption></figure></div>
		</form>
	</div>
</div>

<script type="text/javascript" src="core/js/marked.js"></script>
<script>
visu=document.getElementById('visu');
raw=document.getElementById('raw');
marked.setOptions({
  renderer: new marked.Renderer(),
  gfm: true,
  tables: true,
  breaks: true,
  pedantic: false,
  sanitize: true,
  smartLists: true,
  smartypants: true
});
	on('click','#see',function(){
		var input = raw.value;
    	visu.innerHTML = marked(input);
	});
	on('click',visu,function(){
		toggleClass(visu,'hidden');
	});
	on('submit','#editor_form',function(){
		txtarea=document.getElementById('editor_content');
		editorarea=document.getElementById('editor');
		txtarea.value=editor.toMd();
	});
	on("click","li[data-target]",function(){
		target=attr(this,"data-target");
		addClass("figcaption>div","hidden");
		removeClass(target,"hidden");
		removeClass("li[data-target]","active");
		addClass(this,"active");
	});

</script>