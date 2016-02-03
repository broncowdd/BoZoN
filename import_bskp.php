<?php include('config.php');?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>BoZoN | Convert id file</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="application-name" content="BoZoN">
		<meta name="msapplication-TileImage" content="templates/<?php echo $default_theme;?>/img/favicon.png">
		<meta name="msapplication-TileColor" content="#2c4aff">
		<link rel="apple-touch-icon" href="templates/<?php echo $default_theme;?>/img/favicon.png">
		<link rel="shortcut icon" type="image/png" href="templates/<?php echo $default_theme;?>/img/favicon.png">
		<link rel="stylesheet" type="text/css" href="templates/<?php echo $default_theme;?>/style.css">
	</head>

	<body>
	<header><div id="logo"></div><h2 class="slogan">Convert user data to new version</h2></header>
		<?php
			# import id.php from version <2.1 (add the profile path to the ids)
			function first($array){
				if (empty($array)){return false;}
				$akeys=array_keys($array);
				$key=array_shift($akeys);
				return $array[$key];
			}
			function save_users(){
				global $auto_restrict,$user,$private;
				$array=$auto_restrict;
				unset($auto_restrict);
				$auto_restrict['users'][$user]['login']=$array['login'];
				$auto_restrict['users'][$user]['encryption_key']=$array['encryption_key'];
				$auto_restrict['users'][$user]['salt']=$array['salt'];
				$auto_restrict['users'][$user]['pass']=$array['pass'];
				$auto_restrict['system_salt']=$array['system_salt'];
				$auto_restrict['tokens_filename']=$array['tokens_filename'];
				$auto_restrict['banned_ip_filename']=$array['banned_ip_filename'];


				$ret="\n";$data='<?php'.$ret;
				if (!isset($auto_restrict['users'])){return false;}
				foreach ($auto_restrict['users'] as $key=>$user){
					$data.=	'# user : '.$user['login'].$ret
							.'$auto_restrict["users"]["'.$user['login'].'"]["login"]="'.$user['login']
							.'";$auto_restrict["users"]["'.$user['login'].'"]["encryption_key"]='.var_export($user['encryption_key'],true)
							.';$auto_restrict["users"]["'.$user['login'].'"]["salt"] = '.var_export($user['salt'],true)
							.'; $auto_restrict["users"]["'.$user['login'].'"]["pass"] = '.var_export($user['pass'],true).';'.$ret;
				}
				$data.=$ret.'?>';
				file_put_contents($private.'/auto_restrict_users.php', $data);
				file_put_contents($private.'/auto_restrict_data.php', '<?php '.$ret.'$auto_restrict["system_salt"]='.var_export($auto_restrict['system_salt'],true).';'.$ret.'$auto_restrict["tokens_filename"] = "tokens_'.var_export($auto_restrict["tokens_filename"],true).'.php";'.$ret.'$auto_restrict["banned_ip_filename"] = "banned_ip_'.var_export($auto_restrict["banned_ip_filename"],true).'.php"; '.$ret.'?>');

			}
			$private=dirname($default_id_file);
			if (isset($_GET['import'])){
				
				
				if (is_file($default_id_file)){$ids=unserialize(gzinflate(base64_decode(substr(file_get_contents($default_id_file),9,-strlen(6)))));}else{exit('No id file found !');}
				if (is_file($private.'/auto_restrict_users.php')){
					include('private/auto_restrict_users.php');
					$user=first($auto_restrict["users"]);
					$user=$user['login'];
				}elseif (is_file($private.'/auto_restrict_pass.php')){
					include('private/auto_restrict_pass.php');
					$user=$auto_restrict["login"];
				}else{exit('No user data file found !');}

				# Convert file paths in id data
				foreach($ids as $id=>$file){
					$ids[$id]=$default_path.$user.'/'.$file;
				}

				# Change uploads folder to new profile folder
				if (is_dir($default_path)){rename(str_replace('/','',$default_path),$user);}

				# Recreate uploads folder
				mkdir($default_path);

				# Move profile folder to uploads folder
				
				if (is_dir($user)){rename($user,$default_path.$user);}
				else{mkdir($default_path.$user);}

				# Write ids data file
				file_put_contents($default_id_file, '<?php /* '.base64_encode(gzdeflate(serialize($ids))).' */ ?>');
				
				# Change user file to userS file
				include($private.'/auto_restrict_pass.php');
				include($private.'/auto_restrict_salt.php');
				save_users();

				unlink($private.'/auto_restrict_pass.php');
				unlink($private.'/auto_restrict_salt.php');
				unlink('import.php');
				echo '<script>document.location.href="index.php?login";</script>';
				exit;
			}else if (isset($_GET['no']) || !is_dir($private)){
				unlink('import.php');
				echo '<script>document.location.href="index.php?login";</script>';
				exit;
			}elseif (is_file($private.'/auto_restrict_pass.php')&&is_file($private.'/auto_restrict_salt.php')&&!is_file($private.'/auto_restrict_users.php')){

		?>
		<div style="padding:10px">
			<h1>Before you begin using Bozon</h1>
			<a href="import.php?import">Previous version &lt; 2.1 ? <br/> Mise à jour d'une version &lt;2.1 ? <br/> ¿ Versión anterior &lt;2.1 ?</a><br/>
			<hr/>
			<a href="import.php?no">Previous version &gt;=2.1 or fresh install <br/> Version antérieure  &gt;=2.1 ou nouvelle installation <br/> Versión anterior  &gt;=2.1 o nueva instalación</a>
		</div>
<?php }else{	unlink('import.php');
				echo '<script>document.location.href="index.php?login";</script>';
				exit;}?>
	</body>
</html>