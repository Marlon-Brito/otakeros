<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../../model/anime_model.php';
    require_once __DIR__ . '/../../controller/funcoes.php';

    protegerPagina(1); // Só adms são permitidos nesta página

    // Busca os dados dos animes
    $animes = buscarTodosAnimes($pdo);

    // Carrega a interface passando os dados
    require_once __DIR__ . '/../../view/pagina_dados_animes.php';
?>
