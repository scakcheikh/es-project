var inputKmlFile = "";


function downloadUrl(url,callback) {
 var request = window.ActiveXObject ?
     new ActiveXObject('Microsoft.XMLHTTP') :
     new XMLHttpRequest;

 request.onreadystatechange = function() {
   if (request.readyState == 4) {
     request.onreadystatechange = doNothing;
     callback(request, request.status);
   }
 };

 request.open('GET', url, true);
 request.send(null);
}



var control = document.getElementById("kmlfile");
control.addEventListener("change", function(event) {
    var i = 0,
    files = control.files,
    len = files.length;

    for (; i < len; i++) {
      inputKmlFile = ""+files[i];
        console.log("Filename: " + files[i].name);
        console.log("Type: " + files[i].type);
        console.log("Size: " + files[i].size + " bytes");
    }
}, false);
