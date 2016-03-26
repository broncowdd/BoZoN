<?php
	/**
	* BoZoN editor page:
	* edit and create markdown files
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	require_once('core/auto_restrict.php'); # Connected user only !
	require_once('core/markdown.php'); 
	if (!is_allowed('config page')){safe_redirect('index.php?p=admin&token='.TOKEN);}
	
?>

<div style="clear:both"></div>

<div id="config_page">
	<?php generate_config_form(conf());?>
</div>
