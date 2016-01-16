<?php 
	/**
	* BoZoN login form:
	* part of auto_restrict lib 
	* @author: Bronco (bronco@warriordudimanche.net)
	**/

	include('core.php');
?>
<head>
	<title>BoZon - Admin</title>
	 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="design/<?php echo $_SESSION['theme'];?>/style.css">
	<link rel="shortcut icon" type="/image/png" href="design/<?php echo $_SESSION['theme'];?>/img/bozonlogo2.png">
	<meta charset="utf-8" />
</head>
<body class="login">
<header>
	<div class="overlay">		
		<p class="logo"><strong>BoZoN</strong>: <?php e('Drag, drop, share.');?></p>
	</div>
</header>
		<div class="form_content">
	<form action='' method='post' name='' >
		
			<?php 
				$f=file_exists($auto_restrict['path_to_files'].'/auto_restrict_pass.php');
				if(!$f){echo '<h2>'.e('Create your account',false).'</h2><hr/>';} 
			?>

			<label for='login'><?php  e('Login')?> </label>
			<input type='text' name='login' id='login' required="required" autofocus/>
			
		<label for='pass'><?php  e('Password')?> </label>
		<input type='password' name='pass' id='pass'  required="required"/>	

		
		<?php if($f){echo '<input id="cookie" type="checkbox" value="cookie" name="cookie"/><label for="cookie">'.e('Stay connected',false).'</label>';} ?>
		

		<input type='submit' value='<?php e('Connect');?>'/>	
	</form>
</div>
</body>