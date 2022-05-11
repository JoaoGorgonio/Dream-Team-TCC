function mudarAba(y,z){
    for(x = 1; x <= document.getElementsByClassName("info-pan").length; x++){
        document.getElementById("pan"+x).style.display = "none";
    }

    for(x = 1; x <= document.getElementsByClassName("opt-nav").length; x++){
        document.getElementById("opt"+x).style.borderBottom = "none";
    }

    y.style.borderBottom = "0.4vh #fff solid";

    document.getElementById("pan"+z).style.display = "block";
}
function confirmarPassar(){
    document.getElementById("msg-title").innerHTML = "ATENÇÃO:";
    document.getElementById("msg-content").innerHTML = "Tem certeza que deseja atualizar os dados da rodada?<br>PS: É necessário que os dados dos jogadores já tenham sido atualizados!";
    document.getElementById("msg-confirm").setAttribute("onclick","passarRodada()");
    msgOpen(1, 1, 0);
}
function passarRodada(){
    window.location.href = "back.php?request=$a=new Administrador(codigoSessao(2));$a->passarRodada();";
}
function confirmarSair(){
    document.getElementById("msg-title").innerHTML = "Atenção:";
    document.getElementById("msg-content").innerHTML = "Tem certeza que deseja finalizar sua sessão?";
    document.getElementById("msg-confirm").setAttribute("onclick","voltar()");
    msgOpen(1, 1, 0);
}
function abrirResposta(x){
    document.getElementById("dado-ok").setAttribute("onclick", "fecharPainel()");
    document.getElementById("dados-pan").style = "display: block;";
    setTimeout(function(){
        document.getElementById("dados").style = "opacity: 1; visibility: visible;";
    }, 10);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("titulo-painel").innerHTML = "Solicitação:";
            document.getElementById("content").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "back.php?request=$a=new Administrador(codigoSessao(2));$a->getDadosMensagem(" + x.id + ");", true);
    xmlhttp.send();
}
function atualizarJogador(x){
    document.getElementById("dado-ok").setAttribute("onclick", "fecharPainel()");
    document.getElementById("dados-pan").style = "display: block;";
    setTimeout(function(){
        document.getElementById("dados").style = "opacity: 1; visibility: visible;";
    }, 10);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("titulo-painel").innerHTML = "Solicitação:";
            document.getElementById("content").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "back.php?request=$a=new Jogador();$a->getDadosAtualizar(" + x.id + ");", true);
    xmlhttp.send();
}
function fecharPainel(){
    document.getElementById("dados").style = "opacity: 0;";
    setTimeout(function(){
        document.getElementById("dados-pan").style = "display: none;";
    }, 400);
}
function msgstts(){
    var msg = document.getElementById("desc");
    var status = document.getElementById("stts-desc");

    if(msg.value.length < 50){
        status.style = "color: #fff";
    }
    else{
        if(msg.value.length > 249 && msg.value.length < 400){
            status.style = "color: yellow";
        }
        else{
            if(msg.value.length > 399){
                status.style = "color: darkred";
            }
        }
    }
    status.innerHTML = (msg.value.length + " / 500");
}
function enviarMensagem(){
    var msg = document.getElementById("desc");

    if(msg.value.length < 50){
        document.getElementById("msg-title").innerHTML = "Atenção:";
        document.getElementById("msg-content").innerHTML = "Mensagem muito curta, por favor, detalhe-a mais.";
        msgOpen(0, 0, 1);
        return false;
    }
    else{
        return true;
    }
}
function voltar(){
    window.location.href = "back.php?request=destruirSessao();";
}