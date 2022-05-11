<?php
    require('back.php');
    redirecionar(1);
    $user = new Usuario(codigoSessao(1));

    if($user->verificarCadastro() == "Incompleto"){
        header("Location: concluirCadastro.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta http-equiv="Content-Language" content="pt_br">
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="rgb(138, 160, 255)">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">	
        <meta name="description" content="Mercado do fantasy game Dream Team">
        <link rel="shortcut icon" href="icon.png" type="image/x-icon" />
        <link href="css/suporte.css" rel="stylesheet"/>
        <link href="css/optbar.css" rel="stylesheet"/>
        <link href="css/msg.css" rel="stylesheet"/>
        <script src="js/msg.js"></script>
        <script src="js/suporte.js"></script>
        <script src="js/universal.js"></script>
        <title>Dream Team - Suporte</title>
    </head>
    <body>
        <div class="pag" align="center" oncopy="return false" oncut="return false" onpaste="return false">
            <img alt="ícone usado para abrir a barra de navegação" src="img/menu-white.png" class="navicon" id="opbar" onclick="optbaron()">
            <?php 
                require('componentes/nav-bar.php');
                require("componentes/msg.php");
                if(isset($_REQUEST['msg']) == true){
                    $msg = new Mensagem();
                    if($_REQUEST['msg'] == 1){
                        echo $msg->sucessoMensagem();
                    }
                    else{
                        echo $msg->erroMensagem();
                    }
                }
                echo 
                    "<script>
                        document.getElementById('suporte-opt').setAttribute('class','baropt-select');
                    </script>"
                ;
            ?>
            <img src="img/mail.png" id="suporte">
            <p style='font-size: 4vh; color: white; margin-top: 2vh;'>Escolha a categoria que mais se adequa a sua solicitação:</p>
            <form action="back.php?request=$a=new Usuario(codigoSessao(1));$a->setMensagem();" onsubmit="return enviarMensagem()" method="POST">
                <select id="select-assunto" name='assunto'>
                    <option value="">Assunto</option>
                    <option value="Dúvida">Dúvida</option>
                    <option value="Denúncia">Denúncia</option>
                    <option value="Problemas com compras">Problemas com compras</option>
                    <option value="Bug">Bug</option>
                    <option value="Recuperar conta">Recuperar conta</option>
                    <option value="Sugestão/opinião">Sugestão/opinião</option>
                </select>
                <p style='font-size: 4vh; color: white; margin-top: 6vh;'>Mensagem:&nbsp;<a id="stts-desc" class="error"></a></p>
                <textarea id="desc" maxlength="500" onkeyup='aspas(this), msgstts()' onkeypress='return maxMsg(this)' name='mensagem'></textarea>
                <p style='font-size: 3vh; color: white; margin-top: 2vh;'>*mensagens sem objetivo claro ou sem propósito serão ignoradas<br>*O prazo de resposta, que chegará pelo seu e-mail, é de 24 horas após o envio da mensagem.</p>
                <input id="btn" value="Enviar" type="submit">
            </form>
            <br>
            <br>
        </div>
    </body>
</html>