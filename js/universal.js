function optbaron(){
    document.getElementById("optbar").style = "margin-left: 0vh";
    document.getElementById("opbar").style.visibility = "hidden";
    document.getElementById("opbar").style.opacity = "0";
    if(screen.width < screen.height){
        document.getElementById("optbar").style.width = "100vw";
        document.getElementById("optbar").style.minWidth = "100vw";
    }
    else{
        document.getElementById("optbar").style.minWidth = "44vh";
    }
}
function optbaroff(){
    document.getElementById("optbar").style = "margin-left: -100vh";
    document.getElementById("opbar").style.visibility = "visible";
    document.getElementById("opbar").style.opacity = "1";
}
function logout(){
    document.getElementById('msg-title').innerHTML = "Você tem certeza de que deseja sair?";
    document.getElementById('msg-content').innerHTML = "Após confirmar, a sessão será encerrada e será necessário entrar novamente.";
    document.getElementById('msg-confirm').setAttribute('onclick', "window.location.href = 'back.php?request=$a=destruirSessao(1);'");
    optbaroff();
    msgOpen(1, 1, 0);
}
function apelido(x){
    var pode = "abcdefghijklmnopqrstuvwxyzãõáéíóúâêîôûç0123456789";
    var val = "";
    for(i = 0; i < x.value.length; i++){
    	chn = x.value.charAt(i);
        ch = x.value.toLowerCase().charAt(i);
        r = pode.includes(ch);
        if(r == true || ch == " "){
            val += chn;
        }
    }
    x.value = val;
}
function nm(x){
    var pode = "0123456789";
    var val = "";
    for(i = 0; i < x.value.length; i++){
        ch = x.value.toLowerCase().charAt(i);
        r = pode.includes(ch);
        if(r == true || ch == " "){
            val += ch;
        }
    }
    x.value = val;
}
function letra(x){
    var pode = "abcdefghijklmnopqrstuvwxyzãõáéíóúâêîôûäëïöüç";
    var val = "";
    for(i = 0; i < x.value.length; i++){
    	chn = x.value.charAt(i);
        ch = x.value.toLowerCase().charAt(i);
        r = pode.includes(ch);
        if(r == true || ch == " "){
            val += chn;
        }
    }
    x.value = val;
}
function aspas(x){
    var pode = "'";
    var val = "";
    for(i = 0; i < x.value.length; i++){
    	chn = x.value.charAt(i);
        ch = x.value.toLowerCase().charAt(i);
        r = pode.includes(ch);
        if(r == false){
            var pode = '"';
            r = pode.includes(ch);
            if(r == false){
           	val += chn;
            }	
        }
    }
    x.value = val;
}
function chmail(x){
    var pode = "ãõáéíóúâêîôûäëïöüçabcdefghijklmnopqrstuvwxyz0123456789-_@.";
    var val = "";
    for(i = 0; i < x.value.length; i++){
    	chn = x.value.charAt(i);
        ch = x.value.toLowerCase().charAt(i);
        r = pode.includes(ch);
        if(r == true){
            val += chn;
        }
    }
    x.value = val;
}