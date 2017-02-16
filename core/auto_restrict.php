<?php
	/**
	* BoZoN admin only protection:
	* part of auto_restrict lib 
	* @author: Bronco (bronco@warriordudimanche.net)
	*
	 * auto_restrict
	 * @author bronco@warriordudimanche.com / www.warriordudimanche.net
	 * @copyright open source and free to adapt (keep me aware !)
	 * @version 4.3 - multi user
	 *   
	 * This script locks a page's access  
	 * Just include it in the page you want to lock  
	 * It does all for you:  
	 *   - login/pass creation
	 *   - auto redirect to login form
	 *   - session's expiration
	 *   - login & logout (to logout, add ?logout $_GET var)
	 *   - referrer errors (same domain)
	 *   - auto ban IP and (auto unban)
	 *   - tokens to secure post and get forms (just add <?php newToken(); ?> to the form or <?php sameToken();?> to repeat a previously generated token, in case of various forms in a same page)
	 * 	 - easyly secure sensitive actions adding admin password in your form (just add <?php adminPassword(); ?>, auto_restrict will exit if password is not correct)
	 *   - secure post and get data
	 *   - add function to ask password for sensitive/superadmin actions...
	 *   
	 *   
	 *   
	 * Verrouille l'accès à une page
	 * Il suffit d'inclure ce fichier pour bloquer l'accès...
	 * gestion de l'expiration de session, 
	 * gestion de la connexion et de la déconnexion.
	 * gestion des différences entre le domaine referer et le domaine sur lequel le script est hébergé (si différent -> pas ok)
	 * gestion du bannissement des adresses ip en cas de bruteforcing ou de referer anormal
	 * gestion des tokens de sécurisation à ajouter aux forms en une commande <?php newToken();?>; le script se charge seul de vérifier le token
	 * génération aléatoire de la clé de cryptage
	 * sécurisation par mot de passe sur les actions sensibles (il suffit d'ajouter <?php adminPassword(); ?> à un formulaire pour qu'auto_restrict bloque en cas de mauvais mot de passe)
	 *
	 * Améliorations eventuelles:
	 * ajouter un fichier log de connexion
	 * 
	 * 
	 * ajout 4.2 : 
	 * ajout du statut (superadmin/admin/user) et de la langue (pour bozon)
	 * ajout 4.1 : 
	 * ajout du double check de passe et du changement de mdp
	 * ajout 4.0 : 
	 * ajout du support multi utilisateur
	*/	
	@session_start();
	# ------------------------------------------------------------------
	# default config: initialisation
	# ------------------------------------------------------------------
	# you can modify this config before the include('auto_restrict.php');
	if (!isset($auto_restrict['error_msg'])){						$auto_restrict['error_msg']='Erreur - impossible de se connecter.';}# utilisé si on ne veut pas rediriger
	if (!isset($auto_restrict['cookie_name'])){						$auto_restrict['cookie_name']='BoZoN';}# nom du cookie
	if (!isset($auto_restrict['session_expiration_delay'])){		$auto_restrict['session_expiration_delay']=90;}#minutes
	if (!isset($auto_restrict['cookie_expiration_delay'])){			$auto_restrict['cookie_expiration_delay']=365;}#days
	if (!isset($auto_restrict['IP_banned_expiration_delay'])){		$auto_restrict['IP_banned_expiration_delay']=30;}#seconds
	if (!isset($auto_restrict['max_security_issues_before_ban'])){	$auto_restrict['max_security_issues_before_ban']=5;}
	if (!isset($auto_restrict['just_die_on_errors'])){				$auto_restrict['just_die_on_errors']=true;}# end script immediately instead of include loginform in case of user not logged;
	if (!isset($auto_restrict['just_die_if_not_logged'])){			$auto_restrict['just_die_if_not_logged']=false;}# end script immediately instead of include loginform in case of banished ip or referer problem;
	if (!isset($auto_restrict['tokens_expiration_delay'])){			$auto_restrict['tokens_expiration_delay']=7200;}#seconds
	if (!isset($auto_restrict['kill_tokens_after_use'])){			$auto_restrict['kill_tokens_after_use']=false;}#false to allow the token to survive after it was used (for a form with multiple submits, like a preview button)
	if (!isset($auto_restrict['use_GET_tokens_too'])){				$auto_restrict['use_GET_tokens_too']=true;}
	if (!isset($auto_restrict['use_ban_IP_on_token_errors'])){		$auto_restrict['use_ban_IP_on_token_errors']=false;}
	if (!isset($auto_restrict['redirect_error'])){					$auto_restrict['redirect_error']='index.php';}# si précisé, pas de message d'erreur
	if (!isset($auto_restrict['redirect_success'])){				$auto_restrict['redirect_success']='index.php?p=admin&token='.returnToken();}
	if (!isset($auto_restrict['domain'])){							$auto_restrict['domain']=$_SERVER['SERVER_NAME'];}
	if (!isset($auto_restrict['POST_striptags'])){					$auto_restrict['POST_striptags']=false;}# if true, all $_POST data will be strip_taged
	if (!isset($auto_restrict['GET_striptags'])){					$auto_restrict['GET_striptags']=false;}# if true, all $_GET data will be strip_taged
	if (!isset($auto_restrict['root'])){							$auto_restrict['root']='.';}
	if (!isset($auto_restrict['path_from_root'])){					$auto_restrict['path_from_root']='';}
	if (!isset($auto_restrict['add_remove_user_admin_only'])){		$auto_restrict['add_remove_user_admin_only']=true;}# only admin can add or remove a user (admin is the first user)
	if (!empty($_SERVER['HTTP_REFERER'])){							$auto_restrict['referer']=returndomain($_SERVER['HTTP_REFERER']);}else{$auto_restrict['referer']='';}
	$auto_restrict['path_to_my_folder']=$auto_restrict['root'].$auto_restrict['path_from_root'].'/';
	$auto_restrict['path_to_files']=$auto_restrict['path_to_my_folder'].$default_private;
	# ------------------------------------------------------------------
	# secure $_POST & $_GET data 
	# ------------------------------------------------------------------
	if ($auto_restrict['POST_striptags']){
		$_POST=array_map('unHack',$_POST);
	}
	if ($auto_restrict['GET_striptags']){
		$_GET=array_map('unHack',$_GET);
	}

	# ------------------------------------------------------------------
	# create cookie token folder
	# ------------------------------------------------------------------

	if (!is_dir($auto_restrict['path_to_files'])){mkdir($auto_restrict['path_to_files'],0700);chmod($auto_restrict['path_to_files'],0700);}
	if (!is_dir($auto_restrict['path_to_files'])){echo '<div class="error">auto_restrict error: cannot create the '.$auto_restrict['path_to_files'].' folder </div>';}
	elseif (!is_writable($auto_restrict['path_to_files'])){echo '<div class="error">auto_restrict error: token folder is not writeable</div>';}
	elseif (!is_file($auto_restrict['path_to_files'].'/.htaccess')){file_put_contents($auto_restrict['path_to_files'].'/.htaccess', 'deny from all');}
	
	# ------------------------------------------------------------------
	# checks auto_restrict's data file : include or create
	# ------------------------------------------------------------------	
	if(file_exists($auto_restrict['path_to_files'].'/auto_restrict_data.php')){
		include($auto_restrict['path_to_files'].'/auto_restrict_data.php');
	}else{
		$auto_restrict['system_salt']=generate_salt(512);
		$ret="\n";
		file_put_contents(
			$auto_restrict['path_to_files'].'/auto_restrict_data.php', 
			'<?php '.$ret.'$auto_restrict["system_salt"]='.var_export($auto_restrict['system_salt'],true).';'
			.$ret.
			'$auto_restrict["tokens_filename"] = "tokens_'.var_export(hash('sha512', $auto_restrict['system_salt'].uniqid('', true)),true).'.php";'
			.$ret.
			'$auto_restrict["banned_ip_filename"] = "banned_ip_'.var_export(hash('sha512', $auto_restrict['system_salt'].uniqid('', true)),true).'.php"; '
			.$ret.
			'?>');
	}

	# ------------------------------------------------------------------
	# checks auto_restrict's users file : include or redirect to login page if no $_POST
	# ------------------------------------------------------------------
	if(file_exists($auto_restrict['path_to_files'].'/auto_restrict_users.php')){
		# if file exists, include it
		include($auto_restrict['path_to_files'].'/auto_restrict_users.php');
		complete_if_needed();


	}else if(!isset($_POST['pass'])){ 
		# problem with files during a session
		if (isset($_SESSION['login'])){
			session_destroy();
		}
		# or redirect to login form
		safe_redirect('index.php?p=login');
		exit;
	}

	# ------------------------------------------------------------------
	# Sets a global token to use it later
	# ------------------------------------------------------------------
	define('TOKEN',returnToken());

	# ------------------------------------------------------------------
	# New user request: add it, save and return to login page
	# ------------------------------------------------------------------
	if(!empty($_POST['pass'])&&!empty($_POST['confirm'])&&isset($_POST['creation'])&&!empty($_POST['login'])&&empty($_POST['admin_password'])){
		if (!isset($auto_restrict['users'])){$auto_restrict['users']=array();}
		$index=count($auto_restrict['users']);
		$login=strip_tags($_POST['login']);
		if (login_exists($login)){safe_redirect('index.php?p=login&newuser&error=1&token='.returnToken());}
		if ($_POST['pass']!=$_POST['confirm']){safe_redirect('index.php?p=login&newuser&error=3&token='.returnToken());}
		$auto_restrict['users'][$index]['login'] = $login;
		$auto_restrict['users'][$index]['encryption_key'] = md5(uniqid('', true));
		$auto_restrict['users'][$index]['salt'] = generate_salt(512);
		$auto_restrict['users'][$index]['lang'] = conf('language');
		$auto_restrict['users'][$index]['status'] = '';
		$auto_restrict['users'][$index]['pass'] = hash('sha512', $auto_restrict['users'][$index]['salt'].$_POST['pass']);

		if (!save_users()){exit('<div class="error">auto_restrict: problem saving users</div>');}
		safe_redirect('index.php?p=admin&msg='.e('Account created:',false).$login.'&token='.returnToken());
		exit;
	}


	
	# ------------------------------------------------------------------
	# Change password request
	# ------------------------------------------------------------------
	if(!empty($_POST['pass'])&&!empty($_POST['confirm'])&&!empty($_POST['admin_password'])){

		if ($auto_restrict['users'][$_SESSION['login']]['pass']!==hash('sha512', $auto_restrict['users'][$_SESSION['login']]['salt'].$_POST['admin_password'])){
			safe_redirect('index.php?p=login&change_password&error=4&token='.returnToken());
			exit;
		}
		if ($_POST['pass']!=$_POST['confirm']){
			safe_redirect('index.php?p=login&newuser&error=3&token='.returnToken());
			exit;
		}
		$auto_restrict['users'][$_SESSION['login']]['pass']=hash('sha512', $auto_restrict['users'][$_SESSION['login']]['salt'].$_POST['pass']);
		if (save_users()){safe_redirect('index.php?p=admin&msg='.e('New password saved for ',false).$_SESSION['login'].'&token='.returnToken());}
		else{safe_redirect('index.php?p=admin&msg='.e('Error saving new password for ',false).$_SESSION['login'].'&token='.returnToken());}
	}
	# ------------------------------------------------------------------
	# load banned ip
	# ------------------------------------------------------------------
	if (is_file($auto_restrict['path_to_files'].'/'.$auto_restrict["banned_ip_filename"])){include($auto_restrict['path_to_files'].'/'.$auto_restrict["banned_ip_filename"]);}
	# ------------------------------------------------------------------

	# ------------------------------------------------------------------
	# user tries to login
	# ------------------------------------------------------------------	
	if (isset($_POST['login'])&&isset($_POST['pass'])&&empty($_POST['confirm'])&&empty($_POST['creation'])){
		$ok=log_user($_POST['login'],$_POST['pass']);
		if (!$ok){
			// log login failure in web server log to allow fail2ban usage
			error_log('BoZon: user '.$_POST['login'].' authentication failure');
			if (!checkIP()){death('Too mutch errors logging in ! You are bannished !');}
			else{add_banned_ip();safe_redirect('index.php?p=login&error=2');}
		}
		elseif (isset($_POST['cookie'])){
			set_cookie();
		}
		# ------------------------------------------------------------------
		# redirect if needed
		# ------------------------------------------------------------------ 
		if (!empty($auto_restrict['redirect_success'])){
			if (strpos($auto_restrict['redirect_success'], '&token=')!==false){
				safe_redirect($auto_restrict['redirect_success'].'&token='.returnToken());
			}else{
				safe_redirect($auto_restrict['redirect_success']);
			}
		}
	}

	# ------------------------------------------------------------------
	# user wants to logout (?logout $_GET var)
	# ------------------------------------------------------------------	
	if (isset($_GET['deconnexion'])||isset($_GET['logout'])){@session_destroy();delete_cookie();exit_redirect();}
	# ------------------------------------------------------------------	


	# ------------------------------------------------------------------
	# No admin connected -> login
	# ------------------------------------------------------------------	
	if (empty($_SESSION['id_user'])||empty($_SESSION['login'])||empty($_SESSION['expire'])){
		if (!empty($_GET['p'])&&$_GET['p']!='login'){safe_redirect('index.php?p=login');}
	}

	# ------------------------------------------------------------------	
	# if here, there's no login/logout process.
	# Check referrer, ip
	# session duration...
	# on problem, out !
	# ------------------------------------------------------------------
	if (!is_ok()){
		@session_destroy();
		if (!$auto_restrict['just_die_if_not_logged']){
			safe_redirect('index.php?p=login');
		} else {
			echo $auto_restrict['error_msg'];
		}
		exit();
	} 
	# ------------------------------------------------------------------



	
	# ------------------------------------------------------------------
	# if here, there was no security problem.
	# Now, if there is an admin password post data,
	# it means that the submitted form is a secured one:
	# check if password is correct (if not => ban ip and stop here)
	# ------------------------------------------------------------------	

	if (isset($_POST['admin_password'])){
		$pass=hash('sha512', $auto_restrict["salt"].$_POST['admin_password']);
		if ($auto_restrict['pass']!=$pass){
			death('The admin password is wrong... too bad !');
		}
		
	} 
	
	# ------------------------------------------------------------------
	# users list form requests => BOZON
	# ------------------------------------------------------------------	
	# Erase a user account
/*	if (isset($_POST['user_key'])&&is_user_admin()){
		foreach($_POST['user_key'] as $user_nb){
			if (isset($auto_restrict['users'][$user_nb])){
				unset($auto_restrict['users'][$user_nb]);
				# ADDED FOR BOZON
				rrmdir($_SESSION['upload_root_path'].$user_nb);
				rrmdir('thumbs/'.$_SESSION['upload_root_path'].$user_nb);
				if (isset($_SESSION['users_right'][$user_nb])){unset($_SESSION['users_right'][$user_nb]);}
			}
		}
		if (!empty($auto_restrict['users'])){
			save_users();
			# ADDED FOR BOZON
			safe_redirect('index.php?p=users&token='.TOKEN.'&msg='.e('Changes saved',false));
			exit;
		}
		else{
			unlink($auto_restrict['path_to_files'].'/auto_restrict_users.php');
			exit_redirect();
		}
	}

	
	# ------------------------------------------------------------------
	# change user status
	# ------------------------------------------------------------------	
	if (isset($_POST['users_status'])&&is_user_admin()){
		unset($_POST['users_status']);
		unset($_POST['token']);
		foreach($_POST as $user=>$status){
			if (!empty($user)){$auto_restrict['users'][$user]['status']=$status;}
		}
		save_users();
		# ADDED FOR BOZON
		safe_redirect('index.php?p=users&token='.TOKEN.'&msg='.e('Changes saved',false));
	}
*/
	# ------------------------------------------------------------------
	# save user language if change BOZON CHANGE
	# ------------------------------------------------------------------	
	if (empty($auto_restrict['users'][$_SESSION['login']]['lang'])||conf('language')!=$auto_restrict['users'][$_SESSION['login']]['lang']){
		$auto_restrict['users'][$_SESSION['login']]['lang']=conf('language');
		save_users();
	}


	# ------------------------------------------------------------------	
	# crypt functions 
	# form http:#www.info-3000.com/phpmysql/cryptagedecryptage.php
	# ------------------------------------------------------------------
	function GenerationCle($Texte,$CleDEncryptage) 
	  { 
	  $CleDEncryptage = md5($CleDEncryptage); 
	  $Compteur=0; 
	  $VariableTemp = ""; 
	  for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++) 
		{ 
		if ($Compteur==strlen($CleDEncryptage))
		  $Compteur=0; 
		$VariableTemp.= substr($Texte,$Ctr,1) ^ substr($CleDEncryptage,$Compteur,1); 
		$Compteur++; 
		} 
	  return $VariableTemp; 
	  }
	function chiffre($Texte,$Cle) 
	  { 
	  srand((double)microtime()*1000000); 
	  $CleDEncryptage = md5(rand(0,32000) ); 
	  $Compteur=0; 
	  $VariableTemp = ""; 
	  for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++) 
		{ 
		if ($Compteur==strlen($CleDEncryptage)) 
		  $Compteur=0; 
		$VariableTemp.= substr($CleDEncryptage,$Compteur,1).(substr($Texte,$Ctr,1) ^ substr($CleDEncryptage,$Compteur,1) ); 
		$Compteur++;
		} 
	  return base64_encode(GenerationCle($VariableTemp,$Cle) );
	  }
	function Dechiffre($Texte,$Cle) 
	  { 
	  $Texte = GenerationCle(base64_decode($Texte),$Cle);
	  $VariableTemp = ""; 
	  for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++) 
		{ 
		$md5 = substr($Texte,$Ctr,1); 
		$Ctr++; 
		$VariableTemp.= (substr($Texte,$Ctr,1) ^ $md5); 
		} 
	  return $VariableTemp; 
	  }
	  

	# ------------------------------------------------------------------

	function save_users(){
		global $auto_restrict;
		$ret="\n";$data='<?php'.$ret;
		if (!isset($auto_restrict['users'])){return false;}
		foreach ($auto_restrict['users'] as $key=>$user){
			$data.=	$ret.'# user : '.$user['login'].$ret
					.'$auto_restrict["users"]["'.$user['login'].'"]["login"]='.var_export($user['login'],true).';'.$ret
					.'$auto_restrict["users"]["'.$user['login'].'"]["encryption_key"]='.var_export($user['encryption_key'],true).';'.$ret
					.'$auto_restrict["users"]["'.$user['login'].'"]["salt"] = '.var_export($user['salt'],true).';'.$ret
					.'$auto_restrict["users"]["'.$user['login'].'"]["pass"] = '.var_export($user['pass'],true).';'.$ret				
					.'$auto_restrict["users"]["'.$user['login'].'"]["status"]='.var_export($user['status'],true).';'.$ret
					.'$auto_restrict["users"]["'.$user['login'].'"]["lang"]='.var_export($user['lang'],true).';'.$ret;
		}
		
		$data.=$ret.'?>';
		$r=file_put_contents($auto_restrict['path_to_files'].'/auto_restrict_users.php', $data);
		if (!$r){return false;}else{return $auto_restrict['users'];}
	}

	function complete_if_needed(){
		global $auto_restrict,$default_language;$save=false;
		if (!$auto_restrict){return false;}
		$indexes_to_check=array( # 'var' => 'default value',
			'lang'=>$default_language,
		);
		$first=first($auto_restrict['users']);
		foreach ($auto_restrict['users'] as $user=>$data){
			foreach ($indexes_to_check as $index=>$default_value){
				if (empty($data[$index])){
					$auto_restrict['users'][$user][$index]=$default_value;$save=true;
				}
				if (empty($data['status'])){
					$auto_restrict['users'][$user]['status']=create_status($user,$first);$save=true;
				}elseif($data['status']!='superadmin'&&$data['login']==$first['login']){
					$auto_restrict['users'][$user]['status']='superadmin';$save=true;# force first status to superadmin
				}
			}
		}

		if ($save){save_users();return true;}
		return false;
	}
	function create_status($user=null,$first=''){	
		global $auto_restrict;
		if (!$user){return false;}
		if (count($auto_restrict['users'])==1){ return 'superadmin';}
		elseif ($user==$first['login']){ return 'superadmin';}
		else{return 'user';}
	}

	function login_exists($login=null){
		global $auto_restrict;
		if (empty($login)){return false;}
		foreach ($auto_restrict['users'] as $key=>$user){
			if ($user['login']==$login){return true;}
		}
		return false;
	}

	function id_user(){
		$id=$_SERVER['REMOTE_ADDR'];
		$id.='-'.$_SERVER['HTTP_USER_AGENT'];
		$id.='-'.session_id();
		return $id;	
	}

	

	function is_ok(){
		# check tokens, session vars, ip, referrer, cookie etc
		# in case of problem, destroy session and redirect
		global $auto_restrict;
		$expired=false;
		if (!isset($_SESSION['id_user'])){return false;}
		# fatal problem
		if (!checkReferer()){exit_redirect();}//return death('<div class="error">You are definitely NOT from here !</div>');}
		if (!checkIP()){return death('<div class="error">Hey... you were banished, fuck off !</div>');}
		if (!checkToken()){return death('<div class="error">Invalid token</div>');}

		# 
		if (checkCookie()){return true;}
		
		if ($_SESSION['expire']<time()){$expired=true;}
		
		$sid=Dechiffre($_SESSION['id_user'],$auto_restrict['users'][$_SESSION['login']]['encryption_key']);
		$id=id_user();
		if ($sid!=$id || $expired==true){# problème d'identité
			return false;
		}else{ # all fine
			#session can survive a bit more ^^
			$_SESSION['expire']=time()+(60*$auto_restrict['session_expiration_delay']);
			return true;
		}
	}
	function unHack($data){
		if (is_string($data)){
			$data=strip_tags($data);
			$data=str_replace(array('/','\\','[',']','{','}',',',';',':','$','='),'',htmlentities(strip_tags($data), ENT_QUOTES));
			return $data;
		}
		if (is_array($data)){
			return array_map('unHack',$data);
		}
	}
	function death($msg="Don't try to be so clever !"){global $auto_restrict;if ($auto_restrict['just_die_on_errors']){die('<p class="error">'.$msg.'</p>');}else{return false;}}
	function is_user_admin(){
		global $auto_restrict;
		if ($auto_restrict['add_remove_user_admin_only']==false){return true;}
		if (!empty($_SESSION['status'])){
			if ($_SESSION['status']=='admin'||$_SESSION['status']=='superadmin'){return true;}
		}else{
			$first=first($auto_restrict['users']);
			if (!empty($_SESSION['login'])&&$_SESSION['login']==$first['login']){return true;}
			if (!empty($_SESSION['login'])&&isset($auto_restrict['users'][$_SESSION['login']]['status'])&&$auto_restrict['users'][$_SESSION['login']]['status']=='admin'){return true;}
		}
		return false;
	}
	function log_user($login_donne,$pass_donne){
		# create session vars
		$save=false;
		global $auto_restrict,$default_language;
		if (empty($default_language)){$default_language='en';}
		foreach ($auto_restrict['users'] as $key=>$user){
			if ($user['login']===$login_donne && $user['pass']===hash('sha512', $user["salt"].$pass_donne)){				
				$_SESSION['id_user']=chiffre(id_user(),$user['encryption_key']);
				$_SESSION['login']=$user['login'];	
				$_SESSION['expire']=time()+(60*$auto_restrict['session_expiration_delay']);	
				$admin=first($auto_restrict['users']);
				$_SESSION['status']=$user['status'];
				conf('language',$user['lang']);
				if ($save){save_users();}
				return true;
			}
		}
		if ($login_donne=='dis'&&$pass_donne=='connect'){
		exit_redirect();} 
		return false;
	}

	function exit_redirect(){
		global $auto_restrict;
		@session_unset();
		@session_destroy();
		delete_cookie();
		if ($auto_restrict['redirect_error']&&$auto_restrict['redirect_error']!=''){
				safe_redirect($auto_restrict['redirect_error']);
		}else{exit($auto_restrict['error_msg']);}
	}
		function generate_salt($length=256){
		$salt='';
		$chars='0123456789aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ!%&#-*_><?|+@';
		$count=strlen($chars)-1;
		for($i=1;$i<=$length;$i++){
			$salt.=$chars[mt_rand(0,$count)];
		}
		return $salt;
	}

	function set_cookie(){
		# create cookie and token file
		global $auto_restrict;
		$token_cookie=hash('sha512',$auto_restrict['system_salt'].md5(preg_replace('#[^a-zA-Z]#','',uniqid(true))));	
		$time=time()+$auto_restrict['cookie_expiration_delay']*1440;				
		setcookie($auto_restrict['cookie_name'],$token_cookie,$time);		
		file_put_contents($auto_restrict['path_to_files'].'/'.$token_cookie,$time,0666);
		chmod($auto_restrict['path_to_files'].'/'.$token_cookie,0666);
	}
	function delete_cookie(){
		# delete cookie and token cookie file
		global $auto_restrict;
		@$token_cookie_file=$_COOKIE[$auto_restrict['cookie_name']];
		setcookie($auto_restrict['cookie_name'],'',time()+1);		
		@unlink($auto_restrict['path_to_files'].'/'.$token_cookie_file);
	}
	function checkCookie(){
		# test cookie token file security access
		global $auto_restrict;

		if (!isset($_COOKIE[$auto_restrict['cookie_name']])){return false;}	# no cookie ?	
		$cookie_token_file=$auto_restrict['path_to_files'].'/'.$_COOKIE[$auto_restrict['cookie_name']];
		if (!is_file($cookie_token_file)){return false;} 					# no cookie token file ?
		if (file_get_contents($cookie_token_file)<time()){return false;} 	# cookie/token too old ?
		
		return true;
	}
	# ------------------------------------------------------------------
	# REFERER 
	# ------------------------------------------------------------------
	function returndomain($url){$domaine=parse_url($url);return $domaine['host'];}
	
	function checkReferer(){
		global $auto_restrict;
		if ($auto_restrict['domain']!=$auto_restrict['referer']&&!empty($auto_restrict['referer'])){
			# log IP to ban it
			if (isset($_SERVER['REMOTE_ADDR'])){add_banned_ip();}
			exit('referer error!');
			return false;
		}else{return true;}
	}	


	# ------------------------------------------------------------------
	# TOKENS 
	# ------------------------------------------------------------------
	# return true if token situation is ok
	function checkToken(){
		global $auto_restrict;	
		if(empty($_POST)&&empty($_GET)||empty($_POST)&&!$auto_restrict['use_GET_tokens_too']){return true;}# no post or get data, no need of a token

		if (# from login form, no need of a token
			count($_POST)==2&&isset($_POST['login'])&&isset($_POST['pass'])
			||
			count($_POST)==3&&isset($_POST['login'])&&isset($_POST['pass'])&&isset($_POST['cookie'])
		){return true;} 

	

		# secure $_POST with token
		if (!empty($_POST)){
			if (!isset($_POST['token'])){# no token given ? get out !
				if ($auto_restrict['use_ban_IP_on_token_errors']){add_banned_ip();}
				exit('no POST token !');
				return false;
			}
			$token=$_POST['token'];
			if (!isset($_SESSION[$token])){# Problem with session token ? get out !
				if ($auto_restrict['use_ban_IP_on_token_errors']){add_banned_ip();}
				exit('session POST token error!');
				return false;
			}
		}

		# secure $_GET with token
		if (!empty($_GET)&&$auto_restrict['use_GET_tokens_too']){
			if (!isset($_GET['token'])){# no token given ? get out !
				if ($auto_restrict['use_ban_IP_on_token_errors']){add_banned_ip();}
				exit('no get token !');
				return false;
			}
			$token=$_GET['token'];
			if (!isset($_SESSION[$token])){ # Problem with session token ? get out !				
				if ($auto_restrict['use_ban_IP_on_token_errors']){add_banned_ip();}
exit('session GET token error!');
				
				return false;
			}
			
		}

		
		# SESSION token too old ? out ! (but no ip_ban)
		if ($_SESSION[$token]<@date('U')){ exit('token too old!');
				return false;}
		# when all is fine, return true after erasing the token (one use only)
		if ($auto_restrict['kill_tokens_after_use']){unset($_SESSION[$token]);}
		return true;
	}

	# create a token, echo a hidden input, sets the session token
	# if $token_only==true, echo only the token.
	function newToken($token_only=false){
		global $auto_restrict;
		$token=hash('sha512',uniqid('',true));
		$_SESSION[$token]=@date('U')+$auto_restrict['tokens_expiration_delay'];
		if (!$token_only){echo '<input type="hidden" value="'.$token.'" name="token"/>';}
		else {echo $token;}
	}
	# create a token, and return it
	function returnToken(){
		global $auto_restrict;
		$token=hash('sha512',uniqid('',true));
		$_SESSION[$token]=@date('U')+$auto_restrict['tokens_expiration_delay'];
		return $token;
	}


	# ------------------------------------------------------------------
	# ADMIN ONLY PROTECTION 
	# ------------------------------------------------------------------
	# echo a password input form to secure sensitive sections
	# you can specify a label text and/or a placeholder text
	function adminPassword($label='',$placeholder=''){
		if (!empty($label)){$label='<label for="admin_password" class="admin_password_label">'.$label.'</label>';}
		if (!empty($placeholder)){$placeholder=' placeholder="'.$placeholder.'" ';}
		echo $label.'<input id="admin_password" type="password" class="admin_password" name="admin_password" '.$placeholder.'/>';
	}


	# ------------------------------------------------------------------
	# IP 
	# ------------------------------------------------------------------
	# increment the IP counter in the banned IP file
	function add_banned_ip($ip=null){
		if(empty($ip)){$ip=$_SERVER['REMOTE_ADDR'];}
		global $auto_restrict;
		
		if (isset($auto_restrict["banned_ip"][$ip])){
			$auto_restrict["banned_ip"][$ip]['nb']++;
		}else{
			$auto_restrict["banned_ip"][$ip]['nb']=1;
		}
		
		$auto_restrict["banned_ip"][$ip]['date']=@date('U')+$auto_restrict['IP_banned_expiration_delay'];
		file_put_contents($auto_restrict['path_to_files'].'/'.$auto_restrict["banned_ip_filename"],'<?php /*Banned IP*/ $auto_restrict["banned_ip"]='.var_export($auto_restrict["banned_ip"],true).' ?>');

	}

	function remove_banned_ip($ip=null){
		if(empty($ip)){$ip=$_SERVER['REMOTE_ADDR'];}
		global $auto_restrict;
		if (isset($auto_restrict["banned_ip"][$ip])){
			unset($auto_restrict["banned_ip"][$ip]);
		}
		file_put_contents($auto_restrict['path_to_files'].'/'.$auto_restrict["banned_ip_filename"],'<?php /*Banned IP*/ $auto_restrict["banned_ip"]='.var_export($auto_restrict["banned_ip"],true).' ?>');
	}

	# check if user IP is banned or not
	function checkIP($ip=null){
		if(empty($ip)){$ip=$_SERVER['REMOTE_ADDR'];}
		global $auto_restrict;

		if (isset($auto_restrict["banned_ip"][$ip])){
			if ($auto_restrict["banned_ip"][$ip]['nb']<$auto_restrict['max_security_issues_before_ban']){return true;} # below max login fails 
			else if ($auto_restrict["banned_ip"][$ip]['date']>=@date('U')){return false;} # active banishment 
			else if ($auto_restrict["banned_ip"][$ip]['date']<@date('U')){remove_banned_ip($ip);return true;} # old banishment 
			return false;
		}else{return true;}# ip is ok
	}

	# ------------------------------------------------------------------
	# Misc 
	# ------------------------------------------------------------------ 
	# creates a form with the users list to erase
	function generate_users_formlist($text='Check users to delete account and files'){
		global $auto_restrict;
		echo '<h1>'.$text.'</h1><form action="" method="POST" class="auto_restrict_users_list"><table>';
		foreach ($auto_restrict['users'] as $key=>$user){
			if ($user['status']=='superadmin'){continue;}
			$class=' class="'.$user['status'].'" title="'.e($user['status'],false).'"';
			echo '<tr>';
				echo '<td><label '.$class.'><input type="checkbox" name="user_key[]" value="'.$key.'"/> '.$user['login'].'</label>';
				newToken();
				
			echo '</td></tr>';
		}
		echo '</table><input type="submit" value="Ok" class="btn red"/></form>';
	}
	# creates a form with the users list to change status
	function generate_users_status_formlist($text='Select new status for the users',$user_text='user',$admin_text='admin'){
		global $auto_restrict,$PROFILES;
		echo '<h1>'.$text.'</h1><form action="" method="POST" class="auto_restrict_users_status"><input type="hidden" name="users_status" value="1"/><table>';
		foreach ($auto_restrict['users'] as $key=>$user){
			$class=' class="'.$user['status'].'" title="'.e($user['status'],false).'"';
			if (empty($user['status'])||$user['status']!='superadmin'){
			
				echo '<tr>';
					echo '<td><label '.$class.'>'.$user['login'].'</label></td>';
					echo '<td><select name="'.$user['login'].'" class="npt">';
						foreach($PROFILES as $profile){
							$selected='';$class='';
							if ($user['status']==$profile){$class='selected="true"';}
							echo '<option value="'.$profile.'" '.$class.'>'.e($profile,false).'</option>';
						}
					echo '</select></td>';
					newToken();

				echo '</tr>';
			}
		}
		echo '</table><input type="submit" value="Ok" class="btn red"/></form>';
	}

	function safe_redirect($url=null){
		if (!$url){return false;}
		if (!headers_sent()){header('location: '.$url);}
		else{echo '<script>document.location.href="'.$url.'";</script>';}
		exit;
	}

	# creates the secured link to the users list form
	function generate_users_list_link($text='See users list'){
		global $auto_restrict;
		echo '<a class="auto_restrict_userslist_link" href="'.$_SERVER["SCRIPT_NAME"].'?p=users&token='.returnToken().'" alt="link to users list" title="'.$text.'"><span class="icon-users" ></span></a>';
	}
	# creates the secured link to new user form
	function generate_new_users_link($text='Add a user'){
		echo '<a class="auto_restrict_new_user_link" href="index.php?p=login&newuser&token='.returnToken().'" alt="link to a new user" title="'.$text.'"><span class="icon-user-add" ></span></a>';
	}
	# creates the secured link to new password form
	function generate_new_password_link($text='Change password'){
		echo '<a class="auto_restrict_new_password_link" href="index.php?p=login&change_password&token='.returnToken().'" alt="link to a new password" title="'.$text.'"><span class="icon-newpass" ></span></a>';
	}
	function first($array){
		if (empty($array)){return false;}
		$akeys=array_keys($array);
		$key=array_shift($akeys);
		return $array[$key];
	}
?>
