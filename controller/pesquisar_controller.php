<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../config/conectar.php';
    require_once __DIR__ . '/../model/anime_model.php';
    require_once __DIR__ . '/funcoes.php';

    iniciarSessao(); // Inicia a sessão senão existir uma

    // Obtém uma variável externa especificada pelo nome (por exemplo, da entrada do formulário) e, opcionalmente, a filtra
    // Sanitiza qualquer entrada, protegendo contra scripts maliciosos. Este escapa caracteres especiais convertendo-os em entidades HTML
    $pesquisa = filter_input(INPUT_POST, 'pesquisar', FILTER_SANITIZE_SPECIAL_CHARS);
    // Busca animes baseado na string digitada
    $animes = buscarAnimesPorNome($pdo, $pesquisa);

    // Carrega a interface passando os dados
    require __DIR__ . '/../view/pagina_pesquisar.php';
?>