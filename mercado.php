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

    $pontuado = new Jogador();
    $pontuado->getDadosPontuado();

    $jogadorDisponivel = new Jogador();
    $iconeDisponivel = new Icone();
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
        <link href="css/mercado.css" rel="stylesheet"/>
        <link href="css/optbar.css" rel="stylesheet"/>
        <link href="css/msg.css" rel="stylesheet"/>
        <script src="js/mercado.js"></script>
        <script src="js/universal.js"></script>
        <script src="js/msg.js"></script>
        <title>Dream Team - Mercado</title>
    </head>
    <body onscroll="exibirVoltar()">
        <div class="pag" align="center" oncopy="return false" oncut="return false" onpaste="return false">
            <img alt="ícone usado para abrir a barra de navegação" src="img/menu-white.png" class="navicon" id="opbar" onclick="optbaron()">
            <?php 
                require('componentes/nav-bar.php');
                require("componentes/msg.php");
                echo 
                    "<script>
                        document.getElementById('mercado-opt').setAttribute('class','baropt-select');
                    </script>";
                if($locker == 1){
                    echo 
                        "<div id='locked'>
                            <img src='img/locked.png' id='locked-img'>
                            <p id='locked-msg'>O mercado permanece fechado enquanto em jogo.<br>Volte novamente depois do jogo.</p>
                        </div>"
                    ;
                }
            ?>
            <div id="allinfo">
                <div id="banmer">
                    <img alt="três nuvens nas cores brancas, cinza e cinza escuras" src="img/n-esq-bot.webp" class="nesq">
                    <img alt="nuvem cinza escura" src="img/n-dir-top.webp" class="ndir">
                    <p id='bem-vindo'>Bem vindo ao mercado, <?php echo $user->apelido; ?>!</p>
                    <div class="pad-info">
                        <div class="hold-info">
                            <div id='setaEsquerda' onclick="moverEsquerda()"></div>
                            <div id='setaDireita' onclick="moverDireita()"></div>
                            <div class='info' id='infoSaldo' style='opacity: 1; display: block;'>
                                <p style='font-size: 4vh; margin-top: 2vh;'>Saldo:</p>
                                <img alt="representação de uma dragonita, moeda do dream team." src="img/coin.webp" id="coin">
                                <p style='font-size: 4vh; margin-top: 2vh;'><?php echo $user->dragonitas."dg"; ?></p>
                            </div>
                            <div class='info' id='infoJogador'>
                                <p style='font-size: 4vh; margin-top: 2vh;'>Jogador destaque:</p>
                                <img alt="representação do jogador destaque" src="<?php echo $pontuado->imagem; ?>" id="destaque-foto">
                                <p style='font-size: 4vh; margin-top: 1vh;'><?php echo $pontuado->nome; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="hold-pos">
                    <a href='#banmer'><div id='voltar'>^</div></a>
                    <div id='categorias-select'>
                        <div class='options-holder'><a href='#alas'><p class='categorias-options'>Alas</p></a></div>
                        <div class='options-holder'><a href='#armadores'><p class='categorias-options'>Armadores</p></a></div>
                        <div class='options-holder'><a href='#pivos'><p class='categorias-options'>Pivôs</p></a></div>
                        <div class='options-holder'><a href='#icones'><p class='categorias-options'>Ícones</p></a></div>
                    </div>
                    <p class='titulo-categoria' id='alas'>Alas</p>
                    <img src='img/pointer.png' id='pointer'>
                    <div class='categorias' id='1'>
                        <?php
                            $jogadorDisponivel->getJogadorDisponivel("'Ala/Armador' or tb_jogador.nm_posicao = 'Ala/Pivô' or tb_jogador.nm_posicao = 'Ala')", $partida, $user->codigo, $user->dragonitas);
                        ?>
                        <p class='titulo-categoria' id='armadores'>Armadores</p>
                        <img src='img/pointer.png' id='pointer'>
                    </div>
                    <div class='categorias' id='2'>
                        <?php 
                            $jogadorDisponivel->getJogadorDisponivel("'Ala/Armador' or tb_jogador.nm_posicao = 'Armador')", $partida, $user->codigo, $user->dragonitas); 
                        ?>
                        <p class='titulo-categoria' id='pivos'>Pivôs</p>
                        <img src='img/pointer.png' id='pointer'>
                    </div>
                    <div class='categorias' id='3'>
                        <?php
                            $jogadorDisponivel->getJogadorDisponivel("'Ala/Pivô' or tb_jogador.nm_posicao = 'Pivô')", $partida, $user->codigo, $user->dragonitas);
                        ?>
                        <p class='titulo-categoria' id='icones'>Ícones</p>
                        <img src='img/pointer.png' id='pointer'>
                    </div>
                    <div class='categorias' id='4'>
                        <?php $iconeDisponivel->getIconeDisponivel($user->codigo, $user->dragonitas); ?>
                    </div>
                </div>
            </div>
            <div class="dados-pan" id="dados-pan" align="center">
                <div class="dados" id="dados">
                    <div style='border-bottom: 0.5vh solid black; font-size: 4vh;'>
                        <p style='padding-bottom: 0.5vh;' id='nome-jogador'>&nbsp;</p>
                    </div>
                    <div id='content'>
                        <div class='holder-dado'>
                            <p class='nome-dado'>Pontos:</p>
                            <p class='dado' id='pontos'>&nbsp;</p>
                        </div>
                        <div class='holder-dado'>
                            <p class='nome-dado'>Rebotes:</p>
                            <p class='dado' id='rebotes'>&nbsp;</p>
                        </div>
                        <div class='holder-dado'>
                            <p class='nome-dado'>Arremessos errados:</p>
                            <p class='dado' id='arremessos'>&nbsp;</p>
                        </div>
                        <div class='holder-dado'>
                            <p class='nome-dado'>Assistências:</p>
                            <p class='dado' id='assistencias'>&nbsp;</p>
                        </div>
                        <div class='holder-dado'>
                            <p class='nome-dado'>Turnovers:</p>
                            <p class='dado' id='turnovers'>&nbsp;</p>
                        </div>
                        <div class='holder-dado'>
                            <p class='nome-dado'>Bolas recuperadas:</p>
                            <p class='dado' id='recuperadas'>&nbsp;</p>
                        </div>
                        <div class='holder-dado'>
                            <p class='nome-dado'>Tocos:</p>
                            <p class='dado' id='tocos'>&nbsp;</p>
                        </div><br>
                        <div class='holder-dado'>
                            <p class='nome-dado'>time:</p>
                            <p class='dado'><a id='time-nome'></a><br><img src='img/exfoto.png' id='time-logo'></p>
                        </div>
                    </div>
                    <div class='holder-dado'>
                        <input type='button' id='dado-ok' value='OK' onclick='fecharEstatisticas()'>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>