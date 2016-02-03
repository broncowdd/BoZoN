<?php
	/**
	* BoZoN stats page:
	* lists access log
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	$button_previous=$button_next=$paginate=$message=$log_list='';$from=0;
	if (!function_exists('newToken')){require_once('core/auto_restrict.php');} # Admin only!

	# search/filter
	if (!empty($_GET['filter'])){
		$_SESSION['filter']=$_GET['filter'];
	}else{
		$_SESSION['filter']='';
	}

	if (isset($_GET['kill']) && file_exists($_SESSION['stats_file'])){
		$stats=array();
		file_put_contents($_SESSION['stats_file'],'<?php /* '.base64_encode(gzdeflate(serialize($stats))).' */ ?>');

	}
	if (!empty($_GET['start'])){$from=$_GET['start'];}
	$stats=(file_exists($_SESSION['stats_file']) ? unserialize(gzinflate(base64_decode(substr(file_get_contents($_SESSION['stats_file']),9,-strlen(6))))) : array() );
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
		$button_next='<a class="button" href="index.php?p=stats&start='.$start.'&token='.$t.'">&#8680;</a>';
	}
	if ($from>0){
		$start=$from-$_SESSION['stats_max_lines'];
		if ($start<0){$start=0;}
		$button_previous='<a class="button" href="index.php?p=stats&start='.$start.'&token='.$t.'">&#8678;</a>';
	}
	$nb=count($stats);$c=0;
	for($index=0;$index<$nb;$index+=$_SESSION['stats_max_lines']){	
		$c++;	
		if ($index!=$from){
			$paginate.='<a class="button" href="index.php?p=stats&start='.$index.'&token='.$t.'">'.$c.'</a> ';
		}else{
			$paginate.='<em class="">'.$c.'</em> ';
		}
	}
?>

		<div style="clear:both"></div>



	<?php echo $message;?>

	<div id="content">
		

<div class="window">
	<header><?php e('Access log');?></header>
	<div class="pagination">
		<?php echo $button_previous;?><?php echo $paginate;?><?php echo '[total: '.count($stats).']';?><?php echo $button_next;?>
	</div>
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
	</table>
	<div class="pagination">
		<?php echo $button_previous;?><?php echo $paginate;?><?php echo '[total: '.count($stats).']';?><?php echo $button_next;?>
	</div>
	<a class="trash" title="" href="index.php?p=stats&kill&token=<?php newToken(true);?>"><?php e('Delete all stat data'); ?></a>
</div>
			
		
	</div>
	<div class="feeds"><a href="<?php echo $_SESSION['home'];?>?key=<?php echo $_SESSION['api_rss_key'];?>&statrss" class="rss btn orange">rss</a> <a href="<?php echo $_SESSION['home'];?>?key=<?php echo $_SESSION['api_rss_key'];?>&statjson" class="json btn blue">Json</a></div>
						
<script src="core/sorttable.js"></script>
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
