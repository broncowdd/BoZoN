function play(song_link) {
	removeClass(document.querySelectorAll(".sound"),"playing");
	addClass(song_link,"playing");
	
	player=document.querySelector("audio");
	player.setAttribute("src",song_link.getAttribute("data-src"));
	event.preventDefault();
	event.stopPropagation();
	return false;
}
// Setup the player to autoplay the next track (personal change in vanilla js)
audiojs.events.ready(function() {
    var a = audiojs.createAll(
    	{
    		trackEnded: function() {
	            var current = all("playing");
	            next=next(current[0]);					            
	            removeClass(current,"playing");
	            addClass(next,"playing");
	            audio.load(next.getAttribute("data-src"));
	            audio.play();
          	},
         css:false}
    );
    // Load in the first track
	var audio = a[0];		        	
    first_link=first(".sound");
    first = first_link.getAttribute("data-src");
    addClass(first_link,"playing");
    audio.load(first);
});