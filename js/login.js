function preencherLogin(){
    usuario = document.getElementById("usuario");
    senha = document.getElementById("senha");

    if(usuario.value.length < 3 && usuario.value.length > 0){
        usuario.style = "border-color: red; margin-top: 4vh;";
        return false;
    }
    else{
        usuario.style = "border-color: rgb(28, 115, 230); margin-top: 4vh;";
        if(senha.value.length < 8 && senha.value.length > 0){
            senha.style = "border-color: red;";
            return false;
        }
        else{
            senha.style = "border-color: rgb(28, 115, 230);";
        }
    }
}
function preencherRedefinir(){
    email = document.getElementById("emailRedefinir");
    senha = document.getElementById("senhaRedefinir");

    if(email.value.length < 12){
        document.getElementById('confirm-padding').style = "display: none;";
        email.style = "border-color: red;";
        return false;
    }
    else{
        email.style = "border-color: rgb(28, 115, 230);";
        if(senha.value.length < 8){
            document.getElementById('confirm-padding').style = "display: none;";
            senha.style = "border-color: red; border-radius: 1vh 1vh 0vh 0vh;";
            return false;
        }
        else{
            document.getElementById('confirm-padding').style = "display: inline-block;";
            senha.style = "border-color: rgb(28, 115, 230); border-radius: 1vh 1vh 0vh 0vh;";
        }
    }
}
function getRedefinir(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("msg-content").innerHTML = "Insira seu E-mail e a nova senha desejada, respectivamente.<br>" + this.responseText;
            document.getElementById('msg-title').innerHTML = 'REDEFINIÇÃO:';
            document.getElementById('msg-confirm').setAttribute("onclick", "redefinir()");
        }
    };
    xmlhttp.open("GET", "back.php?request= $a = new Mensagem(); echo $a->redefinir();", true);
    xmlhttp.send();
    msgOpen(1, 0, 0);
}
function redefinir(){
    var email = document.getElementById("emailRedefinir").value;
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200){
                if(this.responseText == "E-mail já cadastrado."){
                    var senha = document.getElementById("senhaRedefinir").value;
                    window.location.href="back.php?request=redefinirSenha('" + senha + "');&mail=" + email;
                }
                else{
                    document.getElementById('msg-title').innerHTML = 'Atenção:';
                    document.getElementById("msg-content").innerHTML = "O e-mail inserido não foi encontrado.";
                    document.getElementById("confirm-padding").style = "display: none;";
                    document.getElementById("deny-padding").style = "display: none;";
                    document.getElementById("ok-padding").style = "display: inline-block;";
                }
            }
        };
    xmlhttp.open("GET", "back.php?request=echo existeDado('email','" + email + "');", true);
    xmlhttp.send();
}
function enterEntrar(){
    if(event.keyCode == 13){entrar();}
}
function mostrarSenha(){
    document.getElementById("mostrarSenha").blur();
    if(document.getElementById("senhaRedefinir").type == "password"){
        document.getElementById("senhaRedefinir").type = "text";
        document.getElementById("mostrarSenha").style = "background-image: url('../img/hide.png')";
    }
    else{
        document.getElementById("senhaRedefinir").type = "password";
        document.getElementById("mostrarSenha").style = "background-image: url('../img/view.png')";
    }
}
function entrar(){
    usuario = document.getElementById("usuario");
    senha = document.getElementById("senha");
    if(document.getElementById('chkSessao').checked == true){
        sessao = 1;
    }
    else{
        sessao = 0;
    }

    if(usuario.value != "" && usuario.style.borderColor != "red" && senha.value != "" && senha.style.borderColor != "red"){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200){
                if(this.responseText != ""){
                    if(this.responseText == "Apelido/E-mail e/ou senha inválido(s)!" || this.responseText == "Você precisa confirmar seu e-mail!"){
                        document.getElementById('msg-title').innerHTML = "Atenção:";
                        document.getElementById('msg-content').innerHTML = this.responseText;
                        msgOpen(0, 0, 1);
                    }
                    else{
                        x = this.responseText;
                        document.getElementById("formlog").style = "opacity:0; visibility: hidden;";
                        setTimeout(function(){
                            eval(x);
                            document.getElementById("formlog").style = "display: none;";
                            document.getElementById("loginfo").style = "display: block; opacity: 0;";
                        }, 400);
                        setTimeout(() => {
                            document.getElementById("loginfo").style = "opacity: 1; display: block;";
                            document.getElementById("progress").value = "100";
                        }, 450);
                    }
                }
                else{
                    document.getElementById('msg-title').innerHTML = 'ERRO';
                    document.getElementById('msg-content').innerHTML = 'Falha ao completar ação, por favor tente novamente mais tarde. Se o problema persistir, por favor, contate o suporte.';
                    msgOpen(0, 0, 1);
                }
            }
        };
        xmlhttp.open("GET", "back.php?request=echo $a=setDadosLogin('" + usuario.value + "','" + senha.value + "', " + sessao + ");", true);
        xmlhttp.send();
    }
}
function cmail(){
    var ch = event.key.toLowerCase();
    var pode = "abcdefghijklmnopqrstuvwxyz0123456789-_@.";
    r = pode.includes(ch);
    if(event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 20 || event.keyCode == 16 || event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40){
        return true;
    }
    if (r == false || event.keyCode == 192)
    {
        return false;
    }
    else{
        return true;
    } 
}