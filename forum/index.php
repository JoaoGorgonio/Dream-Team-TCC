<?php
    require('back.php');
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
        <link href="css/forum.css" rel="stylesheet"/>
        <script src="js/forum.js"></script>
        <title>Fórum Dream Team</title>
    </head>
    <body>
        <div align="center">
            <div class="site" align="center">
                <img alt="três nuvens nas cores brancas, cinza e cinza escuras" src="img/n-esq-bot.webp" class="nesq">
                <img alt="nuvem cinza escura" src="img/n-dir-top.webp" class="ndir">
                <img alt="logo do dream team, a cabeça de um dragão com nuvens atrás do mesmo." src="img/logo.png" class="logo">
                <div id='holder'>
                    <div id='categorias-select'>
                        <div class='options-holder'><p class='categorias-options' style='background: white; color: black;' onclick='categoria(1)' id='noti'>Notícias</p></div>
                        <div class='options-holder'><p class='categorias-options' onclick='categoria(2)' id='att'>Atualizações</p></div>
                    </div>
                    <div class ='content-category'>
                    	<div class='holder-post' style='background: #ffee72; border-color: #d1c470;'>
                    	    <p class='nome-post'><img src='img/pin.png' style='height: 3vh; width: 3vh;'>&nbsp;Início do jogo</p>
                    	    <p class='ds-post'>A partir do dia 18/06/2019 o Dream Team estará disponível para que todos joguem podendo, dentre muitas possibilidades, escalar seu próprio time com jogadores reais e criar suas ligas!</p>
                    	    <p class='data-post'>postado em 02/06/2019, fixado.</p>
                	</div>
                   </div>
                   <div id="noticias" class="content-category">
                        <?php
                            $news = new Noticia;
                            $news->getNoticias();
                        ?>
                    </div>
                    <div id="updates" style="display: none; opacity: 0;" class="content-category">
                        <?php
                            $news = new Update;
                            $news->getUpdates();
                        ?>
                    </div>
                </div>
                <div class="dados-pan" id="dados-pan" align="center">
                <div class="dados" id="dados">
                    <div style='border-bottom: 0.5vh solid black; font-size: 4vh;'>
                        <p style='padding-bottom: 0.5vh;' id='titulo-post'>&nbsp;</p>
                    </div>
                    <div id='content'>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>