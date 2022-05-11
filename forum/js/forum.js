function categoria(x){
    if(x == 1){
        document.getElementById("updates").style = "display: block; opacity: 0;";
        document.getElementById("att").style = "background: transparent; color: white;";
        document.getElementById("noti").style = "background: white; color: black;";
        setTimeout(function(){
            document.getElementById("updates").style = "display: none; opacity: 0;";
            document.getElementById("noticias").style = "display: block; opacity: 0;";
        }, 200);
        setTimeout(function(){
            document.getElementById("noticias").style = "display: block; opacity: 1;";
        }, 250);
    }
    else{
        document.getElementById("att").style = "background: white; color: black;";
        document.getElementById("noti").style = "background: transparent; color: white;";
        document.getElementById("noticias").style = "display: block; opacity: 0;";
        setTimeout(function(){
            document.getElementById("noticias").style = "display: none; opacity: 0;";
        }, 200);
        setTimeout(function(){
            document.getElementById("updates").style = "display: block; opacity: 0;";
            document.getElementById("updates").style = "display: block; opacity: 1;";
        }, 250);
    }
}