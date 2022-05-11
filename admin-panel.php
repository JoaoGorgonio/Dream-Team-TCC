<?php
    require('back.php');
    redirecionar(2);
    $admin = new Administrador(codigoSessao(2));
    date_default_timezone_set("Brazil/East");
    $horaCERTA = date('H');

    $semana = new Semana();
    if ($semana->codigoAtual != null){
        $partida = 1911;
    }
    else{
        $partida = "Intervalo";
    }

    $banco = new Banco();
    $qtTimes = $banco->Consultar("select count(cd_compra) from compra group by cd_usuario having count(cd_usuario) = 5;");
    $qtCompras = $banco->Consultar("select count(cd_compra) from compra;");
    $qtCustomizadas = $banco->Consultar("select cd_liga_customizada from tb_liga_customizada;");
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta http-equiv="Content-Language" content="pt_br">
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="rgb(138, 160, 255)">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">	
        <link rel="shortcut icon" href="icon.png" type="image/x-icon" />
        <link href="css/panel.css" rel="stylesheet"/>
        <link href="css/msg.css" rel="stylesheet"/>
        <script src="js/msg.js"></script>
        <script src="js/panel.js"></script>
        <script src="js/universal.js"></script>
        <title>Dream Team - Painel de Administrador</title>
    </head>
    <body>
        <div class="pag" align="center" oncopy="return false" oncut="return false" onpaste="return false">
            <?php 
                require("componentes/msg.php");
                if(isset($_REQUEST['msg']) == true){
                    if($_REQUEST['msg'] == 1){
                        $msg = new Mensagem();
                        echo $msg->respostaEnviada();
                    }
                    else if($_REQUEST['msg'] == 2){
                        $msg = new Mensagem();
                        echo $msg->acaoConcluida();
                    }
                }
            ?>
            <div id="banner">
                <img alt="três nuvens nas cores brancas, cinza e cinza escuras" src="img/n-esq-bot.webp" id="nesq">
                <img alt="nuvem cinza escura" src="img/n-dir-top.webp" id="ndir">
                <img alt='icone escolhido pelo usuário para representá-lo' src='img/ico512.png' id='user-icone'>
                <?php
                $nome = explode(" ", $admin->nome);
                if($horaCERTA < 12 && $horaCERTA > 5){
                    echo "<p class='cumprimento'>Bom dia, ".$nome[0]."!</p>";
                }
                else{
                    if($horaCERTA < 18 && $horaCERTA > 11){
                        echo "<p class='cumprimento'>Boa tarde, ".$nome[0]."!</p>";
                    }
                    else{
                        if($horaCERTA < 6 || $horaCERTA > 17){
                            echo "<p class='cumprimento'>Boa noite, ".$nome[0]."!</p>";
                        }
                    }
                }
            ?>
            </div>
            <div class="opts-navopt">
                <a class="opt-nav" onclick="mudarAba(this,2)" id="opt2">Suporte</a>
                <a class="opt-nav" onclick="mudarAba(this,1)" style='border-bottom: 0.4vh #fff solid;' id="opt1">Visão geral</a>
                <a class="opt-nav" onclick="mudarAba(this,3)" id="opt3">Jogadores</a>
            </div>
            <div class="info-pan" id="pan1">
                <p id='voltar' onclick='confirmarSair()'>Sair</p>
                <p style='Font-size: 5vh; color: #fff; padding-top: 4vh;'>Partida atual:<br>
                <a style='border-bottom: 0.5vh solid rgb(28, 115, 230); padding: 0vh 2vh 0vh 2vh; color: rgb(28, 115, 230);'><?php echo $partida; ?></a></p>
                <p style='font-size: 5vh; color: white; margin-top: 6vh;'>Estatísticas:</p>
                <div class='padding-info'>
                    <div class='holder-info'>
                        <p class='nome-info'>Times escalados:</p>
                        <img src='img/ball.png'>
                        <p class='nome-info'><?php echo count($qtTimes); ?></p>
                    </div>
                </div>
                <div class='padding-info'>
                    <div class='holder-info'>
                        <p class='nome-info'>Compras efetuadas:</p>
                        <img src='img/player.png'>
                        <p class='nome-info'><?php echo $qtCompras[0]; ?></p>
                    </div>
                </div>
                <div class='padding-info'>
                    <div class='holder-info'>
                        <p class='nome-info'>Ligas customizadas:</p>
                        <img src='img/trophy.png'>
                        <p class='nome-info'><?php echo count($qtCustomizadas); ?></p>
                    </div>
                </div>
                <p style='font-size: 5vh; color: white; margin-top: 6vh;'>Ações:</p>
                <div class='padding-info'>
                    <div class='holder-info'>
                    <?php
                        if($qtCompras[0] == 0){
                            echo "<div class='holder-info' style='background: darkred; border-color: red; color: #fff;'>";
                            echo "<p class='nome-info' style='color: white;'>Passar rodada:</p>";
                            echo "<img src='img/lock.png'>";
                            echo "<p class='nome-info' style='color: white;'>Indisponível</p></div>";
                        }
                        else{
                            echo "<div class='holder-info' onclick='confirmarPassar()' style='background: rgb(0, 221, 0); border-color: rgb(114, 255, 114); cursor: pointer;'>";
                            echo "<p class='nome-info'>Passar rodada:</p>";
                            echo "<img src='img/right-arrow.png'>";
                            echo "<p class='nome-info'>Disponível</p></div>";
                        } 
                    ?>
                    </div>
                </div>
            </div>
            <div class="info-pan" id="pan2" style="display: none;">
                <?php
                    $admin->getMensagens();
                ?>
            </div>
            <div class="info-pan" id="pan3" style="display: none;">
                <?php
                    if($partida != "Intervalo"){
                        $jogador = new Jogador();
                        $jogador->getJogadorAtualizar($partida);
                    }
                    else{
                        echo "<p style='font-size: 5vh; color: white; padding-top: 6vh;'>Em intervalo, volte novamente quando a próxima partida começar.</p>";
                    }
                ?>
            </div>
            <div class="dados-pan" id="dados-pan" align="center">
                <div class="dados" id="dados">
                    <div style='border-bottom: 0.5vh solid black; font-size: 4vh;'>
                        <p style='padding-bottom: 0.5vh;' id='titulo-painel'>&nbsp;</p>
                    </div>
                    <div id='content'>
                    </div>
                    <div class='holder-button'>
                        <input type='button' id='dado-ok' value='Voltar'>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>