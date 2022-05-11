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
function maxMsg(x){
    if(x.value.length == 500){
        return false;
    }
}
function enviarMensagem(){
    var msg = document.getElementById("desc");
    var assunto = document.getElementById("select-assunto");

    if(assunto.value == ""){
        document.getElementById("msg-title").innerHTML = "Atenção:";
        document.getElementById("msg-content").innerHTML = "Escolha um assunto que represente sua mensagem.";
        msgOpen(0, 0, 1);
        return false;
    }
    else{
        if(msg.value.length < 50){
            document.getElementById("msg-title").innerHTML = "Atenção:";
            document.getElementById("msg-content").innerHTML = "Descrição muito curta, por favor, detalhe-a mais.";
            msgOpen(0, 0, 1);
            return false;
        }
        else{
            return true;
        }
    }
}