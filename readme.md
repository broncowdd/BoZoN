BoZoN
Minimalist Drag & drop file sharing app

Install: just unzip on your server; no database/ php 5.2. Then go to admin.php page and create your login/pass. Config: just change globals in the core.php file. 
Upload a file: go to admin.php page, connect and then drop files in the dashed area... that's it !

The share link is the file link in the admin's view.


# new in this version:
add filter/search on admin page
add language support (see lang.php to translate it to another language)
change design and logo
change upload form to personal d&d lib (auto_dropzone)
update auto_restrict to a better secured version
update auto_thumbnail to the last version


# used libraries 
I only used a few libs I made
- auto_restrict : to easily lock access to a page and handle basic security features
- auto_thumbs : a function to generate all the thumbnails
- auto_dropzone : a lib that handle the drag and drop function only by including it in a script

