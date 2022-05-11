function validName(x){
    if(x.value.length > 7){
    document.getElementById("errorname").innerHTML = "&nbsp;";
    x.style.borderColor = "green";}else{
    document.getElementById("errorname").innerHTML = "Nome muito curto!";
    x.style.borderColor = "red";   
    }
}
function validmail(x){
    var ia = x.value.indexOf("@");
    var idt = x.value.indexOf(".", ia);
    if(ia == -1){
        document.getElementById("errormail").innerHTML = "É necessária a presença de um @!";
        x.style.borderColor = "red";
        return false;
    }
    else{
        if (ia == 0){
            document.getElementById("errormail").innerHTML = "O '@' não pode ser o primeiro caractere!";
            x.style.borderColor = "red";
            return false;
        }
        else{
            if(x.value.indexOf(".") == 0){
                document.getElementById("errormail").innerHTML = "É necessário que haja caracteres antes dos pontos!";
                x.style.borderColor = "red";
                return false;
            }
            else{
                if(x.value.indexOf("-", ia) >= 1 || x.value.indexOf("_", ia) >= 1){
                    document.getElementById("errormail").innerHTML = "Os caracteres '-' e '_' só são permitidos antes do '@'!";
                    x.style.borderColor = "red";
                    return false;
                }
                else{
                    var qta = 0;
                    for(i = 1; i <= x.value.length; i++){
                        if(x.value.charAt(i) == "@"){
                            qta++;
                        }
                    }
                    if(qta > 1){
                        document.getElementById("errormail").innerHTML = "Só pode haver 1 '@'!";
                        return false;
                    }
                }
            }
        }
    }
    if(idt == -1){
        document.getElementById("errormail").innerHTML = "É necessária a presença de um domínio de topo!";
        x.style.borderColor = "red";
        return false;
    }
    else{
        if((idt - ia) == 1){
            document.getElementById("errormail").innerHTML = "É necessário um nome de domínio!";
            x.style.borderColor = "red";
            return false;
        }
        else{
            var cs = 0;
            for(i = 1; i <= x.value.length; i++){
                if(x.value.charAt(i) == "." || x.value.charAt(i) == "@" || x.value.charAt(i) == "_" || x.value.charAt(i) == "-"){
                    cs++;
                    if(cs > 1){
                        break;
                    }
                }
                else{
                    cs = 0;
                }
            }
            if(cs > 1){
                document.getElementById("errormail").innerHTML = "É necessário que haja caracteres depois dos caracteres especiais!";
                x.style.borderColor = "red";
                return false;
            }
            else{
                if((x.value.lastIndexOf(".") + 1) == x.value.length){
                    document.getElementById("errormail").innerHTML = "É necessário que haja caracteres depois dos caracteres especiais!";
                    x.style.borderColor = "red";
                }
                else{
                    document.getElementById("errormail").innerHTML = "&nbsp;";
                    x.style.borderColor = "green";
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            if(this.responseText.length > 2){
                                document.getElementById("errormail").innerHTML = this.responseText;
                                x.style.borderColor = "red"; 
                            }
                        }
                    };
                    xmlhttp.open("GET", "back.php?request=echo existeDado('email', '" + x.value + "');", true);
                    xmlhttp.send();
                }
            }
        }
    }
}
function validPassword(){
    if(document.getElementById("pass").value.length < 8){
        document.getElementById("pass").style.borderColor = "red";
        document.getElementById("errorpass").innerHTML = "Senha muito curta!";}
    else{
        document.getElementById("pass").style.borderColor = "green";
        document.getElementById("errorpass").innerHTML = "&nbsp;";
    }
}
function mostrar(){
    document.getElementById("mostrarSenha").blur();
    if(document.getElementById("pass").type == "password"){
        document.getElementById("pass").type = "text";
        document.getElementById("mostrarSenha").style = "background-image: url('../img/hide.png')";
    }
    else{
        document.getElementById("pass").type = "password";
        document.getElementById("mostrarSenha").style = "background-image: url('../img/view.png')";
    }
}
function validcpf(){
    var strCpf = document.getElementById("mask-cpf").value;
    strCpf = strCpf.replace(/[^\d]+/g,'');	
    var soma;
    var resto;
    soma = 0;
    if (strCpf == "00000000000" || strCpf == "11111111111" || strCpf == "22222222222" || strCpf == "33333333333" || strCpf == "44444444444" || strCpf == "55555555555" || strCpf == "66666666666" || strCpf == "77777777777" || strCpf == "88888888888" || strCpf == "99999999999") {
        document.getElementById("mask-cpf").style.borderColor = "red";
        document.getElementById("errorcpf").innerHTML = "Cpf inválido!";
        return false;
    }
        
    for (i = 1; i <= 9; i++) {
        soma = soma + parseInt(strCpf.substring(i - 1, i)) * (11 - i);
    }
        
    resto = soma % 11;
        
    if (resto == 10 || resto == 11 || resto < 2) {
        resto = 0;
    } else {
        resto = 11 - resto;
    }
        
    if (resto != parseInt(strCpf.substring(9, 10))) {
        document.getElementById("mask-cpf").style.borderColor = "red"; 
        document.getElementById("errorcpf").innerHTML = "Cpf inválido!";
        return false;
    }
        
    soma = 0;
        
    for (i = 1; i <= 10; i++) {
        soma = soma + parseInt(strCpf.substring(i - 1, i)) * (12 - i);
    }
    resto = soma % 11;
        
    if (resto == 10 || resto == 11 || resto < 2) {
        resto = 0;
    } else {
        resto = 11 - resto;
    }
    
    if (resto != parseInt(strCpf.substring(10, 11))) {
        document.getElementById("mask-cpf").style.borderColor = "red"; 
        document.getElementById("errorcpf").innerHTML = "Cpf inválido!";
        return false;
    }
    document.getElementById("errorcpf").innerHTML = "&nbsp;";
    document.getElementById("mask-cpf").style.borderColor = "green";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText.length > 2){
                document.getElementById("errorcpf").innerHTML = this.responseText;
                document.getElementById("mask-cpf").style.borderColor = "red"; 
            }
        }
    };
    xmlhttp.open("GET", "back.php?request=echo existeDado('cpf', '" + strCpf + "');", true);
    xmlhttp.send();
    return true;
}
function mostrarTermos(){
    document.getElementById('msg-title').innerHTML = "Termos de Uso:";
    document.getElementById('msg-content').innerHTML = "TERMOS E USOS:<br> Estes Termos e Usos (doravante denominados 'Termos e Usos') regulamenta o uso do serviço do portal de Internet www.dtoficial.com que FANTASY GAME DREAM TEAM oferece aos seus USUÁRIOS.<br>1) Qualquer pessoa, física ou jurídica, doravante nominada USUÁRIO, que pretenda utilizar os serviços do dtoficial.com, deverá aceitar as Cláusulas de Uso e todas as demais políticas e princípios que as regem.<br>2) A ACEITAÇÃO DESTES TERMOS E CONDIÇÕES GERAIS É INDISPENSÁVEL À UTILIZAÇÃO DOS SITES E SERVIÇOS PRESTADOS PELO dtoficial.com. O USUÁRIO deverá ler, certificar-se de haver entendido e aceitar todas as disposições estabelecidas nos Termos e Condições e na Política de Privacidade, para que então seja efetuado com sucesso seu cadastro como USUÁRIO do dtoficial.com.<br><br>II – DO USUÁRIO:<br>3) Os serviços do dtoficial.com somente estão disponíveis para as pessoas que tenham plena capacidade de fato para contratar. Dessa forma, não podem efetuar cadastro pessoas menores de 10 anos ou acometidas por outras incapacidades inscritas nos artigos 3º e 4º do Código Civil Brasileiro, salvo se devidamente representadas ou assistidas.<br>4) O USUÁRIO se compromete a fornecer seus dados pessoais de forma verdadeira e precisa.<br>5) O dtoficial.com não se responsabiliza pela veracidade das informações prestadas por seus USUÁRIOS, sendo deles toda a responsabilidade por seu conteúdo.<br>6) O dtoficial.com pode checar a veracidade dos dados cadastrais de um USUÁRIO a qualquer tempo. Caso constate haver entre eles dados incorretos ou inverídicos, ou ainda caso o USUÁRIO se furte ou se negue a enviar os documentos requeridos, o dtoficial.com poderá bloquear o perfil do USUÁRIO, até que a irregularidade seja sanada.<br>7) O USUÁRIO acessará sua conta através de login e senha, comprometendo-se a não informar a terceiros esses dados, responsabilizando-se integralmente pelo uso que deles seja feito.<br>8) O dtoficial.com compromete-se a notificar a dtoficial.com imediatamente, através de comunicação em que fique certificado o recebimento pelo dtoficial.com, a respeito de qualquer uso não autorizado de sua conta, bem como o acesso não autorizado por terceiros a mesma. O USUÁRIO será o único responsável pelas operações efetuadas em sua conta, uma vez que o acesso à mesma só será possível mediante a senha pessoal do USUÁRIO.<br>9) O login que o USUÁRIO utiliza no dtoficial.com não poderá guardar semelhança com o nome dtoficial.com, tampouco poderá ser utilizado qualquer login considerado ofensivo, bem como os que contenham dados pessoais do USUÁRIO ou alguma URL ou endereço eletrônico.<br><br>III – DO SERVIÇO PRESTADO:<br>10) O dtoficial.com é um website que possui como objetivo divulgar a Liga Nacional de Basquete (LNB) por meio da competitividade trazida no ato de escalar times para alcançar o topo, e com ele, recompensas.<br>11) Os USUÁRIOS não possuem vínculos de permanência com os serviços prestados, podendo, assim, cancelá-los caso desejem, mediante notificação escrita, virtual ou não, com confirmação de recebimento.<br>12) O DTOFICIAL.COM poderá mudar os valores citados neste contrato ou modificar quaisquer de suas clausulas, mediante notificação previa enviada aos USUÁRIOS.";
    msgOpen(0, 0, 1);
}
function send(){
    if(document.getElementById("mask-cpf").value == "000.000.000-00"){
        document.getElementById('msg-title').innerHTML = "Atenção:";
        document.getElementById('msg-content').innerHTML = "Os dados fornecidos estão incorretos ou não preenchem os requisitos, por favor corrija-os para continuar.";
        msgOpen(0, 0, 1);
        return false;
    }
    else{
        if(document.getElementById("errorname").innerHTML != "&nbsp;" || document.getElementById("errormail").innerHTML != "&nbsp;" || document.getElementById("errorcpf").innerHTML != "&nbsp;" || document.getElementById("errorpass").innerHTML != "&nbsp;"){
            document.getElementById('msg-title').innerHTML = "Atenção:";
            document.getElementById('msg-content').innerHTML = "Os dados fornecidos estão incorretos ou não preenchem os requisitos, por favor corrija-os para continuar.";
            msgOpen(0, 0, 1);
            return false;
        }
        else{
            if(document.getElementById("name").style.bordeColor == "rgb(255, 0, 0)" || document.getElementById("mail").style.bordeColor == "rgb(255, 0, 0)" || document.getElementById("pass").style.bordeColor == "rgb(255, 0, 0)" || document.getElementById("mask-cpf").style.bordeColor == "rgb(255, 0, 0)" || document.getElementById("check-termos").checked == false){
                document.getElementById('msg-title').innerHTML = "Atenção:";
                document.getElementById('msg-content').innerHTML = "Os dados fornecidos estão incorretos ou não preenchem os requisitos, por favor corrija-os para continuar.";
                msgOpen(0, 0, 1);
                return false;
            }
            else{
                cpfzin = document.getElementById("mask-cpf").value;
                cpfzao = cpfzin.replace(/[^\d]+/g,'');	
                document.getElementById("cpfUsuario").value = cpfzao;
                return true;
            }
        }
    }
}