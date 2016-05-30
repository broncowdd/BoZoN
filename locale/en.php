<?php
##################################################
# en
##################################################

$lang=array(

##################################################
# ./core/auto_dropzone.php
##################################################
#     "Drop your files here or click to select a local file" => "",
#     "Error, max filelength:" => "",
#     ": Error, forbidden file format !" => "",
#     "The file to big for the server\'s config" => "",
#     "The file to big for this page" => "",
#     "There was a problem during upload (file was truncated)" => "",
#     "No file upload" => "",
#     "No temp folder" => "",
#     "Write error on server" => "",
#     "The file doesn\'t fit" => "",
#     "Upload error" => "",

##################################################
# ./core/auto_restrict.php
##################################################
#     "Account created:" => "",
#     "New password saved for " => "",
#     "Error saving new password for " => "",
#     "Changes saved" => "",

##################################################
# ./core/commands_GET_vars.php
##################################################
#     "Rss feed of stats" => "",

##################################################
# ./core/config_form_help.php
##################################################
#     "The language used by default" => "",
#     " " => "",
#     "The way Bozon displays the files by default" => "",
#     "The mode by default: links or view" => "",
#     "in pixels" => "",
#     "Displays the back button and the . and .. options" => "",
#     "The maximum entries in the stat page" => "",
#     "The maximum entries in stat file" => "",
#     "How much files bozon displays before the «load more» button" => "",
#     "Allow Bozon to calculate the folders\'size (disable in case of slow down with a lot of files)" => "",
#     "Visitor can access to RSS feed" => "",
#     "Visitor can access to JSON feed" => "",
#     "Visitor can access to download" => "",
#     "When the user clicks on the file, download it instead of open" => "",
#     "Updates and checks the ID base on every refresh. Disable if you see a slowdown" => "",
#     "Allow the upload of unknown files types" => "",
#     "Use lightbox or open pictures in a new tab" => "",
#     "When you click on renew id for a shared file, this file is no longer shared." => "",
#     "List of files to open directly in your browser (separate with commas)" => "",
#     "List of files to display as a text file (separate with commas)" => "",

##################################################
# ./core/core.php
##################################################
#     "Private folder is not writable" => "",
#     "Private folder is not readable" => "",
#     "Temp folder is not writable" => "",
#     "Temp folder is not readable" => "",
#     "Problem accessing tree folder: not readable" => "",
#     "Problem accessing tree/folder file: not writable" => "",
#     "Problem accessing " => "",
#     ": folder not readable" => "",
#     ": folder not writable" => "",
#     "is not installed on this server" => "",
#     "More info" => "",
#     "Problem accessing ID file: not readable" => "",
#     "Problem accessing ID file: not writable" => "",
#     "Problem accessing stats file: not readable" => "",
#     "Problem accessing stats file: not writable" => "",
#     "Logout" => "",
#     "Connection" => "",
#     "See as icon" => "",
#     "See as file list" => "",
#     "Manage files" => "",
#     "Manage links" => "",
#     "Deleted" => "",
#     "free" => "",
#     "Yes" => "",
#     "No" => "",
#     "text" => "",

##################################################
# ./core/GET_POST_admin_data.php
##################################################
#     "is not writable" => "",
#     "created" => "",
#     "Problem accessing remote file." => "",
#     "moved to" => "",
#     "Changes saved" => "",

##################################################
# ./core/listfiles.php
##################################################
#     "The user can access this only one time" => "",
#     "The user can access this only with the password" => "",
#     "View this share" => "",
#     "View this file" => "",
#     "Edit this file" => "",
#     "Share this item with another user" => "",
#     "Convert this zip file to folder" => "",
#     "Check all" => "",
#     "Filename" => "",
#     "Filesize" => "",
#     "Filetype" => "",
#     "Foldersize" => "",
#     "Load" => "",
#     "more" => "",
#     "No file or folder" => "",

##################################################
# ./core/share.php
##################################################
#     "This share is protected, please type the correct password:" => "",
#     "This page in" => "",
#     "Download a zip from this folder" => "",
#     "This link is no longer available, sorry." => "",
#     "Rss feed of " => "",

##################################################
# ./core/templates.php
##################################################
#     "Delete this file" => "",
#     "Get the share link" => "",
#     "Get the qrcode of this link" => "",
#     "Rename this file (share link will not change)" => "",
#     "Put a password on this share" => "",
#     "Turn this share into a burn after access share" => "",
#     "Regen the share link" => "",
#     "Download a zip from this folder" => "",
#     "Move file or folder" => "",
#     "Move to" => "",
#     "Move" => "",
#     "To" => "",
#     "Lock access" => "",
#     "Please give a password to lock access to this file" => "",
#     "Rename this file?" => "",
#     "Rename this item?" => "",
#     "Rename" => "",
#     "Delete this item?" => "",
#     "Delete" => "",
#     "Share item" => "",
#     "Share link" => "",
#     "Select the users you want to share with" => "",
#     "Copy this share link" => "",
#     "Yes" => "",
#     "Move this file to another directory" => "",
#     "Create a subfolder" => "",
#     "Create a subfolder in this folder" => "",
#     "New folder" => "",
#     "Paste a file\'s URL" => "",
#     "Paste a file\'s URL to get it on this server" => "",
#     "Read m3u playlist" => "",
#     "Force local filename (leave empty=no change)" => "",
#     "filename (optionnal)" => "",

##################################################
# ./index.php
##################################################
#     "Click to remove" => "",

##################################################
# ./templates/default/admin.php
##################################################
#     "Choose a folder" => "",
#     "Root:" => "",
#     "Filter:" => "",
#     "Create a subfolder in this folder" => "",
#     "Paste a file\'s URL to get it on this server" => "",
#     "Delete selected items" => "",
#     "Zip and download selected items" => "",

##################################################
# ./templates/default/editor.php
##################################################
#     "Path:" => "",
#     "Write" => "",
#     "See" => "",
#     "Help" => "",
#     "Filename" => "",
#     "Save" => "",
    "markdown_help" => "# Title  1
		## Title  2
		### Title  3
		#### Title  4
		##### Title  5
		###### Title  6

		*italic* or _italic_
		**bold** or __bold__
		**_bold italic_**
		~~strike~~

		1. First ordered list item
		2. Another item
		⋅⋅* Unordered sub-list. 
		1. Actual numbers doesn't matter, just that it's a number
		⋅⋅1. Ordered sub-list
		4. And another item.
		⋅⋅⋅You can have properly indented paragraphs within list items. Notice the blank line above, and the leading spaces (at least one, but we'll use three here to also align the raw Markdown).

		⋅⋅⋅To have a line break without a paragraph, you will need to use two trailing spaces.⋅⋅
		⋅⋅⋅Note that this line is separate, but within the same paragraph.⋅⋅
		⋅⋅⋅(This is contrary to the typical GFM line break behaviour, where trailing spaces are not required.)

		* Unordered list can use asterisks
		- Or minuses
		+ Or pluses

		Links
		[I'm an inline-style link](https://www.google.com)

		[I'm an inline-style link with title](https://www.google.com 'Google's Homepage')

		[I'm a reference-style link][Arbitrary case-insensitive reference text]

		[I'm a relative reference to a repository file](../blob/master/LICENSE)

		[You can use numbers for reference-style link definitions][1]

		Or leave it empty and use the [link text itself].

		URLs and URLs in angle brackets will automatically get turned into links. 
		http://www.example.com or <http://www.example.com> and sometimes 
		example.com (but not on Github, for example).

		Some text to show that the reference links can follow later.

		[arbitrary case-insensitive reference text]: https://www.mozilla.org
		[1]: http://slashdot.org
		[link text itself]: http://www.reddit.com

		Images
		Inline-style: 
		![alt text](https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png 'Logo Title Text 1')

		Reference-style: 
		![alt text][logo]

		[logo]: https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png 'Logo Title Text 2'

		Code
		```javascript
		var s = 'JavaScript syntax highlighting';
		alert(s);
		```

		| Tables        | Are           | Cool  |
		| ------------- |:-------------:| -----:|
		| col 3 is      | right-aligned | $1600 |
		| col 2 is      | centered      |   $12 |
		| zebra stripes | are neat      |    $1 |

		> Blockquotes are very handy in email to emulate reply text.
		> This line is part of the same quote.

		Horizontal rules
		Three or more...

		---	Hyphens
		***	Asterisks
		___	Underscores
		",

##################################################
# ./templates/default/edit_profiles.php
##################################################
#     "New profile" => "",

##################################################
# ./templates/default/footer.php
##################################################
#     "Fork me on github" => "",

##################################################
# ./templates/default/header.php
##################################################
#     "Drag, drop, share." => "",
#     "Home" => "",
#     "Edit profiles rights" => "",
#     "Configure Bozon" => "",
#     "Users list" => "",
#     "New user" => "",
#     "Access log file" => "",
#     "Change password" => "",
#     "Rebuild base" => "",
#     "Text editor" => "",
#     "Click or dragover to reveal dropzone" => "",
#     "Upload" => "",
#     "Connect" => "",
#     "Search in the uploaded files" => "",
#     "Filter" => "",
#     "Markdown editor" => "",
#     "Access log" => "",
#     "Create an account" => "",
#     "Please, login" => "",
#     "Users profiles" => "",
#     "Configure profiles rights" => "",
#     "Manage links" => "",
#     "Manage files" => "",

##################################################
# ./templates/default/header_markdown.php
##################################################
#     "Drag, drop, share." => "",

##################################################
# ./templates/default/home.php
##################################################
#     "BoZoN is a simple filesharing app." => "",
#     "Easy to install, free and opensource" => "",
#     "Just copy BoZoN\'s files onto your server. That\'s it." => "",
#     "You can freely fork BoZoN and use it as specified in the AGPL licence" => "",
#     "More info" => "",
#     "Easy to use!" => "",
#     "Drag the file you want to share to upload it to the server" => "",
#     "Share the link with your friends" => "",
#     "BoZoN can do more!" => "",
#     "No database required: easy to backup or move to a new server." => "",
#     "Lock the access to the file/folder with a password." => "",
#     "Share a file or a folder with a unique access link with the «burn mode»:" => "",
#     "Renew a share link with a single click" => "",
#     "Download a folder\'s contents into a zip" => "",
#     "Access BoZoN on a smartphone without an app: your browser is enough" => "",
#     "Use a qrcode to share your link with smartphone users." => "",
#     "Add and remove users as well as manage their rights." => "",
#     "To upload a folder, just zip and upload it: with one click it will be turned into a folder on the server." => "",
#     "Modify the templates & style to make your own BoZoN" => "",

##################################################
# ./templates/default/login.php
##################################################
#     "Login" => "",
#     "New account" => "",
#     "Change password" => "",
#     "Please, login" => "",
#     "This login is not available, please try another one" => "",
#     "Wrong combination login/pass" => "",
#     "Problem with admin password." => "",
#     "Account created:" => "",
#     "Password changed" => "",
#     "User:" => "",
#     "Old password" => "",
#     "Password" => "",
#     "Repeat password" => "",
#     "Stay connected" => "",

##################################################
# ./templates/default/stats.php
##################################################
#     "No stats" => "",
#     "Date" => "",
#     "File" => "",
#     "Owner" => "",
#     "IP" => "",
#     "Origin" => "",
#     "Host" => "",
#     "Delete all stat data" => "",
#     "Export log:" => "",

##################################################
# ./templates/default/users.php
##################################################
#     "Delete" => "",
#     "Status" => "",
#     "Space" => "",
#     "Password" => "",
#     "Check users to delete account and files" => "",
#     "Select new status for the users" => "",
#     "User" => "",
#     "Admin" => "",
#     "Configure folders max size" => "",
#     "Change users\'passwords" => "",
#     "Double-clic to generate a password" => "",

);
?>