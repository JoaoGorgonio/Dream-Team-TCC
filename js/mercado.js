function confirmarJogador(x){
    document.getElementById('msg-title').innerHTML = "Atenção:";
    document.getElementById('msg-content').innerHTML = "Você tem certeza que deseja comprar este jogador?";
    document.getElementById('msg-confirm').setAttribute("onclick", "comprarJogador(" + x.id + ")");
    msgOpen(1, 1, 0);
}
function comprarJogador(id){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('msg-content').innerHTML = this.responseText;
            document.getElementById('confirm-padding').style = "display: none";
            document.getElementById('deny-padding').style = "display: none";
            document.getElementById('msg-ok').setAttribute("onclick", "window.location.href = 'mercado.php'");
            document.getElementById('ok-padding').style = "display: inline-block";
        }
    };
    xmlhttp.open("GET", "back.php?request=$a=new Usuario(codigoSessao(1));echo $a->comprarJogador(" + id + ");", true);
    xmlhttp.send();
    document.getElementById('msg-title').innerHTML = "Status:";
}
function confirmarIcone(x){
    document.getElementById('msg-title').innerHTML = "Atenção:";
    document.getElementById('msg-content').innerHTML = "Você tem certeza que deseja comprar este icone?";
    document.getElementById('msg-confirm').setAttribute("onclick", "comprarIcone(" + x.id + ")");
    msgOpen(1, 1, 0);
}
function comprarIcone(id){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('msg-content').innerHTML = this.responseText;
            document.getElementById('confirm-padding').style = "display: none";
            document.getElementById('deny-padding').style = "display: none";
            document.getElementById('msg-ok').setAttribute("onclick", "window.location.href = 'mercado.php'");
            document.getElementById('ok-padding').style = "display: inline-block";
        }
    };
    xmlhttp.open("GET", "back.php?request=$a=new Usuario(codigoSessao(1));echo $a->comprarIcone(" + id + ");", true);
    xmlhttp.send();
    document.getElementById('msg-title').innerHTML = "Status:";
}
function abrirEstatisticas(x){
    document.getElementById("dados-pan").style = "display: block;";
    setTimeout(function(){
        document.getElementById("dados").style = "opacity: 1; visibility: visible;";
    }, 10);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            eval(this.responseText);
        }
    };
    xmlhttp.open("GET", "back.php?request=$a=new Jogador();echo $a->setDadosJogador(" + x.id + ");", true);
    xmlhttp.send();
}
function fecharEstatisticas(){
    document.getElementById("dados").style = "opacity: 0; visibility: hidden;";
    setTimeout(function(){
        document.getElementById("dados-pan").style = "display: none;";
    }, 400);
}
function purchase_icon(x){
    if(confirm("Tem certeza que deseja comprar este ícone?") == true){
        var id = x.id;
        var price = x.name;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            console.log(this.status);
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText.length > 2){
                    window.location.href = "mercado.php";
                }
            }
        };
        xmlhttp.open("GET", "func-ajax.php?core=Comprar icone&id=" + id + "&price=" + price, true);
        xmlhttp.send();
    }
}

function exibirVoltar(){
    var bodyRect = document.body.getBoundingClientRect(), elemRect = document.getElementById('alas').getBoundingClientRect(), offset   = elemRect.top - bodyRect.top;
    var voltar = document.getElementById('voltar');
    
    if(window.pageYOffset >= offset && voltar.style.right != '2vh'){
        voltar.style.right = '2vh';

        setTimeout(() => {
            voltar.style.right = '-20vh';
        }, 3000);
    }
}

function moverDireita(){
    var saldo = document.getElementById("infoSaldo");
    var jogador = document.getElementById("infoJogador");

    saldo.style = "opacity: 0;";
    document.getElementById('setaDireita').style = "opacity: 0; cursor: default;";
    setTimeout(function(){
        saldo.style = "display: none; opacity: 0;";
        jogador.style = "display: block; opacity: 0;";
    }, 400);
    setTimeout(function(){
        jogador.style = "opacity: 1; display: block;";
        document.getElementById('setaEsquerda').style = "opacity: 1; cursor: pointer;";
    }, 500);
}

function moverEsquerda(){
    var saldo = document.getElementById("infoSaldo");
    var jogador = document.getElementById("infoJogador");

    jogador.style = "opacity: 0;";
    document.getElementById('setaEsquerda').style = "opacity: 0; cursor: default;";
    setTimeout(function(){
        jogador.style = "display: none; opacity: 0;";
        saldo.style = "display: block; opacity: 0;";
    }, 450);
    setTimeout(function(){
        saldo.style = "opacity: 1; display: block;";
        document.getElementById('setaDireita').style = "opacity: 1; cursor: pointer;";
    }, 450);
}