<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../model/usuario_model.php';
    require_once __DIR__ . '/funcoes.php';

    iniciarSessao(); // Inicia a sessão senão existir uma

    $erros = []; // Lista para armazenar os erros

    // Acionado quando o usuário tenta fazer login
    if (isset($_POST["btn_entrar"])) {
        // Obtém uma variável externa especificada pelo nome (por exemplo, da entrada do formulário) e, opcionalmente, a filtra
        // Sanitiza qualquer entrada, protegendo contra scripts maliciosos. Este remove todos os caracteres ilegais de um endereço de e-mail
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_EMAIL);
        $senha = $_POST["senha"];

        // Validações
        if (empty($login)) {
            $erros[] = "Necessário preencher o e-mail!";
            // Filtra uma variável de acordo com um filtro especificado. Este verifica se é um endereço de e-mail válido
        } else if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $erros[] = "E-mail inválido!";
        }

        if (empty($senha)) {
            $erros[] = "Necessário preencher a senha!";
        }

        // Se não houver erros, tenta buscar o usuário cadastrado
        if (empty($erros)) {
            // Buscando todos os dados do usuário que fez login
            $usuario = buscarUsuarioPorEmailSenha($pdo, $login, $senha);

            if ($usuario) {
                // Define a sessão com os dados do usuário
                $_SESSION["login_session"] = $usuario["email"];
                $_SESSION["senha_session"] = $usuario["senha"];
                $_SESSION["id_usuario_session"] = $usuario["id_usuario"];
                $_SESSION["nome_session"] = $usuario["nome"];
                $_SESSION["idade_session"] = $usuario["idade"];
                $_SESSION["avatar_session"] = $usuario["avatar"];
                $_SESSION["tipo_session"] = $usuario["id_tipo"];

                // Redireciona conforme o tipo
                if ($usuario["id_tipo"] == 1) {
                    header("Location: ../index.php?page=dashboard"); // Administradores vão para a dashboard
                } else {
                    header("Location: ../index.php?page=home"); // Expectadores vão para a home
                }
                exit();
            // Erro para caso o login não dê certo
            } else {
                $erros[] = "E-mail ou senha inválidos.";
            }
        }

        // Guarda os erros na sessão e redireciona/envia para exibição
        $_SESSION['erros_login'] = $erros;
        header("Location: ../index.php?page=login");
        exit();
    }
?>
