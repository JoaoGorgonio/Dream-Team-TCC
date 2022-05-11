<?php
    require('back.php');
    redirecionar(1);
    $user = new Usuario(codigoSessao(1));

    if($user->verificarCadastro() == "Incompleto"){
        header("Location: concluirCadastro.php");
    }
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
        <link href="css/preferencias.css" rel="stylesheet"/>
        <link href="css/optbar.css" rel="stylesheet"/>
        <link href="css/msg.css" rel="stylesheet"/>
        <script src="js/preferencias.js"></script>
        <script src="js/msg.js"></script>
        <script src="js/universal.js"></script>
        <title>Dream Team - Configurações</title>
    </head>
    <body>
        <div class="pag" align="center" oncopy="return false" oncut="return false" onpaste="return false">
            <img alt="ícone usado para abrir a barra de navegação" src="img/menu-white.png" class="navicon" id="opbar" onclick="optbaron()">
            <?php 
                require('componentes/nav-bar.php');
                require("componentes/msg.php");
                if(isset($_REQUEST['msg']) == true){
                    $msg = new Mensagem();
                    if($_REQUEST['msg'] == 1){
                        echo $msg->acaoExpirada();
                    }
                    else{
                        if($_REQUEST['msg'] == 2){
                            echo $msg->linkEnviado();
                        }
                        else{
                            echo $msg->acaoConcluida();
                        }
                    }   
                }
                echo 
                    "<script>
                        document.getElementById('preferencias-opt').setAttribute('class','baropt-select');
                    </script>"
                ;
            ?>
            <img src="img/settings.png" class="settings">
            <p class="nome-info"><?php echo $user->email; ?></p>
            <?php 
                if($user->dragonitas >= 1300){
                    echo "<p class='nome-acao' onclick='abrirApelido()'>Alterar apelido - 1300dg</p>";
                }
                else{
                    echo "<p class='nome-acao' style='background: rgb(170, 0, 0); border-color: rgb(170, 0, 0); color: white; cursor: default;'>Alterar apelido - ".(1300 - $user->dragonitas)."dg restantes</p>";
                }
            ?>
            <p class="nome-acao" onclick='abrirSenha()'>Alterar senha</p>
            <p class="nome-acao-red" onclick='confirmarDeletar()'>Deletar conta</p>
        </div>
    </body>
</html>