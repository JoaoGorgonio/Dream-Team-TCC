<?php
    require("PHPMailer.php");
    require("SMTP.php");
    
    echo "<body style='display: none;'>";

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP();

    $mail->SMTPDebug = 1;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->IsHTML(true);
    $mail->Username = "equipedtoficial@gmail.com";
    $mail->Password = "equipe5dt";

    switch($_REQUEST["assunto"]){
        case 1:
            $assunto = "Confirmação de email.";
            $mensagem = "Quase lá! Precisamos que faça uma última coisa: confirmar seu e-mail.<br><br>Você pode fazer isso clicando neste botão abaixo:";
            $acao = "ativarUsuario(".$_REQUEST['code'].");";
            $pagina = "login.php?msg=1";
        break;
        case 2:
            $assunto = "Redefinição de senha.";
            $mensagem = "Você solicitou uma redefinição de senha?<br><br>Se sim, complete a ação clicando no botão abaixo:";
            $acao = "setAcao(".$_REQUEST['code'].");";
            if(isset($_SESSION["user"]) == false && isset($_COOKIE["user"]) == false){
                $pagina = "login.php?msg=1";
            }
            else{
                $pagina = "preferencias.php?msg=2";
            }
        break;
        case 3:
            $assunto = "Exclusão de conta.";
            $mensagem = "Você pretende excluir sua conta?<br><br>Se sim, complete a ação clicando no botão abaixo:";
            $acao = "setAcao(".$_REQUEST['code'].");";
            if(isset($_SESSION["user"]) == false && isset($_COOKIE["user"]) == false){
                $pagina = "login.php?msg=1";
            }
            else{
                $pagina = "preferencias.php?msg=2";
            }
        break;
        case 4:
            $codigo = $_REQUEST["codigo"];
            require("back.php");
            $banco = new Banco();
            $resposta = $banco->Consultar("select tb_suporte.*, tb_usuario.cd_email from tb_suporte join tb_usuario where tb_suporte.cd_suporte = $codigo and tb_suporte.cd_usuario = tb_usuario.cd_usuario;");

            $assunto = "Resposta do suporte.";
            $mensagem = "<a style='color: white'>Você solicitou, recentemente, a ajuda do nosso suporte:</a>
            <br><a style='color: white; font-style: italic;'>'$resposta[2]'</a>
            <br><br><a style='color: white'>Aqui está nossa resposta para o seu caso:</a>
            <br><a style='color: white; font-style: italic;'>'$resposta[3]'</a>";
            $_REQUEST["email"] = $resposta[6];
            $pagina = "admin-panel.php?msg=1";
        break;
    }

    if($assunto != null){
        $mailads = $_REQUEST["email"];
        $ativ = "<body style='margin: 0px; min-width: 100%;'>
            <div style='width: 50vw; min-width: 60vh; min-height: 92vh; padding: 2.5vh 4.5vh 2.5vh 2.5vh; background: #222222; border-radius: 2vh;'>
                <div style='min-height: 100%; width: 100%; border-radius: 2vh; border: 1vh solid white; color: white; font-family: segoe ui;'>
                    <p style='text-align: center; font-size: 10vh; margin-top: 4vh; color: white;'>Dream Team</p>
                    <p style='text-align: justify; padding: 0vh 4vh 0vh 4vh; font-size: 4vh; color: white; margin-top: 0vh;'>$mensagem</p>";
                    if($_REQUEST["assunto"] != 4){
                        $ativ .= "<p align='center' style='padding-top: 4vh;'><a href='http://localhost:8080/back.php?request=".$acao."'><button style='width: 60%; height: 10vh; background-color: white; border-radius: 2vh; border: 0vh; font-family: segoe ui; font-size: 4vh; cursor: pointer; color: black'>Confirmar</button></a></p>";
                    }
                    $ativ .= "<p style='text-align: center; font-size: 4vh; padding-top: 4vh; color: white;'>Mensagem automática, não responda.<br>-A equipe Dream Team</p>
                    <br><br>
                </div>
            </div>
        </body>";
        $mail->SetFrom("equipedtoficial@gmail.com", "Equipe DT");
        $mail->Subject = $assunto;
        $mail->Body = $ativ;
        $mail->AddAddress($mailads);
    }

    if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message has been sent";
    }
    echo "<body>";
    echo "<script> window.location.href = '$pagina'; </script>";
?>