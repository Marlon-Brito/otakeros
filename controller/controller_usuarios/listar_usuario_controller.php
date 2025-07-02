<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../../model/usuario_model.php';
    require_once __DIR__ . '/../../controller/funcoes.php';

    iniciarSessao(); // Inicia a sessão senão existir uma

    protegerPagina(1); // Só adms são permitidos nesta página

    // Busca os dados dos usuários
    $usuarios = buscarTodosUsuarios($pdo);

    // Carrega a interface passando os dados
    require_once __DIR__ . '/../../view/pagina_dados_usuarios.php';
?>
