# BoZoN

## Minimalist Drag & drop file sharing app

- Install: just unzip on your server; no database/ php 5.2. Then go to index.php?p=admin page and create your login/pass. 
- Config: just change config.php file. 
- Upload a file: go to index.php?p=admin page, connect and then drop files in the dashed area... that's it !
- Organize files & folders, share them, manage the shared access etc.

The share link is the file link in the admin's view (you can also access it by the button link on the file or the folder.)

## Required 
Php 5 or +, php5-gd, ZipArchive

## used libraries 
- sorttables.js (http://www.kryogenix.org/code/browser/sorttable/)
- lightbox.js (http://lokeshdhakar.com/projects/lightbox2/)

## Licence
All Bozon code and all the libs used in it are distributed under AGPL: feel free to fork, adapt, distribute, comment etc but please, keep your fork free too ;-)

## FAQ
- _I want to add a user_ : There's a [New user] link in the admin's page top menu, click on it and put a login/pass
- _I want to remove a user_ : Click on the [Users list] link in the admin's page top menu, check the user(s) you want to remove and click on ok.
- _I've changed some config variables and nothing appends !_ : that's not an issue; all variables are in the Session, so you need to restart chromium/firefox/opera etc to see the changes 
- _can't see icons / problems uploading / list refresh problem_ : take a look to access rights (folders / files)
- _I want to change my password / I forgot my password !_ : There's a new option for it in 2.2.
- _I want to change the default language !_ : see in config.php file you can set fr/en/es but you can also make your own traduction (see in lang.php). Don't forget to logout & login to reset Session vars.
- _I don't want a stolen link works anymore (but I don't want to delete the file/folder) !_ : in links mode, click on the regen button (recycle icon) and the share link for this item will automatically change.
- _How to lock a share link with a password ?_ : click on the left menu, use the manage links button; then click on the lock icon on the file/folder and give an password. The file/folder will turn blue with a small lock meaning nobody can now use the share link without the password.
- _Yes, ok, but how to remove the password ?_ : just click on regen button, the id will be regenerated and the password will be destroyed (the share link will change)
- _What if I upload, create a folder or move an item with a name conflict ?_ : Don't worry, BoZoN will just rename the file to avoid overwriting.
- _How to create my own skin ?_ : just copy the default folder in design/ and make the changes you want, then change the config.php ($default_theme='default';).S Don't forget to logout & login to reset Session vars.
- _How to upload a complete folder with subfolders in one time ?_ : make a zip, upload it and use the convert icon (a folder) The uploaded zip will be unzipped on the server and all files and directory structure will be restored.
