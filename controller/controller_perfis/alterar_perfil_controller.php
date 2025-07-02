<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../funcoes.php';
    require_once __DIR__ . '/../../config/conectar.php';
    require_once __DIR__ . '/../../model/usuario_model.php';

    iniciarSessao(); // Inicia a sessão senão existir uma

    $id_usuario = $_SESSION['id_usuario_session']; // Trazendo o id do perfil do usuário

    // Começa a atualização de perfil do usuário caso os novos dados tenham sido enviados via o formulário (post)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtém uma variável externa especificada pelo nome (por exemplo, da entrada do formulário) e, opcionalmente, a filtra
        // Sanitiza qualquer entrada, protegendo contra scripts maliciosos
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS); // Este escapa caracteres especiais convertendo-os em entidades HTML
        $idade = filter_input(INPUT_POST, 'idade', FILTER_SANITIZE_NUMBER_INT); // Este remove todos os caracteres ilegais de um número
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL); // Este remove todos os caracteres ilegais de um endereço de e-mail
        $senha = $_POST["senha"];
        $avatar = '';
        $erros = [];

        // Validações
        if (empty($nome)) $erros[] = "Nome obrigatório!";

        if (empty($idade)) {
            $erros[] = "Idade obrigatória!";
            // Filtra uma variável de acordo com um filtro especificado. Este é usado para validar o valor como inteiro
        } else if (!filter_var($idade, FILTER_VALIDATE_INT)){
            $erros[] = "Idade inválida!";
        }

        if (empty($email)){
            $erros[] = "E-mail obrigatório!";
            // Filtra uma variável de acordo com um filtro especificado. Este verifica se é um endereço de e-mail válido
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $erros[] = "E-mail inválido!";
        }

        if (empty($senha)) $erros[] = "Senha obrigatória!";

        // Busca o usuário pelo seu id
        $usuario = buscarUsuarioPorId($pdo, $id_usuario);
        // Pega o avatar antigo senão o deixa sem
        $avatar_antigo = $usuario["avatar"] ?? '';

        // Upload do avatar se ocorrer
        if (!empty($_FILES['avatar']['name'])) {
            $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            $permitidos = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($ext, $permitidos)) {
                $avatar = 'usuario_' . $id_usuario . '.' . $ext;
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
            header("Location: ../../index.php?page=editar_perfil");
            exit;
        }

        // Atualiza o perfil do usuário
        if (atualizarUsuario($pdo, $nome, $idade, $email, $senha, $avatar, $id_usuario)) {
            $_SESSION["id_usuario_session"] = $id_usuario;
            $_SESSION["nome_session"] = $nome;
            $_SESSION["idade_session"] = $idade;
            $_SESSION["login_session"] = $email;
            $_SESSION["senha_session"] = $senha;
            $_SESSION["avatar_session"] = $avatar;

            header("Location: ../../index.php?page=home&alteracao=ok");
            exit;
        // Erro ao atualizar
        } else {
            $_SESSION['erros_atualizar'] = ['Erro ao editar o usuário.'];
            header("Location: ../../index.php?page=editar_perfil");
            exit;
        }
    }
?>
