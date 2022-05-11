<?php
	require("back.php");
	redirecionar(0);
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Language" content="pt_br">
	<link rel="manifest" href="/manifest.json">
	<meta name="theme-color" content="rgb(138, 160, 255)">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">	
	<link rel="shortcut icon" href="icon.png" type="image/x-icon"/>
	<link href="css/msg.css" rel="stylesheet"/>
	<link href="css/inicio.css" rel="stylesheet"/>
	<script src="js/msg.js"></script>
	<title>Dream Team</title>
</head>
<body>
	<?php 
		if(isset($_REQUEST["msg"]) == true){
			require("componentes/msg.php");
			$mensagem = new Mensagem();
			if($_REQUEST["msg"] == 1){
				echo $mensagem->delete();
			}
			if($_REQUEST["msg"] == 2){
				echo $mensagem->sessaoEncerrada();
			}
		} 
	?>
	<img alt="três nuvens nas cores brancas, cinza e cinza escuras" src="img/n-esq-bot.png" class="nesq">
	<img alt="nuvem cinza escura" src="img/n-dir-top.png" class="ndir">
	<div class="site" align="center">
		<p class="dt" lang='pt_BR'>DREAM TEAM</p>
		<div class='logo-holder'><img alt="logo do dream team, a cabeça de um dragão com nuvens atrás do mesmo." src="img/logo.png" class="logo"></div>
		<div class="play-hold" align="center">
			<a href="login.php"><button class="play"></button></a>
		</div>
		<div class="log-hold">
			<p onclick="window.location.href='cadastro.php'" class="log">Ou <br> cadastre-se!</p>
		</div>
		<div class='holder-dado'>
                    <a href='https://forum.dtoficial.com?saiba=1'><p class='dado'>Saiba mais</p></a>
                </div>
	</div>
	<video autoplay loop class="bgvideo"  muted>
		<source src="video/bg.mp4" type="video/mp4">
		<source id="vid" type="video/webm">	
	</video>
</body>
</html>