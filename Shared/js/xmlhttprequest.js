function ajaxObject(url, callbackFunction) {
 var that=this;   
 this.updating = false;
 this.abort = function() {
  if (that.updating) {
   that.updating=false;
   that.AJAX.abort();
   that.AJAX=null;
  }
 }
 this.update = function(passData,postMethod) { 
  if (that.updating) { return false; }
  that.AJAX = null;             
  if (window.XMLHttpRequest) {       
   that.AJAX=new XMLHttpRequest();       
  } else {                 
   that.AJAX=new ActiveXObject("Microsoft.XMLHTTP");
  }                       
  if (that.AJAX==null) {               
   return false;                
  } else {
   that.AJAX.onreadystatechange = function() {
	 if (that.AJAX.readyState < 4) {
	 document.getElementById('loading_div').style.display='block';
	 document.getElementById('loading_div').style.zIndex  = 1000;
	 }	   
    if (that.AJAX.readyState==4) {
	document.getElementById('loading_div').style.display='none';
     that.updating=false;        
     that.callback(that.AJAX.responseText,that.AJAX.status,that.AJAX.responseXML);    
     that.AJAX=null;                     
    }                           
   }                            
   that.updating = new Date();               
   if (/post/i.test(postMethod)) {
  //  var uri=urlCall+'?'+that.updating.getTime();
    var uri=urlCall;
    that.AJAX.open("POST", uri, true);
    that.AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    that.AJAX.setRequestHeader("Content-Length", passData.length);
    that.AJAX.send(passData);
   } else {
    //var uri=urlCall+'?'+passData+'&timestamp='+(that.updating.getTime());
    var uri=urlCall;
    that.AJAX.open("GET", uri, true);               
    that.AJAX.send(null);                     
   }       
   return true;                       
  }                                      
 }
 var urlCall = url;    
 this.callback = callbackFunction || function () { };
}

function ajaxRequest(){
 var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"] //activeX versions to check for in IE
 if (window.ActiveXObject){ //Test for support for ActiveXObject in IE first (as XMLHttpRequest in IE7 is broken)
  for (var i=0; i<activexmodes.length; i++){
   try{
    return new ActiveXObject(activexmodes[i])
   }
   catch(e){
    //suppress error
   }
  }
 }
 else if (window.XMLHttpRequest) // if Mozilla, Safari etc
  return new XMLHttpRequest()
 else
  return false
}
