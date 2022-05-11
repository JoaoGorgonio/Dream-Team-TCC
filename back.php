<?php
    date_default_timezone_set("Brazil/East");
    $dataAtual = (date('Y'))."-".date("m")."-".date("d");

    session_start();

    if(isset($_REQUEST["request"]) == true){
        eval($_REQUEST["request"]);
    }

    function destruirSessao(){
        session_destroy();
        setcookie("user", null, time() + -1);
        setcookie("admin", null, time() + -1);
        header("location: index.php?msg=2");
    }

    function codigoSessao($cargo){
        if($cargo == 1){
            if(isset($_SESSION["user"]) == true){
                return  $_SESSION["user"];
            }
            else{
                if(isset($_COOKIE["user"]) == true){
                    return  $_COOKIE["user"];
                }
            }
        }
        else{
            if(isset($_SESSION["admin"]) == true){
                return  $_SESSION["admin"];
            }
            else{
                if(isset($_COOKIE["admin"]) == true){
                    return  $_COOKIE["admin"];
                }
            }
        }
    }

    function redirecionar($camada){
        if(codigoSessao(1) != null){
            $user =  new Usuario(codigoSessao(1));
            if($user->codigo != null && $camada == 0){
                header("Location: mercado.php");
            }
            else{
                if($user->codigo != null && $camada == 2){
                    header("Location: mercado.php");
                }
            }
        }
        else{
            if(codigoSessao(2) != null){
                $admin = new Administrador(codigoSessao(2));
                if($admin->codigo != null && $camada == 0){
                    header("Location: admin-panel.php");
                }
                else{
                    if($admin->codigo != null && $camada == 1){
                        header("Location: admin-panel.php");
                    }
                }
            }   
            else{
                if($camada == 1 || $camada == 2){
                    destruirSessao();
                }
            }
        }  
    }

    function iniciarSessao($codigo, $sessao, $cargo){
    	unset($_SESSION["user"]);
    	unset($_SESSION["admin"]);
        setcookie("user", null, time() + -1);
        setcookie("admin", null, time() + -1);
        if($cargo == 1){
            if($sessao == 1){
                setcookie("user", $codigo, time() + ((3600 * 24) * 365));
            }
            else{
                $_SESSION["user"] = $codigo;
            }
            echo "<script> document.location = 'mercado.php'; </script>";
        }
        else{
            if($sessao == 1){
                setcookie("admin", $codigo, time() + ((3600 * 24) * 365));
            }
            else{
                $_SESSION["admin"] = $codigo;
            }
            echo "<script> document.location = 'admin-panel.php'; </script>";
        }
    }

    function setDadosLogin($usuario, $senha, $sessao){
        $banco = new Banco();
        $codigoAtivo = $banco->Consultar("select cd_usuario, nm_apelido from tb_usuario where (nm_apelido = '$usuario' or cd_email = '$usuario') and nm_senha = '$senha'");

        if(isset($codigoAtivo[0]) == true && isset($codigoAtivo[1]) == true){
            $dadosIcone = $banco->Consultar("select distinct tb_icone.nm_path, ordem_icone.cd_icone from tb_icone join ordem_icone where tb_icone.cd_icone = ordem_icone.cd_icone and ordem_icone.ic_escolhido = 1 and ordem_icone.cd_usuario = $codigoAtivo[0]");

            if(isset($dadosIcone[0]) == true){
                $path = $dadosIcone[0];
            }
            else{
                $path = "../img/exfoto.png";
            }
            echo
                "document.getElementById('tituloLogin').innerHTML = 'Bem vindo, <br>".$codigoAtivo[1]."!';
                document.getElementById('userpic').setAttribute('src','$path');
                setTimeout(function(){
                    window.location = 'back.php?request=iniciarSessao($codigoAtivo[0], $sessao, 1);';
                }, 2400);"
            ;
        }
        else{
            if(isset($codigoAtivo[0]) == true && isset($codigoAtivo[1]) == false){
                echo
                    "document.getElementById('tituloLogin').innerHTML = 'Bem vindo!';
                    document.getElementById('userpic').setAttribute('src','../img/exfoto.png');
                    setTimeout(function(){
                        window.location = 'back.php?request=iniciarSessao($codigoAtivo[0], $sessao, 1);';
                    }, 2400);"
                ;
            }
            else{
                $codigoInativo = $banco->Consultar("select cd_usuario from tb_pre_cadastro where cd_email = '$usuario';");
                if(isset($codigoInativo[0]) == true){
                    return "Você precisa confirmar seu e-mail!";
                }
                else{
                    $codigoAdmin = $banco->Consultar("select cd_admin, nm_admin from tb_admin where cd_cpf = '$usuario' and nm_senha = '$senha'");
                    if(isset($codigoAdmin[0]) == true){
                        $nome = explode(" ", $codigoAdmin[1]);
                        echo
                            "document.getElementById('tituloLogin').innerHTML = 'Bem vindo, <br>".$nome[0]."!';
                            document.getElementById('userpic').setAttribute('src','../img/ico512.png');
                            setTimeout(function(){
                                window.location = 'back.php?request=iniciarSessao($codigoAdmin[0], $sessao, 2);';
                            }, 2400);"
                        ;
                    }
                    else{
                        return "Apelido/E-mail e/ou senha inválido(s)!";
                    }
                }
            }
        }
    }

    function existeDado($tipo, $dado){
        $banco = new Banco();
        if($tipo == "email"){
            $email = $banco->Consultar("select cd_email from tb_usuario where cd_email = '$dado';");
            if(isset($email[0]) == true){
                return "E-mail já cadastrado.";
            }
            else{
                $emailInativo = $banco->Consultar("select cd_email from tb_pre_cadastro where cd_email = '$dado';");
                if(isset($emailInativo[0]) == true){
                    return "E-mail já cadastrado.";
                }
            }
        }
        else{
            if($tipo == "apelido"){
                $apelido = $banco->Consultar("select nm_apelido from tb_usuario where nm_apelido = '$dado';");
                if(isset($apelido[0]) == true){
                    return "Apelido já escolhido.";
                }
            }
            else{
                if($tipo == "cpf"){
                    $cpf = $banco->Consultar("select cd_cpf from tb_usuario where cd_cpf = '$dado';");
                    if(isset($cpf[0]) == true){
                        return "CPF já cadastrado.";
                    }
                    else{
                        $cpfInativo = $banco->Consultar("select cd_cpf from tb_pre_cadastro where cd_cpf = '$dado';");
                        if(isset($cpfInativo[0]) == true){
                            return "CPF já cadastrado.";
                        }
                    }
                }
            }
        }
    }
    
    function getDadosApelido($apelido){
        $banco = new Banco();
        $infos = $banco->Consultar("select cd_usuario from tb_usuario where nm_apelido = '$apelido';");
        
        if(isset($infos[0]) == true){
            return $infos[0];
        }
    }

    function redefinirSenha($novoDado){
        $banco = new Banco();
        $maxID = $banco->Consultar("select max(cd_acao) + 1 from tb_acao;");
        if(isset($maxID[0]) == false){
            $maxID[0] = 1;
        }

        $email = $_REQUEST['mail'];
        $dadoAntigo = $banco->Consultar("select nm_senha, cd_usuario from tb_usuario where cd_email = '$email';");
            
        $insert = $banco->ExecutarSQL("insert into tb_acao values($maxID[0], 'Senha', '$novoDado', '$dadoAntigo[0]', CURRENT_TIMESTAMP(), $dadoAntigo[1]);");
    
        header("location: send-mail.php?assunto=2&code=$maxID[0]&email=$email");
    }

    function setAcao($codigo){
        $banco = new Banco();
        $infos = $banco->Consultar("select * from tb_acao where cd_acao = $codigo;");
        $maxID = $banco->Consultar("select max(cd_acao) + 1 from backup_acao;");
        if(isset($maxID[0]) == false){
            $maxID[0] = 1;
        }

        if(isset($infos[0]) == true){
            if($infos[1] == "Senha"){
                $banco->ExecutarSQL("update tb_usuario set nm_senha = '$infos[2]' where nm_senha = '$infos[3]';");
                $banco->ExecutarSQL("insert into backup_acao values($maxID[0], '$infos[1]', '$infos[2]', '$infos[3]', $infos[5], CURRENT_TIMESTAMP());");
                $banco->ExecutarSQL("delete from tb_acao where cd_acao = $codigo;");
                header("location: preferencias.php?msg=3");
            }
            else{
                if($infos[1] == "Deletar"){
                    $banco->ExecutarSQL("delete from ordem_customizada where cd_usuario = $infos[5];");
                    $banco->ExecutarSQL("delete from ordem_patrocinada where cd_usuario = $infos[5];");
                    $banco->ExecutarSQL("delete from tb_acao where cd_usuario = $infos[5];");
                    $banco->ExecutarSQL("delete from backup_acao where cd_usuario = $infos[5];");
                    $banco->ExecutarSQL("delete from compra where cd_usuario = $infos[5];");
                    $banco->ExecutarSQL("delete from backup_compras where cd_usuario = $infos[5];");
                    $banco->ExecutarSQL("delete from ordem_icone where cd_usuario = $infos[5];");
                    $banco->ExecutarSQL("delete from tb_suporte where cd_usuario = $infos[5];");
                    $banco->ExecutarSQL("delete from tb_usuario where cd_usuario = $infos[5];");
                    header("location: index.php?msg=1");
                }
            }
        }
        else{
            if(codigoSessao(1) != null){
                header("location: preferencias.php?msg=1");
            }
            else{
                header("location: login.php?msg=2");
            }
        }
    }

    function ativarUsuario($codigo){
        $banco = new Banco();
        $dados = $banco->Consultar("select * from tb_pre_cadastro where cd_usuario = $codigo;");
        if(isset($dados[0]) == false){
            destruirSessao();
            header("Location: login.php?msg=2");
        }
        else{
            $maxID = $banco->Consultar("select max(cd_usuario) + 1 from tb_usuario;");
            if(isset($maxID[0]) == false){
                $maxID[0] = 1;
            }

            $banco->ExecutarSQL("insert into tb_usuario values($maxID[0], $dados[1], '$dados[2]', '$dados[3]', '$dados[4]', 1000, '$dados[5]', null);");
            $banco->ExecutarSQL("delete from tb_pre_cadastro where cd_usuario = $codigo;");

            iniciarSessao($maxID[0], 0, 1);
            header("location:mercado.php");
        }
    }

    function cadastrarUsuario(){
        $banco = new Banco();
        $maxID = $banco->Consultar("select max(cd_usuario) + 1 from tb_pre_cadastro");
        if(isset($maxID[0]) == false){
            $maxID[0] = 1;
        }

        $email = $_POST["email"];
        $nome = $_POST["nome"];
        $data = $_POST["data"];
        $apelido = $_POST["apelido"];
        $senha = $_POST["senha"];
        $cpf = $_POST["cpfUsuario"];
        $key = md5($email);

        $banco->ExecutarSQL("insert into tb_pre_cadastro values($maxID[0], '$cpf', '$nome', '$email','$data', '$senha', CURDATE())");

        header("location:send-mail.php?assunto=1&code=".$maxID[0]."&email=".$email);
    }

    class Banco{
        public function __construct() {
            $this->user = 'root';
            $this->password = 'usbw';
            $this->database = 'db_dream_team';
            $this->host = 'localhost';
            
            $this->ConectarBanco();
        }
            
        protected function ConectarBanco() {
            $this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->database);

            if (mysqli_connect_errno()) {
                die('Não foi possível conectar-se ao banco de dados');
                exit();
            }
        }
            
        public function FecharBanco() {
            $this->mysqli->close();
        }
            
        public function ExecutarSQL($sql) {
            $this->sql = $this->mysqli->query($sql);
        }
            
        public function Consultar($dados) {
            $this->sql = $this->mysqli->query($dados);
            $this->resposta = array();
            while($row = $this->sql->fetch_assoc()){
                foreach($row as $Result=>$Column) {
                    array_push($this->resposta, $Column);
                }
            }
            return $this->resposta;
        }
    }

    class Administrador{
        public function __construct($codigo) {
            $this->banco = new Banco();
            $infos = $this->banco->Consultar("select * from tb_admin where cd_admin = $codigo");

            if(isset($infos[0]) == true){
                $this->codigo = $infos[0];
                $this->nome = $infos[1];
                $this->cpf = $infos[2];
                $this->senha = $infos[3];
            }
            else{
                destruirSessao();
            }
        }
        

        public function passarRodada(){
            $passarLiga = $this->banco->ExecutarSQL("update tb_liga_customizada set qt_rodada = qt_rodada - 1;");

            $ligasFinalizadas = $this->banco->Consultar("select cd_liga_customizada from tb_liga_customizada where qt_rodada = 0;");
            foreach($ligasFinalizadas as $Row){
                $this->banco->ExecutarSQL("call sp_paga_custom($Row);");
            }

            $pagarTimes = $this->banco->Consultar("SELECT sum(((qt_ponto + qt_rebote + qt_toco + qt_bola_recuperada + qt_assistencia) - ( qt_arremesso_errado + qt_turnover)) * 10) as 'ganho', sum((qt_ponto + qt_rebote + qt_toco + qt_bola_recuperada + qt_assistencia) - ( qt_arremesso_errado + qt_turnover)) as 'pontos', compra.cd_usuario FROM tb_jogador join compra WHERE  tb_jogador.cd_jogador = compra.cd_jogador group by cd_usuario having count(cd_usuario) = 5;");
            foreach(array_chunk($pagarTimes, 3) as $Row=>$dado){
                $pagar = $this->banco->ExecutarSQL("update tb_usuario set qt_dragonitas = (qt_dragonitas + $dado[0]) where cd_usuario = $dado[2];");
                $pontosCustom = $this->banco->ExecutarSQL("update ordem_customizada set qt_pontos = (qt_pontos + $dado[1]) where cd_usuario = $dado[2];");
                $pontosPatroc = $this->banco->ExecutarSQL("update ordem_patrocinada set qt_pontos = (qt_pontos + $dado[1]) where cd_usuario = $dado[2];");
            }
            
            $compras = $this->banco->Consultar("select * from compra;");
            foreach(array_chunk($compras, 3) as $Row=>$dado){
                $maxID = $this->banco->Consultar("select max(cd_compra) from backup_compras;");
                if(isset($maxID[0]) == false){
                    $maxID[0] = 1;
                }

                $insertBackup = $this->banco->ExecutarSQL("insert into backup_compras values($maxID[0], $dado[1], $dado[2], CURDATE(), $this->codigo);");
            }
            $deleteCompras = $this->banco->ExecutarSQL("delete from compra;");

            header("location: admin-panel.php?msg=2");
        }

        public function getMensagens(){
            $infos = $this->banco->Consultar("select tb_suporte.*, tb_usuario.nm_apelido from tb_suporte join tb_usuario where ds_resposta is NULL and tb_suporte.cd_usuario = tb_usuario.cd_usuario;");

            if(isset($infos[0]) == true){
                foreach(array_chunk($infos, 7) as $Row=>$dado){
                    $mensagem = "";
                    if(isset($dado[2]{55}) == true){
                        for($x = 0; $x <= 54; $x++){
                            $mensagem = $mensagem . $dado[2]{$x};
                        }
                        $mensagem = $mensagem . "...";
                    }
                    else{
                        $mensagem = $dado[2];
                    }
    
                    echo
                        "<div class='suporte-pan'>
                            <div class='holder-suporte'>
                                <p class='nome-suporte'>$dado[1]</p>
                                <p class='ds-suporte'>'".$mensagem."'</p>
                                <p class='remetente-suporte'>enviado por $dado[6].</p>
                                <p class='responder' onclick='abrirResposta(this)' id='$dado[0]'>responder</p>
                            </div>
                        </div>"
                    ;
                }
            }
            else{
                echo "<p style='font-size: 5vh; color: white; padding-top: 6vh;'>Nenhuma solicitaçãoo em aberto.</p>";
            }
        }

        public function atualizarJogador($codigo){
            $erros = $_POST['erros'];
            $pontos = $_POST['pontos'];
            $turnovers = $_POST['turnovers'];
            $tocos = $_POST['tocos'];
            $rebotes = $_POST['rebotes'];
            $recuperadas = $_POST['recuperadas'];
            $assistencias = $_POST['assistencias'];

            $jogador = new Jogador();
            $jogador->getDadosJogador($codigo);

            $update = $this->banco->ExecutarSQL("update tb_jogador set qt_ponto = $pontos, qt_rebote = $rebotes, qt_toco = $tocos, qt_bola_recuperada = $recuperadas, qt_assistencia = $assistencias, qt_arremesso_errado = $erros, qt_turnover = $turnovers where cd_jogador = $codigo;");

            $backup = $this->banco->ExecutarSQL("insert into backup_jogador values($codigo, $jogador->pontos, $jogador->rebotes, $jogador->tocos, $jogador->recuperadas, $jogador->assistencias, $jogador->erros, $jogador->turnovers, $this->codigo);");

            header("location: admin-panel.php?msg=2");
        }

        public function getDadosMensagem($codigo){
            $infos = $this->banco->Consultar("select tb_suporte.*, tb_usuario.nm_apelido from tb_suporte join tb_usuario where tb_suporte.cd_suporte = $codigo and tb_suporte.cd_usuario = tb_usuario.cd_usuario;");

            echo 
                "<div class='holder-dado'>
                    <p class='dado'>$infos[1]:</p>
                </div>
                <p id='ds-mensagem'>'$infos[2]'<a id='remetente' class='remetente-suporte'><br><br>-Mensagem enviada por $infos[6]</a></p>
                <div class='holder-dado'>
                    <p class='dado'>Resposta:&nbsp;<a id='stts-desc' class='error'></a></p>
                </div>
                <form action='back.php?request=$"."a=new Administrador(codigoSessao(2));$"."a->responderMensagem($infos[0]);' onsubmit='return enviarMensagem()' method='POST'>
                    <textarea id='desc' maxlength='500' onkeyup='msgstts(), letra(this)' name='mensagem'></textarea>
                    <br><br><input type='submit' class='responder' value='Enviar'><br><br>
                </form>"
            ;
        }

        public function responderMensagem($codigo){
            if(isset($_POST['mensagem']) == true){
                $resposta = $_POST['mensagem'];
                $infos = $this->banco->ExecutarSQL("update tb_suporte set ds_resposta= '$resposta', cd_admin = $this->codigo where cd_suporte = $codigo;");

                header("location: send-mail.php?assunto=4&codigo=$codigo");
            }
            else{
                header("location: admin-panel.php");
            }
        }
    }

    class Usuario{
        public function __construct($codigo) {
            $this->banco = new Banco();
            $infos = $this->banco->Consultar("select * from tb_usuario where cd_usuario = $codigo");

            if(isset($infos[0]) == true){
                $this->codigo = $infos[0];
                $this->cpf = $infos[1];
                $this->nome = $infos[2];
                $this->email = $infos[3];
                $this->nascimento = $infos[4];
                $this->dragonitas = $infos[5];
                $this->senha = $infos[6];
                $this->apelido = $infos[7];
                
                $icone = $this->banco->Consultar("select distinct tb_icone.nm_path, ordem_icone.cd_icone from tb_icone join ordem_icone where tb_icone.cd_icone = ordem_icone.cd_icone and ordem_icone.ic_escolhido = 1 and ordem_icone.cd_usuario = $codigo;");
                if(isset($icone[0]) == true){
                    $this->icone = $icone[0];
                }

                $patrocinada = $this->banco->Consultar("select cd_liga_patrocinio, qt_pontos from ordem_patrocinada where cd_usuario = $codigo;");
                if(isset($patrocinada[0]) == true){
                    $this->liga = $patrocinada[0];
                    $this->pontosPatrocinada = $patrocinada[1];
                }
            }
            else{
                destruirSessao();
            }
        }

        public function getTimeUsuario($usuario){
            $time = $this->banco->Consultar("select tb_jogador.cd_jogador from tb_jogador join compra where tb_jogador.cd_jogador = compra.cd_jogador and compra.cd_usuario = $usuario;");

            if(isset($time[0]) == true){
                foreach($time as $Row){
                    $this->setTimeUsuario($Row);
                }
            }

            for($x = 1; $x <= (5 - count($time)); $x++){
                $this->setTimeUsuario("null");
            }
        }

        public function setTimeUsuario($codigo){
            if($codigo != "null"){
                $jogador = new Jogador();
                $jogador->getDadosJogador($codigo);
                $semana = new Semana();

                echo
                    "<div class='holder-item'>
                        <div class='item'>
                            <img alt='jogador de basquete disponível para compra' class='foto-item' src='$jogador->imagem'>
                            <div class='info-item'>
                                <p class='nome-item' style='margin-top: 0vh'>$jogador->nome</p>
                                <p class='nome-item' style='margin-top: 0vh'>$jogador->posicao, $jogador->preco"."dg</p>";
                                if($semana->codigoAtual != null){
                                    echo "<div class='comprar-indisponivel'>-</div>";
                                }
                                else{
                                    echo "<div class='comprar-indisponivel' style='cursor: pointer;' onclick='confirmarReembolso(this)' id='$jogador->codigo'>x</div>";
                                }
                                echo"
                                <div class='sobre-item' style='opacity: 0; cursor: default;'>%</div>
                            </div>
                        </div>
                    </div>"
                ;
            }
            else{
                echo
                    "<div class='holder-item'>
                        <div class='item'>
                            <img alt='jogador de basquete disponível para compra' class='foto-item' style='opacity: 0' src='img/exfoto.png'>
                            <div class='info-item'>
                                <p class='nome-item' style='margin-top: 0vh'>Nome</p>
                                <p class='nome-item' style='margin-top: 0vh'>Posição, preço</p>
                                <div class='comprar-item' onclick='comprar()'>+</div>
                                <div class='sobre-item' style='opacity: 0; cursor: default'>+</div>
                            </div>
                        </div>
                    </div>"
                ;
            }
        }

        public function verificarCadastro(){
            $ordemCustom = $this->banco->Consultar("select cd_liga_patrocinio from ordem_patrocinada where cd_usuario = $this->codigo;");
            $ordemIcone = $this->banco->Consultar("select max(cd_compra) from ordem_icone where cd_usuario = $this->codigo");

            if($this->apelido == null || isset($ordemCustom[0]) == false || isset($ordemIcone[0]) == false){
                return "Incompleto";
            }
            else{
                return "Completo";
            }
        }

        public function setMensagem(){
            if(isset($_POST['assunto']) == true && isset($_POST['mensagem']) == true){
                $assunto = $_POST['assunto'];
                $mensagem = $_POST['mensagem'];

                $maxID = $this->banco->Consultar("select max(cd_suporte) + 1 from tb_suporte;");
                if(isset($maxID[0]) == false){
                    $maxID[0] = 1;
                }

                $this->banco->ExecutarSQL("insert into tb_suporte value($maxID[0], '$assunto', '$mensagem', null, $this->codigo, null);");
                $return = $this->banco->Consultar("select cd_suporte from tb_suporte where cd_suporte = $maxID[0];");
                if(isset($maxID[0]) == false){
                    header("location: suporte.php?msg=2");
                }
                else{
                    header("location: suporte.php?msg=1");
                }
            }
            else{
                header("location: suporte.php");
            }
        }

        public function getAcao($tipo, $novoDado){
            if($tipo == "Senha"){
                $maxID = $this->banco->Consultar("select max(cd_acao) + 1 from tb_acao;");
                if(isset($maxID[0]) == false){
                    $maxID[0] = 1;
                }
                $email = $this->email;
                $dadoAntigo = $this->banco->Consultar("select nm_senha, cd_usuario from tb_usuario where cd_email = '$email';");
                
                $insert = $this->banco->ExecutarSQL("insert into tb_acao values($maxID[0], '$tipo', '$novoDado', '$dadoAntigo[0]', CURRENT_TIMESTAMP(), $dadoAntigo[1]);");

                header("location: send-mail.php?assunto=2&code=$maxID[0]&email=$email");
            }
            else{
                if($tipo == "Apelido"){
                    $maxID = $this->banco->Consultar("select max(cd_acao) + 1 from backup_acao;");
                    if(isset($maxID[0]) == false){
                        $maxID[0] = 1;
                    }
                    $email = $this->email;

                    $dadoAntigo = $this->banco->Consultar("select nm_apelido, cd_usuario from tb_usuario where cd_email = '$email';");
                    $insert = $this->banco->ExecutarSQL("insert into backup_acao values($maxID[0], '$tipo', '$novoDado', '$dadoAntigo[0]', $dadoAntigo[1], CURRENT_TIMESTAMP());");
                    $pagar = $this->banco->ExecutarSQL("update tb_usuario set qt_dragonitas = (qt_dragonitas - 1300), nm_apelido = '$novoDado' where cd_email = '$email';");

                    header("location: preferencias.php?msg=3");
                }
                else{
                    if($tipo == "Deletar"){
                        $maxID = $this->banco->Consultar("select max(cd_acao) + 1 from tb_acao;");
                        if(isset($maxID[0]) == false){
                            $maxID[0] = 1;
                        }

                        $email = $this->email;
                        
                        $insert = $this->banco->ExecutarSQL("insert into tb_acao values($maxID[0], '$tipo', null, null, CURRENT_TIMESTAMP(), $this->codigo);");

                        header("location: send-mail.php?assunto=3&code=$maxID[0]&email=$email");
                    }
                }
            }
        }

        public function atualizarIcone($codigo){
            $icone = new Icone();
            $icone->getDadosIcone($codigo);

            $desequipar = $this->banco->ExecutarSQL("update ordem_icone set ic_escolhido = 0 where cd_usuario = $this->codigo;");
            $equipar = $this->banco->ExecutarSQL("update ordem_icone set ic_escolhido = 1 where cd_icone = $icone->codigo and cd_usuario = $this->codigo;");
        }

        public function setApelido($apelido){
            $this->banco->ExecutarSQL("update tb_usuario set nm_apelido = '$apelido' where cd_usuario = $this->codigo;");
        }

        public function setLiga($liga){
            $ligaID = $this->banco->Consultar("select cd_liga_patrocinio from tb_liga_patrocinio where nm_liga_patrocinio = '$liga';");
            $existe = $this->banco->Consultar("select cd_liga_patrocinio from ordem_patrocinada where cd_usuario = $this->codigo;");

            if(isset($existe[0]) == false){
                $this->banco->ExecutarSQL("insert into ordem_patrocinada values($ligaID[0], $this->codigo, 0);");
            }
        }

        public function entrarLigaCustom($codigo){
            $ligaCustom = new LigaCustomizada();
            $ligaCustom->getDadosLiga($codigo);

            $ordemUser = $this->banco->Consultar("select cd_liga_customizada from ordem_customizada where cd_liga_customizada = $codigo and cd_usuario = $this->codigo;");

            if($this->dragonitas >= $ligaCustom->preco){
                if(isset($ordemUser[0]) == false){
                    $this->banco->ExecutarSQL("insert into ordem_customizada values($this->codigo, $ligaCustom->codigo, 0);");
                    $this->banco->ExecutarSQL("update tb_usuario set qt_dragonitas = (qt_dragonitas - $ligaCustom->preco) where cd_usuario = $this->codigo;");

                    return "Entrada efetuada com sucesso!";
                }
                else{
                    return "Você já participa desta liga!";
                }
            }
            else{
                return "Dragonitas insuficientes!";
            }
        }

        public function setIcone($codigo){
            $icone = new Icone();
            $infosIcone = $icone->getDadosIcone($codigo);

            $comprou = $this->banco->Consultar("select cd_compra from ordem_icone where cd_usuario = $this->codigo;");
            if(isset($comprou[0]) == false){
                $maxID = $this->banco->Consultar("select max(cd_compra) + 1 from ordem_icone;");
                if(isset($maxID[0]) == false){
                    $maxID[0] = 1;
                }

                $this->banco->ExecutarSQL("insert into ordem_icone values($maxID[0], 1, $this->codigo, $codigo);");
            }
            else{
            }
        }

        public function comprarIcone($codigo){
            $icone = new Icone();
            $infosIcone = $icone->getDadosIcone($codigo);

            if($this->dragonitas >= $icone->preco){
                $maxID = $this->banco->Consultar("select max(cd_compra) + 1 from ordem_icone");
                if(isset($maxID[0]) == false){
                    $maxID[0] = 1;
                }

                $atualizarDragonita = $this->banco->ExecutarSQL("update tb_usuario set qt_dragonitas = (qt_dragonitas - $icone->preco) where cd_usuario = $this->codigo;");
                $desequipar = $this->banco->ExecutarSQL("update ordem_icone set ic_escolhido = 0 where cd_usuario = $this->codigo;");
                $comprar = $this->banco->ExecutarSQL("insert into ordem_icone values($maxID[0], 1, $this->codigo, $codigo)");
                return "Ícone comprado com sucesso!";
            }
            else{
                return "Você não possui dragonitas suficiente.";
            }
        }

        public function comprarJogador($codigo){
            $jogador = new Jogador();
            $dados = $jogador->getDadosJogador($codigo);
            $time = $this->banco->Consultar("select tb_jogador.nm_posicao from compra join tb_jogador where compra.cd_usuario = $this->codigo and compra.cd_jogador = tb_jogador.cd_jogador;");

            if(isset($time[4]) == false){
                if(isset($time[3]) == true){
                    foreach($time as $row){
                        $jogador->posicaoJogador("$row");
                    }

                    $jogador->posicaoJogador("$jogador->posicao");

                    if($GLOBALS["Alas"] > 0 && $GLOBALS["Armadores"] > 0 && $GLOBALS["Pivôs"] > 0){
                        if($this->dragonitas >= $jogador->preco){
                            $maxID = $this->banco->Consultar("select max(cd_compra) + 1 from compra");
                            if(isset($maxID[0]) == false){
                                $maxID[0] = 1;
                            }
                            $atualizarDragonita = $this->banco->ExecutarSQL("update tb_usuario set qt_dragonitas = qt_dragonitas - $jogador->preco where cd_usuario = $this->codigo");
                            $comprar = $this->banco->ExecutarSQL("insert into compra values($maxID[0], $this->codigo, $codigo)");
                            return "Jogador comprado com sucesso!";
                        }
                        else{
                            return "Você não possui dragonitas o suficiente.";
                        }
                    }
                    else{
                        return "Seu time está com uma (ou mais) posição(ões) faltando, escale um jogador de cada posição para comprar este jogador.";
                    }
                }
                else{
                    if($this->dragonitas >= $jogador->preco){
                        $maxID = $this->banco->Consultar("select max(cd_compra) + 1 from compra");
                        if(isset($maxID[0]) == false){
                            $maxID[0] = 1;
                        }
                        $atualizarDragonita = $this->banco->ExecutarSQL("update tb_usuario set qt_dragonitas = qt_dragonitas - $jogador->preco where cd_usuario = $this->codigo");
                        $comprar = $this->banco->ExecutarSQL("insert into compra values($maxID[0], $this->codigo, $codigo)");
                        return "Jogador comprado com sucesso!";
                    }
                    else{
                        return "Você não possui dragonitas o suficiente.";
                    }
                }
                
            }
            else{
                return "Seu time já está completo!";
            }
        }

        public function reembolsoJogador($codigo){
            $jogador = new Jogador();
            $jogador->getDadosJogador($codigo);
            $preco = $jogador->preco;

            $this->banco->ExecutarSQL("delete from compra where cd_jogador = $codigo and cd_usuario = $this->codigo;");
            $this->banco->ExecutarSQL("update tb_usuario set qt_dragonitas = qt_dragonitas + $preco where cd_usuario = $this->codigo;");
            
            return "Jogador reembolsado com sucesso!";
        }

        public function criarLigaCustom($nome, $participantes, $rodadas, $privacidade, $codigo){
            $maxID = $this->banco->Consultar("select max(cd_liga_customizada) + 1 from tb_liga_customizada;");
            if(isset($maxID[0]) == false){
                $maxID[0] = 1;
            }

            if($this->dragonitas >= (($participantes * 10) + ($rodadas * 5) + (($privacidade + 1) * 200))){
                $this->banco->ExecutarSQL("insert into tb_liga_customizada values($maxID[0], '$nome', $rodadas, $participantes, $privacidade, '$codigo');");
                $this->banco->ExecutarSQL("update tb_usuario set qt_dragonitas = qt_dragonitas - (($participantes * 10) + ($rodadas * 5) + (($privacidade + 1) * 200)) where cd_usuario = $this->codigo;");
                $this->banco->ExecutarSQL("insert into ordem_customizada values($this->codigo, $maxID[0], 0);");
                return "Liga criada com sucesso!";
            }
            else{
                return "Você não possui dragonitas suficientes para criar uma liga.";
            }
        }
    }

    class Jogador{
        public function __construct() {
            $this->banco = new Banco();
        }

        public function getDadosAtualizar($codigo){
            $this->getDadosJogador($codigo);
            
            echo
                "<form action='back.php?request=$"."a=new Administrador(codigoSessao(2));$"."a->atualizarJogador($this->codigo);' onsubmit='return envioAtualizar()' method='POST'>
                    <div class='holder-dado'>
                        <p class='nome-dado'>Pontos:</p>
                        <input type='number' name='pontos' class='dados-jogador' min='0' onkeyup='nm(this)' required placeholder='$this->pontos'>
                    </div>
                    <div class='holder-dado'>
                        <p class='nome-dado'>Rebotes:</p>
                        <input type='number' name='rebotes' class='dados-jogador' min='0' onkeyup='nm(this)' required placeholder='$this->rebotes'>
                    </div>
                    <div class='holder-dado'>
                        <p class='nome-dado'>Arremessos errados:</p>
                        <input type='number' name='erros' class='dados-jogador' min='0' onkeyup='nm(this)' required placeholder='$this->erros'>
                    </div>
                    <div class='holder-dado'>
                        <p class='nome-dado'>Assistências:</p>
                        <input type='number' name='assistencias' class='dados-jogador' min='0' onkeyup='nm(this)' required placeholder='$this->assistencias'>
                    </div>
                    <div class='holder-dado'>
                        <p class='nome-dado'>Turnovers:</p>
                        <input type='number' name='turnovers' class='dados-jogador' min='0' onkeyup='nm(this)' required placeholder='$this->turnovers'>
                    </div>
                    <div class='holder-dado'>
                        <p class='nome-dado'>Bolas recuperadas:</p>
                        <input type='number' name='recuperadas' class='dados-jogador' min='0' onkeyup='nm(this)' required placeholder='$this->recuperadas'>
                    </div>
                    <div class='holder-dado'>
                        <p class='nome-dado'>Tocos:</p>
                        <input  type='number' name='tocos' class='dados-jogador' min='0' onkeyup='nm(this)' required placeholder='$this->tocos'>
                    </div><br><br>
                    <input type='submit' class='responder' value='Atualizar'>
                    <br><br>
                </form>"
            ;
        }

        function posicaoJogador($posicao){
            if(isset($GLOBALS["Alas"]) == false){
                $GLOBALS["Alas"] = 0;
            }
            if(isset($GLOBALS["Armadores"]) == false){
                $GLOBALS["Armadores"] = 0;
            }
            if(isset($GLOBALS["Pivôs"]) == false){
                $GLOBALS["Pivôs"] = 0;
            }

            if($posicao == "Ala"){
                $GLOBALS["Alas"]++;
            }

            if($posicao == "Pivô"){
                $GLOBALS["Pivôs"]++;
            }

            if($posicao == "Armador"){
                $GLOBALS["Armadores"]++;
            }
            
        }

        public function setDadosJogador($codigo){
            $this->getDadosJogador($codigo);

            $time = new Time();
            $time->getDadosTime($this->time);

            return
                "document.getElementById('pontos').innerHTML = $this->pontos;
                document.getElementById('tocos').innerHTML = $this->tocos;
                document.getElementById('rebotes').innerHTML = $this->rebotes;
                document.getElementById('arremessos').innerHTML = $this->erros;
                document.getElementById('recuperadas').innerHTML = $this->recuperadas;
                document.getElementById('turnovers').innerHTML = $this->turnovers;
                document.getElementById('assistencias').innerHTML = $this->assistencias;
                document.getElementById('nome-jogador').innerHTML = '$this->nome';
                document.getElementById('time-nome').innerHTML = '$time->nome';
                document.getElementById('time-logo').setAttribute('src','$time->imagem');"
            ;
        }
         
        public function getDadosJogador($codigo){
            $infos = $this->banco->Consultar("SELECT cd_jogador, nm_jogador, nm_posicao, qt_ponto, qt_rebote, qt_toco, qt_bola_recuperada, qt_assistencia, qt_arremesso_errado, qt_turnover, cd_imagem, cd_time, ((qt_ponto + qt_rebote + qt_toco + qt_bola_recuperada + qt_assistencia) - ( qt_arremesso_errado + qt_turnover)) * 10 AS 'preco' FROM tb_jogador WHERE cd_jogador = $codigo");

            $this->codigo = $infos[0];
            $this->nome = $infos[1];
            $this->posicao = $infos[2];
            $this->pontos = $infos[3];
            $this->rebotes = $infos[4];
            $this->tocos = $infos[5];
            $this->recuperadas = $infos[6];
            $this->assistencias = $infos[7];
            $this->erros = $infos[8];
            $this->turnovers = $infos[9];
            $this->imagem = $infos[10];
            $this->time = $infos[11];
            if($infos[12] >= 50){
            	$this->preco = $infos[12];
            }
            else{
            	$this->preco = 50;
            }

            $time = new Time();
            $time->getDadosTime($this->time);
            $this->timeNome = $time->nome;
        }

        public function getDadosPontuado(){
            $codigo = $this->banco->Consultar("select distinct max((qt_ponto + qt_rebote + qt_toco + qt_bola_recuperada + qt_assistencia) - (qt_arremesso_errado + qt_turnover)) as 'Eficiencia', cd_jogador as 'codjog' from tb_jogador");

            $this->getDadosJogador($codigo[1]);
        }

        public function getJogadorDisponivel($posicao, $partida, $usuario, $dragonitas){
            $infos = $this->banco->Consultar("select distinct tb_jogador.cd_jogador as 'CODIGO', tb_time.cd_time as 'CODIGO TIME', tb_semana.cd_semana as 'SEMANA' from tb_jogador join tb_time join tb_partida join tb_semana on tb_jogador.cd_time = tb_time.cd_time or tb_time.cd_time = tb_partida.cd_time_casa and tb_time.cd_time = tb_partida.cd_time_visitante and tb_partida.cd_semana = tb_semana.cd_semana where tb_semana.cd_semana = ".$partida." and (tb_jogador.nm_posicao =".$posicao." and
            tb_jogador.cd_jogador NOT IN (SELECT cd_jogador FROM compra WHERE cd_usuario = $usuario) order by tb_jogador.cd_jogador;");

            $this->quantidade = 0;
            foreach(array_chunk($infos, 3) as $row=>$dado){
                $this->getDadosJogador($dado[0]);
                $this->exibirDisponivel($dragonitas);
                $this->quantidade += 1;
            }

            if($this->quantidade == 0){
                echo "<p style='font-size: 5vh; color: white; padding-top: 6vh;'>Nenhum jogador nesta posição.</p>";
            }
        }

        public function getJogadorAtualizar($partida){
            $infos = $this->banco->Consultar("select distinct tb_jogador.cd_jogador as 'CODIGO', tb_time.cd_time as 'CODIGO TIME', tb_semana.cd_semana as 'SEMANA' from tb_jogador join tb_time join tb_partida join tb_semana on tb_jogador.cd_time = tb_time.cd_time or tb_time.cd_time = tb_partida.cd_time_casa and tb_time.cd_time = tb_partida.cd_time_visitante and tb_partida.cd_semana = tb_semana.cd_semana where tb_semana.cd_semana = ".$partida." order by tb_jogador.cd_jogador;");

            foreach(array_chunk($infos, 3) as $row=>$dado){
                $this->getDadosJogador($dado[0]);
                $this->exibirAtualizar();
                $this->quantidade += 1;
            }
        }

        public function exibirAtualizar(){
            echo
                "<div class='holder-item'>
                    <div class='item' id='$this->codigo'>
                        <img alt='jogador de basquete disponível para compra' class='foto-item' src='$this->imagem'>
                        <div class='info-item'>
                            <p class='nome-item' style='margin-top: 0vh'>$this->nome</p>
                            <p class='nome-item' style='margin-top: 0vh'>$this->posicao</p>
                            <div class='comprar-item' onclick='atualizarJogador(this)' id='$this->codigo'><img src='img/reset.png' style='height: 80%; padding-top: 10%;'></div>
                            <div class='sobre-item' style='opacity: 0; cursor: default;'>%</div>
                        </div>
                    </div>
                </div>"
            ;
        }

        public function exibirDisponivel($dragonitas){
            echo
                "<div class='holder-item'>
                    <div class='item' id='$this->codigo'>
                        <img alt='jogador de basquete disponível para compra' class='foto-item' src='$this->imagem'>
                        <div class='info-item'>
                            <p class='nome-item' style='margin-top: 0vh'>$this->nome</p>
                            <p class='nome-item' style='margin-top: 0vh'>$this->posicao, $this->preco"."dg</p>";
                            if($dragonitas >= $this->preco){
                                echo "<div class='comprar-item' onclick='confirmarJogador(this)' id='$this->codigo'>+</div>";
                                echo "<div class='sobre-item' onclick='abrirEstatisticas(this)' id='$this->codigo'>%</div>";
                            }
                            else{
                                echo "<div class='comprar-indisponivel' onclick='confirmarJogador()' id='$this->codigo'>-</div>";
                                echo "<div class='sobre-item' style='opacity: 0; cursor: default;'>%</div>";
                            }
                            echo
                        "</div>
                    </div>
                </div>"
            ;
        }
    }

    class Mensagem{
        public function delete(){
            return "<script>
			document.getElementById('msg-title').innerHTML = 'SUCESSO:';
			document.getElementById('msg-content').innerHTML = 'Nós sentiremos sua falta, esperamos que um dia volte ._.';
			msgOpen(0, 0, 1);
		    </script>";
        }

        public function sessaoEncerrada(){
            return "<script>
			document.getElementById('msg-title').innerHTML = 'SESSÃO ENCERRADA:';
			document.getElementById('msg-content').innerHTML = 'Inicie sua sessão novamente.';
			msgOpen(0, 0, 1);
		    </script>";
        }

        public function erroMensagem(){
            return "<script>
			document.getElementById('msg-title').innerHTML = 'ERRO:';
			document.getElementById('msg-content').innerHTML = 'Algo de errado aconteceu durante o envio, por favor, tente novamente mais tarde.';
			msgOpen(0, 0, 1);
		    </script>";
        }

        public function sucessoMensagem(){
            return "<script>
			document.getElementById('msg-title').innerHTML = 'SUCESSO:';
			document.getElementById('msg-content').innerHTML = 'Solicitação enviada com sucesso!<br>Sua resposta chegará por e-mail em até 24 horas.';
			msgOpen(0, 0, 1);
		    </script>";
        }

        public function acaoExpirada(){
            return "<script>
			document.getElementById('msg-title').innerHTML = 'Atenção:';
			document.getElementById('msg-content').innerHTML = 'Requisição inválida, é possível que a mesma já tenha expirado. Em caso de expiração, repita o ato da requisição.';
			msgOpen(0, 0, 1);
		    </script>";
        }

        public function linkEnviado(){
            return "<script>
            document.getElementById('msg-title').innerHTML = 'SUCESSO:';
			document.getElementById('msg-content').innerHTML = 'Um link foi enviado para o seu e-mail, acesse-o para continuar.';
			msgOpen(0, 0, 1);
		    </script>";
        }

        public function acaoConcluida(){
            return "<script>
            document.getElementById('msg-title').innerHTML = 'SUCESSO:';
			document.getElementById('msg-content').innerHTML = 'A atualização foi concluida com sucesso.';
			msgOpen(0, 0, 1);
		    </script>";
        }

        public function respostaEnviada(){
            return "<script>
            document.getElementById('msg-title').innerHTML = 'SUCESSO:';
			document.getElementById('msg-content').innerHTML = 'Sua resposta foi enviada ao usuário.';
			msgOpen(0, 0, 1);
		    </script>";
        }

        public function redefinir(){
            return "<input class='dados-msg' autocomplete='off' onkeyup='preencherRedefinir(), chmail(this)' id='emailRedefinir' maxlength='80' type='email' placeholder='E-mail'>
            <input class='dados-msg' autocomplete='off' style='border-radius: 1vh 1vh 0vh 0vh' type='password' onkeyup='preencherRedefinir(), aspas(this)' maxlength='30' placeholder='Nova senha' id='senhaRedefinir'><br>
            <input id='mostrarSenha' onclick='mostrarSenha()'>";
        }

        public function trocarSenha(){
            $user = new usuario(codigoSessao(1));

            return 
                "<input class='dados-msg' autocomplete='off' style='border-radius: 1vh 1vh 0vh 0vh; caret-color: transparent;' type='password' id='senhaExibicao' onkeydown='return false;' value='$user->senha'><br>
                <input class='mostrarSenha' id='mostrarSenhaEx' onclick='mostrarSenha(1)'>
                <input class='dados-msg' autocomplete='off' style='border-radius: 1vh 1vh 0vh 0vh' type='password' onkeyup='preencherSenha(), aspas(this)' maxlength='30' placeholder='Nova senha' id='senhaRedefinir'><br>
                <input class='mostrarSenha' id='mostrarSenha' onclick='mostrarSenha(2)'>"
            ;
        }

        public function trocarApelido(){
            $user = new usuario(codigoSessao(1));

            return 
                "<p class='dados-msg' style='background: rgb(28, 115, 230); color: white;'>$user->apelido</p>
                <input class='dados-msg' autocomplete='off' type='text' onkeyup='preencherApelido(), apelido(this)' maxlength='8' placeholder='Novo apelido' id='apelidoRedefinir'>"
            ;
        }
    }

    class Semana{
        public function __construct(){
            $pesquisa = new Banco();
            $atual = $pesquisa->Consultar("select cd_semana from tb_semana where CURDATE() >= dt_inicio and CURDATE() <= dt_fim");
            $proxima = $pesquisa->Consultar("select min(dt_inicio), cd_semana from tb_semana where dt_inicio > CURDATE()");
            
            if(isset($atual[0]) == true){
                $this->codigoAtual = $atual[0];
            }
            else{
                $this->codigoAtual = null;
            }

            if(isset($proxima[1]) == true){
                $this->codigoProxima = $proxima[1];
            }
            else{
                $this->codigoProxima = "1901";
            }
        }
    }

    class Time{
        public function __construct() {
            $this->banco = new Banco();
        }

        public function getDadosTime($codigo){
            $infos = $this->banco->Consultar("select * from tb_time where cd_time = $codigo;");
            
            $this->codigo = $infos[0];
            $this->nome = $infos[1];
            $this->imagem = $infos[2];
        }
    }

    class LigaCustomizada{
        public function __construct() {
            $this->banco = new Banco();
            $user = new usuario(codigoSessao(1));
            $this->usuario = codigosessao(1);
            $this->saldo = $user->dragonitas;
        }

        public function getLigaCodigo($codigo){
            $infos = $this->banco->Consultar(" SELECT cd_liga_customizada FROM tb_liga_customizada WHERE cd_liga_key = '$codigo';");
            if(isset($infos[0]) == true){
                return $infos[0];
            }
            else{
                return "Liga não encontrada!";
            }
        }

        public function exibirDisponivel(){
            $infos = $this->banco->Consultar(" SELECT * FROM tb_liga_customizada WHERE cd_liga_customizada NOT IN(SELECT cd_liga_customizada FROM ordem_customizada WHERE cd_usuario = $this->usuario) and ic_privacidade != 1;");

            echo 
                "<input type='text' class='codigo-liga' maxlength='40' onkeyup='apelido(this)' onkeypress='if(event.keyCode == 13){pesquisar(this);}' placeholder='Código'>
                <div class='holder-dado' style='margin-top: 4vh;'>
                    <p class='dado'>Ligas públicas:</p>
                </div>"
            ;
            if(count(array_chunk($infos, 6)) > 0){
                foreach(array_chunk($infos, 6) as $Row=>$info){
                    echo "<p class='nome-liga' onclick='infoLigaCustom(this)' id='$info[0]'>$info[1]</p>";
                }
            }
            else{
                echo "<p style='font-size: 5vh; margin-top: 2vh;'>Não há ligas disponíveis no momento.</p>";
            }
        }

        public function setDadosLiga($codigo){
            $this->getDadosLiga($codigo);

            $ordemUser = $this->banco->Consultar("select cd_liga_customizada from ordem_customizada where cd_liga_customizada = $codigo and cd_usuario = $this->usuario;");

            echo 
                "<div class='holder-dado'>
                    <p class='nome-dado'>Liga:</p>
                    <p class='dado'>".$this->nome."</p>
                </div>
                <div class='holder-dado'>
                    <p class='nome-dado'>Limite de usuários:</p>
                    <p class='dado'>".$this->usuarios."/".$this->limite."</p>
                </div>
                <div class='holder-dado'>
                    <p class='nome-dado'>Rodadas:</p>
                    <p class='dado'>".$this->rodadas."</p>
                </div>"
            ;
            if(isset($ordemUser[0]) == false){
                if($this->saldo >= $this->preco){
                    echo
                        "<div class='holder-dado'>
                            <p class='entrar' onclick='confirmarEntrar(this)' id='$this->codigo'>Entrar - ".$this->preco."dg</p>
                        </div>"
                    ;
                }
                else{
                    echo
                        "<div class='holder-dado'>
                            <p class='entrar-indis' style='background: rgb(170, 0, 0); border-color: rgb(170, 0, 0); color: white;'>".($this->preco - $this->saldo)."dg restantes</p>
                        </div>"
                    ;
                }
            }
            else{
                echo
                    "<div class='holder-dado'>
                        <p class='entrar-indis'>Participando</p>
                    </div>"
                ;
            }

            $this->setLigaRanking($codigo);
        }

        function existeLiga($nome){
            $codigo = $this->banco->Consultar("select cd_liga_customizada from tb_liga_customizada where nm_liga_customizada = '$nome'");

            if(isset($codigo[0]) == true){
                return "Este nome já se encontra em uso!";
            }
        }

        public function exibirCriarLiga(){
            echo
                "<p id='error-liga'>&nbsp;</p>
                <input type='text' id='nome-criar' placeholder='Nome da liga' class='text-criar' onkeyup='validarNome(this), apelido(this)' maxlength='30' style='margin-top: 0vh;'>
                <select class='text-criar' id='select-participantes' onchange='valorLiga()'>
                    <option value=''>Participantes</option>
                    <option value='8'>8</option>
                    <option value='16'>16</option>
                    <option value='24'>24</option>
                    <option value='32'>32</option>
                    <option value='40'>40</option>
                    <option value='48'>48</option>
                    <option value='56'>56</option>
                    <option value='64'>64</option>
                    <option value='72'>72</option>
                    <option value='80'>80</option>
                </select>
                <select class='text-criar' id='select-rodadas' onchange='valorLiga()'>
                    <option value=''>Rodadas</option>"
            ;

            for($x = 1; $x <= 21; $x++){
                echo "<option value='$x'>$x</option>";
            }

            echo 
                "</select>
                <div id='privado-info'>
                    <p style='font-size: 4.5vh;' id='privado-p'><input type='checkbox' id='check-criar' onclick='gerarCodigo(this), valorLiga()'>&nbsp;Privado</p>
                    <input type='text' class='text-criar' id='codigo-liga' onkeydown='return false;' onclick='this.select()' style='display: none; caret-color: transparent;'>
                </div>"
            ;
            echo
                "<div class='holder-dado' style='padding-top: 4vh'>
                    <p class='entrar' onclick='confirmarLiga()' id='criar-liga'>200dg</p>
                </div>"
            ;
        }

        public function setLigaRanking($codigo){
            $infos = $this->banco->Consultar("select tb_usuario.nm_apelido, ordem_customizada.qt_pontos as 'pontos' from ordem_customizada join tb_usuario where ordem_customizada.cd_liga_customizada = $codigo and tb_usuario.cd_usuario = ordem_customizada.cd_usuario order by pontos desc;");

            $count = 0;
            echo "<p class='nome-dado' style='font-size: 4.5vh; margin-top: 2vh;'>Ranking:</p>";
            foreach(array_chunk($infos, 2) as $Row=>$info){
                $count++;
                if($count == 1){
                    if($count == count(array_chunk($infos, 2))){
                        echo "<p class='dado-ranking' style='border-radius: 1vh;' align='left'>".$count.". ".$info[0]." - ".$info[1]."pts</p>";
                    }
                    else{
                        echo "<p class='dado-ranking' style='border-radius: 1vh 1vh 0vh 0vh;' align='left'>".$count.". ".$info[0]." - ".$info[1]."pts</p>";
                    }
                    
                }
                else{
                    if($count == count(array_chunk($infos, 2))){
                        echo "<p class='dado-ranking' style='border-radius: 0vh 0vh 1vh 1vh;' align='left'>".$count.". ".$info[0]." - ".$info[1]."pts</p>";
                    }
                    else{
                        echo "<p class='dado-ranking' align='left'>".$count.". ".$info[0]." - ".$info[1]."pts</p>";
                    }
                }
            }
        }

        function setRankingLigas(){
            $infos = $this->banco->Consultar("select sum(ordem_customizada.qt_pontos) as 'pontos', tb_liga_customizada.cd_liga_customizada, tb_liga_customizada.nm_liga_customizada, count(ordem_customizada.qt_pontos) from tb_usuario join ordem_customizada join tb_liga_customizada where tb_usuario.cd_usuario = ordem_customizada.cd_usuario and ordem_customizada.cd_liga_customizada = tb_liga_customizada.cd_liga_customizada and tb_liga_customizada.ic_privacidade = 0 group by tb_liga_customizada.cd_liga_customizada order by pontos desc limit 0,10;");

            $count = 0;
            echo "<p class='nome-dado' style='font-size: 4.5vh; margin-top: 2vh;'>Ranking:</p>";
            foreach(array_chunk($infos, 4) as $Row=>$info){
                $count++;
                if($count == 1){
                    if($count ==  count(array_chunk($infos, 4))){
                        echo "<p class='dado-ranking' style='border-radius: 1vh; width: 56%;' align='left'>".$count.". ".$info[2]."</p>";
                    }
                    else{
                        echo "<p class='dado-ranking' style='border-radius: 1vh 1vh 0vh 0vh; width: 56%;' align='left'>".$count.". ".$info[2]."</p>";
                    }
                    
                }
                else{
                    if($count == count(array_chunk($infos, 4))){
                        echo "<p class='dado-ranking' style='border-radius: 0vh 0vh 1vh 1vh; width: 56%;' align='left'>".$count.". ".$info[2]."</p>";
                    }
                    else{
                        echo "<p class='dado-ranking' style='width: 56%;' align='left'>".$count.". ".$info[2]."</p>";
                    }
                }
            }
        }

        public function getDadosPontuada(){
            $infos = $this->banco->Consultar("select sum(ordem_customizada.qt_pontos) as 'pontos', tb_liga_customizada.cd_liga_customizada, tb_liga_customizada.nm_liga_customizada from tb_usuario join ordem_customizada join tb_liga_customizada where tb_usuario.cd_usuario = ordem_customizada.cd_usuario and ordem_customizada.cd_liga_customizada = tb_liga_customizada.cd_liga_customizada group by tb_liga_customizada.cd_liga_customizada order by pontos desc;");

            if(isset($infos[0]) == true){
                $this->pontos = $infos[0];
                $this->nome = $infos[2];
            }
        }

        public function getDadosLiga($codigo){
            $infos = $this->banco->Consultar("SELECT count(cd_usuario), tb_liga_customizada.* FROM ordem_customizada join tb_liga_customizada where ordem_customizada.cd_liga_customizada = $codigo and tb_liga_customizada.cd_liga_customizada = ordem_customizada.cd_liga_customizada;");

            $this->codigo = $infos[1];
            $this->nome = $infos[2];
            $this->usuarios = $infos[0];
            $this->limite = $infos[4];
            $this->rodadas = $infos[3];
            if($infos[4] == 1){
                $this->preco = (($infos[3] * 10) + ($infos[4] * 5) + 400);
            }
            else{
                $this->preco = (($infos[3] * 10) + ($infos[4] * 5) + 200);
            }
        }

        public function getLigasPrivadas($codigo){
            $infos = $this->banco->Consultar("Select tb_liga_customizada.nm_liga_customizada, tb_liga_customizada.cd_liga_customizada from tb_liga_customizada join ordem_customizada where ordem_customizada.cd_usuario = $codigo and tb_liga_customizada.cd_liga_customizada = ordem_customizada.cd_liga_customizada and tb_liga_customizada.ic_privacidade = 0;");
            
            if(isset($infos[0]) == true){
                foreach(array_chunk($infos, 2) as $Row=>$info){
                    echo "<p class='nome-liga' onclick='infoLigaCustom(this)' id='$info[1]'>$info[0]</p>";
                }
            }
            else{
                echo "<p style='font-size: 4.5vh; color: black; margin-top: 4vh; padding: 1vh; border-radius: 5vh; background: #eee; width: 90%; max-width: 50vh;'>Não participa de nenhuma.</p>";
            }
        }

        public function getLigas(){
            $infos = $this->banco->Consultar("Select tb_liga_customizada.nm_liga_customizada, tb_liga_customizada.cd_liga_customizada from tb_liga_customizada join ordem_customizada where ordem_customizada.cd_usuario = $this->usuario and tb_liga_customizada.cd_liga_customizada = ordem_customizada.cd_liga_customizada;");
            
            if(isset($infos[0]) == true){
                foreach(array_chunk($infos, 2) as $Row=>$info){
                    echo "<p class='nome-liga' onclick='infoLigaCustom(this)' id='$info[1]'>$info[0]</p>";
                }
            }
            else{
                echo "<p style='font-size: 4.5vh; color: black; margin-top: 4vh; padding: 1vh; border-radius: 5vh; background: #eee; width: 90%; max-width: 50vh;'>Não participa de nenhuma.</p>";
            }
        }
    }

    class LigaPatrocinada{
        public function __construct() {
            $this->banco = new Banco();
            $user = new usuario(codigoSessao(1));
            $this->usuario = codigosessao(1);
        }

        public function setDadosLiga($codigo){
            $this->getDadosLiga($codigo);

            echo 
                "<div class='holder-dado'>
                    <p class='nome-dado'>Liga:</p>
                    <p class='dado'>$this->nome</p>
                </div>
                <div class='holder-dado'>
                    <p class='nome-dado'>Patrocinador:</p>
                    <p class='dado'>$this->patrocinador</p>
                </div>"
            ;

            $this->setLigaRanking($codigo);
        }

        public function setLigaRanking($codigo){
            $infos = $this->banco->Consultar("select tb_usuario.nm_apelido, ordem_patrocinada.qt_pontos as 'pontos' from ordem_patrocinada join tb_usuario where ordem_patrocinada.cd_liga_patrocinio = $codigo and tb_usuario.cd_usuario = ordem_patrocinada.cd_usuario order by pontos desc;");

            $count = 0;
            echo "<p class='nome-dado' style='font-size: 4.5vh; margin-top: 2vh;'>Ranking:</p>";
            foreach(array_chunk($infos, 2) as $Row=>$info){
                $count++;
                if($count == 1){
                    if($count == count(array_chunk($infos, 2))){
                        echo "<p class='dado-ranking' style='border-radius: 1vh;' align='left'>".$count.". ".$info[0]." - ".$info[1]."pts</p>";
                    }
                    else{
                        echo "<p class='dado-ranking' style='border-radius: 1vh 1vh 0vh 0vh;' align='left'>".$count.". ".$info[0]." - ".$info[1]."pts</p>";
                    }
                }
                else{
                    if($count == count(array_chunk($infos, 2))){
                        echo "<p class='dado-ranking' style='border-radius: 0vh 0vh 1vh 1vh;' align='left'>".$count.". ".$info[0]." - ".$info[1]."pts</p>";
                    }
                    else{
                        echo "<p class='dado-ranking' align='left'>".$count.". ".$info[0]." - ".$info[1]."pts</p>";
                    }
                }
            }
        }

        public function getDadosPontuada(){
            $infos = $this->banco->Consultar("select sum(ordem_patrocinada.qt_pontos) as 'pontos', tb_liga_patrocinio.cd_liga_patrocinio, tb_liga_patrocinio.nm_liga_patrocinio from tb_usuario join ordem_patrocinada join tb_liga_patrocinio where tb_usuario.cd_usuario = ordem_patrocinada.cd_usuario and ordem_patrocinada.cd_liga_patrocinio = tb_liga_patrocinio.cd_liga_patrocinio group by tb_liga_patrocinio.cd_liga_patrocinio order by pontos desc;");

            $this->pontos = $infos[0];
            $this->nome = $infos[2];
        }

        public function getCodigoLiga($codigo){
            $info = $this->banco->Consultar("select cd_liga_patrocinio from ordem_patrocinada where cd_usuario = $codigo;");

            if(isset($info[0]) == true){
                return $info[0];
            }
        }

        public function getDadosLiga($codigo){
            $infos = $this->banco->Consultar("Select * from tb_liga_patrocinio join tb_patrocinador where tb_liga_patrocinio.cd_liga_patrocinio = $codigo and tb_patrocinador.cd_patrocinador = tb_liga_patrocinio.cd_patrocinador;");

            if(isset($infos[0]) == true){
                $this->codigo = $infos[0];
                $this->nome = $infos[1];
                $this->patrocinador = $infos[3];
            }
        }
        
    }

    class Icone{
        public function __construct() {
            $this->banco = new Banco();
        }

        public function getDadosIcone($codigo){
            $infos = $this->banco->Consultar("SELECT * FROM tb_icone where cd_icone = $codigo");

            $this->codigo = $infos[0];
            $this->nome = $infos[1];
            $this->imagem = $infos[2];
            $this->raridade = $infos[3];
            if($this->raridade == 4){
                $this->preco = ($this->raridade * $this->raridade) * 500;
            }
            else{
                $this->preco = ($this->raridade * $this->raridade) * 100;
            }
            if($this->raridade == 1){
                $this->classe = "Comum";
                $this->classeIMG = "/img/raio-comum.png";
            }
            else{
                if($this->raridade == 2){
                    $this->classe = "Intermediário";
                    $this->classeIMG = "/img/raio-raro.png";
                }
                else{
                    if($this->raridade == 3){
                        $this->classe = "Épico";
                        $this->classeIMG = "/img/raio-epico.png";
                    }
                    else{
                        $this->classe = "Lendário";
                        $this->classeIMG = "/img/raio-lendario.png";
                    }
                }
            }
        }

        public function getIconesObtidos(){
            $user = new usuario(codigoSessao(1));
            
            $infos = $this->banco->Consultar("SELECT cd_icone, nm_path FROM tb_icone WHERE cd_icone IN(SELECT cd_icone FROM ordem_icone WHERE cd_usuario = $user->codigo);");

            $idIcone = 0;
            foreach(array_chunk($infos, 2) as $row=>$dado){
                $idIcone++;
                echo "<div style='padding: 2vh; display: inline-block;'><img onclick='select_icon(this)' id='".$idIcone."' name='".$dado[0]."' src='".$dado[1]."' class='icone'></div>";
            }      
        }

        public function getIconeDisponivel($usuario, $dragonitas){
            $infos = $this->banco->Consultar("SELECT cd_icone FROM tb_icone WHERE cd_icone NOT IN(SELECT cd_icone FROM ordem_icone WHERE cd_usuario = $usuario)");

            $this->quantidade = 0;
            foreach($infos as $dado){
                $this->getDadosIcone($dado[0]);
                $this->exibirDisponivel($dragonitas);
                $this->quantidade += 1;
            }

            if($this->quantidade == 0){
                echo "<p style='font-size: 5vh; color: white; padding-bottom: 6vh;'>Você já possui todos os ícones.</p>";
            }
        }

        public function exibirDisponivel($dragonitas){
            echo
                "<div class='holder-item'>
                    <div class='item' id='$this->codigo'>
                        <img alt='Ícone disponível para compra' class='foto-item' src='$this->imagem'>
                        <div class='info-item'>
                        <p class='nome-item' style='margin-top: 0vh'>$this->nome</p>
                            <p class='nome-item' style='margin-top: 0vh'>$this->classe, $this->preco"."dg</p>";
                            if($dragonitas >= $this->preco){
                                echo "<div class='comprar-item' onclick='confirmarIcone(this)' id='$this->codigo'>+</div>";
                            }
                            else{
                                echo "<div class='comprar-indisponivel' id='$this->codigo'>-</div>";
                            }
                            echo "<div class='raridade-item'><img src='$this->classeIMG'></div>";
                            echo
                        "</div>
                    </div>
                </div>";
        }

        public function exibirIconeGratuito(){
            $icone = $this->banco->Consultar("select cd_icone, nm_path from tb_icone where qt_raridade = 1");

            $idIcone = 0;
            foreach(array_chunk($icone, 2) as $row=>$dado){
                $idIcone++;
                echo "<div style='padding: 2vh; display: inline-block;'><img onclick='select_icon(this)' id='".$idIcone."' name='".$dado[0]."' src='".$dado[1]."' class='icone'></div>";
            }      
        }
    }
?>