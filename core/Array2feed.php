<?php
# Array2feed 
# @author: bronco@warriordudimanche.net
# @version 0.1 (alpha: I'm testing but it works ^^)
# @license  free and opensource
# @inspired by  http://milletmaxime.net/syndexport/
# @use: $items=feed2array('http://sebsauvage.net/links/index.php?do=rss');
# @doc:
	# the array must have an index 'infos' and another called 'items'
	#info key
		# for rss type feed, infos must have at least the 'title', 'description', 'guid' keys
		# for atom type feed, infos must have at least the 'title', 'id', 'subtitle', 'link' keys
	# items key => array
		# for rss type feed, each item must have the 'title', 'description', 'pubDate' and 'link' keys
		# for atom type feed, info must have the 'title', 'id', 'updated, 'link' & 'content' keys 
function makeRSSdate($date=NULL){// format DD-MM-YY HH:MM => rfc2822 (rss compatible)
    if ($date){
        date_default_timezone_set('Europe/Paris');
        $time = strtotime($date);
        return date("r", $time);
    }
}
function no_nl($string){$tab = array( CHR(13) => " ", CHR(10) => " " ); return strtr($string,$tab); }
function array2feed($array=null){


	if (!$array){return false;}
	if (empty($array['infos']['type'])){$array['infos']['type']='rss';}else{$array['infos']['type']=strtolower($array['infos']['type']);}
	if (empty($array['infos']['description'])){$array['infos']['description']='';}
	$r="\n";$t="\t";
	$tpl=array('rss'=>array(),'atom'=>array());
	$tpl['rss']['header']='<?xml version="1.0" encoding="utf-8"?>'.$r.'<rss version="2.0"  xmlns:content="http://purl.org/rss/1.0/modules/content/">'
	.$r.$t.'<channel>'.$r;
	$tpl['atom']['header']='<feed xmlns="http://www.w3.org/2005/Atom">'.$r;
	$tpl['rss']['footer']=$t.'</channel></rss>'.$r;
	$tpl['atom']['footer']='</feed>'.$r;
	$tpl['rss']['content-type']='Content-Type: application/rss+xml; charset=utf-8';
	$tpl['atom']['content-type']='Content-Type: application/atom+xml; charset=utf-8';

	header($tpl[$array['infos']['type']]['content-type']);
	$feed=$tpl[$array['infos']['type']]['header'];
		//create the feed's info content
		foreach($array['infos'] as $key=>$value){
			if ($array['infos']['type']=='atom'){ // ATOM
				if ($key=='link'){$feed.=$t.$t.'<link href="'.$value.'" rel="self" type="application/atom+xml"/>'.$r;}
				elseif ($key=='author'){$feed.=$t.$t.'<author><name>'.$value.'</name></author>'.$r;}
				elseif ($key=='licence'){$feed.=$t.$t.'<'.$key.' href="'.$value.'" rel="license"/>'.$r;} // in atom feed, licence is the link to the licence type
				elseif ($key!='version'&&$key!='type'){$feed.=$t.$t.'<'.$key.'>'.$value.'</'.$key.'>'.$r;}
			}else{ // RSS
				if ($key!='version'&&$key!='type'){$feed.=$t.$t.'<'.$key.'>'.$value.'</'.$key.'>'.$r;}
			}
		}

		//then the items content
		foreach ($array['items'] as $item){
			if ($array['infos']['type']=='atom'){ $feed.=$t.$t.$t.'<entry>'.$r;}else{$feed.=$t.$t.$t.'<item>'.$r;}
				foreach($item as $key=>$value){
					if ($array['infos']['type']=='atom'){ // ATOM
						if ($key=='link'){$feed.=$t.$t.$t.$t.'<link href="'.$value.'" rel="alternate" type="text/html"/>'.$r;}
						elseif ($key=='content'){$feed.=$t.$t.$t.$t.'<content type="text">'.htmlspecialchars($value).'</content>'.$r;}
						elseif (!empty($value)){$feed.=$t.$t.$t.$t.'<'.$key.'>'.no_nl($value).'</'.$key.'>'.$r;}
					}else{ // RSS
						if ($key=='pubDate'||$key=='title'||$key=='link'){$feed.=$t.$t.$t.$t.'<'.$key.'>'.htmlspecialchars($value).'</'.$key.'>'.$r;}
						elseif ($key=='date'){}
						elseif($key=='guid'){ $feed.=$t.$t.$t.$t.'<guid isPermaLink="false"><![CDATA['.$value.']]></guid>'.$r;}
						elseif(!empty($value)){$feed.=$t.$t.$t.$t.'<'.$key.'><![CDATA['.no_nl($value).']]></'.$key.'>'.$r;}
					}
				}
			if ($array['infos']['type']=='atom'){ $feed.=$t.$t.$t.'</entry>'.$r;}else{$feed.=$t.$t.$t.'</item>'.$r;}
		}


	$feed.=$tpl[$array['infos']['type']]['footer'];
	echo $feed;
}
?>