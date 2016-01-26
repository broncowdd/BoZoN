  <footer>
    <p><a class="github" href="https://github.com/broncowdd/BoZoN" title="<?php e('Fork me on github'); ?>">&nbsp;</a></p>
    <p id="version">BoZoN <?php echo VERSION;  if (is_admin_connected()&&empty($_GET['f'])){echo ' - <a href="index.php?p=stats&token='.returnToken().'" class="log_link">'.e('Access log file',false).'</a>';};?></p>
  </footer>
</body>
</html>
