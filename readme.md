# BoZoN



## Minimalist Drag & drop file sharing app

- Install: just unzip on your server; no database/ php 5.2. Then go to admin.php page and create your login/pass. 
- Config: just change config.php file. 
- Upload a file: go to admin.php page, connect and then drop files in the dashed area... that's it !
- Organize files & folders, share them, manage the shared access etc.

The share link is the file link in the admin's view (you can also access it by the button link on the file.)

## Required 
Php 5 min and php5-gd


## New in 1.7
* serious security enhancement by Oros ( https://www.ecirtam.net / https://github.com/Oros42 ) (Thanks a lot for this huge job !)
* add: a link to clear stats

## New in 1.6.3
* added stats page

## New in 1.6.2
* security bugfix

## New in version 1.6.1
* elementaryOS theme/skin
* bugfix: #22 & #23

## New in version 1.6
* skin system to easily create your own theme 
* bugfix: timezone error
* add: tooltips on buttons
* add: explaination on how to remove password
* add: use navigator language by default
* add: turn uploaded zip into a folder

## New in version 1.5
- add: a links mode 
- add: a password protected share acces
- add: a burn after access share mode: user can only acces the ressource one time
- add: button in links mode, regen id for a file
- add: rss feed for a folder share (bottom's index.php page)
- add: json output link for shared folder content list (interoperability)
- add: basic config file
- bugfix: problem in some [exotic] server configs causing issues with mime type (personnal wink & thanks to Cyrille Borne for the help)
- bugfix: free.fr hosting users can now install and use BoZoN ;-)

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
I used a few libs I made
- auto_restrict : to easily lock access to a page and handle basic security features
- auto_thumbs : a function to generate all the thumbnails
- auto_dropzone : a lib that handle the drag and drop function only by including it in a script
- Array2feed.php : a function used to convert an array into a RSS feed without commiting suicide XD

and sorttables.js (http://www.kryogenix.org/code/browser/sorttable/)

## Licence
All Bozon code and all the libs used in it are distributed under AGPL: feel free to fork, adapt, distribute, comment etc but please, keep your fork free too ;-)

## FAQ
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
