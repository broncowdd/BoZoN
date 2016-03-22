<?php
$config_form['options']=array(
	'default_language' => available_languages(),
	'default_theme' => array('theme1','default'),
	'default_aspect' => array('icon','list'),
	'default_mode' => array('view','list'),

);

$config_form['help']=array(
	'default_language' => e('The language used by default',false),
	'default_theme' => e(' ',false),
	'default_aspect' => e('The way Bozon displays the files by default',false),
	'default_mode' => e('The Mode by défault: links or view',false),
	'gallery_thumbs_width' => e('in pixels',false),
	'show_back_button' => e('Displays the back button and the . and .. options',false),
	'default_max_lines_per_page_on_stats_page' => e('The maximum entries in the stat page',false),
	'default_limit_stat_file_entries' => e('The maximum entries in stat files',false),
	'default_max_files_per_page' => e('How much files bozon displays before the «load more» button',false),
	'disable_non_installed_libs_warning' => e(' ',false),
	'allow_folder_size_stat' => e('Allow Bozon to calculate the folders\'size (disable in case of slow down with a lot of files)',false),
	'allow_shared_folder_RSS_feed' => e('Visitor can access to RSS feed',false),
	'allow_shared_folder_JSON_feed' => e('Visitor can access to JSON feed',false),
	'allow_shared_folder_download' => e('Visitor can access to download',false),
	'click_on_link_to_download' => e('When the user clicks on the file, download it instead of open',false),
	'check_ID_base_on_page_load' => e('Updates and checks the ID base on every refresh. Disable if you see a slowdown',false),
	'allow_unknown_filetypes' => e('Allow the upload of unknown files types',false),
	'use_lightbox' => e('Use lightbox or open pictures in a new tab',false),
	'remove_item_from_users_share_when_renew_id' => e('When you click on renew id for a shared file, this file is no longer shared.',false),
	'default_profile_folder_max_size' => e(' ',false),
);

?>