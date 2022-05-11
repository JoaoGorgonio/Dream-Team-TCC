function msgClose(){
    var x = document.getElementById("holder-msg");
    var y = document.getElementById("msg");
    document.getElementById("msg-content").innerHTML = "&nbsp;";
    document.getElementById("msg-title").innerHTML = "&nbsp;";

    y.style = "opacity: 0";
    setTimeout(() => {
        x.style = "display: none";
        document.getElementById("deny-padding").style = "display: none";
        document.getElementById("confirm-padding").style = "display: none";
        document.getElementById("ok-padding").style = "display: none";
    }, 200);

    document.getElementById("confirm-padding").setAttribute("onclick", "");
}

function msgOpen(a, b, c){
    var x = document.getElementById("holder-msg");
    var y = document.getElementById("msg");

    x.style = "display: block";
    setTimeout(() => {
        if(a == 1){
            document.getElementById("deny-padding").style = "display: inline-block";
        }
        if(b == 1){
            document.getElementById("confirm-padding").style = "display: inline-block";
        }
        if(c == 1){
            document.getElementById("ok-padding").style = "display: inline-block";
        }
        y.style = "opacity: 1";
    }, 50);
}