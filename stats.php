<?php
	/**
	* BoZoN stats page:
	* lists access log
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	$button_previous=$button_next=$paginate=$message=$log_list='';$from=0;
	include ('auto_restrict.php'); # Admin only!
	include('core.php');

	# search/filter
	if (!empty($_GET['filter'])){
		$_SESSION['filter']=$_GET['filter'];
	}else{
		$_SESSION['filter']='';
	}

	if (!empty($_GET['start'])){$from=$_GET['start'];}
	@$stats=unserialize(file_get_contents($_SESSION['stats_file']));
	$stats=array_reverse($stats);
	if (empty($stats)){$message='No stats';}
	else{
		for ($index=$from;$index<$from+$_SESSION['stats_max_lines'];$index++){//($stats as $client){
			if (!empty($stats[$index])){
			$log_list.='
				<tr>
					<td>'.$stats[$index]['date'].'</td>
					<td>'.$stats[$index]['file'].' (
					'.$stats[$index]['id'].')</td>
					<td>'.$stats[$index]['ip'].'</td>
					<td>'.$stats[$index]['referrer'].'</td>
					<td>'.$stats[$index]['host'].'</td>
				</tr>';
			}
		}
	}
	$t=returnToken();
	if (!empty($stats[$from+$_SESSION['stats_max_lines']])){
		$start=$from+$_SESSION['stats_max_lines'];
		$button_next='<a class="button" href="stats.php?start='.$start.'&token='.$t.'">&#8680;</a>';
	}
	if ($from>0){
		$start=$from-$_SESSION['stats_max_lines'];
		if ($start<0){$start=0;}
		$button_previous='<a class="button" href="stats.php?start='.$start.'&token='.$t.'">&#8678;</a>';
	}
	$nb=count($stats);$c=0;
	for($index=0;$index<$nb;$index+=$_SESSION['stats_max_lines']){	
		$c++;	
		if ($index!=$from){
			$paginate.='<a class="button" href="stats.php?start='.$index.'&token='.$t.'">'.$c.'</a> ';
		}else{
			$paginate.='<em class="">'.$c.'</em> ';
		}
	}
?>

<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" charset="UTF-8">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
	    <meta name="google" content="noimageindex">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8" />
		<link rel="shortcut icon" type="/image/png" href="design/<?php echo $_SESSION['theme'];?>/img/bozonlogo2.png">
		<link rel="stylesheet" type="text/css" href="design/<?php echo $_SESSION['theme'];?>/style.css">
		<!--[if IE]><script> document.createElement("article");document.createElement("aside");document.createElement("section");document.createElement("footer");</script> <![endif]-->

		<title>BoZoN: LOG</title>
	</head>

	<body id="body" class="admin stats" >

	<header><div class="overlay">
		
		<p class="logo"><strong>BoZoN</strong>: <?php e('Drag, drop, share.');?></p>
		<?php include('menu.php');?>

		<div style="clear:both"></div>
		</div>

	</header>
	<?php echo $message;?>

	<div id="content">
		

<div class="window">
<header><?php e('Access log');?></header>
<table class="sortable">
<thead>
	<tr>
		<th><?php e('Date');?></th>
		<th><?php e('File');?></th>
		<th><?php e('IP');?></th>
		<th><?php e('Origin');?></th>
		<th><?php e('Host');?></th>
	</tr>
	</thead>
	<tbody>
	<?php echo $log_list;?>

	</tbody>

	<tfoot>
		<tr><td><?php echo $button_previous;?></td><td></td><td><?php echo $paginate;?></td><td class="total_entries"><?php echo '[total: '.count($stats).']';?></td><td><?php echo $button_next;?></td></tr>
	</tfoot>
</table>
		</div>
			
		
	</div>
	<footer>

		<div class="credits">Bozon v<?php echo VERSION;?> - <?php e('tiny file sharing app, coded with love and php by ');?> <a href="http://warriordudimanche.net">Bronco</a> - <a href="admin.php?deconnexion"><?php e('Logout'); ?></a></div>
		<a href="https://github.com/broncowdd/BoZoN" class="github" title="<?php e('fork me on github');?>">&nbsp;</a>
	</footer>
<script src="sorttable.js"></script>
<script>
	menu=document.getElementById('menu');
	menu_icon=document.getElementById('menu_icon');
	body=document.getElementById('body');
	cl='open';

	// block closing menu by clicking on it
	menu.addEventListener('click', function(event){
        if(event.stopPropagation) { event.stopPropagation(); }		
	});

	// menu appears and vanish
	menu_icon.addEventListener('click', function(event){
		if (menu.classList) {
		    menu.classList.toggle(cl)
		} else {
		    var classes = menu.className.split(' ')
		    var existingIndex = classes.indexOf(cl)
		    if (existingIndex >= 0)
		      classes.splice(existingIndex, 1)
		    else
		      classes.push(cl);
		    menu.className = classes.join(' ')
		}
        if(event.preventDefault) { event.preventDefault(); }
        if(event.stopPropagation) { event.stopPropagation(); }
		return false;
	});
	// close menu on clicking outside
	body.addEventListener('click', function(event){
		if (menu.classList) {
		   menu.classList.remove(cl);
		} else {
		   var classes = el.className.split(' ')
		    var existingIndex = classes.indexOf(cl)
		    if (existingIndex >= 0){ classes.splice(existingIndex, 1);}		    
		    el.className = classes.join(' ')
		}
        
		
	});

</script>
	</body>
</html>