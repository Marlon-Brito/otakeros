<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../../config/conectar.php';
    require_once __DIR__ . '/../../model/anime_model.php';
    require_once __DIR__ . '/../../controller/funcoes.php';

    iniciarSessao(); // Inicia a sessão senão existir uma
    protegerPagina(1); // Só adms são permitidos nesta página

    // Começa a atualização de anime caso os novos dados tenham sido enviados via o formulário (post)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_anime = $_POST['id'] ?? null;
        // Obtém uma variável externa especificada pelo nome (por exemplo, da entrada do formulário) e, opcionalmente, a filtra
        // Sanitiza qualquer entrada, protegendo contra scripts maliciosos. Este escapa caracteres especiais convertendo-os em entidades HTML
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
        $imagem = '';
        $erros = [];

        if (empty($id_anime)) $erros[] = "ID do anime inválido.";
        if (empty($nome)) $erros[] = "Nome obrigatório.";
        if (empty($descricao)) $erros[] = "Descrição obrigatória.";

        // Busca o anime pelo seu id
        $anime = buscarAnimePorId($pdo, $id_anime);
        // Pega a imagem antiga do anime senão o deixa sem
        $imagem_antiga = $anime['imagem_anime'] ?? '';

        // Upload da imagem se ocorrer
        if (!empty($_FILES['imagem']['name'])) {
            $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            $permitidos = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($ext, $permitidos)) {
                $imagem = 'anime_' . $id_anime . '.' . $ext;
                $destino = __DIR__ . "/../../assets/animes/" . $imagem;

                // Apaga a imagem antiga caso exista e não estiver vazia
                if (!empty($imagem_antiga) && file_exists(__DIR__ . "/../../assets/animes/$imagem_antiga")) {
                    unlink(__DIR__ . "/../../assets/animes/$imagem_antiga");
                }

                move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);
            } else {
                $imagem = $imagem_antiga; // Senão manterá a imagem antiga
            }
        } else {
            $imagem = $imagem_antiga; // Senão manterá a imagem antiga
        }

        // Verifica se há erros, os guarda na sessão e redireciona/envia para exibição
        if (!empty($erros)) {
            $_SESSION['erros_atualizar'] = $erros;
            header("Location: ../../index.php?page=dados_animes&id_anime=$id_anime");
            exit;
        }

        // Atualiza o anime
        if (atualizarAnime($pdo, $id_anime, $nome, $descricao, $imagem)) {
            header('Location: ../../index.php?page=dados_animes&alteracao=ok');
            exit;
        // Erro ao atualizar
        } else {
            $_SESSION['erros_atualizar'] = ['Erro ao atualizar o anime.'];
            header("Location: ../../index.php?page=dados_animes&id_anime=$id_anime&alteracao=erro");
            exit;
        }
    }

    // Buscando anime e carregando seus dados na página de edição caso receba seu id como parâmetro na URL (get)
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_anime'])) {
        $id_anime = $_GET['id_anime'];
        // Busca o anime pelo seu id
        $anime = buscarAnimePorId($pdo, $id_anime);

        // Senão encontrar o anime redireciona
        if (!$anime) {
            header("Location: ../../index.php?page=dados_animes&erro=Anime não encontrado");
            exit;
        }

        // Ao encontrá-lo já processa o caminho da imagem
        $imagem = $anime['imagem_anime'];
        $caminho_imagem = (!isset($imagem) || empty($imagem) || !file_exists(__DIR__ . "/../../assets/animes/$imagem")) 
            ? "../../assets/imgs/icone-quadro.png" 
            : "../../assets/animes/$imagem"
        ;

        // Carrega a interface passando os dados
        include __DIR__ . '/../../view/pagina_alterar_anime.php';
    }
?>
