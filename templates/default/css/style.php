<?php
/**
 * On-the-fly CSS Compression
 * Copyright (c) 2009 and onwards, Manas Tungare. (changes by bronco)
 * Creative Commons Attribution, Share-Alike.
 *
 * In order to minimize the number and size of HTTP requests for CSS content,
 * this script combines multiple CSS files into a single file and compresses
 * it on-the-fly.
 *
 * To use this in your HTML, link to it in the usual way:
 * <link rel="stylesheet" type="text/css" media="screen, print, projection" href="/css/compressed.css.php" />
 */



/*
* this version detects css files and allow very basic replacements (bronco@warriordudimanche.net)
*/
# replacement rules: "String to replace" => "Replacement"
# You can change the colors here !
session_start();
if (!empty($_SESSION['config']['gallery_thumbs_width'])){$size=$_SESSION['config']['gallery_thumbs_width'];}else{$size='256';}
$replace=array(
  '#basic_color_neutral'=>'#456',
  '#basic_color_dark'=>'#345',
  '#basic_color_superdark'=>'#123',
  '#basic_color_light'=>'#678',
  '#hover_color_light'=>'#DEF',
  '#hover_color_neutral'=>'#789',
  '#hover_color_dark'=>'#234',
  '#hover_color_superdark'=>'#123',
  '#THUMBS_SIZE'=>$size,
  '#THUMBS_HIDING_HEIGHT'=>$size+4,
);


# function
if (!function_exists('_glob')){
  function _glob($path,$pattern='') {
    # glob function fallback by Cyril MAGUIRE (thx bro' ;-)
    if($path=='/'){
      $path='';
    }
      $liste =  array();
      $pattern=str_replace('*','',$pattern);
      if ($handle = opendir($path)) {
          while (false !== ($file = readdir($handle))) {
            if(stripos($file, $pattern)!==false || $pattern=='' && $file!='.' && $file!='..' && $file!='.htaccess') {
                  $liste[] = $path.$file;
              }
          }
          closedir($handle);
      }
    natcasesort($liste);
      return $liste;
     
  }

}
$cssFiles = _glob('./','css');

//----------------------------------------------------------
/**
* returns a colour x% darker
* 
* @param string [$color] a hex rgb color :#FFF or #FFFFFF 
* @param integer [$percent] amount to substract
*/ 
function darken($color, $percent){
    // change the color to a x% darker
    $rgb=separatRGB($color);
    
    $percent=100-$percent;    
    $rgb['r']=round(($percent*$rgb['r'])/100);
    $rgb['g']=round(($percent*$rgb['g'])/100);
    $rgb['b']=round(($percent*$rgb['b'])/100);    
     
    return dec2hexRGB($rgb);
}
//----------------------------------------------------------
/**
* returns a colour x% lighter
* 
* @param string [$color] a hex rgb color :#FFF or #FFFFFF 
* @param integer [$percent] amount to add
*/ 
function lighten($color, $percent){
    $rgb=separatRGB($color);
    
    $r2=round(($percent*255)/100);
    $g2=round(($percent*255)/100);
    $b2=round(($percent*255)/100);
    $rgb['r']+=$r2;
    $rgb['g']+=$g2;
    $rgb['b']+=$b2; 
    if ($rgb['r']>255){$rgb['r']=255;}
    if ($rgb['g']>255){$rgb['g']=255;}
    if ($rgb['b']>255){$rgb['b']=255;}   
    return dec2hexRGB($rgb);
}
//----------------------------------------------------------
/**
* reverse the lighter and the darker color
* 
* @param string [$color] a hex rgb color :#FFF or #FFFFFF 
* 
*/ 
function reverse($color){
   $rgb=separatRGB($color);
   $max=array_search(max($rgb),$rgb);
   $min=array_search(min($rgb),$rgb);
   
   $temp=$rgb[$max];
   $rgb[$max]=$rgb[$min];
   $rgb[$min]=$temp;
   
   return dec2hexRGB($rgb);
   
}


/**
 * Ideally, you wouldn't need to change any code beyond this point.
 */
$buffer = "";
foreach ($cssFiles as $cssFile) {
  $buffer .= file_get_contents($cssFile);
}

$buffer=str_replace(array_keys($replace),array_values($replace),$buffer);
// Remove unnecessary characters
$buffer = preg_replace("|/\*[^*]*\*+([^/][^*]*\*+)*/|", "", $buffer);
$buffer = preg_replace("/[\s]*([\:\{\}\;\,])[\s]*/", "$1", $buffer);

// Remove whitespace
$buffer = str_replace(array("\r\n", "\r", "\n"), '', $buffer);

// Enable GZip encoding.
//ob_start("ob_gzhandler");

// Enable caching
header('Cache-Control: public');

// Expire in one day
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');

// Set the correct MIME type, because Apache won't set it for us
header("Content-type: text/css");

// Write everything out
echo($buffer);
?>
