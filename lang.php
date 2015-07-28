<?php
	/**
	* BoZoN language file:
	* sets all the messages in various languages
	* to add one, simply copy paste the french one and change all the values: the array's keys must stay the same !
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	function e($txt,$echo=true){
		global $lang;
		if (isset($lang[$_SESSION['language']][$txt])){$t= $lang[$_SESSION['language']][$txt];}else{$t= $txt;}
		if ($echo){echo $t;}else{return $t;}
	}
	$lang=array();

	# ENGLISH (by default)
	$lang['en']=array();

	# FRENCH
	$lang['fr']=array(
		'Drag, drop, share.'=>'Glisse, d&eacute;pose, partage.',
		'Search in the uploaded files'=>'Rechercher dans les fichiers uploadés',
		'Filter'=>'Mot-clé',
		'Drag the file you want to share to upload it on the server'=>'glisser le fichier à partager pour l\'envoyer sur ton serveur',
		'Copy the file\'s link (right click on it)'=>'copier le lien du fichier (clic bouton droit, copier le lien)',
		'Share the link with your buddies...'=>'partager le lien avec les autres...',
		'tiny file sharing app, coded with love and php by '=>'mini app de partage de fichier, codée avec amour et php par ',
		'Logout'=>'Déconnexion',
		'Type to filter the list'=>'Filtrer la liste',
		'Drop your files here or click to select a local file'=>'Glisser les fichiers ici ou cliquer pour sélectionner un fichier local',
		'Please, login'=>'Connectez-vous',
		'Create your account'=>'Créez votre compte',
		'Login'=>'Login',
		'Password'=>'Passe',
		'Stay connected'=>'Rester connect&eacute;',
		'No file on the server'=>'Aucun fichier sur le serveur',
		'Delete this file ?'=>'Supprimer ce fichier ?',
		'Rename this file ?'=>'Renommer ce fichier ?',
		'Problem accessing remote file.'=>'Problème d\'acces au fichier distant',
		'Paste a file\'s URL to get it on this server'=>'Coller l\'URL d\'un fichier pour le récupérer sur ce serveur',
		'Paste a file\'s URL'=>'Coller l\'URL d\'un fichier',
		'New_folder'=>'Nouveau_dossier',
		'Create a subfolder'=>'Créer un nouveau dossier',
		'Manage links'=>'Gérer les liens',
		'Move files'=>'Déplacer des fichiers',
		'Manage files'=>'Gérer les fichiers',
		'Move file or folder'=>'Dépl. fichier/dossier',
		'Move'=>'Déplacer',
		'To'=>'Vers',
		'Move a file by clicking on it and choosing the destination folder in the list'=>'Déplacer un fichier en cliquant dessus puis en sélectionnant la destination dans la liste',
		'Move a folder by clicking on the move icon and choosing the destination folder in the list'=>'Déplacer un dossier en cliquant sur "Déplacer" puis en sélectionnant la destination dans la liste',

	);


	# ESPANOL
	$lang['es']=array(
		'Drag, drop, share.'=>'Arrastra, deposita, comparte.',
		'Search in the uploaded files'=>'Buscar en los ficheros del servidor',
		'Filter'=>'Filtrar',
		'Drag the file you want to share to upload it on the server'=>'Deposita el fichero que quieras subir al servidor',
		'Copy the file\'s link (right click on it)'=>'Copia el enlace del fichero (haz un clic con el botón derecho y copia el enlace)',
		'Share the link with your buddies...'=>'Comparte la dirección con los demás...',
		'tiny file sharing app, coded with love and php by '=>'Mini utilidad para compartir ficheros, creada con amor y php por ',
		'Logout'=>'Salir',
		'Type to filter the list'=>'Filtrar la lista',
		'Drop your files here or click to select a local file'=>'Deposita los ficheros aquí o pincha para escoger uno en tu ordenador',
		'Please, login'=>'Conéctate',
		'Create your account'=>'Crea tu cuenta admin',
		'Login'=>'Login',
		'Password'=>'Contrasena',
		'Stay connected'=>'Permanecer conectado',
		'No file on the server'=>'Ningún fichero en el servidor',
		'Delete this file ?'=>'¿ Borrar este fichero ?',
		'Rename this file ?'=>'¿ Cambiar el nombre del fichero ?',
		'Problem accessing remote file.'=>'Imposible acceder al fichero remoto',
		'Paste a file\'s URL to get it on this server'=>'Pegar la URL de un fichero',
		'Paste a file\'s URL'=>'Pegar la URL de un fichero',
		'New_folder'=>'Nueva_carpeta',
		'Create a subfolder'=>'Crear una carpeta nueva',
		'Manage links'=>'Gestionar los enlaces',
		'Move files'=>'Mover ficheros',
		'Manage files'=>'Gestionar los ficheros',
		'Move file or folder'=>'Mover fichero/carpeta',
		'Move'=>'Mover',
		'To'=>'A',
		'Move a file by clicking on it and choosing the destination folder in the list'=>'Mueve un fichero haciendo clic en él y escogiendo el destino en la lista',
		'Move a folder by clicking on the move icon and choosing the destination folder in the list'=>'Mueve una carpeta pinchando en "Mover" y escogiendo el destino en la lista',

	);
?>