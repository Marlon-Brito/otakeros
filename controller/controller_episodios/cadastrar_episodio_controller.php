<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../../config/conectar.php';
    require_once __DIR__ . '/../../model/anime_model.php';
    require_once __DIR__ . '/../../model/episodio_model.php';
    require_once __DIR__ . '/../funcoes.php';

    iniciarSessao(); // Inicia a sessão senão existir uma
    protegerPagina(1); // Só adms são permitidos nesta página

    // Começa o cadastro de episódio caso os dados tenham sido enviados via o formulário (post)
    if (isset($_POST["btn_enviar"])) {
        // Obtém uma variável externa especificada pelo nome (por exemplo, da entrada do formulário) e, opcionalmente, a filtra
        // Este é usado para validar o valor como inteiro
        $id_anime = filter_input(INPUT_POST, 'anime', FILTER_VALIDATE_INT);
        $numero = filter_input(INPUT_POST, 'numero', FILTER_VALIDATE_INT);
        $video = '';
        $erros = [];

        // Validações
        if (empty($numero)) {
            $erros[] = "Número do episódio obrigatório!";
        }

        // Verifica se há erros, os guarda na sessão e redireciona/envia para exibição
        if (!empty($erros)) {
            $_SESSION['erros_cadastro'] = $erros;
            header("Location: ../../index.php?page=cadastrar_episodio&id_anime=$id_anime");
            exit;
        }

        // Verificar se o número do episódio já existe para este anime
        $existe = verificarNumeroEpisodioExiste($pdo, $id_anime, $numero);

        if ($existe) {
            $_SESSION['erros_cadastro'] = ["Já existe um episódio número {$numero} para este anime."];
            header("Location: ../../index.php?page=cadastrar_episodio&id_anime=$id_anime");
            exit;
        }

        // Buscar o nome do anime para gerar o nome do episódio
        $anime = buscarNomeDoAnime($pdo, $id_anime);

        if (!$anime) {
            $_SESSION['erros_cadastro'] = ["Anime não encontrado."];
            header("Location: ../../index.php?page=cadastrar_episodio&id_anime=$id_anime");
            exit;
        }

        // Remove acentos do nome do anime
        $nomeSemAcento = removerAcentos($anime['nome_anime']);
        // Remove espaços e o transforma para minúsculo
        $nomeAnimeFormatado = strtolower(str_replace(' ', '', $nomeSemAcento));
        $nomeEpisodio = $anime['nome_anime'] . " - Episódio " . $numero;

        // Verificar e validar o vídeo antes de inserir se enviado
        if (!empty($_FILES['video']['name'])) {
            $ext = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
            $permitidos = ['mp4', 'avi', 'mkv', 'mov'];

            if (!in_array(strtolower($ext), $permitidos)) {
                $_SESSION['erros_cadastro'] = ["Formato de vídeo inválido. Apenas: mp4, avi, mkv, mov."];
                header("Location: ../../index.php?page=cadastrar_episodio&id_anime=$id_anime");
                exit;
            }

            // Tratando nomenclatura do vídeo
            $video = "{$id_anime}-{$nomeAnimeFormatado}-episodio-{$numero}.{$ext}";
        } else {
            $_SESSION['erros_cadastro'] = ["Você precisa selecionar um arquivo de vídeo para o episódio."];
            header("Location: ../../index.php?page=cadastrar_episodio&id_anime=$id_anime");
            exit;
        }

        // Agora sim cadastrar o episódio
        if (inserirEpisodio($pdo, $numero, $nomeEpisodio, $video, $id_anime)) {
            $id_novo_episodio = $pdo->lastInsertId();
            $destino = __DIR__ . "/../../assets/videos/" . $video;

            if (move_uploaded_file($_FILES['video']['tmp_name'], $destino)){
                // Atualiza o vídeo no banco
                atualizarVideoEpisodio($pdo, $id_novo_episodio, $video);
            }

            header('Location: ../../index.php?page=dados_episodios&id_anime=' . $id_anime . '&cadastro=ok');
            exit;
        // Erro de cadastro
        } else {
            $_SESSION['erros_cadastro'] = ['Erro ao cadastrar episódio.'];
            header("Location: ../../index.php?page=cadastrar_episodio&id_anime=$id_anime&cadastro=erro");
            exit;
        }
    }
?>
