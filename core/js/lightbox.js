/*
	Minimalist Lightbox by Bronco (bronco@warriordudimanche.net)
*/
var lb_hide=function(){
	var lb_nav=document.getElementById("lb_nav");	
	var lb_overlay=document.getElementById("lb_overlay");
	
	lb_overlay.style.height=0;
	lb_overlay.style.opacity=0;
	lb_nav.style.height=0;
	lb_nav.style.opacity=0;
	event.preventDefault();
	event.stopPropagation();
}

var lb_show=function(obj){
	var lb_overlay=document.getElementById("lb_overlay");	
	var lb_content=document.getElementById("lb_content");	
	var lb_info=document.getElementById("lb_content-info");	
	var lb_nav=document.getElementById("lb_nav");	
	var lb_prev=document.getElementById("lb_prev");
	var lb_next=document.getElementById("lb_next");
	var type=obj.getAttribute("data-type");
	var path=obj.getAttribute("href");
	var alt=obj.getAttribute("alt");
	var group=obj.getAttribute("data-group");

	if (group==null&&path!="prev"&&path!="next"){
		lb_prev.style.display="none";
		lb_next.style.display="none";
	}else{
		group_set=document.querySelectorAll("a[data-group="+group+"]");
		if (group_set.length>0){
			for (var index=0; index<group_set.length; ++index){
				if (group_set[index].getAttribute("href")==path){
					if (index>0){
						prev=group_set[index-1];
						lb_prev.style.display="block";
						lb_next.setAttribute("style","margin-left:0");
					}else{
						prev=null;
						lb_prev.setAttribute("style","display:none;");
						lb_next.setAttribute("style","margin-left:32px");
					}
					if (index<group_set.length-1){
						next=group_set[index+1];
						lb_next.style.display="block";
					}else{
						next=null;
						lb_next.style.display="none";
					}
				}
			}
		}else{
			lb_prev.style.display="none";
			lb_next.style.display="none";
		}

	}
	if (path=="prev"&&prev!=null){lb_show(prev);return false;}             
	if (path=="next"&&next!=null){lb_show(next);return false;}

	if (type=="img"){
		lb_content.innerHTML='';
		lb_content.setAttribute("style","background-image:url('"+path+"');");
		lb_info.innerHTML=alt;
	}else if (type="iframe"){
		lb_content.setAttribute("style","background:transparent;");
		lb_content.innerHTML='<iframe src="'+path+'"></iframe>';

	}else{
		lb_content.setAttribute("style","background:white;width:95%;height:100%;overflow-y:scroll");
		request = new XMLHttpRequest();request.open('GET', path, true);request.send();
		request.onreadystatechange=function(){
			if (this.readyState==4){
				lb_content.innerHTML=this.responseText;
			}			
		}
	}

	lb_overlay.style.height="100%";
	lb_overlay.style.opacity=100;
	lb_nav.style.height="100%";
	lb_nav.style.opacity=100;
	event.preventDefault();
	return false;
}
