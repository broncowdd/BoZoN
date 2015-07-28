# BoZoN

## Minimalist Drag & drop file sharing app

- Install: just unzip on your server; no database/ php 5.2. Then go to admin.php page and create your login/pass. 
- Config: just change globals in the core.php file. 
- Upload a file: go to admin.php page, connect and then drop files in the dashed area... that's it !

The share link is the file link in the admin's view or you can access it by the button link on the file.

## Required 
Php 5 min

## New in this version 1.4.1
- add: a move file/folder mode (access with left menu)
- add: new left-side menu (group all options inside)
- add: a github link (wink Cyrille ;-)
- bug fix: download problem with links of files geater than 1go
- bug fix: better detection of too big files upload atempts
- bug fix: better error detection with file selection fallback
- add:visualiser et rendre le lien téléchargeable (download="")
- add: active state on active language link
- bugfix: disable dropzone during upload


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

## used libraries 
I only used a few libs I made
- auto_restrict : to easily lock access to a page and handle basic security features
- auto_thumbs : a function to generate all the thumbnails
- auto_dropzone : a lib that handle the drag and drop function only by including it in a script

## FAQ
- can't see icons / problems uploading / list refresh problem : take a look to access rights (folders / files)
- I want to change my password / I forgot my password ! : just use your FTP client and delete the *auto_restrict_files* folder, then try to login again and create a new login/pass.
