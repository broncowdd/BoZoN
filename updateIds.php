<?php
include_once('core.php');
if ($handle = opendir('./uploads')) {
	while (false !== ($entry = readdir($handle))) {
		if(!is_dir('./uploads/'.$entry) && !in_array(strtolower($entry),$ids) && $entry != 'index.html'){
			$ids[uniqid()]=strtolower($entry);
			store(ID_FILE,$ids);
		}
	}
	closedir($handle);
}

?>
