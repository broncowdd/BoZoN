<?php
  /**
  * BoZoN stats page:
  * lists access log
  * @authors
  *   - Bronco (bronco@warriordudimanche.net)
  *   - Eauland (philippe@eauland.com)
  **/
  $button_previous=$button_next=$paginate=$message=$log_list='';
  $from=0;
  if (!function_exists('newToken')) require_once'core/auto_restrict.php'; // Admin only!
  
  // search/filter
  if (!empty($_GET['filter'])) $_SESSION['filter']=$_GET['filter'];
  else                         $_SESSION['filter']='';
  
  if (isset($_GET['kill']) && file_exists($_SESSION['stats_file'])){
    $stats=array();
    file_put_contents($_SESSION['stats_file'],'<?php /* '.base64_encode(gzdeflate(serialize($stats))).' */ ?>');
  }
  
  if (!empty($_GET['start'])){$from=$_GET['start'];}
  $stats=(file_exists($_SESSION['stats_file']) ? unserialize(gzinflate(base64_decode(substr(file_get_contents($_SESSION['stats_file']),9,-strlen(6))))) : array() );
  $stats=array_reverse($stats);
  if (empty($stats)){
    $message=e('No stats',false);
  }else{
    for($index=$from; $index<$from+$_SESSION['stats_max_lines']; $index++){ //($stats as $client){
      if (!empty($stats[$index])){
      $log_list.='
        <tr>
          <td class="date">'.date("d/m/Y", strtotime($stats[$index]['date'])).'</td>
          <td class="file">'.$stats[$index]['file'].' ('.$stats[$index]['id'].')</td>
          <td class="ip">'.$stats[$index]['ip'].'</td>
          <td class="origin">'.$stats[$index]['referrer'].'</td>
          <td class="host">'.$stats[$index]['host'].'</td>
        </tr>';
      }
    }
  }
  $t=returnToken();
  if (!empty($stats[$from+$_SESSION['stats_max_lines']])){
    $start=$from+$_SESSION['stats_max_lines'];
    $button_next=' <a href="index.php?p=stats&amp;start='.$start.'&amp;token='.$t.'">&gt;</a>';
  }
  if ($from>0){
    $start=$from-$_SESSION['stats_max_lines'];
    if ($start<0) $start=0;
    $button_previous='<a href="index.php?p=stats&amp;start='.$start.'&amp;token='.$t.'">&lt;</a> ';
  }
  $nb=count($stats);$c=0;
  for($index=0;$index<$nb;$index+=$_SESSION['stats_max_lines']){	
    $c++;	
    if($index!=$from) $paginate.='<a href="index.php?p=stats&amp;start='.$index.'&amp;token='.$t.'">'.$c.'</a> ';
    else              $paginate.='<em>'.$c.'</em> ';
  }
?>

<div id="stats">
  <h1><?php e('Access log');?></h1>
  
  <?php
  if(isset($message) && !empty($message)):
    echo '<p id="message">'.$message.'</p>';
  else:
  ?>
  
  <div class="pagination">
    <?php echo $button_previous; ?><?php echo $paginate; ?><?php echo $button_next; ?>
  </div>
  
  <p id="total"><?php e('Total:'); echo ' '.count($stats); ?></p>
  
  <table class="sortable">
  <thead>
    <tr>
      <th class="date"><?php e('Date'); ?></th>
      <th class="file"><?php e('File'); ?></th>
      <th class="ip"><?php e('IP'); ?></th>
      <th class="origin"><?php e('Origin'); ?></th>
      <th class="host"><?php e('Host'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php echo $log_list; ?>
  </tbody>
  </table>
  
  <div class="pagination">
    <?php echo $button_previous; ?><?php echo $paginate; ?><?php echo $button_next; ?>
  </div>
  
  <p id="trash"><a title="<?php e('Delete all stat data'); ?>" href="index.php?p=stats&amp;kill&amp;token=<?php newToken(true); ?>"><?php e('Delete all stat data'); ?></a></p>
  
  <div id="feeds"><?php e('Export log:'); ?> <a href="<?php echo $_SESSION['home']; ?>?key=<?php echo $_SESSION['api_rss_key']; ?>&statrss">Rss</a> <a href="<?php echo $_SESSION['home']; ?>?key=<?php echo $_SESSION['api_rss_key']; ?>&statjson">Json</a></div>
  <?php
  endif;
  ?>
</div>

<script type="text/javascript" src="inc/js/sorttable.js"></script>
<script type="text/javascript">
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
