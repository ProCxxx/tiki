function kedow()
{
  var x = $("#mes").val();
  $("#rem").text( x.length );
}

function keup() {
  var x = $("#pw2").val();
  var y = $("#pw").val();

  if (x == y) {
    $("#err").text("");
    return true;
  } else {
    $("#err").text("Password doesen't match");
    return false;
  }
}

function pwkeup() {
  var x = $("#pw1").val();
  var y = $("#pw2").val();

  if (x == y) {
    $(".err2").text("");
    return true;
  } else {
    $(".err2").text("Password doesen't match");
    return false;
  }
}


function xyz(){
var rex = setInterval( function(){ tajm(); },1000);
}

function tajm() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {

     document.getElementById("lower-time-span").innerHTML = this.responseText;
    }
  }
  xhttp.open("GET", "other/time.php?t=0", true);
  xhttp.send();
}


function lajk(uph, sid) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(sid).innerHTML = this.responseText;
      }
    }
    
    xhttp.open('POST', 'other/like.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('user='+uph+'&status='+sid);
}

function dilit(uph, sid) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(sid).innerHTML = this.responseText;
        location.reload(true); 
      }
    }
       
    xhttp.open('POST', 'other/delete.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('user='+uph+'&status='+sid);
}
