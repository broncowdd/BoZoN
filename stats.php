<?php
	/**
	* BoZoN stats page:
	* lists access log
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	$button_previous=$button_next=$paginate=$message=$log_list='';$from=0;
	include ('core/auto_restrict.php'); # Admin only!
	include('core/core.php');

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
	
	include('themes/'.$default_theme.'/stats.php');
?>
