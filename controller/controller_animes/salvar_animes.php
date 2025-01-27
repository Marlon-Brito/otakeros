<?php
    // Conexão com o Banco de Dados
    include "../../model/conectar.php";

    // Selecionando os campos através dos arrays de POST que vem com as propriedades NAME do form
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];

    // Se clicar no botão fará o processamento e depois tratamento dos dados
    if (isset($_POST["btn_enviar"])){
        // Array de erros que armazenará as mensagens de erro
        $erros = [];

        // Sanitizar ou limpeza dos dados como primeira validação
        // Retirando conteúdos não adequados para o sistema dos campos
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

        // Se os campos estiverem vazios também adicionará um erro
        if (empty($nome)){
            $erros[] = 'Necessário preencher o nome!';
        }
        if (empty($descricao)){
            $erros[] = 'Necessário preencher a descrição!';
        }

        // Se tiver erros irá exibi-los senão estará tudo certo
        if (!empty($erros)){
            foreach ($erros as $erro){
                echo "<li class='erros'>$erro</li>";
            }
        
            echo '<div class="btns">
                <a href="../controller_animes/cadastrar_animes.php" id="btn__voltar--cadastro">Voltar ao Cadastro</a>
        
                <a href="../controller_animes/listar_animes.php" id="btn__voltar--inicio">Voltar a Lista</a>
            </div>';
        }else{
            // Pesquisando tudo do anime verificando se o nome informado já está cadastrado
            $testar = $sql -> query("SELECT * FROM anime WHERE nome_anime = '$nome' ");

            // Obtém o número de linhas no conjunto de resultados
            $check = mysqli_num_rows($testar);

            // Se a verificação for positiva irá mostrar uma mensagem de erro dizendo que o anime já está cadastrado
            if ($check == 1){
                echo "<h1 class='aviso'>Anime já Cadastrado!</h1>";
                
                echo '<div class="btns">
                    <a href="../controller_animes/cadastrar_animes.php" id="btn__voltar--cadastro">Voltar ao Cadastro</a>
            
                    <a href="../controller_animes/listar_animes.php" id="btn__voltar--inicio">Voltar a Lista</a>
                </div>';
            }
            // Senão irá pegar as informações deste anime e cadastrá-lo
            else{
                // Controle do envio do arquivo de upload
                if(isset($_POST['btn_enviar'])){
                    $tipos_permitidos = ['jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG'];
                    $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);

                    // Verificar no array de tipos permitidos se existe a extensão do arquivo
                    if (in_array($extensao, $tipos_permitidos)){
                        $uploaddir = './imagem/';
                        $temporario = $_FILES['imagem']['tmp_name'];
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

                // Redirecionar para a lista de animes
                echo "<script>alert('Anime cadastrado com sucesso!');</script>";
                echo "<script>location.href='../controller_animes/listar_animes.php';</script>";

                // Inserir os dados do anime no banco
                $sql -> query("INSERT INTO anime (id_anime, nome_anime, descricao_anime, imagem_anime)
                VALUES (NULL, '$nome', '$descricao', '$uploadfile')");
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
    </style>
</head>
<body>
    <!-- Estilização dos Erros -->
</body>
</html>