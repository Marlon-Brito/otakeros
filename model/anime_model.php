<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../config/conectar.php'; // Todas as funções usam a conexão com o banco uma vez que recebem o objeto PDO

    // Listando todos os animes por ordem alfabética
    function listarTodosAnimes($pdo){
        // Busca com filtro de ordenação
        $sql = "SELECT * FROM anime ORDER BY nome_anime";
        // Como não há parâmetros, a query executa diretamente sem preparação
        $stmt = $pdo->query($sql);
        // Traz o resultado no modo padrão (PDO::FETCH_BOTH), retorna tanto com chaves associativas (nomes das colunas) quanto com índices numéricos
        return $stmt->fetchAll();
    }

    // Buscando um anime através do seu ID
    function buscarAnimePorId($pdo, $id_anime){
        // Busca com filtro
        $sql = "SELECT * FROM anime WHERE id_anime = ?";
        // Usa ? como marcador posicional, e o valor é passado como array ao executar
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_anime]);
        // Retorna apenas uma linha em array associativo
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscando animes pelo seu nome para filtrá-los
    function buscarAnimesPorNome($pdo, $pesquisa){
        // Filtro que busca um anime com base na string digitada de forma ordenada e com limite
        $sql = "SELECT * FROM anime WHERE nome_anime LIKE ? ORDER BY nome_anime LIMIT 20";
        // Como tem parâmetro ocorre a preparação da query
        $stmt = $pdo->prepare($sql);
        // Aí passa o seu valor com caractere coringa como array ao executar
        $stmt->execute(["%$pesquisa%"]);
        // Traz todas linhas como array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscando todos os animes
    function buscarTodosAnimes($pdo){
        // Busca sem filtro
        $sql = "SELECT * FROM anime";
        // A query executa diretamente sem preparação, porque não há parâmetros
        $stmt = $pdo->query($sql);
        // Transforma o resultado em array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar o nome do anime para gerar o nome do episódio
    function buscarNomeDoAnime($pdo, $id_anime){
        // Filtro que busca nome do anime pelo seu id
        $sql = "SELECT nome_anime FROM anime WHERE id_anime = ?";
        // Como tem parâmetro ocorre a preparação da query
        $stmt = $pdo->prepare($sql);
        // Aí passa o seu valor como array ao executar
        $stmt->execute([$id_anime]);
        // Traz apenas uma linha como array associativo
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Verificando se o anime já existe, caso exista retorna 1 senão retornará "vazio"
    function verificarNomeAnimeExistente($pdo, $nome){
        // Busca com filtro leve só para verificar existência
        $sql = "SELECT 1 FROM anime WHERE nome_anime = ?";
        // Como tem parâmetro ocorre a preparação da query
        $stmt = $pdo->prepare($sql);
        // Aí passa o seu valor como array ao executar
        $stmt->execute([$nome]);
        // Traz apenas uma linha como array associativo
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Inserindo os dados do anime para cadastro
    function inserirAnime($pdo, $nome, $descicao, $imagem){
        // Insere um novo anime
        $sql = "INSERT INTO anime (nome_anime, descricao_anime, imagem_anime) VALUES (?, ?, ?)";
        // A query é preparada aguardando os parâmetros posicionais
        $stmt = $pdo->prepare($sql);
        // Os seus valores passados formam um array ao executar, retornando true ou false indicando sucesso
        return $stmt->execute([$nome, $descicao, $imagem]);
    }

    // Atualizando o anime
    function atualizarAnime($pdo, $id_anime, $nome, $descricao, $imagem){
        // Atualiza os dados completos de um anime existente baseado no seu id como filtro
        $sql = "UPDATE anime 
            SET nome_anime = ?, descricao_anime = ?, imagem_anime = ? 
            WHERE id_anime = ?"
        ;
        // A query é preparada aguardando os parâmetros posicionais
        $stmt = $pdo->prepare($sql);
        // Os seus valores passados formam um array ao executar, retornando true ou false indicando sucesso
        return $stmt->execute([$nome, $descricao, $imagem, $id_anime]);
    }

    // Atualizando a imagem de um anime
    function atualizarImagemAnime($pdo, $id_anime, $imagem){
        // Atualiza a imagem de um anime pelo seu id como filtro
        $sql = "UPDATE anime SET imagem_anime = ? WHERE id_anime = ?";
        // A query é preparada aguardando os parâmetros posicionais
        $stmt = $pdo->prepare($sql);
        // Os seus valores passados formam um array ao executar, retornando true ou false indicando sucesso
        return $stmt->execute([$imagem, $id_anime]);
    }

    // Excluindo anime por ID
    function excluirAnime($pdo, $id_anime){
        // Exclui um anime permanentemente com base no seu id
        $sql = "DELETE FROM anime WHERE id_anime = ?";
        // A query é preparada aguardando o parâmetro posicional
        $stmt = $pdo->prepare($sql);
        // O seu valor passado forma um array ao executar, retornando true ou false indicando sucesso
        return $stmt->execute([$id_anime]);
    }
?>
