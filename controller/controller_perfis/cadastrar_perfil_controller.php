<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../funcoes.php';
    require_once __DIR__ . '/../../config/conectar.php';
    require_once __DIR__ . '/../../model/usuario_model.php';

    iniciarSessao(); // Inicia a sessão senão existir uma
    protegerPagina(1); // Só adms são permitidos nesta página

    // Começa o cadastro de perfil de usuário caso os dados tenham sido enviados via o formulário (post)
    if (isset($_POST["btn_enviar"])) {
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

        // Verifica se há erros, os guarda na sessão e redireciona/envia para exibição
        if (!empty($erros)) {
            $_SESSION['erros_cadastro'] = $erros;
            header("Location: ../index.php?page=cadastrar_perfil");
            exit;
        }

        // Verifica se um usuário já está cadastrado a partir do e-mail informado (este deve ser único)
        if (verificarEmailExistente($pdo, $email)) {
            $_SESSION['erros_cadastro'] = ['Usuário já cadastrado com este e-mail!'];
            header("Location: ../index.php?page=cadastrar_perfil");
            exit;
        }

        // Cadastra usuário sem avatar no momento
        if (inserirUsuario($pdo, $nome, $idade, $email, $senha, $avatar)) {

            // Upload do avatar se ocorrer
            if (!empty($_FILES['avatar']['name'])) {
                $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $permitidos = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array(strtolower($ext), $permitidos)) {
                    $avatar = $nome . '.' . $ext;
                    $destino = __DIR__ . "/../avatar/" . $avatar;
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $destino);
                } else {
                    $avatar = '';
                }
            }

            header('Location: ../index.php?page=login&cadastro=ok');
            exit;
        // Erro no cadastro
        } else {
            $_SESSION['erros_cadastro'] = ['Erro ao cadastrar usuário.'];
            header("Location: ../index.php?page=cadastrar_perfil");
            exit;
        }
    }
?>
