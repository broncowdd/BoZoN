<?php
##################################################
# es
##################################################

$lang=array(

##################################################
# ./core/auto_dropzone.php
##################################################
    "Drop your files here or click to select a local file" => "Deposita los archivos aquí o haz clic para escoger uno en tu ordenador",
    "Error, max filelength:" => "Error, tamaño máximo para los archivos:",
     ": Error, forbidden file format !" => ": ¡ Error, formato prohibido !",
     "The file to big for the server\'s config" => "El tamaño del archivo es superior a la configuración del servidor",
     "The file to big for this page" => "El archivo es demasiado grande para la página",
     "There was a problem during upload (file was truncated)" => "Problema durante la transmisión",
     "No file upload" => "Ningún archivo enviado",
     "No temp folder" => "Ningúna carpeta temp",
     "Write error on server" => "Error de escritura en el servidor",
    "The file doesn\'t fit" => "El archivo no cabe",
    "Upload error" => "Error subiendo el archivo",

##################################################
# ./core/auto_restrict.php
##################################################
    "Account created:" => "Cuenta creada:",
    "New password saved for " => "Nueva contraseña cambiada para ",
    "Error saving new password for " => "Error guardando la nueva contraseña para ",
    "Changes saved" => "Cambios almacenados",

##################################################
# ./core/commands_GET_vars.php
##################################################
    "Rss feed of stats" => "Enlace RSS de las estadísticas",

##################################################
# ./core/config_form_help.php
##################################################
    "The language used by default" => "Idioma usado en defecto",
#     " " => "",
    "The way Bozon displays the files by default" => "De qué forma Bozon presenta los archivos",
    "The mode by default: links or view" => "El modo en defecto: enlaces o lista de archivos",
    "in pixels" => "en pixeles",
    "Displays the back button and the . and .. options" => "Muestra los botones para volver a la carpeta anterior",
    "The maximum entries in the stat page" => "Número máximo de líneas en cada página de estadística",
    "The maximum entries in stat file" => "Número máximo de entradas en el archivo de estadísticas",
    "How much files bozon displays before the «load more» button" => "Cuántos archivos muestra Bozon antes de poner el botón «ver más»",
    "Allow Bozon to calculate the folders\'size (disable in case of slow down with a lot of files)" => "Le permite a Bozon calcular el tamaño de las carpetas (inutilizar en caso de lentitud con una gran cantidad de archivos)",
    "Visitor can access to RSS feed" => "Los  visitantes que acceden al enlace público de una carpeta pueden utilizar el formato RSS",
    "Visitor can access to JSON feed" => "Los  visitantes que acceden al enlace público de una carpeta pueden utilizar el formato JSON",
    "Visitor can access to download" => "Los  visitantes que acceden al enlace público de una carpeta pueden descargarla como un archivo ZIP",
    "When the user clicks on the file, download it instead of open" => "Cuando el usuario pincha en un archivo, descargarlo en vez de abrirlo",
    "Updates and checks the ID base on every refresh. Disable if you see a slowdown" => "Completa y comprueba la base de datos cada vez que una página se carga (inutilizar en caso de lentitud)",
    "Allow the upload of unknown files types" => "Autoriza el usuario a que suba archivos con formato desconocido",
    "Use lightbox or open pictures in a new tab" => "Utiliza la lightbox para visualizar las imágenes (inutilizar para abrir en una nueva página ",
    "When you click on renew id for a shared file, this file is no longer shared." => "Cuando pinchas en cambiar el ID para un archivo compartido, el archivo dejar de estar compartido con los otros usuarios",
    "List of files to open directly in your browser (separate with commas)" => "Lista de los tipos de archivos que Bozon tiene que abrir directamente en el navegador",
    "List of files to display as a text file (separate with commas)" => "Lista de los tipos de archivos que Bozon tiene que mostrar como un texto",

##################################################
# ./core/core.php
##################################################
    "Private folder is not writable" => "Carpeta Private protegida contra la escritura",
    "Private folder is not readable" => "Carpeta Private protegida contra la lectura",
    "Temp folder is not writable" => "Carpeta Temp protegida contra la escritura",
    "Temp folder is not readable" => "Carpeta Temp protegida contra la lectura",
     "Problem accessing tree folder: not readable" => "Carpeta Tree protegida contra la lectura",
     "Problem accessing tree/folder file: not writable" => "Carpeta Tree protegida contra la escritura",
    "Problem accessing " => "Problema accediendo a ",
    ": folder not readable" => ": Carpeta protegida contra la lectura",
    ": folder not writable" => ": Carpeta protegida contra la escritura",
    "is not installed on this server" => "no está instalado en este servidor",
    "More info" => "Más informaciones",
    "Problem accessing ID file: not readable" => "Error de acceso leyendo el archivo ID.",
    "Problem accessing ID file: not writable" => "Error de acceso escribiendo al archivo ID.",
    "Problem accessing stats file: not readable" => "Error de acceso leyendo el archivo de estadísticas",
     "Problem accessing stats file: not writable" => "Error de acceso escribiendo al archivo de estadísticas",
    "Logout" => "Salir",
    "Connection" => "Connección",
    "See as icon" => "Ver como iconos",
    "See as file list" => "Ver como lista",
    "Manage files" => "Gestionar los archivos",
    "Manage links" => "Gestionar los enlaces",
    "Deleted" => "Borrado",
    "free" => "libre",
    "Yes" => "Sí",
#     "No" => "",
     "text" => "texto",

##################################################
# ./core/GET_POST_admin_data.php
##################################################
    "is not writable" => "está protegido contra la escritura",
    "created" => "creado",
    "Problem accessing remote file." => "Imposible acceder al archivo remoto",
    "moved to" => "movido a",

##################################################
# ./core/listfiles.php
##################################################
    "The user can access this only one time" => "El usuario solo puede acceder al archivo una vez",
    "The user can access this only with the password" => "El usuario solo puede acceder al archivo con una contraseña",
    "View this share" => "Ver este archivo",
    "View this file" => "Ver el archivo",
    "Edit this file" => "Editar el archivo",
    "Share this item with another user" => "Comparte con otro usuario",
    "Convert this zip file to folder" => "Convertir este archivo Zip en carpeta",
    "Check all" => "Seleccionar todo",
    "Filename" => "Nombre del archivo",
    "Filesize" => "Tamaño del archivo",
    "Filetype" => "Tipo",
    "Foldersize" => "Tamaño de la carpeta",
    "Load" => "Cargar",
    "more" => "más",
    "No file or folder" => "Ningún archivo",

##################################################
# ./core/share.php
##################################################
    "This share is protected, please type the correct password:" => "Este enlace está protegido por una contraseña:",
    "This page in" => "Esta página en formato ",
    "Download a zip from this folder" => "Bajar un zip con esta carpeta",
    "This link is no longer available, sorry." => "Este enlace está caducado.",
    "Rss feed of " => "Enlace RSS de ",

##################################################
# ./core/templates.php
##################################################
    "Delete this file" => "Borra este archivo",
    "Get the share link" => "Conseguir el enlace público",
    "Get the qrcode of this link" => "Consigue el código qr del enlace",
    "Rename this file (share link will not change)" => "Cambiar el nombre (el enlace no cambiará)",
    "Put a password on this share" => "Proteger con una contraseña",
    "Turn this share into a burn after access share" => "Pasar al modo acceso único",
    "Regen the share link" => "Renovar el enlace público",
    "Move file or folder" => "Mover archivo/carpeta",
    "Move to" => "Mover a",
    "Move" => "Mover",
    "To" => "A",
    "Lock access" => "Impedir el acceso",
    "Please give a password to lock access to this file" => "Por favor, ingresa una contraseña para el archivo",
    "Rename this file?" => "Renombrar el archivo",
    "Rename this item?" => "¿ Cambiar el nombre del archivo ?",
    "Rename" => "Cambiar el nombre",
    "Delete this item?" => "¿ Borrar este elemento ?",
    "Delete" => "Borrar",
    "Share item" => "Compartir",
    "Share link" => "Enlace público",
    "Select the users you want to share with" => "Selecciona los usuarios con quien compartir la carpeta",
    "Copy this share link" => "Copia este enlace público",
    "Move this file to another directory" => "Desplazar este archivo a otra carpeta",
    "Create a subfolder" => "Crear una carpeta nueva",
    "Create a subfolder in this folder" => "Crear una subcarpeta nueva en esta carpeta",
    "New folder" => "Nueva carpeta",
    "Paste a file\'s URL" => "Pega el URL de un archivo",
    "Paste a file\'s URL to get it on this server" => "Pegar una dirección para guardar el archivo",
#     "Read m3u playlist" => "",
    "Force local filename (leave empty=no change)" => "Cambiar el nombre del archivo (vacío = nombre original)",
    "filename (optionnal)" => "Nombre del archivo (facultativo)",

##################################################
# ./index.php
##################################################
    "Click to remove" => "Pincha para quitar",

##################################################
# ./templates/default/admin.php
##################################################
    "Choose a folder" => "Escoja una carpeta",
    "Root:" => "Raíz :",
    "Filter:" => "Filtro :",
    "Delete selected items" => "Borrar los archivos seleccionados",
    "Zip and download selected items" => "Crea un archivo Zip con la selección",
    "Paste a file's URL" => "Ingresar una URL",
    "Paste a BoZoN share url" => "Ingresar una URL BoZoN",
    "Import from another bozon" => "Importar desde otro bozon",
    "Paste a file's URL to get it on this server" => "Ingresar la dirección de un archivo distante",

##################################################
# ./templates/default/editor.php
##################################################
    "Path:" => "Camino:",
    "Write" => "Escribir",
    "See" => "Ver",
    "Help" => "Ayuda",
    "Save" => "Guardar",
    "markdown_help" => "# Título 1
		## Título 2
		### Título 3
		#### Título 4
		##### Título 5
		###### Título 6

		*bastardilla* o _bastardilla_
		**negrilla** ou __negrilla__
		**_negrilla bastardilla_**
		~~tachado~~

		1. lista ordenada
		2. segunda línea
		⋅⋅* no ordenado 
		1. los números no tienen importancia
		⋅⋅1. ordenado

		+ lista no ordenada
		- lista no ordenada
		* lista no ordenada

		[Texto del enlace](https://direccion.com)
		![Alt de la imagen](http://direccion/imagen.jpg)

		```javascript
		var s = 'JavaScript syntax highlighting';
		alert(s);
		```

		| Tableros       | son               | Chulos |
		| -------------- |:-----------------:| ------:|
		| col 3 está     | alienada derecha  | $1600  |
		| col 2 está     | centrada          |   $12  |

		> para las citas
		> éste carácter primero:'>'

		--- o *** o ___ = línea",

##################################################
# ./templates/default/edit_profiles.php
##################################################
    "New profile" => "Nuevo perfil",

##################################################
# ./templates/default/footer.php
##################################################
    "Fork me on github" => "Forkéame en github",

##################################################
# ./templates/default/header.php
##################################################
    "Drag, drop, share." => "Arrastra, deposita, comparte.",
    "Home" => "Entrada",
    "Edit profiles rights" => "Cambiar los derechos de los perfiles",
    "Configure Bozon" => "Configurar Bozon",
    "Users list" => "Lista de usuarios",
    "New user" => "Nuevo usuario",
    "Access log file" => "Estadísticas de acceso",
    "Change password" => "Cambiar la contraseña.",
    "Rebuild base" => "Completar la base",
    "Text editor" => "Editor de texto",
    "Click or dragover to reveal dropzone" => "Haz click o arrastra un archivo para desubrir la zona de upload",
    "Upload" => "Subir",
    "Connect" => "Conectarse",
    "Search in the uploaded files" => "Buscar en los archivos del servidor",
    "Filter" => "Filtrar",
    "Markdown editor" => "Editor Markdown",
    "Access log" => "Log de accesos",
    "Create an account" => "Crear una cuenta",
    "Please, login" => "Conéctate",
    "Users profiles" => "Usuarios",
    "Configure profiles rights" => "Configurar los derechos de los perfiles",

##################################################
# ./templates/default/header_markdown.php
##################################################

##################################################
# ./templates/default/home.php
##################################################
    "BoZoN is a simple filesharing app." => "BoZoN es una simple utilidad de almacenamiento y de reparto de archivos.",
    "Easy to install, free and opensource" => "Fácil de instalar, libre y de código abierto",
     "Just copy BoZoN\'s files onto your server. That\'s it." => "Basta con subir los archivos de Bozon a tu servidor.",
    "You can freely fork BoZoN and use it as specified in the AGPL licence" => "Puedes copiar y modificar libremente esta utilidad según la licencia AGPL",
    "Easy to use!" => "Fácil de utilizar",
     "Drag the file you want to share to upload it to the server" => "Deposita el archivo que quieras subir al servidor",
    "Share the link with your friends" => "Comparte la dirección con los demás...",
    "BoZoN can do more!" => "¡ Hay más !",
     "No database required: easy to backup or move to a new server." => "Ningún base de datos: fácil de guardar o de trasladar a otro servidor.",
    "Lock the access to the file/folder with a password." => "Pónle una contraseña al archivo.",
     "Share a file or a folder with a unique access link with the «burn mode»:" => "Comparte un archivo o una carpeta con un enlace público de acceso único con el modo «burn».",
     "Renew a share link with a single click" => "Cambia un enlace público con solo un clic.",
     "Download a folder's contents into a zip" => "Baja una carpeta de tu BoZoN directamente en formato zip.",
     "Access BoZoN on a smartphone without an app: your browser is enough" => "Ingresa en tu BoZoN desde tu móvil solo con el navegador.",
    "Use a qrcode to share your link with smartphone users." => "Utiliza un QRcode para compartir enlaces con móviles",
     "Add and remove users as well as manage their rights." => "Añade y borra cuentas de usuarios y gestiona sus derechos",
     "To upload a folder, just zip and upload it: with one click it will be turned into a folder on the server." => "Sube una carpeta completa: la zipeas, la subes al servidor y la dezipeas con un clic.",
    "Modify the templates & style to make your own BoZoN" => "Crea tu propio BoZoN cambiando el tema y el estilo css",

##################################################
# ./templates/default/login.php
##################################################
    "Login" => "Login",
    "New account" => "Nueva cuenta",
    "This login is not available, please try another one" => "Este nombre ya existe, por favor, ingrese uno diferente.",
    "Wrong combination login/pass" => "Error en el nombre o en la contraseña",
    "Problem with admin password." => "La contraseña anterior es falsa.",
    "Password changed" => "Contraseña cambiada",
    "User:" => "Usuario:",
    "Old password" => "Contraseña anterior.",
    "Password" => "Contraseña",
    "Repeat password" => "Repetir la contraseña.",
    "Stay connected" => "Permanecer conectado",

##################################################
# ./templates/default/stats.php
##################################################
    "No stats" => "Ninguna estadística",
    "Date" => "Fecha",
    "File" => "archivo",
    "Access" => "Acceso",
    "Owner" => "Propietario",
#     "IP" => "",
    "Origin" => "Página de origen",
    "Host" => "Huésped",
    "Delete all stat data" => "Borrar las estadìsticas",
    "Export log:" => "Exportar el log :",

##################################################
# ./templates/default/users.php
##################################################
    "Status" => "Estatus",
    "Space" => "Espacio",
    "Check users to delete account and files" => "Selecciona los usuarios para borrar su cuenta y sus archivos",
    "Select new status for the users" => "Cambia el estatus de los usuarios",
    "User" => "Usuario",
    "Admin" => "Administrador",
    "Configure folders max size" => "Limitar la capacidad de las carpetas de usuarios",
    "Change users\'passwords" => "Cambiar la contraseña de los usuarios",
    "Double-clic to generate a password" => "Doble clic para generar una contraseña",

##################################################
# Orphans 
##################################################
    "used" => "utilizado",
    "guest" => "invitado",
    "user" => "usuario",
    "admin" => "administrador",
    "add user" => "Añadir usuario",
    "delete user" => "Borrar usuario",
    "change user status" => "cambiar el estatus del usuario",
    "change folder size" => "cambiar el tamaño de la carpeta",
    "change status rights" => "cambiar los derechos de los estatuses",
    "change passes" => "cambiar las contraseñas",
    "markdown editor" => "Editor Markdown",
    "regen ID base" => "regenerar la base",
    "acces logfile" => "log de accesos",
    "delete files" => "borrar archivos",
    "move files" => "mover archivos",
    "rename files" => "cambiar el nombre de los archivos",
    "create folder" => "crear una carpeta",
    "users page" => "página de usuario",
    "config page" => "página de configuración",
    "Just copy BoZoN's files on your server. That's it." => "Basta con subir los archivos de Bozon a tu servidor.",
    "Drag the file you want to share to upload it on the server" => "Deposita el archivo que quieras subir al servidor",
    "No database: easy to backup or move to a new server." => "Ningún base de datos: fácil de guardar o de trasladar a otro servidor.",
    "Share a file or a folder with a unique acces link with the «burn mode»:" => "Comparte un archivo o una carpeta con un enlace público de acceso único con el modo «burn».",
    "Renew a share link with a single clic" => "Cambia un enlace público con solo un clic.",
    "Download a folder content into a zip" => "Baja una carpeta de tu BoZoN directamente en formato zip.",
    "Acces to BoZoN on smartphone without any specific app: your browser is enougth" => "Ingresa en tu BoZoN desde tu móvil solo con el navegador.",
    "Add, remove users and manage their rights" => "Añade y borra cuentas de usuarios y gestiona sus derechos",
    "To upload a folder, just zip and upload it: with one clic it will be turned into a folder on the server." => "Sube una carpeta completa: la zipeas, la subes al servidor y la dezipeas con un clic.",
    "The passwords doesn't match." => "Las contraseñas no corresponden",
    "language" => "idioma",
    "theme" => "tema",
    "aspect" => "aspecto",
    "mode" => "modo",
    "gallery thumbs width" => "Tamaño de las miniaturas para la galerìa",
    "show back button" => "mostrar el botón atras",
    "files to echo" => "archivos para mostrar como texto",
    "files to return" => "archivos para retornar",
    "max lines per page on stats page" => "Número de lineas en cada página",
    "limit stat file entries" => "número máximo de estadísticas",
    "max files per page" => "Número máximo de archivos por página",
    "disable non installed libs warning" => "inutilizar el aviso de biblioteca sin instalar",
    "allow folder size stat" => "autorizar el cálculo de tamaño para las carpetas",
    "allow shared folder RSS feed" => "autorizar el enlace RSS público",
    "allow shared folder JSON feed" => "autorizar el enlace JSON público",
    "allow shared folder download" => "autorizar la descarga de carpeta",
    "click on link to download" => "pinchar para descargar",
    "check ID base on page load" => "comprobar la base de datos al cargar la página",
    "allow unknown filetypes" => "autorizar los tipos de archivo desconocidos",
    "use lightbox" => "utilizar la lightbox",
    "remove item from users share when renew id" => "quitar los archivos con nuevo ID de la lista compartida con los usuarios",
    "profile folder max size" => "tamaño máximo de la carpeta de los usuarios",
    "When burn is on, the user can access the file/folder only once" => "En modo burn, el usuario solo puede acceder al archivo una vez",
    "Move files" => "Mover archivos",
    "Root" => "Raíz",
    "Manage users" => "Gestionar los usuarios",
    "Users status" => "estatus des los usuarios",
    "Type to filter the list" => "Filtrar la lista",
    "List" => "Lista",
    "Icons" => "Íconos",
    "Change theme" => "Cambiar el aspecto",
    "Error, forbidden file format!" => "¡ Error, formato prohibido !",
    "Delete this file?" => "¿ Borrar este archivo ?",
    "Files list" => "Lista de archivos",
    "tiny file sharing app, coded with love and php by " => "Mini utilidad para compartir archivos, creada con amor y php por ",
    "Move a file by clicking on it and choosing the destination folder in the list" => "Mueve un archivo haciendo clic en él y escogiendo el destino en la lista",
    "Move a folder by clicking on the move icon and choosing the destination folder in the list" => "Mueve una carpeta pinchando en 'Mover' y escogiendo el destino en la lista",
    "Renew the share link of the file/folder (in case of a stolen link for example)" => "Cambia el enlace de un archivo con solo un clic",
    "If you want to remove the password, just click on Renew button" => "Si quiere quitarle la contraseña, solo tiene que pinchar en el botón Renovar el enlace",

);
?>