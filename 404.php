<?php
    require("back.php");
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
        <title>Dream Team - 404</title>
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
	</style>
        <div class='site' align="center" style='height: 100vh; padding: 0vh; overflow: hidden;'>
            <p style='font-size: 10vh; color: white; position: absolute; width: 100%; text-align: center; padding-top: 20vh; z-index: 10;'>
                ERROR 404: NOT FOUND<br>
                <a href='index.php' style='text-decoration: none; font-size: 7vh; background: white; padding: 1.5vh 4vh 1vh 4vh; border-radius: 20vh; color: black; '>INICIO</a>
            </p>
            <img alt="tr??s nuvens nas cores brancas, cinza e cinza escuras" src="img/n-esq-bot.webp" class="nesq">
            <img alt="nuvem cinza escura" src="img/n-dir-top.webp" class="ndir">
            <img src='img/cesta.png' style='position: relative; z-index: 6; margin-top: 50vh; height: 50vh;'>
        </div>
    </body>
</html>