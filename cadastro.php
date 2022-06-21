<?php
    date_default_timezone_set("Brazil/East");
    $datamax = (date('Y') - 10)."-".date("m")."-".date("d");
    $datamin = (date('Y') - 80)."-".date("m")."-".date("d");
    require('back.php');
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
        <link rel="shortcut icon" href="icon.png" type="image/x-icon" />
        <link href="css/cadastro.css" rel="stylesheet"/>
        <link href="css/msg.css" rel="stylesheet"/>
        <script src="js/cadastro.js"></script>
        <script src="js/msg.js"></script>
        <script src="js/universal.js"></script>
        <title>Dream Team - Cadastro</title>
    </head>
    <body>
        <div align="center">          
            <?php
                require('componentes/msg.php');
            ?>
            <div class="site" align="center" oncopy="return false" oncut="return false" onpaste="return false">
                <h1 id='tituloLogin'>Cadastre a sua conta</h1>
                <form style="margin-top: -6vh;" onsubmit="return send()"  method="POST" enctype="multipart/form-data" action="back.php?request=cadastrarUsuario();">
                    <input type='text' id='cpfUsuario' style='display: none;' name='cpfUsuario'>
                    <a class="error" id="errorname" style='margin-top: 10vh;'></a>
                    <input autocomplete="off" class="dados" pattern="[a-zA-z\s]+$" onkeyup="validName(this), letra(this)" type="text" required="required" minlength="8" name="nome" placeholder="Nome completo" maxlength="80" id="name" style='margin-top: 14vh;'><br>
                    <a class="error" id="errorcpf2"></a>
                    <input autocomplete="off" class="dados" min="0" required onkeyup="validcpf(), nm(this)" max="99999999999" id='mask-cpf' type="number" placeholder="CPF"><br>
                    <a class="error" id="errormail"></a>
                    <input autocomplete="off" class="dados" onkeyup="validmail(this), chmail(this)" required="required" minlength="6" name="email" maxlength="80" type="email" id="mail" placeholder="E-mail"><br>
                    <a class="error" id="errorpass"></a>
                    <input autocomplete="off" class="dados" style='border: none; border-radius: 1vh 1vh 0vh 0vh;' type="password" onkeyup="validPassword(this), aspas(this)" maxlength="30" minlength="8" placeholder="Senha" name="senha" id="pass" required="required"><br>
                    <input id='mostrarSenha' onclick='mostrar()'><br>
                    <input autocomplete="off" class="dados" placeholder="Data de nasc." type="text" onfocus="(this.type='date')" id="dt" max="<?php echo $datamax; ?>" min="<?php echo $datamin; ?>" name="data" required="required"><br>
                    <p style='font-size: 4.5vh;'><input type='checkbox' id='check-termos'>&nbsp;Li e aceito os <a style='color: rgb(0, 76, 216); cursor: pointer;' onclick='mostrarTermos()'>Termos de Uso</a></p>
                    <p><input class="btn" value="Confirmar" type="submit"></p>
                    <div class='btnInicio-padding'><p class='btnInicio' onclick="window.location.href='index.php'">Inicio</p></div>
                    <div class='btnInicio-padding'><p class='btnInicio' onclick="window.location.href='login.php'">Login</p></div>
                </form>
            </div>
        </div>
    </body>
</html>
