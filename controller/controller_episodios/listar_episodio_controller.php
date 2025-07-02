<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../../config/conectar.php';
    require_once __DIR__ . '/../../model/episodio_model.php';
    require_once __DIR__ . '/../../controller/funcoes.php';

    protegerPagina(1); // Só adms são permitidos nesta página

    // Obtém uma variável externa especificada pelo nome (por exemplo, de parâmetros na URL) e, opcionalmente, a filtra
    // Filtra uma variável de acordo com um filtro especificado. Este é usado para validar o valor como inteiro
    $id_anime = filter_input(INPUT_GET, 'id_anime', FILTER_VALIDATE_INT);

    // Senão achar o id do anime redireciona
    if (!$id_anime) {
        header("Location: ../../index.php?page=dados_animes&erro=Anime não encontrado");
        exit;
    }

    // Busca os dados dos episódios de determinado anime
    $episodios = buscarEpisodiosPorAnime($pdo, $id_anime);

    // Carrega a interface passando os dados
    require_once __DIR__ . '/../../view/pagina_dados_episodios.php';
?>
