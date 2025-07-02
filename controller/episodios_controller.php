<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../config/conectar.php';
    require_once __DIR__ . '/../model/anime_model.php';
    require_once __DIR__ . '/../model/episodio_model.php';
    require_once __DIR__ . '/../controller/funcoes.php';

    iniciarSessao(); // Inicia a sessão senão existir uma

    // Obtém uma variável externa especificada pelo nome (por exemplo, de parâmetros na URL) e, opcionalmente, a filtra
    // Sanitiza qualquer entrada, protegendo contra scripts maliciosos. Este remove todos os caracteres ilegais de um número (exceto sinais de + ou de -)
    $id_anime = filter_input(INPUT_GET, 'id_anime', FILTER_SANITIZE_NUMBER_INT);

    // Senão achar o id do anime redireciona
    if (!isset($id_anime)) {
        header('Location: index.php?page=home');
        exit;
    }

    // Busca um anime pelo seu id
    $anime = buscarAnimePorId($pdo, $id_anime);
    // Busca os episódios de um anime pelo seu id
    $episodios = buscarEpisodiosPorAnime($pdo, $id_anime);

    // Senão achar o anime redireciona
    if (!isset($anime)) {
        header('Location: index.php?page=home');
        exit;
    }

    // Carrega a interface passando os dados
    require_once __DIR__ . '/../view/pagina_episodios.php';
?>