<?php
    require('back.php');
    redirecionar(1);

    if(isset($_REQUEST["apelido"]) == true){
        $apelido = $_REQUEST["apelido"];
        $codigo = getDadosApelido("$apelido");
        if($codigo == null){
            header("location: perfil.php");
        }
        else{
            $user = new Usuario($codigo);
        }
    }
    else{
        $user = new Usuario(codigoSessao(1));

        if($user->verificarCadastro() == "Incompleto"){
            header("Location: concluirCadastro.php");
        }
    }
    
    $custom = new ligaCustomizada();
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
        <link href="css/perfil.css" rel="stylesheet"/>
        <link href="css/optbar.css" rel="stylesheet"/>
        <link href="css/msg.css" rel="stylesheet"/>
        <script src="js/universal.js"></script>
        <script src="js/perfil.js"></script>
        <script src="js/msg.js"></script>
        <title>Dream Team - Perfil</title>
    </head>
    <body>
        <div class="pag" align="center" oncopy="return false" oncut="return false" onpaste="return false">
            <img alt="ícone usado para abrir a barra de navegação" src="img/menu-white.png" class="navicon" id="opbar" onclick="optbaron()">
            <?php 
                require('componentes/nav-bar.php');
                require("componentes/msg.php");
                echo 
                    "<script>
                        document.getElementById('perfil-opt').setAttribute('class','baropt-select');
                    </script>"
                ;
            ?>
            <div id="banner" align="center">
                <img alt="três nuvens nas cores brancas, cinza e cinza escuras" src="img/n-esq-bot.webp" id="nesq">
                <img alt="nuvem cinza escura" src="img/n-dir-top.webp" id="ndir">
                <?php
                    if(isset($user->icone) == true){
                        echo "<img alt='icone escolhido pelo usuário para representá-lo' src='".$user->icone."' id='user-icone'>";
                    }
                    else{
                        echo "<img alt='icone escolhido pelo usuário para representá-lo' src='img/exfoto.png' id='user-icone'>";
                    }   

                    if(isset($apelido) == false){
                        ?><img alt="botão usado para abrir o painel de seleção de ícones" src="img/refresh.png" onclick='abrirIcone()' id="refresh"><?php
                    } ?>
                <p id="user-nome"><?php echo $user->apelido; ?></p>
            </div>
            <div style='height: 0.4vh; background: white; width: 100%;'></div>
            <img src='img/pointer.png' id='pointer'>
            <div class="hold-perfil">
                <div style='margin-top: -10vh;'>
                    <input type="text" id="searchApelido" placeholder="Apelido" maxlength="8" onkeyup="apelido(this)" onkeypress="setSearch()">
                    <input type='text' id='searchGo' onclick='search()'>
                    <?php 
                        if(isset($apelido) == true){
                            echo "<p id='voltar' onclick='voltar()'>Voltar</p>";
                        }
                    ?>
                </div>
                <p style="font-size: 7vh; margin-top: 6vh;">VISÃO GERAL:</p>
                <div class='padding-info'>
                    <div class='holder-info'>
                        <p class='nome-info'>Dragonitas:</p>
                        <img alt='representação da liga mais pontuada, sendo um grupo de usuários em chamas.' src='img/coin.webp'>
                        <p class='nome-info'><?php echo $user->dragonitas."dg"; ?></p>
                    </div>
                </div>
                <div class='padding-info'>
                    <div class='holder-info'>
                        <p class='nome-info'>Patrocinada:</p>
                        <div class='pontos'>
                            <p style='padding-top: 8.5vh; font-size: 4vh;'>
                                <?php
                                    if(isset($user->pontosPatrocinada) == true){
                                        echo $user->pontosPatrocinada."pts";
                                    }
                                    else{
                                        echo "Não escolhida.";
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <p style="font-size: 7vh; margin-top: 6vh">LIGAS CUSTOMIZADAS:</p>
                <?php
                    if(isset($apelido) == true){
                        $custom->getLigasPrivadas($user->codigo);
                    }
                    else{
                        $custom->getLigas();
                    }
                ?>
                <p style="font-size: 7vh; margin-top: 6vh">LIGAS PATROCINADAS:</p>
                <?php 
                    $patrocinada = new ligaPatrocinada();
                    if($patrocinada->getCodigoLiga($user->codigo) != null){
                        $patrocinada->getDadosLiga($patrocinada->getCodigoLiga($user->codigo));
                        echo "<p class='nome-liga' onclick='abrirRanking(this)' id='$patrocinada->codigo'>$patrocinada->nome</p>";
                    }
                    else{
                        echo "<p style='font-size: 4.5vh; color: black; margin-top: 4vh; padding: 1vh; border-radius: 5vh; background: #eee; width: 90%; max-width: 50vh;'>Não escolhida.</p>";
                    }
                ?>
            </div>
            <?php
                if(isset($apelido) == false){
                    ?><div id='icone-holder'>
                        <div id='icone-pan'>
                            <p style='font-size: 4.5vh; padding: 1vh 0vh 1vh 0vh;'>Escolha um ícone:</p>
                            <div id='icone-list'>
                                <input type='text' id='cd-icone' style='display:none;'>
                                <?php
                                    $icone = new Icone();
                                    $icone->getIconesObtidos();
                                ?>
                            </div>
                            <div class='holder-button'>
                                <input type='button' id='dado-ok' value='OK' onclick="fecharIcone()">
                            </div>
                        </div>
                    </div><?php
                } ?>
            <div class="dados-pan" id="dados-pan" align="center">
                <div class="dados" id="dados">
                    <div style='border-bottom: 0.5vh solid black; font-size: 4vh;'>
                        <p style='padding-bottom: 0.5vh;' id='titulo-painel'>&nbsp;</p>
                    </div>
                    <div id='content'>
                    </div>
                    <div class='holder-button'>
                        <input type='button' id='dado-voltar' value='Voltar'>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>