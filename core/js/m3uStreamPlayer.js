;(function(root, name, output){
  if(typeof define == "function" && define.amd) return define([], output)
  if(typeof module == "object" && module.exports) module.exports = output()
  else root[name] = output()
})(this.window, "m3uStreamPlayer", function(){

  'use strict';

  // Defaults
  var exports = {
    selector: '[data-playlist]',
    debug: false
  };


  // Load playlist, and get sources.
  var _getPlaylistSources = function(elem) {
    // XHR Request to playlist file
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = process;
    xhr.open("GET", elem.getAttribute('data-playlist'), true);
    xhr.send();
    function process() {
      if (xhr.readyState == 4) {
        // m3uToUrl From https://github.com/aitorciki/jquery-playlist/blob/master/jquery.playlist.js
        elem.sources = xhr.responseText.match(/^(?!#)(?!\s).*$/mg).filter(function(element){return (element);});
        if (exports.debug) console.log("Sources: "+elem.sources);
        // Load first source
        elem.src = elem.sources[0];
        // Play first source
        if (elem.getAttribute('autoplay')) elem.play();
      }
    }    
  }

  // Get current source index
  var _getSourceIdx = function(elem) {
    for(var i = 0; i < elem.sources.length; i++){
      if (elem.currentSrc == elem.sources[i]) return i;
    }
    return 0;
  }

  // Jump to next source.
  var _nextSource = function(elem) {
    var sourceIdx  = _getSourceIdx(elem);
    var nextSourceIdx = (sourceIdx == elem.sources.length -1 ) ? 0 : sourceIdx + 1;

    elem.src = elem.sources[nextSourceIdx];
    if (exports.debug) console.log("Source updated: "+elem.src);
    elem.play();
  }

  // Randomize source.
  var _randomizeSource = function(elem) {
    elem.src = elem.sources[Math.floor(Math.random()*elem.sources.length)];
    // this.currentTime = 0;
    if (exports.debug) console.log("Source randomized: "+elem.src);
    elem.play();
  }

  // Display human readable message in console.
  var _errorMessage = function(event) {
    switch (event.target.error.code) {
      case event.target.error.MEDIA_ERR_ABORTED:
        return "The fetching process for the media resource was aborted by the user agent at the user's request.";
      case event.target.error.MEDIA_ERR_NETWORK:
        return "A network error of some description caused the user agent to stop fetching the media resource, after the resource was established to be usable.";
      case event.target.error.MEDIA_ERR_DECODE:
        return "An error of some description occurred while decoding the media resource, after the resource was established to be usable.";
      case event.target.error.MEDIA_ERR_SRC_NOT_SUPPORTED:
        return "The media resource indicated by the src attribute was not suitable.";
      default:
        return "An unknown error occurred.";
    }
  }

  // Process element, attach listeners
  var _process = function(elem) {
    elem.sources = [];
    _getPlaylistSources(elem);

    // On error, update source, and play again.
    elem.addEventListener('error', function(e) {
      if (exports.debug) console.log("Error: " + _errorMessage(e));
      _nextSource(this);
    });

    // On end, update source, and play again.
    elem.addEventListener('ended', function() {
      if (exports.debug) console.log("Ended");
      _nextSource(this);
    });

    // Show current source, debug only.
    elem.addEventListener('play', function(e) {
      if (exports.debug) console.log("Play: "+this.currentSrc);
    });

    // Pause event, debug only.
    elem.addEventListener('pause', function() {
      if (exports.debug) console.log("Pause");
    });
  }

  // Expose nextSource function
  exports.nextSource = function(elem) {
    _nextSource(elem);
  }

  // Expose randomizeSource function
  exports.randomizeSource = function(elem) {
    _randomizeSource(elem);
  }

  exports.init = function (obj) {
    // Allow string to be passed as argument.
    if (typeof obj === "string") obj = {selector: obj}

    // Mix options with defaults.
    for (var key in obj) {
      exports[key] = obj[key];
    }

    // Prevent IE8 from bugging when a calling console.log
    if (exports.debug) {
      if (!window.console) window.console = {};
      if (!window.console.log) window.console.log = function () { };
    }

    // Get nodes, and process them.
    var nodes = document.querySelectorAll(exports.selector);
    for (var i = 0; i < nodes.length; i++) {
      var node = nodes[i];
      if (node.nodeName === "VIDEO" || node.nodeName === "AUDIO") {
        _process(node);
      }
    }
  };

  return exports;
});

