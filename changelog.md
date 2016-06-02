
# Version history

## New in build 15
- Change: The layout icons (list/icons) are now just one icon (the current layout icon desapears)
- Added : an import function to get a shared folder/file from another instance of BoZoN.
- Added : Access type in stats (From Website, RSS feed, Json or Export)

## New in build 13-14
- bugfixes
- Added : cron job update for IDs (#158): use www.myserver.com/?cron_update=$cron_security_string (see config.php)

## New in 2.4 (build 12)
- bugfix : close #144

## New in 2.4 (build 10-11)
- Added : new profiles rights: move files, rename files, delete files, create subfolder
- Added : shared files with others unsers (like folder share)

## New in 2.4 (build 9)
- Added : you can add a readme.md file in gallery or playlist folders to add some informations; the readme.md content will be displayed in the public share page.

## New in 2.4 (build 5 - 8)
- Bugfixes

## New in 2.4 (build 4)
- bugfix : burn mode is no longer a problem \o/
- bugfix : refresh bug on users page
- better upload zone behaviour when drag over
- Added : a config page
- Added : file type column (idea from jerrywham )
- Added : new header from #122 & #121 (Pluxopolis) Manually added because of changes. Thx ^^
- close #118
- close #115
- close #109
- close #108

## New in 2.4 (build 3)
- bugfix : files no longer appears twice
- pdf now displays correctly in the browser
- better upload zone behaviour when drag over

## New in 2.4 (build 2)
- bugfix on lightbox with firefox #108
- missing traduction fr/es #103
- bugfix on share files change #102
- bugfix for password generation 
- enhancement: lock folder with password now with a paswword input and confirm.

Upcoming: more bugfixes and a *REAL* *USER FRIENDLY* config page 

## New in 2.4
- optimisation : reduce slow down when folder tree contains a huge amount of files (tested with more than 30,000 files ^^ thx to Cyrille)
- optimisation : reduce regen base use to reduce useless files scans (even for zip to folder option)
- Added : volume option for playlist
- Enhancement : unzipping file on server creates a new folder
- Added : zip and download selection of files and folders
- Added : in public access to a folder can now fold/unfold the folders.
- Added : a regen base button for the admins who use FTP access instead of the bozon's upload (adds the new IDs, removes the old one and rebuilds the tree)
- Added : a temp cleaning procedure
- Added : a $default_temp_folder variable in config.php
- Added : a load more button in admin list files (for those who save thousands of files in the same directory ^^ wink to Cyrille (again)) 
- Added : a config variable to choose between two click on file options.
- Enhancement : change some js functions to use my own vanillajs lib
- Enhancement : share button will no longer appear when there's only one user
- Enhancement : Some little changes in the design
- Bugfix : the locked folder now works again correctly
- Added : language choice is now saved in the user profile
- Added : three status for users (admin/user/guest). The first user created is now superadmin.
- Enhancement : the drag and drop fallback now accepts multiselection
- Added : a markdown editor to quickly create a new document and share it or edit a text file (still a beta feature but it works)
- Enhancement : users page is now available only if there's more than one user
- Enhancement : users page design
- Enhancement : change png icons to webfont (thx fontello ^^) 56k -> 9k \o/
- Enhancement : change users management page (tabs instead of dialog boxes) 
- Added : Superadmin can now change the user's password
- Added : brand new profiles rights managing; now, you can create new profiles and allow acces to specific parts of the app to those profiles.
- Added : . and .. in file list 
- Added : download a zip from a shared folder on visitor's access
- Added : config variable to allow or not rss/json/download from user shared access
- Added : warnings if required libs are not installed; however, bozon can work without those libs (some functions will be disabled) and if you want to disable those warnings, go to config.php and set $disable_non_installed_libs_warning to true
- Bugfix : encoding accents problems
- Bugfix : refresh needed when adding or deleting a user
- Added : config variable to use lightbox or new tab to open images/txt etc
- Enhancement : lightbox 
- Bugfix : shared links works again
- Enhancement/Bugfix : when you renew a shared folder id, the id will change in the shared file or  will be removed from it (see $remove_item_from_users_share_when_renew_id in config.php)


## New in 2.3b
- Added : folder size limit for users (if there's no limit, the free space icon will not display)
- Added : display free space in user's folder (this information will not display if admin or if allowed free space is set to 0)
- Added : display folder size
- Added : lazy load for gallery http://dinbror.dk/blazy/
- Added : a minimalist lightbox
- Bugfixes : links lost when moving a file/folder, video name in gallery mode...
- Enhancement : brand new html/css structure by Eauland.
- Enhancement : new table based file list
- Added : some information on homepage
- Added : qrcode on share page
- Added : playlist audio. If a folder only contains mp3/ogg, it'll be shared as a playlist
- Added : a shortcut to share link in links mode
- Added : an icon to go directly to a gallery or a playlist in file mode
- Changed : the dropzone is now hidden by default: click on upload button or drag a file on it to reveal the dropzone
- Added : an option to easily change the colors: just change the values in template/default/css/styles.php !
- Changed : color 
- Removed : old time forgotten javascript in stats.php
- Added : scrolltotop from Cyril MAGUIRE
- Added : download from url allows to specify a local filename
- Added : a required state for important fields in dialog boxes
- Bugfix : remove exif error on thumb generation
- Added : sorting filelist by name or size
- Enhancement : A burn mode id stays in burn mode when accessed by the connected owner (id will be burned only if not connected or not owner)
- Bugfix : security bug
- Added : multiselection to delete files/folders

## New in 2.2beta
- Added : double check for the password on profile creation
- Added : password change for user connected
- Added : markdown display for md files 
- Added : qrcode to easily get a share on smartphone 
- Added : secured rss feed for log file
- Added : share folders between users \o/
- Added : changes on files/folders only allowed to the owner
- Bugfixes: htaccess problems, catching distant file path problem, some css problems

## New in 2.1
### /!\ Read carefully to avoid data loss !
- added a top bar menu
- added a minimalist auto gallery function: when a folder contains only images, it will be displayed as a gallery for the user.
- bug fix on rss feed and share links
- Added multiuser capacity ! Now, the admin (the first user) can create new users. Each user has his own separated upload folder.
- Added a import script: beacause of multiuser change, the ID file, the upload folder, the users data has a new format...
If you're upgrading from 2.0 or less, keep only private and upload folders, install bozon. 
When you first start, it will ask you if you want to import previous data.

## New in 2.0 beta
- major changes in bozon's structure: all is called from index page
- real home page
- major design improvements: lighter, no more menu etc.
- bugfixes
- all pages'files are now in the template folder (easier to modify)
- html files replace the variable template (easier for designers ;-) 
- language files are now seperated in a locale folder
- language can now also be changed in user mode (not only admin)
- default language: set at browser default if not specified in config

## New in 1.7.5b
- added a function to erase no longuer used ids
- bugfix with file with accent on first char: a basename function bug ! oO

## New in 1.7.5
- change in the templates: templates are now html files, easier to modify
- added the mode in the file list's title.


## New in 1.7.4
bug fixes (thx to chatainsim on Github)
- #56: problem deleting a folder
- #53: error deleting files you just uploaded
- #55: password protection problem when a password is used for several files (caution, this fix is not compatible with old password protection)
- disapearing files and folders until page is refreshed.
- my blog's URL removed (too «hasbeen»: wink to eauland ;-)


## New in 1.7.3
- some bugs fixed (rename bug, home icon bug)
- little changes on resolutions below 600 (switch from icon to list view)
- added handheld rule for media queries


## New in 1.7.2
- new list layout (change layout in config or in menu)
- change theme with get variable theme=xxx
- 

## New in 1.7
* serious security enhancement by Oros ( https://www.ecirtam.net / https://github.com/Oros42 ) (Thanks a lot for this huge job !)
* add: a link to clear stats
* BEWARE! Because of the new data & files structure, all previous generated IDs will no longer be valid. 
