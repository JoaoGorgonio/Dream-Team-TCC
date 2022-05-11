<?php
    require('back.php');
    redirecionar(1);
    $user = new Usuario(codigoSessao(1));

    if($user->verificarCadastro() == "Incompleto"){
        header("Location: concluirCadastro.php");
    }

    $semana = new Semana();
    if ($semana->codigoAtual != null){
        $locker = 1;
    }else{
        $locker = 0;
        if($semana->codigoProxima != null){
            $partida = $semana->codigoProxima;
        }
        else{
            $partida = "1911";
        }
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
        <meta name="description" content="Escalação de time do fantasy game Dream Team">
        <link rel="shortcut icon" href="icon.png" type="image/x-icon" />
        <link href="css/meutime.css" rel="stylesheet"/>
        <link href="css/optbar.css" rel="stylesheet"/>
        <link href="css/msg.css" rel="stylesheet"/>
        <script src="js/universal.js"></script>
        <script src="js/meutime.js"></script>
        <script src="js/msg.js"></script>
        <title>Dream Team - Meu Time</title>
    </head>
    <body>
        <div class="pag" align="center" oncopy="return false" oncut="return false" onpaste="return false">
            <img alt="ícone usado para abrir a barra de navegação" src="img/menu-white.png" class="navicon" id="opbar" onclick="optbaron()">
            <?php 
                require('componentes/nav-bar.php');
                require("componentes/msg.php");
                echo 
                    "<script>
                        document.getElementById('time-opt').setAttribute('class','baropt-select');
                    </script>"
                ;
            ?>
            <div class="hold-time">
            <img alt="três nuvens nas cores brancas, cinza e cinza escuras" src="img/n-esq-bot.webp" class="nesq">
            <img alt="nuvem cinza escura" src="img/n-dir-top.webp" class="ndir">
                <?php
                    $user->getTimeUsuario($user->codigo);
                ?>
            </div>
        </div>
    </body>
</html>