<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../config/conectar.php';
    require_once __DIR__ . '/../model/anime_model.php';
    require_once __DIR__ . '/../model/episodio_model.php';
    require_once __DIR__ . '/../controller/funcoes.php';

    iniciarSessao(); // Inicia a sessão senão existir uma

    // Pegando valores via GET do id do anime e do número do episódio
    $id_anime = $_GET['id_anime'] ?? null;
    $numero_episodio = $_GET['numero_episodio'] ?? null;

    // Senão encontrar o id do anime ou o número do episódio redireciona
    if (!$id_anime || !$numero_episodio){
        header("Location: ../index?page=erro_url");
        exit;
    }

    // Buscando um anime pelo seu id
    $anime = buscarAnimePorId($pdo, $id_anime);
    // Buscando um episódio pelo seu número e pelo id do seu anime
    $episodio = buscarEpisodio($pdo, $id_anime, $numero_episodio);

    // Se o anime não estiver definido redireciona
    if (!$anime){
        header("Location: ../index?page=erro_url");
        exit;
    }

    // Variáveis auxiliares para navegação nos episódios do anime
    $episodio_atual = $episodio['numero_episodio'] ?? $numero_episodio;
    $episodio_anterior = max($episodio_atual - 1, 1); // Retorna o maior valor dentre os especificados
    $episodio_posterior = $episodio_atual + 1;

    // Conta a quantidade de episódios que certo anime possui
    $total_episodios = contarEpisodiosPorAnime($pdo, $id_anime);

    // Carrega a interface passando os dados
    require_once __DIR__ . "/../view/pagina_assistir.php";
?>