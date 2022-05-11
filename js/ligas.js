function abrirRanking(x){
    document.getElementById("titulo-painel").innerHTML = "Status da sua liga patrocinada:";
    document.getElementById("dado-ok").setAttribute("onclick", "fecharPainel()");
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
function pesquisar(x){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText != "Liga não encontrada!"){
                infoLigaCustom(this.responseText);
            }
            else{
                document.getElementById("msg-title").innerHTML = "Atenção:";
                document.getElementById("msg-content").innerHTML = "Liga não encontrada!<br>Certifique-se de que inseriu o código corretamente.";
                msgOpen(0, 0, 1);
            }
        }
    };
    xmlhttp.open("GET", "back.php?request=$a=new LigaCustomizada();echo $a->getLigaCodigo('"+x.value+"');", true);
    xmlhttp.send();
}
function abrirSuasLigas(){
    document.getElementById("titulo-painel").innerHTML = "Sua(s) liga(s) customizada(s):";
    document.getElementById("dado-ok").setAttribute("onclick", "fecharPainel()");
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
    xmlhttp.open("GET", "back.php?request=$a=new LigaCustomizada();echo $a->getLigas();", true);
    xmlhttp.send();
}
function abrirRankingLigas(){
    document.getElementById("titulo-painel").innerHTML = "Top 10 ligas customizadas:";
    document.getElementById("dado-ok").setAttribute("onclick", "fecharPainel()");
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
    xmlhttp.open("GET", "back.php?request=$a=new LigaCustomizada();echo $a->setRankingLigas();", true);
    xmlhttp.send();
}
function abrirLigasDisponiveis(){
    document.getElementById("titulo-painel").innerHTML = "Ligas customizadas disponíveis:";
    document.getElementById("dado-ok").setAttribute("onclick", "fecharPainel()");
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
    xmlhttp.open("GET", "back.php?request=$a=new LigaCustomizada();echo $a->exibirDisponivel();", true);
    xmlhttp.send();
}
function infoLigaCustom(x){
    document.getElementById("titulo-painel").innerHTML = "Status da liga:";
    document.getElementById("dado-ok").setAttribute("onclick", "fecharPainel()");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('content').innerHTML = this.responseText + "<br><br>";
        }
    };
    if(x.id != null){
        xmlhttp.open("GET", "back.php?request=$a=new LigaCustomizada();$a->setDadosLiga(" + x.id + ");", true);
    }
    else{
        xmlhttp.open("GET", "back.php?request=$a=new LigaCustomizada();$a->setDadosLiga(" + x + ");", true);
    }
    xmlhttp.send();
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
function abrirCriar(){
    document.getElementById("titulo-painel").innerHTML = "Criar liga customizada:";
    document.getElementById("dado-ok").setAttribute("onclick", "fecharPainel()");
    document.getElementById("dados-pan").style = "display: block;";
    setTimeout(function(){
        document.getElementById("dados").style = "opacity: 1; visibility: visible;";
    }, 10);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('content').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "back.php?request=$a=new LigaCustomizada();echo $a->exibirCriarLiga();", true);
    xmlhttp.send();
}
function validarNome(x){
    if(x.value.length < 3){
        document.getElementById("error-liga").innerHTML = "Nome muito curto!";
        x.style.borderColor = "red";
        document.getElementById("privado-info").style.display = "none";
    }
    else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText == "Este nome já se encontra em uso!"){
                    document.getElementById("error-liga").innerHTML = this.responseText;
                    x.style.borderColor = "red";
                    document.getElementById("privado-info").style.display = "none";
                }
                else{
                    
                    var nome = x.value;
                    while(nome.indexOf(" ") != -1){
                        nome = nome.replace(" ", "");
                    }

                    document.getElementById("error-liga").innerHTML = "&nbsp;";
                    document.getElementById("privado-info").style.display = "block";
                    x.style.borderColor = "rgb(28, 115, 230)";
                    document.getElementById("codigo-liga").value = "dt/" + nome.toLowerCase() + (Math.random() * 1000).toFixed(0);
                }
            }
        };
        xmlhttp.open("GET", "back.php?request=$a=new LigaCustomizada();echo $a->existeLiga('" + x.value + "');", true);
        xmlhttp.send();
    }
}
function confirmarLiga(){
    if(document.getElementById("nome-criar").value.length < 3){
        document.getElementById("msg-title").innerHTML = "Atenção:";
        document.getElementById("msg-content").innerHTML = "Nome inválido, por favor, insira um nome com no mínimo 3 digitos.";
        msgOpen(0, 0, 1);
    }
    else{
        if(document.getElementById("select-participantes").value == ""){
            document.getElementById("msg-title").innerHTML = "Atenção:";
            document.getElementById("msg-content").innerHTML = "Selecione a quantidade de participantes.";
            msgOpen(0, 0, 1);
        }
        else{
            if(document.getElementById("select-rodadas").value == 0){
                document.getElementById("msg-title").innerHTML = "Atenção:";
                document.getElementById("msg-content").innerHTML = "Selecione a quantidade de rodadas.";
                msgOpen(0, 0, 1);
            }
            else{
                document.getElementById("msg-title").innerHTML = "Atenção:";
                document.getElementById("msg-content").innerHTML = "Tem certeza de que deseja criar esta liga?";
                document.getElementById("msg-confirm").setAttribute("onclick", "criarLiga()")
                msgOpen(1, 1, 0);
            }
        }
    }
}
function criarLiga(){
    if(document.getElementById("check-criar").checked == true){
        privacidade = 1;
    }
    else{
        privacidade = 0;
    }
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
    xmlhttp.open("GET", "back.php?request=$a=new Usuario(codigoSessao(1));echo $a->criarLigaCustom('" + document.getElementById("nome-criar").value + "', " + document.getElementById("select-participantes").value + ", " + document.getElementById("select-rodadas").value + "," + privacidade + ",'" + document.getElementById("codigo-liga").value + "');", true);
    xmlhttp.send();
}
function valorLiga(){
    if(document.getElementById("check-criar").checked == true){
        var privacidade = 400;
    }
    else{
        var privacidade = 200;
    }
    var valor = ((document.getElementById("select-participantes").value * 10) + (document.getElementById("select-rodadas").value * 5) + privacidade);
    document.getElementById("criar-liga").innerHTML = valor + "dg";
}
function gerarCodigo(x){
    if(x.checked == true){
        document.getElementById("codigo-liga").style.display = "block";
    }
    else{
        document.getElementById("codigo-liga").style.display = "none";
    }
}
function fecharPainel(){
    document.getElementById("dados").style = "opacity: 0; visibility: hidden;";
    setTimeout(function(){
        document.getElementById("dados-pan").style = "display: none;";
    }, 400);
}