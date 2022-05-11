<?php
    require('back.php');
    redirecionar(1);
    $user = new Usuario(codigoSessao(1));
    if($user->apelido != null && isset($user->liga) == true && isset($user->icone) == true){
        header("location: mercado");
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
        <link href="css/msg.css" rel="stylesheet"/>
        <script src="js/concluirCadastro.js"></script>
        <script src="js/msg.js"></script>
        <script src="js/universal.js"></script>
        <title>Dream Team - Conclusão de cadastro</title>
    </head>
    <body>
    	<style>
    	*{
	    margin: 0;
	    padding: 0;
	    font-family: supreme;
	}
	body{
	    max-width: 100vw;
	    min-height: 100vh;
		margin: 0px;
		background: url(../img/wallpaperdesk.jpg);
	    background-size: cover;
	    background-attachment: fixed;
	}
	@font-face{
		font-family: supreme;
		src: url('../fonts/supreme.ttf');
	}
	.site{
	    padding-top: 4vh;
	    background-color: #222;
	    min-height: 96vh;
	    background-image: url('../img/basquete-wpp.png');
	    background-size: 70vh;
	    background-position: center;
	    background-attachment: fixed;
	}
	.dados{
	    min-width: 32vh;
	    width: 30%;
	    text-align: center;
	    font-size: 6vh;
	    color: #000;
	    background: #fff;
	    border-radius: 1vh;
	    border: none;
	    border-bottom: 0.5vh rgb(28, 115, 230) solid;
	    transition: 0.2s;
	    padding: 0.5vh 0vh 0.5vh 0vh;
	    box-shadow: 0 0 1vh 0.1vh rgba(0, 0, 0, 0.192);
	}
	.dados:focus{
	    background: rgb(219, 231, 255);
	}
	input:focus{
	    outline: none;
	}
	#tituloBemVindo{
	    color: white;
	    font-size: 6vh;
	    padding: 25vh 2vh 0vh 2vh;
	    transition: 1s;
	}
	#tituloPasso1{
	    color: white;
	    font-size: 6vh;
	    padding: 15vh 2vh 0vh 2vh;
	    transition: 1s;
	}
	#tituloPasso2{
	    color: white;
	    font-size: 6vh;
	    padding: 12.5vh 2vh 0vh 2vh;
	    transition: 1s;
	}
	#tituloPasso3{
	    color: white;
	    font-size: 6vh;
	    padding: 5vh 2vh 0vh 2vh;
	    transition: 1s;
	}
	#tituloPasso4{
	    color: white;
	    font-size: 6vh;
	    padding: 10vh 2vh 0vh 2vh;
	    transition: 1s;
	}
	#userpic{
	    margin-top: 4vh;
	    width: 14vw;
	    height: 14vw;
	    min-width: 26vh;
	    min-height: 26vh;
	    border: 1.5vh rgb(28, 115, 230) double;
	    border-radius: 50%;
	}
	#progressBar[value]{
	    -webkit-appearance: none;
	    position: relative;
	    z-index: 6;
	    appearance: none;
	    height: 4vh;
	    width: 90%;
	    min-width: 30vh;
	    display: block;
	    opacity: 0;
	    transition: 1s;
	    margin-top: 0vh;
	}
	#progressBar[value]::-webkit-progress-value{
	    background: linear-gradient(to right, rgb(0, 57, 133) 60%, rgb(42, 134, 255));
	    -webkit-background-clip: background;
	    border-radius: 1vh;
	    transition: 1s;
	}
	#progressBar[value]::-webkit-progress-bar{
	    background-color: transparent;
	    border-radius: 0.5vh;
	}
	.btn{
	    color: rgb(28, 115, 230);
	    width: 20%;
	    min-width: 32vh;
	    font-family: supreme;
	    font-size: 5vh;
	    border: 0.5vh solid rgb(28, 115, 230);
	    height: 8vh;
	    border-radius: 1vh;
	    text-align: center;
	    padding-left: 1%;
	    padding-right: 1%;
	    cursor: pointer;
	    background: #222;
	    transition: 0.4s;
	}
	.btn:hover{
	    color: white;
	    background:rgb(28, 115, 230);
	}
	.paddingBtn{
	    padding: 4vh;
	}
	.passos{
	    position: relative;
	    z-index: 6;
	    opacity: 0;
	    transition: 0.5s;
	    display: none;
	}
	.nesq{
	    position: fixed;
	    z-index: 5;
		bottom: 0vh;
		left: 0vh;
	    width: 20%;
	    min-width: 20vh;
	}
	.ndir{
		position: fixed;
	    z-index: 5;
	    top: 0;
		right: 0;
	    width: 18%;
	    min-width: 18vh;
	}
	#icone-pan{
	    margin-top: 4vh;
	    min-width: 36vh;
	    width: 50%;
	    border-radius: 2vh;
	    background: white;
	    min-height: 40vh;
	    transition: 0.2s;
	    opacity: 1;
	}
	#icone-list{
	    background-color: #eee;
	    border-radius: 2vh;
	    padding: 2vh 0vh 2vh 0vh;
	    height: 40vh;
	    overflow-y: scroll;
	}
	#icone-list::-webkit-scrollbar-track {
	    background-color: transparent;
	}
	#icone-list::-webkit-scrollbar {
	    width: 1vh;
	    background: transparent;
	}
	#select-concluir{
	    min-width: 28vh;
	    margin-top: 4vh;
	    width: 30%;
	    text-align: center;
	    font-size: 6vh;
	    color: #000;
	    border-radius: 1vh;
	    border: none;
	    border-bottom: 0.5vh rgb(28, 115, 230) solid;
	    transition: 0.2s;
	    display: block;
	    -webkit-appearance: none;
	    padding: 0.5vh 0vh 0.5vh 2vh;
	    background: url("../img/down-arrow.png");
	    background-repeat: no-repeat;
	    background-position: 95% 50%;
	    background-size: 6vh;
	    background-color: #fff;
	    cursor: pointer;
	}
	.icone{
	    width: 16vh;
	    height: 16vh;
	    border: 0.5vh rgb(28, 115, 230) solid;
	    border-radius: 50%;
	    display: inline-block;
	    cursor: pointer;
	}
	#icone-done{
	    width: 16vh;
	    height: 6vh;
	    margin-top: 2vh;
	    font-size: 4vh;
	    background: white;
	    border-radius: 2vh;
	    color: rgb(0, 100, 231);
	    border: none;
	    box-shadow: 0 0 1vh 0.1vh rgba(2, 2, 2, 0.4);
	    cursor: pointer;
	}
	.error-concluir{
	    color: red;
	    font-size: 3.5vh;
	    text-align: center;
	    margin-top: 3vh;
	}
	</style>
        <?php
            require("componentes/msg.php");
        ?>
        <div align="center">
            <div class="site" align="center" oncopy="return false" oncut="return false" onpaste="return false">
                    <img alt="três nuvens nas cores brancas, cinza e cinza escuras" src="img/n-esq-bot.webp" class="nesq">
                    <img alt="nuvem cinza escura" src="img/n-dir-top.webp" class="ndir">
                <progress id='progressBar' align='left' value="00" max="100"></progress>
                <div id='inicio' class='passos'>
                    <p id="tituloBemVindo">Bem-vindo ao jogo!<br>Vamos concluir seu cadastro para que possa jogar.</p>
                    <div class='paddingBtn'><input class="btn" value="Começar" type="button" onclick="continuar(1)"></div>
                </div>
                <div id='passo1' class='passos' style='display: none;'>
                    <p id="tituloPasso1">Vamos começar:<br>Como você gostaria de ser chamado(a)?</p>
                    <p class='error-concluir' id='error-apelido'>&nbsp;</p>
                    <input class="dados" onkeyup="verificarApelido(), apelido(this)" maxlength='8' type="text" id="apelido" placeholder="Apelido"><br>
                    <div class='paddingBtn'><input class="btn" value="Próximo" type="button" onclick="setApelido()"></div>
                </div>
                <div id='passo2' class='passos' style='display: none;'>
                    <p id="tituloPasso2">Lute por uma causa!<br>Escolha a liga patrocinada que mais lhe agrada abaixo:</p>
                    <p class='error-concluir' id='error-patrocinio'>&nbsp;</p>
                    <select id="select-concluir" name="patrocinio" id="pat">
                        <option value="">Patrocinio</option>
                        <option value="Liga Caixa">Liga Caixa</option>
                        <option value="Nike Be True">Nike Be True</option>
                        <option value="Voe com a Infraero">Voe com a Infraero</option>
                        <option value="Liga Penalty">Liga Penalty</option>
                        <option value="Liga Guarani">Liga Guarani</option>
                    </select>
                    <div class='paddingBtn'><input class="btn" value="Próximo" type="button" onclick="setLiga()"></div>
                </div>
                <div id='passo3' class='passos' style='display: none'>
                    <p id="tituloPasso3">Escolha seu visual!<br>Os ícones representam seu estilo e gostos.<br>O primeiro é por conta da casa!</p>
                    <div id='icone-pan'>
                        <div id='icone-list'>
                            <input type='text' id='cd-icone' style='display:none;'>
                            <?php
                                $icone = new Icone();
                                $icone->exibirIconeGratuito();
                            ?>
                        </div>
                    </div>
                    <div class='paddingBtn'><input class="btn" value="Próximo" type="button" onclick="setIcone()"></div>
                </div>
                <div id='passo4' class='passos' style='display: none'>
                    <p id="tituloPasso4">Tudo pronto, <a id='apelido-concluir'></a>!<br>Preparado para começar?</p>
                    <img src='img/exfoto.png' id='userpic'>
                    <div class='paddingBtn'><input class="btn" value="Jogar" type="button" onclick="window.location.href='como-jogar.php';"></div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
    if($user->apelido != null){
        echo "<script> continuar(1); continuar(2); </script>";
        if(isset($user->liga) == true){
            echo "<script> continuar(3); </script>";
            if(isset($user->icone) == true){
                echo "<script> continuar(1); continuar(4); </script>";
            }
        }
    }
?>