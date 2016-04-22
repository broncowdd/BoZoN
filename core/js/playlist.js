var audio=first('audio');
    var files=all('li[data-href]');
    addClass(first('li[data-href]'),'playing');
    on('click','li[data-href]',function(){
        audio.pause();
        file=attr(this,'data-href');
        if (file!=null){
            audio.src=file;
            removeClass('.sound', 'playing');
            addClass(this,'playing');
            audio.play();
        }
    });

    on('ended',audio,function(){
        // play next if possible
        var current=first('li.playing');
        index=parseInt(attr(current,'data-index'))+1;
        var nextfile=first('li[data-index="'+index+'"]');
        if (nextfile!=null){//nextfile=first("li[data-index]");}
            removeClass(current,'playing');
            addClass(nextfile,'playing');
            audio.src=attr(nextfile,'data-href');
            audio.play();
        }
    });