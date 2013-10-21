if (typeof(_DISABLE_LOAD_BOX) != 'undefined') {
	var frms = $('body_container').getElementsByTagName("form");
	for (var ii = 0; ii < frms.length; ii ++) { // lookup all forms
		if (typeof(frms[ii]) != 'undefined') { // start object check
			  if (frms[ii].name && document.forms[frms[ii].name]) { // html form has name
			  
			  if (document.forms[frms[ii].name].getAttribute('onsubmit') && 
			      document.forms[frms[ii].name].getAttribute('onsubmit').indexOf('validate') != -1) {
			      _DISABLE_LOAD_BOX = true;
			  } else {
				     document.forms[frms[ii].name].onsubmit = function() {
					 if (!_DISABLE_LOAD_BOX) {
						createLoadingBox("Silahkan tunggu...", true);
					 } else {
					 	 _DISABLE_LOAD_BOX = false;
					 	}
				  }
			  }
			  
		   } else if (frms[ii].id && $(frms[ii].id)) { // html form has id
		   
		    if (document.forms[frms[ii].name].getAttribute('onsubmit') && 
			      document.forms[frms[ii].name].getAttribute('onsubmit').indexOf('validate') != -1) {
			      _DISABLE_LOAD_BOX = true;
			      } else {
					   $(frms[ii].id).onsubmit = function() {
						if (!_DISABLE_LOAD_BOX) {
							createLoadingBox("Processing...", true);
						 } else {
						 	 _DISABLE_LOAD_BOX = false;
						 	}
					  }
			      }
		   } 
		} // end object check
			   
	} // end lookup
}

/**
 * Overrides every window.confirm method in onclick event of input button/submit or image
 * 
 */
/**if (typeof(enableCustomConfirm) != 'undefined' && enableCustomConfirm) {
	var inputElements =  $('main-table').getElementsByTagName("input");
	var elementId, onclickAttr, oText;
	for (i=0; i < inputElements.length; i++) { // iterate input elements
			if ((inputElements[i].type == "button" || inputElements[i].type == "submit" || inputElements[i].type == "image") && 
			    (!inputElements[i].getAttribute('readonly') && !inputElements[i].getAttribute('disabled'))) { // check input type
			    	
						onclickAttr = inputElements[i].getAttribute('onclick');
						if (onclickAttr && onclickAttr.indexOf('confirm(') != -1) { // only treat input with confirm event onclick
							// start window.confirm text message parsing

							
						    elementId = inputElements[i].getAttribute('id') ? inputElements[i].getAttribute('id') : inputElements[i].getAttribute('name');
							oText = onclickAttr.substring(onclickAttr.indexOf('return confirm') + 1, onclickAttr.length);
							oText = oText.substring(oText.indexOf("(") + 1, oText.indexOf(")"));
							
							oText = removeQuotes(oText);
							
							// end window.confirm text message parsing
							inputElements[i].onclick = function() {
								createCustomConfirm(oText,elementId);
								      return false;
								}
						}
			}
	} // end iteration
}*/
if (typeof(enableCustomConfirm) != 'undefined' && enableCustomConfirm) {
	var inputElements =  $('main-table').getElementsByTagName("a");
	var elementId, onclickAttr, oText;
	for (i=0; i < inputElements.length; i++) { // iterate input elements
			
			    	
						onclickAttr = inputElements[i].getAttribute('onclick');
						if (onclickAttr && onclickAttr.indexOf('confirm(') != -1) { // only treat input with confirm event onclick
							
						    elementId = inputElements[i].getAttribute('id') ? inputElements[i].getAttribute('id') : inputElements[i].getAttribute('name');
							oText = onclickAttr.substring(onclickAttr.indexOf('return confirm') + 1, onclickAttr.length);
							oText = oText.substring(oText.indexOf("(") + 1, oText.indexOf(")"));
							
							oText = removeQuotes(oText);
							
							// end window.confirm text message parsing
							inputElements[i].onclick = function() {
								createCustomConfirm(oText,elementId);
								      return false;
								}
						}
			
	} // end iteration
}
 