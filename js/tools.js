var _COLON_SYMBOL = ':';
var _DISABLE_LOAD_BOX = false;
var continueProcess = 0;

var ALERT_TITLE = "Gismo";
var ALERT_BUTTON_OK = "OK";
var CONFIRM_TITLE = "Gismo";

var CONFIRM_BUTTON_YES = "YA";
var CONFIRM_BUTTON_NO = "TIDAK";

var enableCustomAlert = true;
var enableCustomConfirm = false;

window.onload = function() {
    
    /**if ($('successMessages')) {
        new Effect.Highlight('successMessages');
    }*/
    if ($('errorMessages')) {
        new Effect.Highlight('errorMessages');
    }
    
    
}

if (!Array.prototype.contains){
     Array.prototype.contains = function(obj){
    var len = this.length;
    for (var i = 0; i < len; i++){
      if(this[i]==obj){ return true;}
    }
    return false;
  };
}

Array.prototype.remove=function(s){
	  var index = this.indexOf(s);
	  if(index != -1) {
	     this.splice(index, 1);
	  }
}

/* This function is used to change the style class of an element */
function swapClass(obj, newStyle) {
  if (obj) {
     obj.className = newStyle;
   }

}

function isUndefined(value) {   
    var undef;   
    return value == undef; 
}

function checkAll(theForm) { // check all the checkboxes in the list
  for (var i=0;i<theForm.elements.length;i++) {
    var e = theForm.elements[i];
		var eName = e.name;
    	if (eName != 'allbox' && 
            (e.type.indexOf("checkbox") == 0)) {
        	e.checked = theForm.allbox.checked;		
		}
	} 
}

/* Function to clear a form of all it's values */
function clearForm(frmObj) {
	for (var i = 0; i < frmObj.length; i++) {
        var element = frmObj.elements[i];
		if(element.type.indexOf("text") == 0 || 
				element.type.indexOf("password") == 0) {
					element.value="";
		} else if (element.type.indexOf("radio") == 0 && !element.type.disabled) {
			element.checked=false;
		} else if (element.type.indexOf("checkbox") == 0 && !element.type.disabled) {
			element.checked = false;
		} else if (element.type.indexOf("select") == 0 && !element.type.disabled) {
			for(var j = 0; j < element.length ; j++) {
				element.options[j].selected=false;
			}
            element.options[0].selected=true;
		}
	} 
}

/* Function to get a form's values in a string */
function getFormAsString(frmObj) {
    var query = "";
	for (var i = 0; i < frmObj.length; i++) {
        var element = frmObj.elements[i];
        if (element.type.indexOf("checkbox") == 0 || 
            element.type.indexOf("radio") == 0) { 
            if (element.checked) {
                query += element.name + '=' + escape(element.value) + "&";
            }
		} else if (element.type.indexOf("select") == 0) {
			for (var j = 0; j < element.length ; j++) {
				if (element.options[j].selected) {
                    query += element.name + '=' + escape(element.value) + "&";
                }
			}
        } else {
            query += element.name + '=' 
                  + escape(element.value) + "&"; 
        }
    } 
    return query;
}

/* Function to hide form elements that show through
   the search form when it is visible */
function toggleForm(frmObj, iState) // 1 visible, 0 hidden 
{
	for(var i = 0; i < frmObj.length; i++) {
		if (frmObj.elements[i].type.indexOf("select") == 0 || frmObj.elements[i].type.indexOf("checkbox") == 0) {
            frmObj.elements[i].style.visibility = iState ? "visible" : "hidden";
		}
	} 
}



/* This function is used to select a checkbox by passing
 * in the checkbox id
 */
function toggleChoice(elementId) {
    var element = $(elementId);
    if (element.checked) {
        element.checked = false;
    } else {
        element.checked = true;
    }
}

/* This function is used to select a radio button by passing
 * in the radio button id and index you want to select
 */
function toggleRadio(elementName, index) {
    var element = document.getElementsByName(elementName)[index];
    element.checked = true;
}

/* This function is used to open a pop-up window */
function openWindow(url, winTitle, winParams) {
	winName = window.open(url, winTitle, winParams);
    winName.focus();
}


/* This function is to open search results in a pop-up window */
function openSearch(url, winTitle) {
    var screenWidth = parseInt(screen.availWidth);
    var screenHeight = parseInt(screen.availHeight);

    var winParams = "width=" + screenWidth + ",height=" + screenHeight;
        winParams += ",left=0,top=0,toolbar,scrollbars,resizable,status=yes";

    openWindow(url, winTitle, winParams);
}

/* This function is used to set cookies */
function setCookie(name,value,expires,path,domain,secure) {
  document.cookie = name + "=" + escape (value) +
    ((expires) ? "; expires=" + expires.toGMTString() : "") +
    ((path) ? "; path=" + path : "") +
    ((domain) ? "; domain=" + domain : "") + ((secure) ? "; secure" : "");
}

/* This function is used to get cookies */
function getCookie(name) {
	var prefix = name + "=" 
	var start = document.cookie.indexOf(prefix) 

	if (start==-1) {
		return null;
	}
	
	var end = document.cookie.indexOf(";", start+prefix.length) 
	if (end==-1) {
		end=document.cookie.length;
	}

	var value=document.cookie.substring(start+prefix.length, end) 
	return unescape(value);
}

/* This function is used to delete cookies
function deleteCookie(name,path,domain) {
  if (getCookie(name)) {
    document.cookie = name + "=" +
      ((path) ? "; path=" + path : "") +
      ((domain) ? "; domain=" + domain : "") +
      "; expires=Thu, 01-Jan-70 00:00:01 GMT";
  }
}  */

// This function is for stripping leading and trailing spaces
function trim(str) { 
    if (str != null) {
        var i; 
        for (i=0; i<str.length; i++) {
            if (str.charAt(i)!=" ") {
                str=str.substring(i,str.length); 
                break;
            } 
        } 
    
        for (i=str.length-1; i>=0; i--) {
            if (str.charAt(i)!=" ") {
                str=str.substring(0,i+1); 
                break;
            } 
        } 
        
        if (str.charAt(0)==" ") {
            return ""; 
        } else {
            return str; 
        }
    }
} 

// This function is a generic function to create form elements
function createFormElement(element, type, name, id, value, parent) {
    var e = document.createElement(element);
    e.setAttribute("name", name);
    e.setAttribute("type", type);
    e.setAttribute("id", id);
    e.setAttribute("value", value);
    parent.appendChild(e);
}

// Show the document's title on the status bar
window.defaultStatus=document.title;


// hide DIV
function hideDiv(el) {
	if (typeof(el) == "string") {
		el = $(el);
	}
	if (el) {
		el.style.display = "none";
	}
}

// show DIV
function showDiv(el) {

	if (typeof(el) == "string") {
		el = $(el);
	}
	if (el) {
	alert("show " + el.id);
		el.style.display = "";
		el.style.visibility = "visible";
	}
}


function submitOnEnter(e) {
   if ($('elementOrButton')) {

	    var keycode;
	    if (window.event) { 
	        keycode = window.event.keyCode;
	    } else if (e) {
	        keycode = e.which;
	    } else {
	        return true;
	    }
	    
	    if (keycode == 13) {
	          $('elementOrButton').click();
	          return false;
	    } else {
	          return true;
	    }
    }      
}

function makeAllDivDraggable() {
  if ($('container')) {
      var divElements = $("container").getElementsByTagName("div");
      
      if (divElements.length) {
          var ii = 0;
          for (ii = 0; ii< divElements.length; ii++) {
              if ($(divElements[ii].id) && !/topMenuHorizontal|yui*/.test(divElements[ii].id)) {
                 new Draggable(divElements[ii].id, { scroll: window });
              }
          }
      }
  }
}


function isArray(obj) {
    return obj.constructor == Array;
}


// ------------------------------------ CUSTOM ALERT WINDOW -----------------------------------//
/* This script and many more are available free online at
The JavaScript Source!! http://javascript.internet.com
Created by: Steve Chipman | http://slayeroffice.com/ */
// constants to define the title of the alert and button text.



var _preload_image;
// over-ride the alert method only if this a newer browser.
// Older browser will see standard alerts

if (document.getElementById) {
      if (enableCustomAlert) {
	      window.alert = function(txt) {
	      	               createCustomAlert(txt);
	                     }
      }
       
      if (document.images) {
       _preload_image = new Image(31,31); 
       _preload_image.src = contextPath +  '/images/spinner.gif';
     }
   
  
} 

function createCustomAlert(txt) {
  if (typeof(txt) == 'string') {
      txt = txt.replace(/\n/, '<br/>');
      txt = txt.replace(/\t/, '<br/>');
  }
  // shortcut reference to the document object
  d = document;
  // if the modalContainer object already exists in the DOM, bail out.
  if(d.getElementById("modalContainer")) { removeCustomAlert();}
  // create the modalContainer div as a child of the BODY element

  mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
  mObj.id = "modalContainer";

   // make sure its as tall as it needs to be to overlay all the content on the page
  mObj.style.height = document.documentElement.scrollHeight + "px";

  // create the DIV that will be the alert 
  alertObj = mObj.appendChild(d.createElement("div"));
  alertObj.id = "alertBox";

  // MSIE doesnt treat position:fixed correctly, so this compensates for positioning the alert

  if(d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
  // center the alert box
  alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth)/2 + "px";
  if (txt.length > 200 ){
    alertObj.style.height = (txt.length)/2 + "px";
  }

  // create an H1 element as the title bar
  h1 = alertObj.appendChild(d.createElement("h1"));
  h1.appendChild(d.createTextNode(ALERT_TITLE));

  // create a paragraph element to contain the txt argument
  msg = alertObj.appendChild(d.createElement("p"));
  msg.innerHTML = txt;
  
  // create an anchor element to use as the confirmation button.
  if (txt.length > 200 ){
     btn = msg.appendChild(d.createElement("a"));	
  } else {
  	 btn = alertObj.appendChild(d.createElement("a"));	
  }
    
  btn.id = "close_Button";
  btn.appendChild(d.createTextNode(ALERT_BUTTON_OK));
  
  btn.href = "#";
  // set up the onclick event to remove the alert when the anchor is clicked
  btn.onclick = function() { removeCustomAlert();return false; }
  if (txt.length > 200 ){
     msg.appendChild(d.createElement("br"));
  }
}

/** custom confirm box */
function createCustomConfirm(txt, htmlElementId) {
  if (typeof(txt) == 'string') {
      txt = txt.replace(/\n/, '<br/>');
  }
  
  // shortcut reference to the document object
  d = document;
  // if the modalContainer object already exists in the DOM, bail out.
  if(d.getElementById("modalContainerConfirm")) return;

  // create the modalContainer div as a child of the BODY element
  mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
  mObj.id = "modalContainerConfirm";
   // make sure its as tall as it needs to be to overlay all the content on the page
  mObj.style.height = document.documentElement.scrollHeight + "px";

  // create the DIV that will be the alert 
  confirmObj = mObj.appendChild(d.createElement("div"));
  confirmObj.id = "confirmBox";

  // MSIE doesnt treat position:fixed correctly, so this compensates for positioning the alert
  if(d.all && !window.opera) confirmObj.style.top = document.documentElement.scrollTop + "px";
  // center the alert box
  confirmObj.style.left = (d.documentElement.scrollWidth - confirmObj.offsetWidth)/2 + "px";

  // create an H1 element as the title bar
  h1 = confirmObj.appendChild(d.createElement("h1"));
  h1.appendChild(d.createTextNode(CONFIRM_TITLE));

  // create a paragraph element to contain the txt argument
  msg = confirmObj.appendChild(d.createElement("p"));
  msg.innerHTML = txt;

  // create an anchor element to use as the confirmation button.
  btnYes = confirmObj.appendChild(d.createElement("a"));
  btnYes.id = "yes_Button";
  btnYes.appendChild(d.createTextNode(CONFIRM_BUTTON_YES));
  btnYes.href = "#";
  
  // set up the onclick event to remove the alert when the anchor is clicked
  btnYes.onclick = function() {
  	                       removeCustomConfirm(); 
  	                       if ($(htmlElementId)) {
  	                       	  //var ocAttr = $(htmlElementId).getAttribute('onclick');
  	                       	 // ocAttr = ocAttr.replace(/return\sfalse/, "");  
  	                       	  
  	                       	  //if (ocAttr.indexOf('confirm')  != -1 && ocAttr.indexOf(';') != -1) {
  	                       	   //   ocAttr = ocAttr.substring(ocAttr.indexOf(';') + 1, ocAttr.length);	
  	                       	  //}
  	     
  	                       	   $(htmlElementId).setAttribute("onclick", "this.form.submit();");
  	                       	   $(htmlElementId).click();
  	                       	}  	                        
  	 	                    return true;    	 	                    
  }
  
  btnNo = confirmObj.appendChild(d.createElement("a"));
  btnNo.id = "no_Button";
  btnNo.appendChild(d.createTextNode(CONFIRM_BUTTON_NO));
  btnNo.href = "#";

  // set up the onclick event to remove the alert when the anchor is clicked
  btnNo.onclick = function() {
  	removeCustomConfirm(); 
  	 	return false; 
   }
  
}

function createCustomConfirmWithFunction(txt, func) {
  if (typeof(txt) == 'string') {
      txt = txt.replace(/\n/, '<br/>');
  }
  
  // shortcut reference to the document object
  d = document;
  // if the modalContainer object already exists in the DOM, bail out.
  if(d.getElementById("modalContainerConfirm")) return;

  // create the modalContainer div as a child of the BODY element
  mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
  mObj.id = "modalContainerConfirm";
   // make sure its as tall as it needs to be to overlay all the content on the page
  mObj.style.height = document.documentElement.scrollHeight + "px";

  // create the DIV that will be the alert 
  confirmObj = mObj.appendChild(d.createElement("div"));
  confirmObj.id = "confirmBox";

  // MSIE doesnt treat position:fixed correctly, so this compensates for positioning the alert
  if(d.all && !window.opera) confirmObj.style.top = document.documentElement.scrollTop + "px";
  // center the alert box
  confirmObj.style.left = (d.documentElement.scrollWidth - confirmObj.offsetWidth)/2 + "px";

  // create an H1 element as the title bar
  h1 = confirmObj.appendChild(d.createElement("h1"));
  h1.appendChild(d.createTextNode(CONFIRM_TITLE));

  // create a paragraph element to contain the txt argument
  msg = confirmObj.appendChild(d.createElement("p"));
  msg.innerHTML = txt;

  // create an anchor element to use as the confirmation button.
  btnYes = confirmObj.appendChild(d.createElement("a"));
  btnYes.id = "yes_Button";
  btnYes.appendChild(d.createTextNode(CONFIRM_BUTTON_YES));
  btnYes.href = "#";
  
  // set up the onclick event to remove the alert when the anchor is clicked
  btnYes.onclick = function() {
  	                       removeCustomConfirm(); 
  	                       if (func) {
  	                       	  setTimeout(func, 0);
  	                       	}  	                        
  	 	                    return true;    	 	                    
  }
  
  btnNo = confirmObj.appendChild(d.createElement("a"));
  btnNo.id = "no_Button";
  btnNo.appendChild(d.createTextNode(CONFIRM_BUTTON_NO));
  btnNo.href = "#";

  // set up the onclick event to remove the alert when the anchor is clicked
  btnNo.onclick = function() {
  	removeCustomConfirm(); 
  	 	return false; 
   }
  
}

// removes the custom alert from the DOM

function removeCustomConfirm() {
  document.getElementsByTagName("body")[0].removeChild(document.getElementById("modalContainerConfirm"));  
}

function removeCustomAlert() {
  document.getElementsByTagName("body")[0].removeChild(document.getElementById("modalContainer"));
}
// ------------------------------------- END CUSTOM ALERT WINDOW -----------------------------------------//

function disabledOnClick(elementId, executeClick) {
     if ($(elementId) && $(elementId).type == "submit") {
         $(elementId).onclick = function() {
                  if (executeClick) {this.click;}  
				  this.setAttribute('class', 'buttonspin');
                  this.value = '';
                  this.setAttribute('onfocus', 'this.blur');
         };
     }
}

function continueSubmit() {
     continueProcess = 1;
}


function removeQuotes(oText) {
 
  oText = oText.replace(/\'/g, ""); 
  oText = oText.replace(/\"/g, ""); 
                        
 return oText;
}


function createLoadingBox(txt, withSpinner) {
  if ($('container')) {
	   $('container').setStyle({opacity: .30});
	   $('container').style.filter = 'alpha(opacity=30)';
  }	
  if (typeof(txt) == 'string') {
      txt = txt.replace(/\n/, '<br/>');
      txt = txt.replace(/\t/, '<br/>');
  }
  // shortcut reference to the document object
  d = document;
  // if the modalContainer object already exists in the DOM, bail out.
  if(d.getElementById("loadContainer")) { removeLoadBox();}
  // create the modalContainer div as a child of the BODY element

  mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
  mObj.id = "loadContainer";

   // make sure its as tall as it needs to be to overlay all the content on the page
  mObj.style.height = document.documentElement.scrollHeight + "px";

  // create the DIV that will be the alert 
  alertObj = mObj.appendChild(d.createElement("div"));
  alertObj.id = "loadBox";

  // MSIE doesnt treat position:fixed correctly, so this compensates for positioning the alert

  if(d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
  // center the alert box
  alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth)/2 + "px";
  
  // create a paragraph element to contain the txt argument
  msg = alertObj.appendChild(d.createElement("p"));
  msg.innerHTML = txt;
  
  if (withSpinner) {
     imgs = msg.appendChild(d.createElement("img"));
     imgs.src = _preload_image.src;
  }  
  continueProcess = 1;
}

function removeLoadBox() {
  if ($('container')) {
	   $('container').setStyle({opacity: 1});
	   $('container').style.filter = 'alpha(opacity=100)';
  }	
  document.getElementsByTagName("body")[0].removeChild(document.getElementById("loadContainer"));
}

function disableLoadBox() {
     setTimeout("removeLoadBox()", 3000);
}

function displayDiv(invisibleDiv, visibleDiv, allRelative) {
    if (document.getElementById(invisibleDiv) != null) {
        if (document.getElementById(invisibleDiv).style.visibility == "visible") {
            document.getElementById(invisibleDiv).style.visibility = "hidden";
            if ( allRelative) {
                document.getElementById(invisibleDiv).style.position = "relative";
            } else {
               document.getElementById(invisibleDiv).style.position = "absolute";
            }
            document.getElementById(visibleDiv).style.position = "relative";

        } else {
            document.getElementById(invisibleDiv).style.visibility = "visible";
            if (allRelative) {
                document.getElementById(invisibleDiv).style.position = "relative";
            } else {
                document.getElementById(invisibleDiv).style.position = "absolute";
            }

        }
    }
}

function getStockAlertColor(percentage) {
	if (document.getElementById('station_monitor_row')) {
		if (parseInt(percentage) > 50) {
		  document.getElementById('station_monitor_row').style = 'green_alert';
		} else if (parseInt(percentage) == 50) {
		  document.getElementById('station_monitor_row').style = 'yellow_alert';
		} else if (parseInt(percentage) < 50) {
		  document.getElementById('station_monitor_row').style = 'red_alert';
		}
	   //alert(percentage);
	}
          
}
function excelExport() {
    location.href=contextPath + "/DepotMonitorAction.php?method=excel_export";
}

function deliveryMonitor() {
    var url = contextPath + "/DeliveryMonitorAction.php";
    
}

/**
 * selected date format : dd/mm/yyyy
 */
function recalculateDate(htmlElementPrefix, form, selectedDate) {
	
	 
	 var dd = form.elements[htmlElementPrefix + 'Day'].options.selectedIndex;
	 var mm = form.elements[htmlElementPrefix + 'Month'].options.selectedIndex;
	 var yy = form.elements[htmlElementPrefix + 'Year'].options.selectedIndex;


	 var selectedDateArr = selectedDate.split("\/");

     for (var ii = 0; ii< form.elements[htmlElementPrefix + 'Day'].options.length; ii++) {
    	 form.elements[htmlElementPrefix + 'Day'].options[ii].removeAttribute("selected");
		 if (form.elements[htmlElementPrefix + 'Day'].options[ii].value == selectedDateArr[0]) {
			 form.elements[htmlElementPrefix + 'Day'].options[ii].setAttribute("selected", "selected");
		 }
	 }
	 for (var ii = 0; ii< form.elements[htmlElementPrefix + 'Month'].options.length; ii++) {
		 form.elements[htmlElementPrefix + 'Month'].options[ii].removeAttribute("selected");
		 if (form.elements[htmlElementPrefix + 'Month'].options[ii].value == selectedDateArr[1]) {
			 form.elements[htmlElementPrefix + 'Month'].options[ii].setAttribute("selected", "selected");
		 }
	 }
     for (var ii = 0; ii< form.elements[htmlElementPrefix + 'Year'].options.length; ii++) {
    	 form.elements[htmlElementPrefix + 'Year'].options[ii].removeAttribute("selected");
		 if (form.elements[htmlElementPrefix + 'Year'].options[ii].value == selectedDateArr[2]) {
			 form.elements[htmlElementPrefix + 'Year'].options[ii].setAttribute("selected", "selected");
		 }
	 }
	
	
}
/**
 * selected date format : dd/mm/yyyy HH:MM:ss
 */
function recalculateDateTime(dateElementPrefix, timeElementPrefix, form, selectedDateTime) {
	
	 var sdta = selectedDateTime.split(" ");
	 var selectedDate = sdta[0];
	 var selectedTime = sdta[1];
	
	 var dd = form.elements[dateElementPrefix + 'Day'].options.selectedIndex;
	 var mm = form.elements[dateElementPrefix + 'Month'].options.selectedIndex;
	 var yy = form.elements[dateElementPrefix + 'Year'].options.selectedIndex;
	 
	 var hh = form.elements[timeElementPrefix + 'Hour'].options.selectedIndex;
	 var nn = form.elements[timeElementPrefix + 'Minute'].options.selectedIndex;

	 var selectedDateArr = selectedDate.split("\/");
	 var selectedTimeArr = selectedTime.split("\:");

    for (var ii = 0; ii< form.elements[dateElementPrefix + 'Day'].options.length; ii++) {
   	 form.elements[dateElementPrefix + 'Day'].options[ii].removeAttribute("selected");
		 if (form.elements[dateElementPrefix + 'Day'].options[ii].value == selectedDateArr[0]) {
			 form.elements[dateElementPrefix + 'Day'].options[ii].setAttribute("selected", "selected");
		 }
	 }
	 for (var ii = 0; ii< form.elements[dateElementPrefix + 'Month'].options.length; ii++) {
		 form.elements[dateElementPrefix + 'Month'].options[ii].removeAttribute("selected");
		 if (form.elements[dateElementPrefix + 'Month'].options[ii].value == selectedDateArr[1]) {
			 form.elements[dateElementPrefix + 'Month'].options[ii].setAttribute("selected", "selected");
		 }
	 }
    for (var ii = 0; ii< form.elements[dateElementPrefix + 'Year'].options.length; ii++) {
   	 form.elements[dateElementPrefix + 'Year'].options[ii].removeAttribute("selected");
		 if (form.elements[dateElementPrefix + 'Year'].options[ii].value == selectedDateArr[2]) {
			 form.elements[dateElementPrefix + 'Year'].options[ii].setAttribute("selected", "selected");
		 }
	 }
    
    for (var ii = 0; ii< form.elements[timeElementPrefix + 'Hour'].options.length; ii++) {
    	form.elements[timeElementPrefix + 'Hour'].options[ii].removeAttribute("selected");
		 if (form.elements[timeElementPrefix + 'Hour'].options[ii].value == selectedTimeArr[0]) {
			 form.elements[timeElementPrefix + 'Hour'].options[ii].setAttribute("selected", "selected");
		 }
	 }
    for (var ii = 0; ii< form.elements[timeElementPrefix + 'Minute'].options.length; ii++) {
    	 form.elements[timeElementPrefix + 'Minute'].options[ii].removeAttribute("selected");
		 if (form.elements[timeElementPrefix + 'Minute'].options[ii].value == selectedTimeArr[1]) {
			 form.elements[timeElementPrefix + 'Minute'].options[ii].setAttribute("selected", "selected");
		 }
	 }
	
	
}
/**
 * selected time format : HH:MM:ss
 */
function recalculateTime(htmlElementPrefix, form, selectedTime) {
	 
	 var hh = form.elements[htmlElementPrefix + 'Hour'].options.selectedIndex;
	 var nn = form.elements[htmlElementPrefix + 'Minute'].options.selectedIndex;
	 var selectedTimeArr = selectedTime.split("\:");
	 
    for (var ii = 0; ii< form.elements[htmlElementPrefix + 'Hour'].options.length; ii++) {
    	form.elements[htmlElementPrefix + 'Hour'].options[ii].removeAttribute("selected");
		 if (form.elements[htmlElementPrefix + 'Hour'].options[ii].value == selectedTimeArr[0]) {
			 form.elements[htmlElementPrefix + 'Hour'].options[ii].setAttribute("selected", "selected");
		 }
	 }
    for (var ii = 0; ii< form.elements[htmlElementPrefix + 'Minute'].options.length; ii++) {
    	 form.elements[htmlElementPrefix + 'Minute'].options[ii].removeAttribute("selected");
		 if (form.elements[htmlElementPrefix + 'Minute'].options[ii].value == selectedTimeArr[1]) {
			 form.elements[htmlElementPrefix + 'Minute'].options[ii].setAttribute("selected", "selected");
		 }
	 }
	
}


/* This function is used to delete cookies */
deleteCookie = function(name,path,domain,secure) {
    document.cookie = name + "=" +
      ((path) ? "; path=" + path : "") +
      ((domain) ? "; domain=" + domain : "") +
      "; expires=Thu, 01-Jan-70 00:00:01 GMT" +
      ((typeof(secure) != 'undefined' && secure) ? "; secure" : "");

};
