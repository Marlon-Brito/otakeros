<?php
    // Conexão com o Banco de Dados
    include "../../model/conectar.php";

    // Selecionando os campos através dos arrays de POST que vem com as propriedades NAME do form
    $numero = $_POST["numero"];
    $nome = $_POST["nome"];
    $anime = $_POST["anime"];
    $nome_anime = $_POST["nome_anime"];

    // Se clicar no botão fará o processamento e depois tratamento dos dados
    if (isset($_POST["btn_enviar"])){
        // Array de erros que armazenará as mensagens de erro
        $erros = [];

        // Sanitizar ou limpeza dos dados como primeira validação
        // Retirando conteúdos não adequados para o sistema dos campos
        $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT);
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);

        // Filtros validate após sanitizar como segunda validação
        // Caso os tipos de dados não forem válidos adicionará um erro
        if (!filter_var(($numero), FILTER_VALIDATE_INT)){
            $erros[] = "Número do Episódio precisa ser um número!";
        }

        // Se os campos estiverem vazios também adicionará um erro
        if (empty($numero)){
            $erros[] = 'Necessário preencher o numero!';
        }
        if (empty($nome)){
            $erros[] = 'Necessário preencher o nome!';
        }

        // Se tiver erros irá exibi-los senão estará tudo certo
        if (!empty($erros)){
            foreach ($erros as $erro){
                echo "<li class='erros'>$erro</li>";
            }
        
            echo '<div class="btns">
                <a href="../controller_episodios/cadastrar_episodios.php?id_anime='.$anime.'" id="btn__voltar--cadastro">Voltar ao Cadastro</a>
        
                <a href="../controller_episodios/listar_episodios.php?id_anime='.$anime.'" id="btn__voltar--inicio">Voltar a Lista</a>
            </div>';
        }else{
            // Pesquisando tudo do episódio verificando se o nome informado já está cadastrado
            $testar = $sql -> query("SELECT * FROM episodio WHERE nome_episodio = '$nome' ");

            // Obtém o número de linhas no conjunto de resultados
            $check = mysqli_num_rows($testar);

            // Se a verificação for positiva irá mostrar uma mensagem de erro dizendo que o episódio já está cadastrado
            if ($check == 1){
                echo "<h1 class='aviso'>Episódio já Cadastrado!</h1>";
                
                echo '<div class="btns">
                    <a href="../controller_episodios/cadastrar_episodios.php?id_anime='.$anime.'" id="btn__voltar--cadastro">Voltar ao Cadastro</a>
            
                    <a href="../controller_episodios/listar_episodios.php?id_anime='.$anime.'" id="btn__voltar--inicio">Voltar a Lista</a>
                </div>';
            }
            // Senão irá pegar as informações deste episódio e cadastrá-lo
            else{
                // Controle do envio do arquivo de upload
                if (isset($_POST['btn_enviar']) && isset($_FILES['video'])){
                    $video_name = $_FILES['video']['name'];
                    $tmp_name = $_FILES['video']['tmp_name'];
                    $error = $_FILES['video']['error'];
            
                    // Se não tiver erros irá fazer as configurações do vídeo
                    if ($error === 0){
                        $video_ex = pathinfo($video_name, PATHINFO_EXTENSION); // Pegando a extensão
                        $video_ex_lc = strtolower($video_ex); // Deixando a extensão em minúsculas
                        $allowed_exs = array('mp4', 'm4v', 'webm', 'ogv', 'avi', 'flv'); // Extensões de vídeo permitidas
                        $nome_anime_sem_espacos = str_replace(' ', '', $nome_anime); // Tirando espaços do nome para melhorar a url do vídeo
                        $nome_anime_lc = strtolower($nome_anime_sem_espacos); // Também deixando o nome em minúsculas para melhorar a url do vídeo
            
                        // Verificar no array de tipos permitidos se existe a extensão do arquivo
                        if (in_array($video_ex_lc, $allowed_exs)){
                            $new_video_name = $anime . '-' . $nome_anime_lc . '-episodio-' . $numero . '.' . $video_ex_lc;
                            $video_upload_path = './video/' . $new_video_name;
                            // Fazer upload do arquivo de fato para depois colocar o caminho do vídeo dentro do banco
                            move_uploaded_file($tmp_name, $video_upload_path);
            
                            // Inserir os dados do episódio no banco
                            $sql -> query("INSERT INTO episodio (id_episodio, id_numero_episodio, nome_episodio, video_url_episodio, id_anime)
                            VALUES (NULL, '$numero', '$nome', '$new_video_name', '$anime')");
                        }else{
                            // Senão é porque o seu tipo não é permitido
                            echo "<script>alert('Sem vídeo ou Tipo do arquivo não é permitido! Não foi possível concluir o upload do vídeo...');</script>";
                        }
                    }
                // Senão retornará
                }else{
                    echo "<script>location.href='../controller_episodios/listar_episodios.php?id_anime=$anime';</script>";
                }

                // Redirecionar para a lista de episódios
                echo "<script>alert('Episódio cadastrado com sucesso!');</script>";
                echo "<script>location.href='../controller_episodios/listar_episodios.php?id_anime=$anime';</script>";
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