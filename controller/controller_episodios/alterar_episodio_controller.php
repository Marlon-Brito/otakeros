<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../../config/conectar.php';
    require_once __DIR__ . '/../../model/episodio_model.php';
    require_once __DIR__ . '/../../controller/funcoes.php';

    iniciarSessao(); // Inicia a sessão senão existir uma
    protegerPagina(1); // Só adms são permitidos nesta página

    // Começa a atualização de episódio caso os novos dados tenham sido enviados via o formulário (post)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_episodio = $_POST['id'] ?? null;
        $id_anime = $_POST['id_anime'] ?? null;
        $erros = [];

        if (empty($id_episodio)) $erros[] = "ID do episódio inválido.";

        // Busca o episódio pelo seu id
        $episodio = buscarEpisodioPorId($pdo, $id_episodio);
        // Pega o antigo vídeo do episódio senão o deixa sem
        $video_antigo = $episodio['video_url_episodio'] ?? '';

        // Upload do vídeo se ocorrer
        if (!empty($_FILES['video']['name'])) {
            $ext = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));
            $permitidos = ['mp4', 'mkv', 'avi', 'mov'];

            if (in_array($ext, $permitidos)) {
                $video = $episodio['video_url_episodio'];
                $destino = __DIR__ . "/../../assets/videos/" . $video;

                // Apaga o vídeo antigo caso exista e não estiver vazio
                if (!empty($video_antigo) && file_exists(__DIR__ . "/../../assets/videos/$video_antigo")) {
                    unlink(__DIR__ . "/../../assets/videos/$video_antigo");
                }

                move_uploaded_file($_FILES['video']['tmp_name'], $destino);

                // Atualiza apenas o vídeo do episódio
                atualizarVideoEpisodio($pdo, $id_episodio, $video);

                header('Location: ../../index.php?page=dados_episodios&id_anime=' . $id_anime . '&alteracao=ok');
                exit;
            } else {
                $erros[] = "Formato de vídeo não permitido. Use: mp4, mkv, avi ou mov.";
            }
        } else {
            $erros[] = "Nenhum vídeo foi enviado.";
        }

        // Verifica se há erros, os guarda na sessão e redireciona/envia para exibição
        if (!empty($erros)) {
            $_SESSION['erros_atualizar'] = $erros;
            header("Location: ../../index.php?page=editar_episodio&id_episodio=$id_episodio&alteracao=erro");
            exit;
        }
    }

    // Buscando vídeo e carregando seus dados na página de edição caso receba seu id como parâmetro na URL (get)
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_episodio'])) {
        $id_episodio = $_GET['id_episodio'] ?? null;
        $episodio = buscarEpisodioPorId($pdo, $id_episodio);
        $anime = $episodio['id_anime'] ?? null;

        if (!$episodio || !$anime) {
            header("Location: ../../index.php?page=dados_episodios&erro=Episódio não encontrado");
            exit;
        }

        // Ao encontrá-lo já processa o caminho do vídeo
        $video_url = $episodio['video_url_episodio'];
        $caminho_video = (!isset($video_url) || empty($video_url) || !file_exists(__DIR__ . "/../../assets/videos/$video_url")) 
            ? "../../assets/imgs/icone-quadro.png" 
            : "../../assets/videos/$video_url"
        ;

        // Carrega a interface passando os dados
        include __DIR__ . '/../../view/pagina_alterar_episodio.php';
    }
?>
