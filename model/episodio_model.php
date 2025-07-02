<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../config/conectar.php'; // Todas as funções usam a conexão com o banco uma vez que recebem o objeto PDO

    // Buscando os episódios de um anime
    function buscarEpisodiosPorAnime($pdo, $id_anime) {
        // Busca com filtro
        $sql = "SELECT * FROM episodio WHERE id_anime = ?";
        // Usa ? como marcador posicional, e o valor é passado como array ao executar
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_anime]);
        // Transforma o resultado em array associativo (os dados são retornados com os nomes das colunas como chaves)
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscando um episódio específico de um anime para assistir
    function buscarEpisodio($pdo, $id_anime, $numero_episodio){
        // Filtro que busca episódio baseado no seu id e no id do seu anime
        $sql = "SELECT * FROM episodio WHERE id_anime = ? AND id_numero_episodio = ?";
        // Como tem parâmetros ocorre a preparação da query
        $stmt = $pdo->prepare($sql);
        // Aí passa os seus valores como array ao executar
        $stmt->execute([$id_anime, $numero_episodio]);
        // Retorna apenas uma linha em array associativo
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscando episódio pelo seu ID
    function buscarEpisodioPorId($pdo, $id_episodio){
        // Busca com filtro 
        $sql = "SELECT * FROM episodio WHERE id_episodio = ?";
        // Como tem parâmetro ocorre a preparação da query
        $stmt = $pdo->prepare($sql);
        // Aí passa o seu valor como array ao executar
        $stmt->execute([$id_episodio]);
        // Traz apenas uma linha como array associativo
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscando os vídeos dos episódios de uma anime
    function buscarVideosPorAnime($pdo, $id_anime){
        // Filtra todos os vídeos de episódios que pertençam a um anime
        $sql = "SELECT video_url_episodio FROM episodio WHERE id_anime = ?";
        // Como tem parâmetro ocorre a preparação da query
        $stmt = $pdo->prepare($sql);
        // Aí passa o seu valor como array ao executar
        $stmt->execute([$id_anime]);
        // Retorna um array simples com todos os valores da coluna
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Contanto o número total de episódios de um anime
    function contarEpisodiosPorAnime($pdo, $id_anime){
        // Filtro que verifica quantos episódios um anime tem
        $sql = "SELECT COUNT(*) FROM episodio WHERE id_anime = ?";
        // Como tem parâmetro ocorre a preparação da query
        $stmt = $pdo->prepare($sql);
        // Executa a query com o id do anime fornecido como parâmetro
        $stmt->execute([$id_anime]);
        // Retorna o valor diretamente que representa o número de episódios
        return $stmt->fetchColumn();
    }

    // Verificar se o número de episódio já existe para este anime
    function verificarNumeroEpisodioExiste($pdo, $id_anime, $numero){
        // Filtro que verifica se um episódio já existe para certo anime
        $sql = "SELECT COUNT(*) FROM episodio WHERE id_anime = ? AND id_numero_episodio = ?";
        // Como tem parâmetros ocorre a preparação da query
        $stmt = $pdo->prepare($sql);
        // Aí passa os seus valores como array ao executar
        $stmt->execute([$id_anime, $numero]);
        // Retorna o valor diretamente (ex.: 1, 0, etc)
        return $stmt->fetchColumn();
    }

    // Inserindo episódio para cadastro
    function inserirEpisodio($pdo, $numero, $nome, $video, $id_anime){
        // Insere um novo episódio
        $sql = "INSERT INTO episodio (id_numero_episodio, nome_episodio, video_url_episodio, id_anime) VALUES (?, ?, ?, ?)";
        // A query é preparada aguardando os parâmetros posicionais
        $stmt = $pdo->prepare($sql);
        // Os seus valores passados formam um array ao executar, retornando true ou false indicando sucesso
        return $stmt->execute([$numero, $nome, $video, $id_anime]);
    }

    // Atualizar dados do episódio
    function atualizarEpisodio($pdo, $id_episodio, $numero, $nome, $video) {
        // Atualiza os dados completos de um episódio existente baseado no seu id como filtro
        $sql = "UPDATE episodio 
            SET id_numero_episodio = ?, nome_episodio = ?, video_url_episodio = ?
            WHERE id_episodio = ?
        ";
        // A query é preparada aguardando os parâmetros posicionais
        $stmt = $pdo->prepare($sql);
        // Os seus valores passados formam um array ao executar, retornando true ou false indicando sucesso
        return $stmt->execute([$numero, $nome, $video, $id_episodio]);
    }

    // Atualizando o vídeo do episódio
    function atualizarVideoEpisodio($pdo, $id_episodio, $video){
        // Atualiza o vídeo de um episódio pelo seu id como filtro
        $sql = "UPDATE episodio SET video_url_episodio = ? WHERE id_episodio = ?";
        // A query é preparada aguardando os parâmetros posicionais
        $stmt = $pdo->prepare($sql);
        // Os seus valores passados formam um array ao executar, retornando true ou false indicando sucesso
        return $stmt->execute([$video, $id_episodio]);
    }

    // Excluindo episódio
    function excluirEpisodio($pdo, $id_episodio){
        // Exclui um episódio permanentemente com base no seu id
        $sql = "DELETE FROM episodio WHERE id_episodio = ?";
        // A query é preparada aguardando o parâmetro posicional
        $stmt = $pdo->prepare($sql);
        // O seu valor passado forma um array ao executar, retornando true ou false indicando sucesso
        return $stmt->execute([$id_episodio]);
    }
?>
