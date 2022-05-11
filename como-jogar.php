<?php
    require('back.php');
    redirecionar(1);
    $user = new Usuario(codigoSessao(1));

    if($user->verificarCadastro() == "Incompleto"){
        header("Location: concluirCadastro.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Language" content="pt_BR">
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="rgb(138, 160, 255)">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">	
        <link rel="shortcut icon" href="icon.png" type="image/x-icon" />
        <link href="css/como-jogar.css" rel="stylesheet"/>
        <link href="css/optbar.css" rel="stylesheet"/>
        <link href="css/msg.css" rel="stylesheet"/>
        <script src="js/como-jogar.js"></script>
        <script src="js/msg.js"></script>
        <script src="js/universal.js"></script>
        <title>Dream Team - Conclusão de cadastro</title>
    </head>
    <body>
        <div align="center">
            <img alt="ícone usado para abrir a barra de navegação" src="img/menu-white.png" class="navicon" id="opbar" onclick="optbaron()">
            <?php 
                require('componentes/msg.php');
                require('componentes/nav-bar.php');
                echo 
                    "<script>
                        document.getElementById('como-jogar-opt').setAttribute('class','baropt-select');
                    </script>"
                ;
            ?>
            <div class="site" align="center">
                <img alt="três nuvens nas cores brancas, cinza e cinza escuras" src="img/n-esq-bot.webp" class="nesq">
                <img alt="nuvem cinza escura" src="img/n-dir-top.webp" class="ndir">
                <progress id='progressBar' align='left' value="00" max="100"></progress>
                <div id='inicio' class='passos'>
                    <p class="titulo">É novo por aqui?<br>Fique tranquilo, nós te ajudaremos!</p>
                    <div class='paddingBtn'><input class="btn" value="Começar" type="button" onclick="continuar(1)"></div>
                </div>
                <div id='passo1' class='passos' style='display: none;'>
                    <p class="tituloPagina">Mercado</p><br>
                    <div class="content">
                        <p class="descPagina">Essa é a principal aba na qual se pode realizar as mais diversas compras utilizando suas dragonitas (moeda virtual do aplicativo) em conta, podendo comprar os jogadores para o “Meu Time” e até mesmo ícones para dar um toque de estilo no seu perfil.</p>
                        <p class="descPagina">Cada jogador possui um preço diferente com base em sua eficiência ((pontos  + rebotes + tocos + bolas recuperadas + assistências) – (arremessos errados + turnovers)), dependendo do quanto o jogador foi eficiente na partida real. Isso também vale para os ícones, que são divididos em categorias. Do menor ao maior: comum, raro, épico e lendário. Quanto maior a raridade, maior será o preço do ícone e a ostentação.</p>
                        <p class="descPagina">Ressaltando que o Mercado estará fechado durante a rodada em andamento, ficando apenas aberto entre as rodadas.</p>
                    </div>
                    <div class='paddingBtn'><input class="btn" value="Próximo" type="button" onclick="continuar(2)"></div>
                </div>
                <div id='passo2' class='passos' style='display: none;'>
                    <p class="tituloPagina">Meu Time</p><br>
                    <div class="content">
                        <p class="descPagina">Nesta aba, você poderá ver o time que escalou com base nas compras feitas do Mercado. Durante os intervalos de rodadas, será possível mudar o time, bem como até mesmo reembolsar jogadores.</p>
                        <p class="descPagina">Como comentando anteriormente, durante as rodadas ocorrendo, o Mercado estará fechado, ou seja, não será possível editar seu time uma vez que a rodada tenha começado.</p>
                    </div>
                    <div class='paddingBtn'><input class="btn" value="Próximo" type="button" onclick="continuar(3)"></div>
                </div>
                <div id='passo3' class='passos' style='display: none;'>
                    <p class="tituloPagina">Ligas</p><br>
                    <div class="content">
                        <p class="descPagina">Já na aba de Ligas, você poderá ver a liga patrocinada escolhida no momento do cadastro, além de exibir as ligas customizadas que você se encontra, tendo a opção de entrar em mais uma liga customizada ou até mesmo criar uma.</p>
                        <p class="descPagina">Caso opte por criar uma liga customizada, será necessário inserir a quantidade de jogadores máxima que participarão da liga, o número de rodadas e um nome único. Quanto maior a quantidade de jogadores e rodadas, mais caro será o preço da liga, sendo tanto na criação quanto para se juntar a mesma.</p>
                    </div>
                    <div class='paddingBtn'><input class="btn" value="Próximo" type="button" onclick="continuar(4)"></div>
                </div>
                <div id='passo4' class='passos' style='display: none;'>
                    <p class="titulo">O nosso tutorial chegou ao fim!<br>Declaramos você formado.</p>
                    <div class='paddingBtn'><input class="btn" value="Jogar" type="button" onclick="window.location.href = 'mercado.php'"></div>
                </div>
            </div>
        </div>
    </body>
</html>