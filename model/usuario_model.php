<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../config/conectar.php'; // Todas as funções usam a conexão com o banco uma vez que recebem o objeto PDO

    // Buscando todos dados de usuários
    function buscarTodosUsuarios($pdo){
        // Busca sem filtro
        $sql = "SELECT * FROM usuario";
        // A query executa diretamente sem preparação, porque não há parâmetros
        $stmt = $pdo->query($sql);
        // Transforma o resultado em array associativo (os dados são retornados com os nomes das colunas como chaves)
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar dados do usuário por ID
    function buscarUsuarioPorId($pdo, $id){
        // Busca com filtro
        $sql = "SELECT * FROM usuario WHERE id_usuario = ?";
        // Usa ? como marcador posicional, e o valor é passado como array ao executar
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        // Retorna apenas uma linha em array associativo
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Listando o tipo de usuário para diferenciar admin de espectador
    function listarTiposUsuario($pdo) {
        // Busca sem filtro, sem parâmetros então executa diretamente e traz todas linhas em array associativo
        $sql = "SELECT * FROM tipo_usuario";
        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscando dados do usuário para ele fazer login
    function buscarUsuarioPorEmailSenha($pdo, $email, $senha){
        // Filtro que busca usuário com e-mail e senha exatos
        $sql = "SELECT * FROM usuario WHERE email = :email AND senha = :senha";
        // Usa placeholders nomeados (:email, :senha) como marcadores posicionais, e o valor é passado como array assoc ao executar
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':senha' => $senha,
        ]);
        // Traz apenas uma linha como array associativo
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vendo se o usuário já tem registro
    function verificarEmailExistente($pdo, $email){
        // Filtro que verifica se o e-mail já existe ou não
        $sql = "SELECT COUNT(*) FROM usuario WHERE email = ?";
        // Como tem parâmetro ocorre a preparação da query
        $stmt = $pdo->prepare($sql);
        // Aí passa o seu valor como array ao executar
        $stmt->execute([$email]);
        // Retorna o valor diretamente (ex.: 1, 0, etc)
        return $stmt->fetchColumn() > 0;
    }

    // Insere os dados do usuário para cadastro
    function inserirUsuario($pdo, $nome, $idade, $email, $senha, $avatar){
        // Insere um novo usuário fixo como expectador (tipo = 2)
        $sql = "INSERT INTO usuario (nome, idade, email, senha, avatar, id_tipo) VALUES (?, ?, ?, ?, ?, 2)";
        // A query é preparada aguardando os parâmetros posicionais
        $stmt = $pdo->prepare($sql);
        // Os seus valores passados formam um array ao executar, retornando true ou false indicando sucesso
        return $stmt->execute([$nome, $idade, $email, $senha, $avatar]);
    }

    // Atualizando o usuário
    function atualizarUsuario($pdo, $nome, $idade, $email, $senha, $avatar, $id){
        // Atualiza os dados completos de um usuário existente baseado no seu id como filtro
        $sql = "UPDATE usuario 
            SET nome = ?, idade = ?, email = ?, senha = ?, avatar = ? 
            WHERE id_usuario = ?"
        ;
        // A query é preparada aguardando os parâmetros posicionais
        $stmt = $pdo->prepare($sql);
        // Os seus valores passados formam um array ao executar, retornando true ou false indicando sucesso
        return $stmt->execute([$nome, $idade, $email, $senha, $avatar, $id]);
    }

    // Atualizando o avatar do usuário
    function atualizarAvatarUsuario($pdo, $id, $avatar){
        // Atualiza o avatar de um usuário pelo seu id como filtro
        $sql = "UPDATE usuario SET avatar = ? WHERE id_usuario = ?";
        // A query é preparada aguardando os parâmetros posicionais
        $stmt = $pdo->prepare($sql);
        // Os seus valores passados formam um array ao executar, retornando true ou false indicando sucesso
        return $stmt->execute([$avatar, $id]);
    }

    // Excluindo usuário por ID
    function excluirUsuario($pdo, $id){
        // Exclui um usuário permanentemente com base no seu id
        $sql = "DELETE FROM usuario WHERE id_usuario = ?";
        // A query é preparada aguardando o parâmetro posicional
        $stmt = $pdo->prepare($sql);
        // O seu valor passado forma um array ao executar, retornando true ou false indicando sucesso
        return $stmt->execute([$id]);
    }
?>
