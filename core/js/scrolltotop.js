/*
# ------------------ BEGIN LICENSE BLOCK ------------------
#
# Copyright (c) 2009 - 2014 Cyril MAGUIRE
# Licensed under the CeCILL v2.1 license.
# See http://www.cecill.info/licences.fr.html
#
# ------------------- END LICENSE BLOCK -------------------
*/
;(function(window,undefined) {

    'use_strict';

    var timeOut;
    var isIE = isIE();
    var bodyTag = first('body');
    var idOfBody = id(bodyTag);
    if (idOfBody == null) {
        idOfBody = 'top';
        bodyTag.setAttribute('id', 'top');
    }

    function isIE() {
        var nav = navigator.userAgent.toLowerCase();
        return (nav.indexOf('msie') != -1) ? parseInt(nav.split('msie')[1]) : false;
    }

    function backToTop() {
        if (document.body.scrollTop!=0 || document.documentElement.scrollTop!=0){
            window.scrollBy(0,-50);
            timeOut=setTimeout('backToTop()',10);
        }
        else {
            clearTimeout(timeOut);
        }
    }

    function getScrollPosition() {
        return Array((document.documentElement && document.documentElement.scrollLeft) || window.pageXOffset || self.pageXOffset || document.body.scrollLeft,(document.documentElement && document.documentElement.scrollTop) || window.pageYOffset || self.pageYOffset || document.body.scrollTop);
    }

    function Remove(idOfParent,idToRemove) {
        if (isIE) {
            document.getElementById(idToRemove).removeNode(true);
        } else {
            var Node1 = document.getElementById(idOfParent); 
            var len = Node1.childNodes.length;
            
            for(var i = 0; i < len; i++){           
                if (Node1.childNodes[i] != undefined && Node1.childNodes[i].id != undefined && Node1.childNodes[i].id == idToRemove){
                    Node1.removeChild(Node1.childNodes[i]);
                }
            }
        }   
    }

    function addElement(idOfParent,idToAdd,htmlToInsert) {
        var DomParent = document.getElementById(idOfParent);//id of body
        var newdiv = document.createElement('div');

        newdiv.setAttribute('id',idToAdd);
        newdiv.innerHTML = htmlToInsert;

        DomParent.appendChild(newdiv);
    }

    function displayBackButton() {
        var pos = [];
        var fleche = '▲';

        if (isIE) {
            fleche = '▲';
        }
        pos = getScrollPosition();
        var topLink = document.getElementById('toplink');
        if (pos[1] > 150) {
            if (topLink == null) {
                addElement(idOfBody,'toplink','<a href="#" onclick="backToTop();return false;">'+fleche+'</a>');
            }
        } else {
            if (topLink != null) {
                Remove(idOfBody,'toplink');
            }
        }
    }

    //add to global namespace
    window.onscroll = displayBackButton;
    window.displayBackButton = displayBackButton;
    window.backToTop = backToTop;


})(window);  
    