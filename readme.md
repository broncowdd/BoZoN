# BoZoN



## Minimalist Drag & drop file sharing app
( http://bozon.warriordudimanche.net/ )
- Install: just unzip on your server; no database/ php 5.2. Then go to index.php?p=admin page and create your login/pass. 
- Config: just change config.php file. 
- Upload a file: go to index.php?p=admin page, connect and then drop files in the dashed area... that's it !
- Organize files & folders, share them, manage the shared access etc.

The share link is the file link in the admin's view (you can also access it by the button link on the file or the folder.)

## Required 
Php 5 min, php5-gd, ZipArchive

# Version history

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

## used libraries 
I used a few libs I made
- auto_restrict : to easily lock access to a page and handle basic security features
- auto_thumbs : a function to generate all the thumbnails
- auto_dropzone : a lib that handle the drag and drop function only by including it in a script
- Array2feed.php : a function used to convert an array into a RSS feed without commiting suicide XD

and sorttables.js (http://www.kryogenix.org/code/browser/sorttable/)

## Licence
All Bozon code and all the libs used in it are distributed under AGPL: feel free to fork, adapt, distribute, comment etc but please, keep your fork free too ;-)

## FAQ
- _I want to add a user_ : There's a [New user] link in the admin's page top menu, click on it and put a login/pass
- _I want to remove a user_ : Click on the [Users list] link in the admin's page top menu, check the user(s) you want to remove and click on ok.
- _I've changed some config variables and nothing appends !_ : that's not an issue; all variables are in the Session, so you need to restart chromium/firefox/opera etc to see the changes 
- _can't see icons / problems uploading / list refresh problem_ : take a look to access rights (folders / files)
- _I want to change my password / I forgot my password !_ : just use your FTP client and delete «private/auto_restrict*.php» files, then try to login again and create a new login/pass.
- _I want to change the default language !_ : see in config.php file you can set fr/en/es but you can also make your own traduction (see in lang.php)
- _I don't want a stolen link works anymore (but I don't want to delete the file/folder) !_ : in links mode, click on the regen button (recycle icon) and the share link for this item will automatically change.
- _How to lock a share link with a password ?_ : click on the left menu, use the manage links button; then click on the lock icon on the file/folder and give an password. The file/folder will turn blue with a small lock meaning nobody can now use the share link without the password.
- _Yes, ok, but how to remove the password ?_ : just click on regen button, the id will be regenerated and the password will be destroyed (the share link will change)
- _What if I upload, create a folder or move an item with a name conflict ?_ : Don't worry, BoZoN will just rename the file to avoid overwriting.
- _How to create my own skin ?_ : just copy the default folder in design/ and make the changes you want, then change the config.php ($default_theme='default';)
- _How to upload a complete folder with subfolders in one time ?_ : make a zip, upload it and use the convert icon (a folder) The uploaded zip will be unzipped on the server and all files and directory structure will be restored.

## Special thanks
To Cyrille Borne [ https://github.com/cborne & http://www.cyrille-borne.com ]: without your comments, issues reporting and enhancement ideas this app would never have been so complete ;-)
