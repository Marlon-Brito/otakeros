<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../funcoes.php';
    require_once __DIR__ . '/../../config/conectar.php';
    require_once __DIR__ . '/../../model/anime_model.php';

    iniciarSessao(); // Inicia a sessão senão existir uma
    protegerPagina(1); // Só adms são permitidos nesta página

    // Começa o cadastro de episódio caso os dados tenham sido enviados via o formulário (post)
    if (isset($_POST["btn_enviar"])) {
        // Obtém uma variável externa especificada pelo nome (por exemplo, da entrada do formulário) e, opcionalmente, a filtra
        // Sanitiza qualquer entrada, protegendo contra scripts maliciosos. Este escapa caracteres especiais convertendo-os em entidades HTML
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
        $imagem = '';
        $erros = [];

        // Validações
        if (empty($nome)) {
            $erros[] = "Nome do anime obrigatório!";
        }

        if (empty($descricao)) {
            $erros[] = "Descrição obrigatória!";
        }

        // Verifica se há erros, os guarda na sessão e redireciona/envia para exibição
        if (!empty($erros)) {
            $_SESSION['erros_cadastro'] = $erros;
            header("Location: ../../index.php?page=cadastrar_anime");
            exit;
        }

        // Verifica se um anime já está cadastrado a partir do seu nome (este deve ser único)
        if (verificarNomeAnimeExistente($pdo, $nome)) {
            $_SESSION['erros_cadastro'] = ['Anime já cadastrado com esse nome!'];
            header("Location: ../../index.php?page=cadastrar_anime");
            exit;
        }

        // Cadastra anime sem imagem inicialmente
        if (inserirAnime($pdo, $nome, $descricao, '')) {
            $id_novo_anime = $pdo->lastInsertId();

            // Upload da imagem se ocorrer
            if (!empty($_FILES['imagem']['name'])) {
                $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                $permitidos = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array(strtolower($ext), $permitidos)) {
                    $imagem = 'anime_' . $id_novo_anime . '.' . $ext;
                    $destino = __DIR__ . "/../../assets/animes/" . $imagem;

                    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)){
                        atualizarImagemAnime($pdo, $id_novo_anime, $imagem);
                    }
                }
            }

            header('Location: ../../index.php?page=dados_animes&cadastro=ok');
            exit;
        // Erro no cadastro
        } else {
            $_SESSION['erros_cadastro'] = ['Erro ao cadastrar anime.'];
            header("Location: ../../index.php?page=cadastrar_anime&cadastro=erro");
            exit;
        }
    }
?>
