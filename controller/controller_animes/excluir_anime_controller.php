<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../../model/anime_model.php';
    require_once __DIR__ . '/../../model/episodio_model.php';

    // Começará a exclusão caso tenha encontrado o ID do anime
    if (isset($_GET['id_anime']) && !empty($_GET['id_anime'])) {
        $id_anime = $_GET['id_anime'];

        // Antes de excluir o anime, buscar os vídeos dos episódios dele, assim os deleta e depois o anime
        $videos = buscarVideosPorAnime($pdo, $id_anime);
        // Apagando os vídeos dos episódios em efeito cascata
        foreach ($videos as $video){
            $caminho_video = __DIR__ . "/../../assets/videos/" . $video;
            // Percorrendo cada vídeo e verificando se existem
            if (file_exists($caminho_video)){
                unlink($caminho_video); // Apaga o arquivo
            }
        }

        // Buscar o anime para pegar a sua imagem
        $anime = buscarAnimePorId($pdo, $id_anime);
        $imagem = $anime['imagem_anime'];

        // Excluir anime
        $sucesso = excluirAnime($pdo, $id_anime);

        if ($sucesso) {
            // Excluir a imagem se existir e não for vazia
            if (!empty($imagem) && file_exists(__DIR__ . "/../../assets/animes/$imagem")) {
                unlink(__DIR__ . "/../../assets/animes/$imagem");
            }
            
            // Redireciona com feedback caso a exclusão dê certo
            header('Location: ../../index.php?page=dados_animes&excluido=1');
            exit;
        } else {
            // Redireciona com feedback caso a exclusão dê errado
            header('Location: ../../index.php?page=dados_animes&erro=1');
            exit;
        }
    // Caso contrário não vai excluir e dará erro
    } else {
        header('Location: ../../index.php?page=dados_animes&erro=1');
        exit;
    }
?>
