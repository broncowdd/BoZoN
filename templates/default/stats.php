<?php
	/**
	* BoZoN stats page:
	* lists access log
	* @authors
	*   - Bronco (bronco@warriordudimanche.net)
	*   - Eauland (philippe@eauland.com)
	**/
	$button_previous=$button_next=$paginate=$message=$log_list='';$from=0;
	if (!function_exists('newToken')){require_once('core/auto_restrict.php');} # Connected user only !
	if (!is_allowed('access logfile')){safe_redirect('index.php?p=admin&token='.TOKEN);}
	
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
	if (empty($stats)){
    $message=e('No stats',false);
  }
	else{
		for ($index=$from;$index<$from+conf('stats_max_lines');$index++){//($stats as $client){
			if (!empty($stats[$index])){
				if (empty($stats[$index]['access'])){$stats[$index]['access']='-';}
				$log_list.='
				<tr>
					<td class="date">'.date("d/m/Y, H:i:s", strtotime($stats[$index]['date'])).'</td>
					<td class="file">'.$stats[$index]['file'].' ('.$stats[$index]['id'].')</td>
					<td class="owner">'.return_owner($stats[$index]['id']).'</td>
					<td class="ip">'.$stats[$index]['ip'].'</td>
					<td class="ip">'.$stats[$index]['access'].'</td>
					<td class="origin">'.$stats[$index]['referrer'].'</td>
					<td class="host">'.$stats[$index]['host'].'</td>
				</tr>';
			}
		}
	}
	$t=returnToken();
	if (!empty($stats[$from+conf('stats_max_lines')])){
		$start=$from+conf('stats_max_lines');
		$button_next='<a class="button" href="index.php?p=stats&start='.$start.'&token='.$t.'">&#8680;</a>';
	}
	if ($from>0){
		$start=$from-conf('stats_max_lines');
		if ($start<0){$start=0;}
		$button_previous='<a class="button" href="index.php?p=stats&start='.$start.'&token='.$t.'">&#8678;</a>';
	}
	$nb=count($stats);$c=0;
	for($index=0;$index<$nb;$index+=conf('stats_max_lines')){	
		$c++;	
		if ($index!=$from){
			$paginate.='<a class="button" href="index.php?p=stats&start='.$index.'&token='.$t.'">'.$c.'</a> ';
		}else{
			$paginate.='<em class="">'.$c.'</em> ';
		}
	}
?>

<div id="stats">
	
	
	<?php
  if(isset($message) && !empty($message)){
    echo '<p id="message">'.$message.'</p>';
  }else{
  ?>
  
	<div class="pagination">
		<?php echo $button_previous;?><?php echo $paginate;?><?php echo '[total: '.count($stats).']';?><?php echo $button_next;?>
	</div>
	
	<table class="sortable">
	<thead>
		<tr>
			<th class="date"><?php e('Date');?></th>
			<th class="file"><?php e('File');?></th>
			<th class="owner"><?php e('Owner');?></th>
			<th class="ip"><?php e('IP');?></th>
			<th class="ip"><?php e('Access');?></th>
			<th class="origin"><?php e('Origin');?></th>
			<th class="host"><?php e('Host');?></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $log_list;?>
	</tbody>
	</table>
	
	<div class="pagination">
		<?php echo $button_previous;?><?php echo $paginate;?><?php echo '[total: '.count($stats).']';?><?php echo $button_next;?>
	</div>
	
	<p id="trash"><a title="<?php e('Delete all stat data'); ?>" href="index.php?p=stats&kill&token=<?php newToken(true);?>"><span class="icon-trash" ></span> <?php e('Delete all stat data'); ?></a></p>
	
	<div id="feeds"><?php e('Export log:'); ?> <a href="<?php echo $_SESSION['home'];?>?key=<?php echo $_SESSION['api_rss_key'];?>&statrss">Rss</a> <a href="<?php echo $_SESSION['home'];?>?key=<?php echo $_SESSION['api_rss_key'];?>&statjson">Json</a></div>
	<?php
	}
	?>
</div>

<script src="core/js/sorttable.js"></script>

