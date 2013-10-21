var menus = [];

var enableMenus = new Array();	
if ($('menubar')) {
    var ahref = $('menubar').getElementsByTagName("a");
    for (var jj=0;jj<ahref.length;jj++) {
        if (ahref[jj].id && ahref[jj].id.indexOf("act") != -1) {
        	idx = parseInt(ahref[jj].id.split("act")[1]);
        	
        	if (idx > 0) {
        		
        		if ($("menu" + (idx - 1))) {
        			$(ahref[jj].id).setAttribute("onmouseout", "ypSlideOutMenu.hideMenu('menu" + (idx + 1) + "');ypSlideOutMenu.hideMenu('menu" + (idx - 1) + "');");	
        		} else if ($("menu" + (idx + 1))) {
            			$(ahref[jj].id).setAttribute("onmouseout", "ypSlideOutMenu.hideMenu('menu" + (idx + 1) + "');");	
            		
        		}
        		
        		$(ahref[jj].id).setAttribute("onmouseover", "ypSlideOutMenu.showMenu('menu" + (idx + 1) + "');");
        	} else {
        		$(ahref[jj].id).setAttribute("onmouseover", "ypSlideOutMenu.showMenu('menu" + (idx + 1) + "');");
        		$(ahref[jj].id).setAttribute("onmouseout", "ypSlideOutMenu.hideMenu('menu" + (idx + 1) + "');");
        	}
        	
            enableMenus.push(ahref[jj].id);
        }
    }
}

var startMargin = 400;
if (enableMenus && enableMenus.length > 0) {
   for (var ii=0; ii < enableMenus.length; ii ++) {
	   
	    if (ii > 0) {
	       startMargin = startMargin + 85;
	    }
	    // menu element id, orientation, left-margin, top-margin, width, height
		menus.push(new ypSlideOutMenu("menu" + (parseInt(enableMenus[ii].split("act")[1]) + 1) , "down", parseInt(startMargin), 140, 170, 280));
        
	}
	
	for (var i = 0; i < menus.length; i++) {
		menus[i].onactivate = new Function("document.getElementById('" + (enableMenus[i]) + "').className='active';");
		menus[i].ondeactivate = new Function("document.getElementById('" + (enableMenus[i]) + "').className='';");
	}

  ypSlideOutMenu.writeCSS();
}

