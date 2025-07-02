<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    // O __DIR__ retorna o diretório do arquivo atual, permitindo montar o caminho correto. Se o arquivo estiver dentro de uma subpasta, use dirname(__DIR__) para voltar um nível
    require_once dirname(__DIR__) . '/config/banco_credenciais.php';

    // Tratando conexão com o banco de dados via PDO
    try {
        /* Criar uma nova instância de classe e especificar:
            - O driver (software que permite a comunicação entre uma aplicação e um SGBD) que vai usar, no caso o mysql
            - O nome do banco de dados
            - O nome de usuário 
            - E a senha
        */
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lançar exceções em caso de erro
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Retornar resultados como array associativo
            PDO::ATTR_EMULATE_PREPARES => false, // Melhor segurança (protege) contra SQL Injection
        ]);

        // Exibe mensagens de erro e avisos no arquivo de registros, gerados pelo PHP durante a execução de scripts
        error_log("Conectado com sucesso ao banco de dados!");
    // Caso dê erro na conexão
    } catch (PDOException $e) {
        // Exibe mensagens de erro e avisos no arquivo de registros, gerados pelo PHP durante a execução de scripts
        error_log("Erro na conexão com o banco de dados: " . $e->getMessage());
        die("Erro interno. Tente novamente mais tarde.");
    }
?>
