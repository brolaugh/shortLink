var shortLink;

function getLink(){
  var link = document.forms["myForm"]["long_url"].value;
  var pref_l = document.forms["myForm"]["pref_url"].value;

  if (str.length == 0) {
        document.getElementById("result").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("result").innerHTML = xmlhttp.responseText;
                shortLink = xmlhttp.responseText;
                printResult();
            }
        }

        xmlhttp.open("POST","functions/getlink.php",true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("long_url="+link+"&pref_url="+pref_l);
}
printResult(){
  document.getElementById("result").innerHTML = shortLink;
}

function CopyToClipboard() {
    Copied = shortLink.createTextRange();
    Copied.execCommand("Copy");
}
