<?php
	/**
	* BoZoN basic config page:
	* change if you need
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	if(!ini_get('date.timezone') ){date_default_timezone_set("Europe/Paris");} # list of timezones here http://php.net/manual/en/timezones.php Europe/Paris Europe/Madrid Europe/London etc.
	$default_language='en';
	$debug_mode=false;
	if (function_exists('navigatorLanguage')){$default_language=navigatorLanguage();}
	
	#############################################################
	# Path config (change it BEFORE first start)
	#############################################################
	$default_path='uploads/'; 												# upload folder
	$default_private='private/'; 											# private folder
	$default_id_file=$default_private.'id.php';								# IDs file name
	$default_config_file=$default_private.'config.php';						# config file name
	$default_temp_folder=$default_private.'temp/';							# temp folder path 
	$default_users_rights_file=$default_private.'users_rights_file.php';	# IDs file name 
	$default_profiles_rights_file=$default_private.'profiles_rights.php';	# profiles rights file name 
	$default_folder_share_file=$default_private.'folder_share.php';			# IDs file name 
	$default_stat_file=$default_private.'stats_log.php';					# stats file name 
	$root=false;															# to force root url (in case of problem) change this to $root="URL";

	#############################################################
	# Aspect config
	#############################################################
	$default_theme='default';									# you can make your own bozon design and set this variable with the folder skin's name inside the design folder
	$default_aspect='list'; 									# «icon»/«list»
	$default_mode='view'; 
	$gallery_thumbs_width=256;
	$show_back_button=true;										# show previous folder button 

	#############################################################
	# Behaviour config
	#############################################################
	$default_files_to_echo='nfo,m3u,txt,js,html,php,SPHP,htm,shtml,shtm,css';
	$default_files_to_return='md,jpg,jpeg,gif,png,mp3,mp4,svg,pdf';
	$default_max_lines_per_page_on_stats_page=100;
	$default_limit_stat_file_entries=10000;
	$default_max_files_per_page=100;	
	$clean_temp_folder_time=1800;								# time (in seconds) between two temp folder cleaning process
	$disable_non_installed_libs_warning=false;											
	$allow_folder_size_stat=true;								# show folder size (put false if you have a big slowdown with huge amount of files) 
	$allow_shared_folder_RSS_feed=true;							# Visitor can access to the rss feed of a shared folder 
	$allow_shared_folder_JSON_feed=true;						# Visitor can access to the json feed of a shared folder 
	$allow_shared_folder_download=true;							# Visitor can download a shared folder as a zip
	$click_on_link_to_download=true;							# true= download a file by clicking on it, false= open file in new tab (img/pdf etc)
	$check_ID_base_on_page_load=false;							# true= the base will be checked for deleted files / added files and problems with IDs on each page load: put false if you see a slow down when you have a huge amout of files and folders.
	$allow_unknown_filetypes=true;								# true= allow exotic filetypes (when filetype mime is not recognised)
	$use_lightbox=true;											# false= view in a new tab
	$remove_item_from_users_share_when_renew_id=false;			# false= id will be updated in share file, true= id will be removed from share file
	$max_length=2048;							// Mo (see php.ini if changes doesn't work [post_max_size / upload_max_filesize])

	#############################################################
	# Profiles config
	#############################################################
	$default_profile_folder_max_size=50; 						# false = infinite or specify in MB
	
	#############################################################
	# Misc
	#############################################################
	$cron_security_string='aQw1zSx2eDc3rFv4';					# basic security access: change it. cron url is: www.myserver.com/?cron_update=aQw1zSx2eDc3rFv4

?>
