<?php
    require("back.php");
    redirecionar(0);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Language" content="pt_BR">
        <meta charset="utf-8">	
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="rgb(138, 160, 255)">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="icon.png" type="image/x-icon" />
        <link href="css/login.css" rel="stylesheet"/>
        <link href="css/msg.css" rel="stylesheet"/>
        <script src="js/login.js"></script>
        <script src="js/universal.js"></script>
        <script src="js/msg.js"></script>
        <title>Dream Team - Login</title>
    </head>
    <body>
        <?php
            require("componentes/msg.php");
            if(isset($_REQUEST["msg"]) == true){
                $mensagem = new Mensagem();
                if($_REQUEST['msg'] == 1){
                    echo $mensagem->linkEnviado();
                }
                else{
                    echo $mensagem->acaoExpirada();
                }
            } 
        ?>
        <div align="center">          
            <div class="site" align="center" oncopy="return false" oncut="return false" onpaste="return false">
                <h1 id="tituloLogin">Entrar</h1>
                <form id="formlog">
                    <input class="dados" onkeyup="preencherLogin(), aspas(this)" style='margin-top: 4vh;' onkeypress="enterEntrar()" name="usuario" maxlength="80" type="text" id="usuario" placeholder="E-mail/apelido"><br>
                    <input class="dados" type="password" onkeyup="preencherLogin(), aspas(this)" onkeypress="enterEntrar()" maxlength="30" name="senha" placeholder="Senha" id="senha"><br>
                    <p style='margin-top: 4vh; font-size: 4.5vh;'><input id='chkSessao' type='checkbox'>&nbsp;Manter sessão.</p>
                    <input class="btn" value="Entrar" type="button" onclick="entrar()">
                    <p id="redefinirSenha" onclick="getRedefinir()">Esqueci minha senha</p>
                    <div class='btnInicio-padding'><p class='btnInicio' onclick="window.location.href='index.php'">Inicio</p></div>
                    <div class='btnInicio-padding'><p class='btnInicio' onclick="window.location.href='cadastro.php'">Cadastro</p></div>
                </form>
                <div class="loginfo" id='loginfo'>
                    <img src="img/exfoto.png" id="userpic"><br>
                    <progress id='progress' align='left' value="00" max="100"></progress>
                </div>
            </div>
        </div>
    </body>
</html>