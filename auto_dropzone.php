<?php
if (session_id()==''){session_start();}
/* Auto_dropzone.php v1.2 # Version Bozon !!!!!!!!!
    author: Bronco
    email: bronco@warriordudimanche.net
    web: http://warriordudimanche.net
    licence: free & free ^^ (feel free to use & modify for free)

    based on http://www.script-tutorials.com/html5-drag-and-drop-multiple-file-uploader/ 

    New in 1.3:
    ----------------------------------------------
    - fixed config changes conflict
    New in 1.2:
    - handle form upload errors
    - handle minimal filesize (script config/php.ini value)
    - handle automatic refresh when no errors

    todo:
    ----------------------------------------------
    * fallback for old browsers ?
    * selective uploads paths (depending on mime): if destination_filepath is an array(mime=>path) ->  adapt behaviour.


    How to use it ?
    ----------------------------------------------
    just include this file in your project: the script generates the dropzone and handles the upload.
    If you need, you can configure it like explained below

    configuration / init
    ----------------------------------------------
    you can configure outside this script, before the include('auto_dropzone.php');
    with this kind of init:

  $auto_dropzone=array(
    'destination_filepath'=>'path/to/', 
    'dropzone_text'=>'D&D here !',
    'dropzone_id'=>'drop_images', 
    'dropzone_class'=>'drop_images', 
    'forbidden_filetypes'=>'exe,php',
    'use_style'=>true, // false if you're using an css file
  );
  
    'destination_filepath' key:'destination_filepath'=>"$_SESSION['upload_path']/" (with ending slash)
    if not specified, the destination folder will be destination/ (created on the first start)
    you also can set specific paths for each mime type like that
        'destination_filepath'=>array('gif'=>'path/to/gif/','png'=>'path/to/png/' ... )

    'forbidden_filetypes' key: restrict allowed filetypes (separated with ,)
    ----------------------------------------------

* this is the default config
*/

// Configuration
$phpini=ini_get_all();
$default_config=array(
    'forbidden_filetypes'=>'php',
    'use_style'=>false,                         // false if you're using a external css file
    'auto_refresh_after_upload'=>true,          // auto refresh page after uploading files (except on errors)
    'max_length'=>2048,                          // Mo (see php.ini if changes doesn't work [post_max_size / upload_max_filesize])
    'dropzone_text'=>e('Drop your files here or click to select a local file',false),
    'dropzone_id'=>'dropArea',
    'dropzone_class'=>'dropArea',
    'destination_filepath'=>$_SESSION['current_path'].'/',     // this can be an array like 'jpg'=>'upload/jpeg/' or a string 'destination/'
    'my_filepath'=>$_SERVER['SCRIPT_NAME'],
);

foreach($default_config as $key=>$val){
    // create or complete config var
    if(!isset($auto_dropzone[$key])){ $auto_dropzone[$key]=$auto_dropzone[$key]=$val;}

    // has config changed ?
    if (!isset($_SESSION[$key]) || $auto_dropzone[$key]!=$_SESSION[$key]){ $_SESSION[$key]=$auto_dropzone[$key];}
}

if (!is_array($auto_dropzone['destination_filepath'])&&!is_dir($auto_dropzone['destination_filepath'])){
    mkdir($auto_dropzone['destination_filepath'],01777);file_put_contents($auto_dropzone['destination_filepath'].'index.html','');
}   

$max=min($auto_dropzone['max_length'],intval($phpini['upload_max_filesize']['global_value']),intval($phpini['post_max_size']['global_value']));



$auto_dropzone_error=false;

// uploading files
if ($_FILES){ 

    // HANDLE UPLOAD
    function bytesToSize1024($bytes, $precision = 2) {
        if (!empty($bytes)){
            $unit = array('B','KB','MB');
            return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision).' '.$unit[$i];
        }else{return false;}
    }
    function error2msg($e){
        if ($e>0&&$e<7){
            $errors=array(
                1=>'The file to big for the server\'s config',
                2=>'The file to big for this page',
                3=>'There was a problem during upload (file was truncated)',
                4=>'No file upload',
                5=>'No temp folder',
                6=>'Write error on server',
            );
            return $errors[$e];
        }else if ($e>7){return true;}
        else{return false;}
    }
    function secure($file){
        return preg_replace('#(.+)\.php#i','$1.SECURED_PHP',$file);
    }

    
    if (isset($_FILES['myfile']) && strtolower($_FILES['myfile']['name'])!="index.html") { 
        $sFileName = secure($_FILES['myfile']['name']);
        $sFileType = $_FILES['myfile']['type'];
        $sFileSize = intval(bytesToSize1024($_FILES['myfile']['size'], 1));
        $sFileError = error2msg($_FILES['myfile']['error']);
        $sFileExt  = pathinfo($sFileName,PATHINFO_EXTENSION);
        

        $ok='<li class="DD_file DD_success '.$sFileExt.'">   
            <span class="DD_filename">'.$sFileName.'</span>
            [<em class="DD_filetype">'.$sFileType.'</em>, 
            <em class="DD_filesize">'.$sFileSize.'</em>] [OK]
        </li>';
        $notok='<li class="DD_file DD_error">   
            <span class="DD_filename">'.$sFileName.'</span>
            [<em class="DD_filetype">'.$sFileType.'</em>, 
            <em class="DD_filesize">'.$sFileSize.'</em>] [UPLOAD ERROR !]
        </li>';
        if (
            is_array($auto_dropzone['destination_filepath'])
            &&!empty($auto_dropzone['destination_filepath'][$sFileExt])
            &&is_dir($auto_dropzone['destination_filepath'][$sFileExt])            
        ){
            $sFileName = $auto_dropzone['destination_filepath'][$sFileExt].$sFileName;
            echo $ok;
            rename($_FILES['myfile']['tmp_name'], $sFileName );
            chmod($sFileName,0644);
        }elseif(
            is_array($auto_dropzone['destination_filepath'])
            &&!empty($auto_dropzone['destination_filepath'][$sFileExt])
            &&!is_dir($auto_dropzone['destination_filepath'][$sFileExt])
            ||
            is_string($auto_dropzone['destination_filepath'])
            &&!is_dir($auto_dropzone['destination_filepath'])
        ){
            //local upload dir error
            echo '<li class="DD_file DD_error"><span class="DD_filename">Upload path problem with '.$sFileName.' </span></li>            ';
            
        }elseif($sFileError){
            // file upload error
            echo '<li class="DD_file DD_error"><span class="DD_filename">'.$sFileName.': '.$sFileError.' </span></li>            ';
            
        } elseif(is_dir($auto_dropzone['destination_filepath'])){
            $file=$sFileName;
            $sFileName = $auto_dropzone['destination_filepath'].$sFileName;
            if (is_file($sFileName)){
                $newfilename=rename_item($file);
                echo '<li class="DD_file DD_warning"><span class="DD_filename">'.$file.' => '.$newfilename.' </span></li>';
                $sFileName=$auto_dropzone['destination_filepath'].$newfilename;
            }
            echo $ok;
            rename($_FILES['myfile']['tmp_name'], $sFileName );
            chmod($sFileName,0644);
            addID($sFileName);
        }    
    } else {
        echo $notok;
    }
    exit();
}else{
    // GENERATE DROPZONE
    if ($auto_dropzone['use_style']){
        echo '
        <style>
            .DD_dropzone{
                font-family:courier;cursor:pointer;
                text-shadow:0 2px 1px white;
                box-sizing: border-box;
                text-align:center;
                box-shadow:inset 0 2px 3px;
                margin:5px;padding:20px;
                width:100%;min-height:100px;
                border-radius:3px;border:3px dashed darkblue;
                background-color:#99F;
            }
            .DD_uploading{ background-color:orange;}
            .DD_hover{background-color:yellow;box-shadow:inset 0 4px 8px;}
            .DD_text{font-size:30px;margin:15px 0;font-weight:bold;text-shadow:0 2px 2px white;}
            .DD_file,.DD_error{padding:10px;box-sizing: border-box;border-radius:3px;box-shadow:0 1px 2px #0A0;display:block;margin-bottom:5px;}
            .DD_success{background-color:#0F0;}
            .DD_error{font-weight:bold;background-color:#F00;color:white;box-shadow:0 1px 2px #F00;text-shadow: 0 1px 1px maroon}
            .DD_info{font-size:12px;text-align:left;}
            .DD_info li.DD_file{list-style:none;}
            #DD_progressbar{
                overflow:hidden;
                font-size:12px;
                box-sizing: border-box;
                border-radius:3px;
                padding:3px 0;
                text-align:center;
                background-color:#3f3;
                box-shadow:0 0 3px #0F0;
                height:20px;width:0%
            }
            .DD_hidden{display:none;
        </style>
        ';
    }
?>

        <td class="<?php echo $auto_dropzone['dropzone_class']; ?> DD_dropzone" id="<?php echo $auto_dropzone['dropzone_id'];?>">
            <p class="DD_text"><?php echo $auto_dropzone['dropzone_text'];?><br/><em>(max:<?php echo $max;?> Mo)</em></p>

            <div class="DD_info">
                <div id="result"></div>
                <div id="DD_progressbar"></div>
            </div>
        </td>
        <form action="#" method="post" enctype="multipart/form-data" id="DD_fallback_form" >
            <input type="file" name="myfile" id="fileToUpload" class="DD_hidden"/>
            <input type="hidden" value="fallback" name="fallback"/>
            <input type="submit" id="DD_submit" class="DD_hidden"/>
        </form>

    <script>
        document.body.addEventListener("dragover",function(e){
         
          e.preventDefault();
        },false);
        document.body.addEventListener("drop",function(e){

          e.preventDefault();
        },false);

        // variables
        var dropArea        = document.getElementById('<?php echo $auto_dropzone['dropzone_id'];?>');
        var bar             = document.getElementById('DD_progressbar');
        var result          = document.getElementById('result');
        var list            = [];
        var totalSize       = 0;
        var totalProgress   = 0;
        var uploading       = false;

        function reload_list(){
           //reload list
            var request = new XMLHttpRequest();
            request.open('GET', 'listfiles.php', true);
            target=document.getElementById('liste');
            request.onload = function() {
              if (request.status >= 200 && request.status < 400) {
                // Success!                        
                target.innerHTML= request.responseText;
              } else {
                target.innerHTML= 'erreur de rechargement de la liste'

              }
            };

            request.onerror = function() {
              // There was a connection error of some sort
            };

            request.send();
        }

        function filetype(filemime){
            var parts = filemime.split("/");
            return (parts[(parts.length-1)]);
        }
        function is_allowed(filemime){
            var r='<?php echo $auto_dropzone['forbidden_filetypes']; ?>';
            m=filetype(filemime);
            if (m==''){return false;}
            if(r.indexOf(m)==-1){return true;}
            else{return false;}
        }


        // main initialization
        
            
            // init handlers
            function initHandlers() {
                dropArea.addEventListener('drop', handleDrop, false);
                dropArea.addEventListener('dragover', handleDragOver, false);
                dropArea.addEventListener('dragleave', handleDragLeave, true );
            }

            // draw progress
            function drawProgress(progress) {
                if(progress!='NaN'){
                    percent=Math.floor(progress*100)+'%';
                    bar.style.width=percent;
                    bar.innerHTML=percent;
                }else{bar.style.width='0';}
            }

            // drag over
            function handleDragOver(event) {
                event.stopPropagation();
                event.preventDefault();
                dropArea.className = 'DD_dropzone DD_hover';
            }

            // drag leave
            function handleDragLeave(event) {
                event.stopPropagation();
                event.preventDefault();
                dropArea.className = 'DD_dropzone';
            }

            // drag drop
            function handleDrop(event) {
                if(event.preventDefault) { event.preventDefault(); }
                if(event.stopPropagation) { event.stopPropagation(); }
                if (uploading==true){return false;}
                processFiles(event.dataTransfer.files);
                
                return false;
            }

            // process bunch of files
            function processFiles(filelist) {
                if (!filelist || !filelist.length || list.length) return;
                totalSize = 0;
                totalProgress = 0;
                result.textContent = '';                
                for (var i = 0; i < filelist.length; i++) {                    
                    list.push(filelist[i]);
                    totalSize += filelist[i].size;                    
                }
                uploadNext();
            }

            // on complete - start next file
            function handleComplete(size) {
                uploading=false;
                totalProgress += size;
                drawProgress(totalProgress / totalSize);
                uploadNext();
            }

            // update progress
            function handleProgress(event) {
                var progress = totalProgress + event.loaded;
                drawProgress(progress / totalSize);
            }

            // upload file
            function uploadFile(file, status) {               
                    // prepare XMLHttpRequest
                    uploading=true;
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', "<?php echo $auto_dropzone['my_filepath'];?>");
                    xhr.onload = function() {
                        result.innerHTML += this.responseText;
                        handleComplete(file.size);
                    };
                    xhr.onerror = function() {
                        result.textContent = this.responseText;
                        handleComplete(file.size);
                    };
                    xhr.upload.onprogress = function(event) {
                        handleProgress(event);
                    }
                    xhr.upload.onloadstart = function(event) {
                    }

                    // prepare FormData
                    var formData = new FormData();  
                    formData.append('myfile', file); 
                    formData.append('token', "<?php newToken(true);?>"); 

                    xhr.send(formData);               
            }

            // upload next file
            function uploadNext() {
                reload_list();
                if (list.length) {
                    dropArea.className = 'DD_dropzone DD_uploading';
                    var nextFile = list.shift();

                    if (nextFile.size >= <?php echo $max*1048576; ?>) { 
                        result.innerHTML += '<li class="DD_error">'+nextFile.name+': Error, max filelength: <?php echo $max;?> Mo </li>';
                        handleComplete(nextFile.size);                        
                    } else if(is_allowed(nextFile.type)==false){                        
                        result.innerHTML += '<li class="DD_error">'+nextFile.name+': Error, forbidden file format !</li>';
                        handleComplete(nextFile.size);
                    } else {
                        uploadFile(nextFile, status);
                    }
                } else {
                    dropArea.className = 'DD_dropzone'
                    bar.style.width='0';
                    reload_list();
                    uploading=false;
                }
            }

            initHandlers();
        
            

            // click on dropzone: fallback file
            document.getElementById('<?php echo $auto_dropzone['dropzone_id'];?>').addEventListener('click', function(){
                document.getElementById('fileToUpload').click();
               
            });
            document.getElementById('fileToUpload').addEventListener('change', function(){
                if (this.files[0].size >= <?php echo $max*1048576; ?>) { 
                    result.innerHTML += '<li class="DD_error">'+this.files[0].name+': Error, max filelength: <?php echo $max;?> Mo </li>';                                         
                }else if(is_allowed(this.files[0].type)==false){                        
                    result.innerHTML += '<li class="DD_error">'+this.files[0].name+': Error, forbidden file format !</li>';                    
                } else {
                    uploadFile(this.files[0],'');     
                }           
            });
    </script>
<?php }


 ?>
