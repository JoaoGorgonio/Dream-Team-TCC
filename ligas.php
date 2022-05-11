<?php
    require('back.php');
    redirecionar(1);
    $user = new Usuario(codigoSessao(1));

    if($user->verificarCadastro() == "Incompleto"){
        header("Location: concluirCadastro.php");
    }

    $patrocinada = new LigaPatrocinada();
    $codigoPatrocinada = $patrocinada->getCodigoLiga($user->codigo);
    $pontuada = $patrocinada->getDadosPontuada();

    $customizada = new LigaCustomizada();
    $customizada->getDadosPontuada();
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
        <link href="css/ligas.css" rel="stylesheet"/>
        <link href="css/optbar.css" rel="stylesheet"/>
        <link href="css/msg.css" rel="stylesheet"/>
        <script src="js/ligas.js"></script>
        <script src="js/msg.js"></script>
        <script src="js/universal.js"></script>
        <title>Dream Team - Ligas</title>
    </head>
    <body>
        <div class="pag" align="center" oncopy="return false" oncut="return false" onpaste="return false">
            <img alt="ícone usado para abrir a barra de navegação" src="img/menu-white.png" class="navicon" id="opbar" onclick="optbaron()">
            <?php 
                require('componentes/msg.php');
                require('componentes/nav-bar.php'); 
                echo 
                    "<script>
                        document.getElementById('ligas-opt').setAttribute('class','baropt-select');
                    </script>"
                ;
            ?>
            <img alt="três nuvens nas cores brancas, cinza e cinza escuras" src="img/n-esq-bot.webp" class="nesq">
            <img alt="nuvem cinza escura" src="img/n-dir-top.webp" class="ndir">
            <div class='pag-content' style='padding-top: 6vh;'>
                <p class='titulo-categoria'>Ligas customizadas</p>
                <img src='img/pointer.png' id='pointer'>
                <div style='margin-top: -10vh'>
                    <div class='padding-info'>
                        <div class='holder-info'>
                            <p class='nome-info'>Liga mais pontuada:</p>
                            <img alt='representação da liga mais pontuada, sendo um grupo de usuários em chamas.' src='img/liga-pontuada.png'>
                            <p class='nome-info'><?php if(isset($customizada->nome) == true){echo $customizada->nome;}else{echo "Sem ligas cadastradas.";}?></p>
                        </div>
                    </div><br>
                    <div class='acao-padding'><p class='acao-azul' onclick='abrirLigasDisponiveis()'>Entrar</p></div>
                    <div class='acao-padding'><p class='acao-azul' onclick='abrirRankingLigas()'>Ranking de ligas</p></div>
                    <div class='acao-padding'><p class='acao-azul' onclick='abrirSuasLigas()'>Ranking de usuários</p></div><br>
                    <div class='acao-padding'><p class='acao-verde' onclick='abrirCriar()'>Criar</p></div>
                </div>
            </div>
            <div class='pag-content' style='padding-bottom: 6vh;'>
                <p class='titulo-categoria'>Ligas patrocinadas</p>
                <img src='img/pointer.png' id='pointer'>
                <div style='margin-top: -10vh'>
                    <div class='padding-info'>
                        <div class='holder-info'>
                            <p class='nome-info'>Liga mais pontuada:</p>
                            <img alt='representação da liga mais pontuada, sendo um grupo de usuários em chamas.' src='img/liga-pontuada.png'>
                            <p class='nome-info'><?php echo $patrocinada->nome; ?></p>
                        </div>
                    </div><br>
                    <div class='acao-padding'><p class='acao-azul' id="<?php echo $codigoPatrocinada; ?>" onclick='abrirRanking(this)'>Ver ranking</p></div>
                </div>
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