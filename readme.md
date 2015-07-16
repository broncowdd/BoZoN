# BoZoN

## Minimalist Drag & drop file sharing app

- Install: just unzip on your server; no database/ php 5.2. Then go to admin.php page and create your login/pass. 
- Config: just change globals in the core.php file. 
- Upload a file: go to admin.php page, connect and then drop files in the dashed area... that's it !

The share link is the file link in the admin's view.


# new in version 1.3 (actually still in beta testing):
- add: rename file is now possible
- add: upload a file using a fallback fileselect form
- add: get a local version of a distant file only with it's URL
- bugfix: search with only one result now return the result (!)
- bugfix: link to file contains the filename
- bugfix: ajax refreshing list problem (seems solved in almost all cases)


# new in version 1.2:
- add: filter/search on admin page
- add: language support (see lang.php to translate it to another language)
- change: design and logo
- change: upload form to personal d&d lib (auto_dropzone)
- update: auto_restrict to a better secured version
- update: auto_thumbnail to the last version

# TODO
- add a config page
- some security enhancements
- maybe a «protected link» mode available only for one person (I'm just thinking ^^)
- Folders

# used libraries 
I only used a few libs I made
- auto_restrict : to easily lock access to a page and handle basic security features
- auto_thumbs : a function to generate all the thumbnails
- auto_dropzone : a lib that handle the drag and drop function only by including it in a script

# FAQ
- can't see icons / problems uploading / list refresh problem : take a look to access rights (folders / files)
