<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../model/anime_model.php';

    // Busca os dados dos animes
    $animes = listarTodosAnimes($pdo);

    // Carrega a interface passando os dados
    require_once __DIR__ . '/../view/pagina_home.php'
?>