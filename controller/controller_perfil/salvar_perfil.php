<?php
    // Conexão com o Banco de Dados
    include "../../model/conectar.php";

    // Selecionando os campos através dos arrays de POST que vem com as propriedades NAME do form
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Se clicar no botão fará o processamento e depois tratamento dos dados
    if (isset($_POST["btn_enviar"])){
        // Array de erros que armazenará as mensagens de erro
        $erros = [];

        // Sanitizar ou limpeza dos dados como primeira validação
        // Retirando conteúdos não adequados para o sistema dos campos
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $idade = filter_input(INPUT_POST, 'idade', FILTER_SANITIZE_NUMBER_INT);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        // Filtros validate após sanitizar como segunda validação
        // Caso os tipos de dados não forem válidos adicionará um erro
        if (!filter_var(($idade), FILTER_VALIDATE_INT)){
            $erros[] = "Idade precisa ser um número!";
        }

        if (!filter_var(($email), FILTER_VALIDATE_EMAIL)){
            $erros[] = "E-mail inválido!";
        }

        // Se os campos estiverem vazios também adicionará um erro
        if (empty($nome)){
            $erros[] = 'Necessário preencher o nome!';
        }
        if (empty($idade)){
            $erros[] = 'Necessário preencher a idade!';
        }
        if (empty($email)){
            $erros[] = 'Necessário preencher o e-mail!';
        }
        if (empty($senha)){
            $erros[] = 'Necessário preencher a senha!';
        } 

        // Se tiver erros irá exibi-los senão estará tudo certo
        if (!empty($erros)){
            foreach ($erros as $erro){
                echo "<li class='erros'>$erro</li>";
            }
            
            echo '<div class="btns">
                <a href="./cadastrar_perfil.php" id="btn__voltar--cadastro">Voltar ao Cadastro</a>
        
                <a href="../../index.php" id="btn__voltar--inicio">Voltar ao Início</a>
            </div>';
        }else{
            // Pesquisando tudo do usuário verificando se o e-mail informado já está cadastrado
            $testar = $sql -> query("SELECT * FROM usuario WHERE email = '$email' ");

            // Obtém o número de linhas no conjunto de resultados
            $check = mysqli_num_rows($testar);

            // Se a verificação for positiva irá mostrar uma mensagem de erro dizendo que o usuário já está cadastrado
            if ($check == 1){
                echo "<h1 class='aviso'>Usuário já Cadastrado!</h1>";
                
                echo '<div class="btns">
                    <a href="./cadastrar_perfil.php" id="btn__voltar--cadastro">Voltar ao Cadastro</a>
            
                    <a href="../../index.php" id="btn__voltar--inicio">Voltar ao Início</a>
                </div>';
            }
            // Senão irá pegar as informações deste usuário e cadastrá-lo
            else{
                // Controle do envio do arquivo de upload
                if(isset($_POST['btn_enviar'])){
                    $tipos_permitidos = ['jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG'];
                    $extensao = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

                    // Verificar no array de tipos permitidos se existe a extensão do arquivo
                    if (in_array($extensao, $tipos_permitidos)){
                        $uploaddir = '../../avatar/';
                        $temporario = $_FILES['avatar']['tmp_name'];
                        $uploadfile = $nome . '.' . $extensao;

                        // Fazer upload do arquivo de fato
                        if (move_uploaded_file($temporario, $uploaddir.$uploadfile)){
                            echo '<p>Upload realizado!</p>';
                        }else{
                            echo '<p>Falha no Upload!</p>';
                        }
                    }else{
                        // Senão é porque o seu tipo não é permitido
                        echo "<script>alert('Sem imagem ou Tipo do arquivo não é permitido! Não foi possível concluir o upload da imagem...');</script>";
                        $uploadfile = '';
                    }
                }

                // Redirecionar para o início
                echo "<script>alert('Usuário cadastrado com sucesso!');</script>";
                echo "<script>location.href='../../index.php';</script>";

                // Inserir os dados do perfil do usuário no banco
                $sql -> query("INSERT INTO usuario (id_usuario, nome, idade, email, senha, avatar, id_tipo)
                VALUES (NULL, '$nome', '$idade', '$email', '$senha', '$uploadfile', 2)");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Erro</title>
    <link rel="stylesheet" href="../../estilizacao/erros.css">
</head>
<body>
    <!-- Estilização dos Erros -->
</body>
</html>