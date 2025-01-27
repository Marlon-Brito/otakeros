<?php
    // Conexão com o Banco de Dados
    include "../../model/conectar.php";

    // Selecionando os campos através dos arrays de POST que vem com as propriedades NAME do form
    $id_episodio = $_POST["id"];
    $numero = $_POST["numero"];
    $nome = $_POST["nome"];
    $nome_anime = $_POST["nome_anime"];
    $id_anime = $_POST["id_anime"];

    // Pesquisando o vídeo do episódio que tem o mesmo id que veio do form
    $dados = $sql -> query("SELECT video_url_episodio FROM episodio WHERE id_episodio = $id_episodio");

    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
    while ($linha = mysqli_fetch_array($dados)){
        $video_episodio = $linha["video_url_episodio"];
    }

    // Isso tudo para deletar seu vídeo atual e fazer upload do novo ao alterar
    unlink("./video/$video_episodio");
   
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
                $new_video_name = $id_anime . '-' . $nome_anime_lc . '-episodio-' . $numero . '.' . $video_ex_lc;
                $video_upload_path = './video/' . $new_video_name;
                // Fazer upload do arquivo de fato para depois colocar o caminho do vídeo dentro do banco
                move_uploaded_file($tmp_name, $video_upload_path);

                // Alterar os dados do episódio no banco
                $sql -> query("UPDATE episodio SET
                    id_numero_episodio = '$numero', 
                    nome_episodio = '$nome', 
                    video_url_episodio = '$new_video_name',
                    id_anime = '$id_anime'
                    WHERE id_episodio = $id_episodio
                ");
            }else{
                // Senão é porque o seu tipo não é permitido
                echo "<script>alert('Sem vídeo ou Tipo do arquivo não é permitido! Não foi possível concluir o upload do vídeo...');</script>";
            }
        }
    // Senão retornará
    }else{
        header("Location: ../controller_episodios/listar_episodios.php?id_anime=$id_anime");
    }
    
    // Redirecionar para a lista de episódios
    echo "<script>alert('Episódio alterado com sucesso!');</script>";
    echo "<script>location.href='../controller_episodios/listar_episodios.php?id_anime=$id_anime';</script>";
?>