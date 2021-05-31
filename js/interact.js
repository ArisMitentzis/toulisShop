function setLinkActive(curlink){
    
    var link = document.getElementById(curlink);
    var initialClass = link.className;
    link.className = initialClass + " active";
}
        
