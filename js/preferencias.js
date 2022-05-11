function abrirApelido(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("msg-content").innerHTML = this.responseText;
            document.getElementById('msg-title').innerHTML = 'REDEFINIÇÃO:';
            document.getElementById('msg-confirm').setAttribute("onclick", "trocarApelido()");
        }
    };
    xmlhttp.open("GET", "back.php?request= $a = new Mensagem(); echo $a->trocarApelido();", true);
    xmlhttp.send();
    msgOpen(1, 0, 0);
}
function preencherApelido(){
    apl = document.getElementById("apelidoRedefinir");

    if(apl.value.length < 3){
        document.getElementById('confirm-padding').style = "display: none;";
        apl.style = "border-color: red";
    }
    else{
        document.getElementById('confirm-padding').style = "display: inline-block;";
        apl.style = "border-color: border-color: rgb(28, 115, 230);";
    }
}
function preencherSenha(){
    senha = document.getElementById("senhaRedefinir");

    if(senha.value.length < 8){
        document.getElementById('confirm-padding').style = "display: none;";
        senha.style = "border-color: red; border-radius: 1vh 1vh 0vh 0vh;";
    }
    else{
        document.getElementById('confirm-padding').style = "display: inline-block;";
        senha.style = "border-color: rgb(28, 115, 230); border-radius: 1vh 1vh 0vh 0vh;";
    }
}
function abrirSenha(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("msg-content").innerHTML = this.responseText;
            document.getElementById('msg-title').innerHTML = 'REDEFINIÇÃO:';
            document.getElementById('msg-confirm').setAttribute("onclick", "trocarSenha()");
        }
    };
    xmlhttp.open("GET", "back.php?request= $a = new Mensagem(); echo $a->trocarSenha();", true);
    xmlhttp.send();
    msgOpen(1, 0, 0);
}
function trocarSenha(){
    window.location.href="back.php?request=$a=new usuario(codigoSessao(1)); $a->getAcao('Senha', '" + document.getElementById("senhaRedefinir").value + "');";
}
function trocarApelido(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText != "Apelido já escolhido."){
                window.location.href="back.php?request=$a=new usuario(codigoSessao(1)); $a->getAcao('Apelido', '" + document.getElementById("apelidoRedefinir").value + "');";
            }
            else{
                document.getElementById('msg-title').innerHTML = 'Atenção:';
                document.getElementById("msg-content").innerHTML = "O apelido inserido já foi escolhido.";
                document.getElementById("confirm-padding").style = "display: none;";
                document.getElementById("deny-padding").style = "display: none;";
                document.getElementById("ok-padding").style = "display: inline-block;";
            }
        }
    };
    xmlhttp.open("GET", "back.php?request=echo existeDado('apelido', '" + apelido.value + "');", true);
    xmlhttp.send();
}
function fecharPainel(){
    document.getElementById("dados").style = "opacity: 0;";
    setTimeout(function(){
        document.getElementById("dados-pan").style = "display: none;";
    }, 400);
}
function mostrarSenha(x){
    document.getElementById("mostrarSenha").blur();
    if(x == 1){
        if(document.getElementById("senhaExibicao").type == "password"){
            document.getElementById("senhaExibicao").type = "text";
            document.getElementById("mostrarSenhaEx").style = "background-image: url('../img/hide.png')";
        }
        else{
            document.getElementById("senhaExibicao").type = "password";
            document.getElementById("mostrarSenhaEx").style = "background-image: url('../img/view.png')";
        }
    }
    else{
        if(document.getElementById("senhaRedefinir").type == "password"){
            document.getElementById("senhaRedefinir").type = "text";
            document.getElementById("mostrarSenha").style = "background-image: url('../img/hide.png')";
        }
        else{
            document.getElementById("senhaRedefinir").type = "password";
            document.getElementById("mostrarSenha").style = "background-image: url('../img/view.png')";
        }
    }
}
function confirmarDeletar(){
    document.getElementById('msg-title').innerHTML = 'ATENÇÃO:';
    document.getElementById("msg-content").innerHTML = "TEM CERTEZA DE QUE DESEJA EXCLUIR SUA CONTA? ESSA AÇÃO É IRREVERSÍVEL!";
    document.getElementById('msg-confirm').setAttribute("onclick", "deletar()");
    msgOpen(1, 1, 0);
}
function deletar(){
    window.location.href="back.php?request=$a=new usuario(codigoSessao(1)); $a->getAcao('Deletar', null);";
}