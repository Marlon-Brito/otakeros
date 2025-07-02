<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../../model/episodio_model.php';

    // Começará a exclusão caso tenha encontrado o ID do episódio
    if (isset($_GET['id_episodio']) && !empty($_GET['id_episodio'])) {
        $id_episodio = $_GET['id_episodio'];

        // Buscar o episódio para pegar o seu vídeo
        $episodio = buscarEpisodioPorId($pdo, $id_episodio);
        $video = $episodio['video_url_episodio'];

        // Excluir episódio
        $sucesso = excluirEpisodio($pdo, $id_episodio);

        if ($sucesso) {
            // Excluir o vídeo se existir e não for vazio
            if (!empty($video) && file_exists(__DIR__ . "/../../assets/videos/$video")) {
                unlink(__DIR__ . "/../../assets/videos/$video");
            }

            // Redireciona com feedback caso a exclusão dê certo
            header('Location: ../../index.php?page=dados_episodios&id_anime=' . $episodio['id_anime'] . '&excluido=1');
            exit;
        } else {
            // Redireciona com feedback caso a exclusão dê errado
            header('Location: ../../index.php?page=dados_episodios&id_anime=' . $episodio['id_anime'] . '&erro=1');
            exit;
        }
    // Caso contrário não vai excluir e dará erro
    } else {
        header('Location: ../../index.php?page=dados_animes&erro=1');
        exit;
    }
?>
