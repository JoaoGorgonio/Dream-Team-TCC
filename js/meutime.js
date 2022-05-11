function confirmarReembolso(x){
    document.getElementById("msg-title").innerHTML = "Atenção:";
    document.getElementById("msg-content").innerHTML = "Tem certeza que deseja reembolsar este jogador?";
    document.getElementById("msg-confirm").setAttribute("onclick","reembolsoJogador(" + x.id + ")");
    msgOpen(1, 1, 0);
}
function reembolsoJogador(x){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText.length > 2){
                document.getElementById("msg-title").innerHTML = "Status:";
                if(this.responseText == "Jogador reembolsado com sucesso!"){
                    document.getElementById("msg-content").innerHTML = "Jogador reembolsado com sucesso!";
                }
                else{
                    document.getElementById("msg-content").innerHTML = "Algo de errado ocorreu durante a operação, por favor tente novamente mais tarde.";
                }
                document.getElementById("confirm-padding").style = "display: none;";
                document.getElementById("deny-padding").style = "display: none";
                document.getElementById("ok-padding").style = "display: inline-block";
                document.getElementById("msg-ok").setAttribute("onclick","window.location.href = 'meutime.php';");
            }
        }
    };
    xmlhttp.open("GET", "back.php?request=$a=new Usuario(codigoSessao(1));echo $a->reembolsoJogador(" + x + ");", true);
    xmlhttp.send();
}
function comprar(){
    window.location.href = "mercado.php";
}