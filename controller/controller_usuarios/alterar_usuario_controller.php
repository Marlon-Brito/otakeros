<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../../config/conectar.php';
    require_once __DIR__ . '/../../model/usuario_model.php';
    require_once __DIR__ . '/../../controller/funcoes.php';

    iniciarSessao(); // Inicia a sessão senão existir uma
    protegerPagina(1); // Só adms são permitidos nesta página

    // Começa a atualização de usuário caso os novos dados tenham sido enviados via o formulário (post)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        // Obtém uma variável externa especificada pelo nome (por exemplo, da entrada do formulário) e, opcionalmente, a filtra
        // Sanitiza qualquer entrada, protegendo contra scripts maliciosos
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS); // Este escapa caracteres especiais convertendo-os em entidades HTML
        $idade = filter_input(INPUT_POST, 'idade', FILTER_SANITIZE_NUMBER_INT); // Este remove todos os caracteres ilegais de um número
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL); // Este remove todos os caracteres ilegais de um endereço de e-mail
        $senha = $_POST['senha'] ?? '';
        $avatar = '';
        $erros = [];

        if (empty($id)) $erros[] = "ID do usuário inválido.";
        if (empty($nome)) $erros[] = "Nome obrigatório.";
        // Filtra uma variável de acordo com um filtro especificado. Este é usado para validar o valor como inteiro
        if (empty($idade) || !filter_var($idade, FILTER_VALIDATE_INT)) $erros[] = "Idade inválida.";
        // Filtra uma variável de acordo com um filtro especificado. Este verifica se é um endereço de e-mail válido
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $erros[] = "E-mail inválido.";
        if (empty($senha)) $erros[] = "Senha obrigatória.";

        // Busca o usuário pelo seu id
        $usuario = buscarUsuarioPorId($pdo, $id);
        // Pega o avatar antigo senão o deixa sem
        $avatar_antigo = $usuario['avatar'] ?? '';

        // Upload do avatar se ocorrer
        if (!empty($_FILES['avatar']['name'])) {
            $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            $permitidos = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($ext, $permitidos)) {
                $avatar = 'usuario_' . $id . '.' . $ext;
                $destino = __DIR__ . "/../../assets/avatar/" . $avatar;

                // Apaga o avatar antigo caso exista e não estiver vazio
                if (!empty($avatar_antigo) && file_exists(__DIR__ . "/../../assets/avatar/$avatar_antigo")) {
                    unlink(__DIR__ . "/../../assets/avatar/$avatar_antigo");
                }

                move_uploaded_file($_FILES['avatar']['tmp_name'], $destino);
            } else {
                $avatar = $avatar_antigo; // Senão manterá o avatar antigo
            }
        } else {
            $avatar = $avatar_antigo; // Senão manterá o avatar antigo
        }

        // Verifica se há erros, os guarda na sessão e redireciona/envia para exibição
        if (!empty($erros)) {
            $_SESSION['erros_atualizar'] = $erros;
            header("Location: ../../index.php?page=editar_usuario&id_usuario=$id");
            exit;
        }

        // Atualiza o usuário
        if (atualizarUsuario($pdo, $nome, $idade, $email, $senha, $avatar, $id)) {
            header('Location: ../../index.php?page=dados_usuarios&alteracao=ok');
            exit;
        // Erro ao atualizar
        } else {
            $_SESSION['erros_atualizar'] = ['Erro ao atualizar o usuário.'];
            header("Location: ../../index.php?page=dados_usuarios&id_usuario=$id&alteracao=erro");
            exit;
        }
    }

    // Buscando usuário e carregando seus dados na página de edição caso receba seu id como parâmetro na URL (get)
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_usuario'])) {
        $id_usuario = $_GET['id_usuario'];
        // Busca o usuário pelo seu id
        $usuario = buscarUsuarioPorId($pdo, $id_usuario);
        // Busca os tipos de usuário
        $tipos = listarTiposUsuario($pdo);

        // Senão encontrar o usuário redireciona
        if (!$usuario) {
            header("Location: ../../index.php?page=dados_usuarios&erro=Usuário não encontrado");
            exit;
        }

        // Ao encontrá-lo já processa o caminho do avatar
        $avatar = $usuario['avatar'];
        $caminho_avatar = (!isset($avatar) || empty($avatar) || !file_exists(__DIR__ . "/../../assets/avatar/$avatar")) 
            ? "../../assets/imgs/icone-usuario.jpg" 
            : "../../assets/avatar/$avatar"
        ;

        // Carrega a interface passando os dados
        require __DIR__ . '/../../view/pagina_alterar_usuario.php';
    }
?>
