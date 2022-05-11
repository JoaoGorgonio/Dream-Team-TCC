window.onload = function() {
    document.getElementById('inicio').style.display = 'block';
    setTimeout(() => {
        document.getElementById('inicio').style.opacity = '1';
    }, 100);
};

function continuar(x){
    var anterior = 'passo' + (x - 1);
    var atual = 'passo' + x;

    if(x == 1){
        document.getElementById('inicio').style.opacity = '0';
        setTimeout(() => {
            document.getElementById('inicio').style.display = 'none';
            document.getElementById('passo1').style.display = 'block';
        }, 500);
    }
    else{
        setTimeout(() => {
            document.getElementById(anterior).style.display = 'none';
            document.getElementById(atual).style.display = 'block';
        }, 500);
    }

    for(i = 1; i < (document.getElementsByClassName('passos').length - 1); i++){
        document.getElementById('passo' + i).style.opacity = '0';
        setTimeout(() => {
            document.getElementById('passo' + i).style.display = 'none';
        }, 50);
    }
    
    setTimeout(() => {
        document.getElementById(atual).style.opacity = '1';
        document.getElementById('progressBar').value = x * 25;
        document.getElementById('progressBar').style = 'opacity: 1;';
    }, 600);

    if(x == 4){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("userpic").setAttribute("src", this.responseText);
            }
        };
        xmlhttp.open("GET", "back.php?request=$a=new Usuario(codigoSessao(1));echo $a->icone;", true);
        xmlhttp.send();

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("apelido-concluir").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "back.php?request=$a=new Usuario(codigoSessao(1));echo $a->apelido;", true);
        xmlhttp.send();
    }
}
function verificarApelido(){
    var x = document.getElementById("apelido");
    if(x.value.length < 3){
        document.getElementById("error-apelido").innerHTML = "Apelido curto demais!";
    }
    else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText == "Apelido já escolhido."){
                    document.getElementById("error-apelido").innerHTML = this.responseText;
                    x.style.borderColor = "red"; 
                }
                else{
                    document.getElementById("error-apelido").innerHTML = "&nbsp;";
                    x.style.borderColor = "rgb(28, 115, 230)"; 
                }   
            }
        };
        xmlhttp.open("GET", "back.php?request=echo existeDado('apelido', '" + x.value + "');", true);
        xmlhttp.send();
    }
}
function setApelido(){
    if(document.getElementById("apelido").style.borderColor == "rgb(255, 0, 0)" || document.getElementById("error-apelido").innerHTML != "&nbsp;" || document.getElementById("apelido").value.length == 0){
        document.getElementById("msg-title").innerHTML = "Atenção:";
        document.getElementById("msg-content").innerHTML = "Escolha um apelido dentro das normas.";
        msgOpen(0, 0, 1);
    }
    else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                continuar(2);
            }
        };
        xmlhttp.open("GET", "back.php?request=$a=new Usuario(codigoSessao(1));echo $a->setApelido('" + document.getElementById("apelido").value + "');", true);
        xmlhttp.send();
    }
}
function setLiga(){
    if(document.getElementById("select-concluir").value == ""){
        document.getElementById("msg-title").innerHTML = "Atenção:";
        document.getElementById("msg-content").innerHTML = "Escolha a sua liga patrocinada.";
        msgOpen(0, 0, 1);
    }
    else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                continuar(3);
            }
        };
        xmlhttp.open("GET", "back.php?request=$a=new Usuario(codigoSessao(1));echo $a->setLiga('" + document.getElementById("select-concluir").value + "');", true);
        xmlhttp.send();
    }
}
function setIcone(){
    if(document.getElementById("cd-icone").value == ""){
        document.getElementById("msg-title").innerHTML = "Atenção:";
        document.getElementById("msg-content").innerHTML = "Escolha um icone.";
        msgOpen(0, 0, 1);
    }
    else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200){
                continuar(4);
            }
        };
        xmlhttp.open("GET", "back.php?request=$a=new Usuario(codigoSessao(1));$a->setIcone(" + document.getElementById("cd-icone").value + ");", true);
        xmlhttp.send();
    }
}
function select_icon(x){
    for(i = 1; i <= (document.getElementsByClassName("icone").length); i++){
        document.getElementById(i).style = "border-color: rgb(28, 115, 230)";
    }
    x.style.borderColor = "rgb(255, 114, 0)";
    document.getElementById("cd-icone").value = x.name;
    document.getElementById("preview").setAttribute("src", x.src);
}