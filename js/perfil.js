function abrirRanking(x){
    document.getElementById("titulo-painel").innerHTML = "Status da sua liga patrocinada:";
    document.getElementById("dado-voltar").setAttribute("onclick", "fecharPainel()");
    document.getElementById("dados-pan").style = "display: block;";
    setTimeout(function(){
        document.getElementById("dados").style = "opacity: 1; visibility: visible;";
    }, 10);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('content').innerHTML = this.responseText + "<br><br>";
        }
    };
    xmlhttp.open("GET", "back.php?request=$a=new LigaPatrocinada();$a->setDadosLiga(" + x.id + ");", true);
    xmlhttp.send();
}
function infoLigaCustom(x){
    document.getElementById("titulo-painel").innerHTML = "Status da liga:";
    document.getElementById("dado-voltar").setAttribute("onclick", "fecharPainel()");
    document.getElementById("dados-pan").style = "display: block;";
    setTimeout(function(){
        document.getElementById("dados").style = "opacity: 1; visibility: visible;";
    }, 10);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('content').innerHTML = this.responseText + "<br><br>";
        }
    };
    xmlhttp.open("GET", "back.php?request=$a=new LigaCustomizada();$a->setDadosLiga(" + x.id + ");", true);
    xmlhttp.send();
}
function abrirIcone(){
    document.getElementById("icone-holder").style = "display: block;";
    setTimeout(function(){
        document.getElementById("icone-pan").style = "opacity: 1;";
    }, 10);
}
function fecharIcone(){
    if(document.getElementById("cd-icone").value == ""){
        document.getElementById("icone-pan").style = "opacity: 0;";
        setTimeout(function(){
            document.getElementById("icone-holder").style = "display: none;";
        }, 200);
    }
    else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                window.location.href = "perfil.php";
            }
        };
        xmlhttp.open("GET", "back.php?request=$a=new Usuario(codigoSessao(1));echo $a->atualizarIcone(" + document.getElementById("cd-icone").value + ");", true);
        xmlhttp.send();
    }
}
function setSearch(){
    if(event.key == 'Enter'){
        search();
    }
}
function search(){
    if(document.getElementById("searchApelido").value.length < 3){
        document.getElementById("msg-title").innerHTML = "Atenção:";
        document.getElementById("msg-content").innerHTML = "Preencha corretamente o campo de pesquisa!";
        msgOpen(0, 0, 1);
    }
    else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200){
                if(this.responseText != "Apelido já escolhido."){
                    document.getElementById("msg-title").innerHTML = "Atenção:";
                    document.getElementById("msg-content").innerHTML = "Não foi encontrado um usuário com tal apelido.";
                    msgOpen(0, 0, 1);
                }
                else{
                    window.location.href = "perfil.php?apelido=" + document.getElementById("searchApelido").value;
                }  
            }
        };
        xmlhttp.open("GET", "back.php?request=echo existeDado('apelido', '" + document.getElementById("searchApelido").value + "');", true);
        xmlhttp.send();
    }
}
function fecharPainel(){
    document.getElementById("dados").style = "opacity: 0;";
    setTimeout(function(){
        document.getElementById("dados-pan").style = "display: none;";
    }, 400);
}
function select_icon(x){
    for(i = 1; i <= (document.getElementsByClassName("icone").length); i++){
        document.getElementById(i).style = "border-color: rgb(28, 115, 230)";
    }
    x.style.borderColor = "rgb(255, 114, 0)";
    document.getElementById("cd-icone").value = x.name;
    document.getElementById("preview").setAttribute("src", x.src);
}
function voltar(){
    window.location.href = "perfil.php";
}
function confirmarEntrar(x){
    document.getElementById("msg-title").innerHTML = "Atenção:";
    document.getElementById("msg-content").innerHTML = "Você tem certeza que deseja entrar nessa liga?";
    document.getElementById("msg-confirm").setAttribute("onclick","entrarLiga("+x.id+")");
    msgOpen(1, 1, 0);
}
function entrarLiga(x){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('confirm-padding').style.display = "none";
            document.getElementById('deny-padding').style.display = "none";
            document.getElementById('ok-padding').style.display = "inline-block";
            document.getElementById('msg-content').innerHTML = this.responseText;
            document.getElementById('msg-ok').setAttribute("onclick","window.location.href = 'ligas.php'");
        }
    };
    xmlhttp.open("GET", "back.php?request=$a=new Usuario(codigoSessao(1));echo $a->entrarLigaCustom(" + x + ");", true);
    xmlhttp.send();
}