<?php
##################################################
# fr
##################################################

$lang=array(

##################################################
# ./core/auto_dropzone.php
##################################################
    "Drop your files here or click to select a local file" => "Glisser les fichiers ici ou cliquer pour sélectionner un fichier local",
    "Error, max filelength:" => "Erreur, taille max par fichier :",
#     ": Error, forbidden file format !" => "",
#     "The file to big for the server\'s config" => "",
#     "The file to big for this page" => "",
#     "There was a problem during upload (file was truncated)" => "",
#     "No file upload" => "",
#     "No temp folder" => "",
#     "Write error on server" => "",
    "The file doesn\'t fit" => "Pas assez d'espace libre",
    "Upload error" => "Erreur lors de l'envoi",

##################################################
# ./core/auto_restrict.php
##################################################
    "Account created:" => "Compte créé :",
    "New password saved for " => "Nouveau mot de passe sauvé pour ",
    "Error saving new password for " => "Erreur en sauvant le mot de passe pour ",
    "Changes saved" => "Changements sauvegardés",

##################################################
# ./core/commands_GET_vars.php
##################################################
    "Rss feed of stats" => "RSS des stats",

##################################################
# ./core/config_form_help.php
##################################################
    "The language used by default" => "Le langage utilisé par défaut",
#     " " => "",
    "The way Bozon displays the files by default" => "La façon dont Bozon affiche les fichiers",
    "The mode by default: links or view" => "La façon dont Bozon affiche les fichiers",
    "in pixels" => "en pixels",
    "Displays the back button and the . and .. options" => "Affiche le bouton de retour et les options . et ..",
    "The maximum entries in the stat page" => "Le nombre maximum pour chaque page",
    "The maximum entries in stat file" => "Le nombre maximum de lignes de stats dans le fichier",
    "How much files bozon displays before the «load more» button" => "Combien de fichiers affichés avant le bouton «charger plus»",
    "Allow Bozon to calculate the folders\'size (disable in case of slow down with a lot of files)" => "Autorise Bozon à calculer la taille des dossiers (désactiver en cas de ralentissements avec un grand nombre de fichiers)",
    "Visitor can access to RSS feed" => "Les visiteurs ont accès au RSS des dossiers dont ils ont le lien",
    "Visitor can access to JSON feed" => "Les visiteurs peuvent récupérer la liste du contenu des dossiers au format JSON",
    "Visitor can access to download" => "Les visiteurs peuvent télécharger un dossier partagé sous forme de zip",
    "When the user clicks on the file, download it instead of open" => "Quand l'utilisateur clique sur un fichier, il se télécharge au lieu de s'ouvrir dans le navigateur",
    "Updates and checks the ID base on every refresh. Disable if you see a slowdown" => "Régénère la base à chaque chargement (désactiver en cas de ralentissement avec beaucoup de fichiers)",
    "Allow the upload of unknown files types" => "Permet d'envoyer des fichiers dont le type est inconnu",
    "Use lightbox or open pictures in a new tab" => "Utiliser la lightbox ou ouvrir les images dans un nouvel onglet",
    "When you click on renew id for a shared file, this file is no longer shared." => "Quand vous cliquez sur «renouveler le lien de partage», le fichier disparaît des partages utilisateurs (si non, le nouveau lien remplace l'ancien dans les partages)",
    "List of files to open directly in your browser (separate with commas)" => "Liste des fichiers à ouvrir directement dans le navigateur (séparés par des virgules)",
    "List of files to display as a text file (separate with commas)" => "Liste des fichiers à afficher comme du texte (séparés par des virgules)",

##################################################
# ./core/core.php
##################################################
    "Private folder is not writable" => "Le dossier private/ est verrouillé en écriture",
    "Private folder is not readable" => "Le dossier private/ est verrouillé en lecture",
    "Temp folder is not writable" => "Le dossier private/temp est verrouillé en écriture",
    "Temp folder is not readable" => "Le dossier private/temp est verrouillé en lecture",
#     "Problem accessing tree folder: not readable" => "",
#     "Problem accessing tree/folder file: not writable" => "",
    "Problem accessing " => "Problème lors de l'accès à ",
    ": folder not readable" => ": dossier verrouillé en lecture",
    ": folder not writable" => ": dossier verrouillé en écriture",
    "is not installed on this server" => "n'est pas installé sur ce serveur",
    "More info" => "En savoir plus",
    "Problem accessing ID file: not readable" => "Erreur d'accès en lecture au fichier ID.",
    "Problem accessing ID file: not writable" => "Erreur d'accès en écriture au fichier ID.",
    "Problem accessing stats file: not readable" => "Fichier de stats verrouillé en lecture",
    "Problem accessing stats file: not writable" => "Fichier de stats verrouillé en écriture",
    "Logout" => "Déconnexion",
    "Connection" => "Connexion",
    "See as icon" => "Voir sous forme d'icônes",
    "See as file list" => "Voir sous forme de liste",
    "Manage files" => "Gérer les fichiers",
    "Manage links" => "Gérer les liens",
    "Deleted" => "Supprimé",
    "free" => "libre",
    "Yes" => "Oui",
    "No" => "Non",
#     "text" => "",

##################################################
# ./core/GET_POST_admin_data.php
##################################################
    "is not writable" => "est verrouillé en écriture",
    "created" => "créé",
    "Problem accessing remote file." => "Problème d'accès au fichier distant",
    "moved to" => "déplacé vers",

##################################################
# ./core/listfiles.php
##################################################
    "The user can access this only one time" => "L'utilisateur ne pourra y accéder qu'une fois",
    "The user can access this only with the password" => "L'utilisateur ne pourra y accéder qu'avec un mot de passe.",
    "View this share" => "Voir ce partage",
    "View this file" => "Voir ce fichier",
    "Edit this file" => "Editer ce fichier",
    "Share this item with another user" => "Partager cette ressource avec un autre utilisateur",
    "Convert this zip file to folder" => "Convertir ce fichier Zip en dossier",
    "Check all" => "Tout cocher",
    "Filename" => "Nom de fichier",
    "Filesize" => "Taille de fichier",
    "Filetype" => "Type de fichier",
    "Foldersize" => "Taille du dossier",
    "Load" => "Charger",
    "more" => "de plus",
    "No file or folder" => "Aucun fichier ou dossier",

##################################################
# ./core/share.php
##################################################
    "This share is protected, please type the correct password:" => "Ce lien est protégé: veuillez taper le mot de passe.",
    "This page in" => "Cette page au format ",
    "Download a zip from this folder" => "Télécharger un zip à partir de ce dossier",
    "This link is no longer available, sorry." => "Ce lien n'est plus valable, désolé.",
    "Rss feed of " => "Flux RSS de ",

##################################################
# ./core/templates.php
##################################################
    "Delete this file" => "Supprimer ce fichier",
    "Get the share link" => "Obtenir le lien de partage",
    "Get the qrcode of this link" => "Voir le qrcode de ce lien",
    "Rename this file (share link will not change)" => "Renommer ce fichier (le lien de partage ne changera pas)",
    "Put a password on this share" => "Protéger l'accès par mot de passe",
    "Turn this share into a burn after access share" => "Passer ce partage en mode accès unique",
    "Regen the share link" => "Régénérer le lien de partage",
    "Move file or folder" => "Dépl. fichier/dossier",
    "Move to" => "Déplacer vers",
    "Move" => "Déplacer",
    "To" => "Vers",
    "Lock access" => "Verrouiller l'accès",
    "Please give a password to lock access to this file" => "Saisir un mot de passe pour verrouiller cette ressource",
    "Rename this file?" => "Renommer ce fichier ?",
    "Rename this item?" => "Renommer cet élément ?",
    "Rename" => "Renommer",
    "Delete this item?" => "Supprimer cet élément ?",
    "Delete" => "Supprimer",
    "Share item" => "Partager item.",
    "Share link" => "Lien de partage",
    "Select the users you want to share with" => "Sélectionnez les utilisateurs avec qui partager cette ressource",
    "Copy this share link" => "Copiez ce lien de partage",
    "Move this file to another directory" => "Déplacer ce fichier vers un autre dossier",
    "Create a subfolder" => "Créer un nouveau dossier",
    "Create a subfolder in this folder" => "Créer un sous-dossier dans ce dossier",
    "New folder" => "Nouveau dossier",
    "Paste a file's URL" => "Coller une URL",
    "Paste a BoZoN share url" => "Coller une URL BoZoN",
    "Import from another bozon" => "Importer depuis un autre bozon",
    "Paste a file's URL to get it on this server" => "Coller l'url d'un fichier pour le récupérer sur ce serveur",
#     "Read m3u playlist" => "",
    "Force local filename (leave empty=no change)" => "Changer le nom du fichier (vide = nom original)",
    "filename (optionnal)" => "Nom de fichier (facultatif)",

##################################################
# ./index.php
##################################################
    "Click to remove" => "Cliquer pour retirer",

##################################################
# ./templates/default/admin.php
##################################################
    "Choose a folder" => "Choisissez un dossier",
    "Root:" => "Racine :",
    "Filter:" => "Filtre :",
    "Delete selected items" => "Supprimer les items sélectionnés",
    "Zip and download selected items" => "Zipper et télécharger les items sélectionnés",

##################################################
# ./templates/default/editor.php
##################################################
    "Path:" => "Chemin:",
    "Write" => "Écrire",
    "See" => "Voir",
    "Help" => "Aide",
    "Save" => "Sauvegarder",
    "markdown_help" => "# Titre 1
		## Titre 2
		### Titre 3
		#### Titre 4
		##### Titre 5
		###### Titre 6

		*italique* ou _italique_
		**gras** ou __gras__
		**_gras italique_**
		~~barré~~

		1. liste ordonnée
		2. deuxième item
		⋅⋅* sous-item non ordonné. 
		1. Les nombres ne sont pas importants
		⋅⋅1. sous-item ordonné

		+ liste non ordonnée
		- liste non ordonnée
		* liste non ordonnée

		[Texte du lien](https://adresse.com)
		![Alt de l\'image](http://adressede/image.jpg)

		par référence (permet de répéter un lien/une image sans retaper l\'adresse):
		[Texte lien][ref1]
		[ref1]: http://adresse.fr

		![alt text][logo]
		[logo]: http://adresse/image.jpg


		```javascript
		var s = 'JavaScript syntax highlighting';
		alert(s);
		```

		| Tableaux       | sont              | Cools |
		| -------------- |:-----------------:| -----:|
		| col 3 est      | alignée à droite  | $1600 |
		| col 2 est      | centrée           |   $12 |

		> pour les citations
		> ce signe en début de ligne

		--- ou *** ou ___ = ligne",

##################################################
# ./templates/default/edit_profiles.php
##################################################
    "New profile" => "Nouveau profil",

##################################################
# ./templates/default/footer.php
##################################################
    "Fork me on github" => "Forkez-moi sur github",

##################################################
# ./templates/default/header.php
##################################################
    "Drag, drop, share." => "Glisser, déposer, partager.",
    "Home" => "Accueil",
    "Edit profiles rights" => "Éditer les droits d'accès des profils",
    "Configure Bozon" => "Configurer Bozon",
    "Users list" => "Liste des utilisateurs",
    "New user" => "Nouvel utilisateur",
    "Access log file" => "Voir le fichier d'accès",
    "Change password" => "Changer le mot de passe",
    "Rebuild base" => "Régénérer la base",
    "Text editor" => "Éditeur de texte",
    "Click or dragover to reveal dropzone" => "Cliquez ou glisser un fichier pour révéler la zone d'upload",
    "Upload" => "Envoyer",
    "Connect" => "Se connecter",
    "Search in the uploaded files" => "Rechercher dans les fichiers envoyés",
    "Filter" => "Mot-clé",
    "Markdown editor" => "Éditeur markdown",
    "Access log" => "Journal des accès",
    "Create an account" => "Créer un compte",
    "Please, login" => "Se connecter",
    "Users profiles" => "Profils utilisateurs",
    "Configure profiles rights" => "Configurer les droits d'accès",

##################################################
# ./templates/default/header_markdown.php
##################################################

##################################################
# ./templates/default/home.php
##################################################
    "BoZoN is a simple filesharing app." => "BoZoN est une application simplifiée de stockage et de partage de fichiers.",
    "Easy to install, free and opensource" => "Simple à installer, libre et opensource",
#     "Just copy BoZoN\'s files onto your server. That\'s it." => "",
    "You can freely fork BoZoN and use it as specified in the AGPL licence" => "Vous pouvez librement forker et utiliser BoZoN comme spécifié dans la licence AGPL",
    "Easy to use!" => "Simple à utiliser",
#     "Drag the file you want to share to upload it to the server" => "",
    "Share the link with your friends" => "Partager un lien avec vos amis...",
    "BoZoN can do more!" => "Ce n'est pas tout !",
#     "No database required: easy to backup or move to a new server." => "",
    "Lock the access to the file/folder with a password." => "Verrouillez l'accès au fichier/dossier à l'aide d'un mot de passe.",
#     "Share a file or a folder with a unique access link with the «burn mode»:" => "",
#     "Renew a share link with a single click" => "",
#     "Download a folder\'s contents into a zip" => "",
#     "Access BoZoN on a smartphone without an app: your browser is enough" => "",
    "Use a qrcode to share your link with smartphone users." => "Utilisez un QRcode pour partager un lien avec un smartphone",
#     "Add and remove users as well as manage their rights." => "",
#     "To upload a folder, just zip and upload it: with one click it will be turned into a folder on the server." => "",
    "Modify the templates & style to make your own BoZoN" => "Modifiez le thème par défaut pour créer votre propre style.",

##################################################
# ./templates/default/login.php
##################################################
    "Login" => "Identifiant",
    "New account" => "Nouveau compte",
    "This login is not available, please try another one" => "Ce nom est déjà utilisé, veuillez en choisir un autre.",
    "Wrong combination login/pass" => "Identifiant ou mot de passe incorrect",
    "Problem with admin password." => "Le mot de passe de l'admin est incorrect.",
    "Password changed" => "Mot de passe changé",
    "User:" => "Utilisateur :",
    "Old password" => "Ancien mot de passe",
    "Password" => "Mot de passe",
    "Repeat password" => "Resaisir le mot de passe",
    "Stay connected" => "Rester connecté",

##################################################
# ./templates/default/stats.php
##################################################
    "No stats" => "Aucune statistique",
    "Date" => "Date",
    "File" => "Fichier",
    "Access" => "Accès",
    "Owner" => "Propriétaire",
#     "IP" => "",
    "Origin" => "Page d'origine",
    "Host" => "Hôte",
    "Delete all stat data" => "Supprimer les données statistiques",
    "Export log:" => "Exporter le journal :",

##################################################
# ./templates/default/users.php
##################################################
    "Status" => "Statut",
    "Space" => "Espace",
    "Check users to delete account and files" => "Selectionnez les utilisateurs pour supprimer leur compte et leurs fichiers.",
    "Select new status for the users" => "Sélectionnez un nouveau statut pour les utilisateurs",
    "User" => "Utilisateur",
    "Admin" => "Administrateur",
    "Configure folders max size" => "Fixer la taille maximum des dossiers",
    "Change users\'passwords" => "Changer les mots de passe des utilisateurs",
    "Double-clic to generate a password" => "Double-cliquez pour générer un mot de passe",

##################################################
# Orphans 
##################################################
    "used" => "utilisé",
    "guest" => "invité",
    "user" => "utilisateur",
    "admin" => "administrateur",
    "add user" => "ajouter utilisateur",
    "delete user" => "supprimer utilisateur",
    "change user status" => "modifier statut",
    "change folder size" => "modifier espace alloué",
    "change status rights" => "modifier droits d'accès",
    "change passes" => "modifier les passes",
    "markdown editor" => "éditeur markdown",
    "regen ID base" => "régénérer la base",
    "acces logfile" => "accéder au log",
    "delete files" => "effacer les fichiers",
    "move files" => "déplacer des fichiers",
    "rename files" => "renommer des fichiers",
    "create folder" => "créer des dossiers",
    "users page" => "page utilisateurs",
    "config page" => "page de configuration",
    "Just copy BoZoN\'s files on your server. That\'s it." => "Copiez simplement les fichiers de BoZoN sur votre serveur. C'est tout.",
    "Drag the file you want to share to upload it on the server" => "Glisser le fichier à partager pour l'envoyer sur le serveur",
    "No database: easy to backup or move to a new server." => "Pas de base de données: backup et migration faciles.",
    "Share a file or a folder with a unique acces link with the «burn mode»:" => "Partagez un fichier ou un dossier pour un accès unique avec le mode «burn».",
    "Renew a share link with a single clic" => "Renouvelez un lien de partage en un clic.",
    "Download a folder content into a zip" => "Téléchargez tout un dossier sous la forme d'un fichier zip.",
    "Acces to BoZoN on smartphone without any specific app: your browser is enougth" => "Accédez à votre BoZoN depuis votre smartphone sans application spécifique.",
    "Add, remove users and manage their rights" => "Ajoutez, retirez des utilisateurs et gérez leurs droits",
    "To upload a folder, just zip and upload it: with one clic it will be turned into a folder on the server." => "Envoyez un dossier complet en le zippant puis en dézippant sur le serveur en un clic.",
    "The passwords doesn't match." => "Les mots de passe ne correspondent pas.",
    "language" => "langue",
    "theme" => "thème",
    "aspect" => "Le langage utilisé par défaut",
    "mode" => "mode",
    "gallery thumbs width" => "largeur des miniatures de la galerie",
    "show back button" => "afficher le bouton retour ",
    "files to echo" => "fichiers à afficher",
    "files to return" => "fichiers à renvoyer",
    "max lines per page on stats page" => "nombre de lignes de stats maximum par page",
    "limit stat file entries" => "limite d'entrées dans le fichier stats",
    "max files per page" => "nombre maximum de fichiers par page",
    "disable non installed libs warning" => "empêcher les avertissements de bibliothèques non installées",
    "allow folder size stat" => "permettre le calcul de taille des dossiers",
    "allow shared folder RSS feed" => "autoriser le flux RSS des dossiers partagés",
    "allow shared folder JSON feed" => "autoriser l'accès JSON des dossiers partagés",
    "allow shared folder download" => "autoriser le téléchargement des dossiers",
    "click on link to download" => "cliquer sur un lien télécharge le fichier",
    "check ID base on page load" => "vérifier la base d'ID à chaque chargement",
    "allow unknown filetypes" => "autoriser les fichiers inconnus",
    "use lightbox" => "utiliser la lightbox",
    "remove item from users share when renew id" => "supprimer les items du partage entre utilisateurs lors d'un renouvellement",
    "profile folder max size" => "taille max des dossiers utilisateurs",
    "When burn is on, the user can access the file/folder only once" => "Quand l'item est en mode burn, l'utilisateur ne pourra accéder à la ressource qu'une seule fois",
    "Move files" => "Déplacer des fichiers",
    "Root" => "Racine",
    "Manage users" => "Gérer les utilisateurs",
    "Users status" => "Statut des utilisateurs",
    "Type to filter the list" => "Filtrer la liste",
    "List" => "Liste",
    "Icons" => "Icônes",
    "Change theme" => "Changer le thème",
    "Error, forbidden file format!" => "Erreur, format de fichier interdit !",
    "Delete this file?" => "Supprimer ce fichier ?",
    "Files list" => "Liste de fichiers",
    "tiny file sharing app, coded with love and php by " => "mini app de partage de fichier, codée avec amour et php par ",
    "Move a file by clicking on it and choosing the destination folder in the list" => "Déplacer un fichier en cliquant dessus puis en sélectionnant la destination dans la liste",
    "Move a folder by clicking on the move icon and choosing the destination folder in the list" => "Déplacer un dossier en cliquant sur 'Déplacer' puis en sélectionnant la destination dans la liste",
    "Renew the share link of the file/folder (in case of a stolen link for example)" => "Renouveler le lien de partage d'un fichier/dossier quand celui-ci a fuité par exemple",
    "If you want to remove the password, just click on Renew button" => "Si vous voulez retirer le mot de passe, cliquez sur le bouton Régénérer le lien",

);
?>