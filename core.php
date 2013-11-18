<?php 
	define('ID_FILE','id.txt');
	define('UPLOAD_PATH','uploads/');
	$behaviour['FILES_TO_ECHO']=array('txt','js','html','php','htm','shtml','shtm');
	$behaviour['FILES_TO_RETURN']=array('jpg','jpeg','gif','png','pdf','swf');
 
	if (!is_dir(UPLOAD_PATH)){mkdir(UPLOAD_PATH);}
	if (!is_file(UPLOAD_PATH.'index.html')){file_put_contents(UPLOAD_PATH.'index.html',' ');}
	
	if (!is_dir('thumbs/')){mkdir('thumbs/');}
	if (!is_file('thumbs/index.html')){file_put_contents('thumbs/index.html',' ');}

	if (!file_exists(ID_FILE)){$ids=array();store(ID_FILE,$ids);}
	$ids=unstore(ID_FILE);

	function is_in($ext,$type){global $behaviour;if (!empty($behaviour[$type])){return array_search($ext,$behaviour[$type]);}}
	function store($file,$datas){file_put_contents($file,gzdeflate(json_encode($datas)));}
	function unstore($file){return json_decode(gzinflate(file_get_contents($file)),true);}
	function id2file($id){
		global $ids;
		if (isset($ids[$id])){return $ids[$id];}else{return false;}
	}


?>
