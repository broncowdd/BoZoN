<?php
	/**
	* BoZoN basic config page:
	* change if you need
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	if(!ini_get('date.timezone') ){date_default_timezone_set("Europe/Paris");} # list of timezones here http://php.net/manual/en/timezones.php Europe/Paris Europe/Madrid Europe/London etc.

	$default_language=navigatorLanguage();
	// $default_language='en'; 		# change this if you want to force another language by default (see in lang.php)
	$default_path='uploads/'; 		# upload folder, change it BEFORE first start: once links are generated, if you change the path there are no longer available
	$default_id_file='private/id.php';		# IDs file name, change it BEFORE first start
	$default_stat_file='private/stats_log.php';	# stats file name, change it BEFORE first start
	$default_theme='default';	# you can make your own bozon design and set this variable with the folder skin's name inside the design folder
	$default_max_lines_per_page_on_stats_page=100;
	$default_limit_stat_file_entries=10000;
	$default_aspect='list'; // «icon»/«list»
?>
