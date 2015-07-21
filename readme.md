# BoZoN

BUGS:
Fatal error: Call to undefined function mime_content_type() in /CHEMIN/BoZoN-master/index.php on line 14
Warning : Invalid argument supplied for foreach() in /CHEMIN/BoZoN-master/listfiles.php on line 24
Warning: unlink(./auto_restrict_files/) [function.unlink]: Is a directory in /CHEMIN/BoZoN-master/auto_restrict.php on line 301
Warning: Cannot modify header information - headers already sent by (output started at /CHEMIN/BoZoN-master/auto_restrict.php:301) in /CHEMIN/BoZoN-master/auto_restrict.php on line 270
You need a valid token to do that, boy !
si on up un fichier portant le même nom qu'un fichier déjà présent sur le serveur, le nouveau fichier écrase l'ancien.

## Minimalist Drag & drop file sharing app

- Install: just unzip on your server; no database/ php 5.2. Then go to admin.php page and create your login/pass. 
- Config: just change globals in the core.php file. 
- Upload a file: go to admin.php page, connect and then drop files in the dashed area... that's it !

The share link is the file link in the admin's view or you can access it by the button link on the file.

## Required 
Php 5 min

## New in version 1.4
- add: allow extension rename
- add: create subfolders
- add: share a folder
- add: user index.php page can list a shared folder content with share links
- add: allow subfolder navigation & upload
- add: direct subfolder item number on folder icon
- add: delete folders, sub folders and their content
- add: a share link button (click to prompt and ctrl+c the link)
- bugfix: glob fallback for php < 5.2 
- design: better icon placement on items
- add: a fork help text

## new in version 1.3 (actually still in beta testing but working):
- add: rename file is now possible
- add: upload a file using a fallback fileselect form
- add: get a local version of a distant file only with it's URL
- bugfix: search with only one result now return the result (!)
- bugfix: link to file contains the filename
- bugfix: ajax refreshing list problem (seems solved in almost all cases)

## new in version 1.2:
- add: filter/search on admin page
- add: language support (see lang.php to translate it to another language)
- change: design and logo
- change: upload form to personal d&d lib (auto_dropzone)
- update: auto_restrict to a better secured version
- update: auto_thumbnail to the last version

## TODO
- move a file to another folder
- add a config page (file status by default public/private, etc)
- change the uniqid rename system to a day-month-year-hour-minutes-seconds system
- some security enhancements
- maybe a «protected link» mode available only for one person (I'm just thinking ^^)
- serious tests on mobile devices (not done yet)
- manage a public file access on the index.php page (public/private button) maybe

## used libraries 
I only used a few libs I made
- auto_restrict : to easily lock access to a page and handle basic security features
- auto_thumbs : a function to generate all the thumbnails
- auto_dropzone : a lib that handle the drag and drop function only by including it in a script

## FAQ
- can't see icons / problems uploading / list refresh problem : take a look to access rights (folders / files)
- I want to change my password / I forgot my password ! : just use your FTP client and delete the *auto_restrict_files* folder, then try to login again and create a new login/pass.
