<?php
    // Inicia uma nova sessão ou retoma uma sessão existente
    session_start();

    // Conexão com o Banco de Dados
    include "../model/conectar.php";

    // Selecionando os campos através dos arrays de POST que vem com as propriedades NAME do form  ($login = $email -> usuário)
    $login = $_POST["login"];
    $senha = $_POST["senha"];
    
    // Pesquisando se a senha do usuário é igual a digitada no login
    $getSenha = $sql -> query("SELECT senha FROM usuario WHERE senha = '$senha' ");

    // Se algum dos campos estiverem vazios irá pedir para fazer o login novamente
    if (empty($login) || empty($senha)){
        header("location: ../view/erro_url.html");
    }

    // Se clicar no botão fará o processamento e depois tratamento dos dados
    if (isset($_POST["btn_entrar"])){
        // Array de erros que armazenará as mensagens de erro
        $erros = [];

        // Sanitizar ou limpeza dos dados como primeira validação
        // Retirando conteúdos não adequados para o sistema dos campos
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_EMAIL);

        // Filtros validate após sanitizar como segunda validação
        // Caso os tipos de dados não forem válidos adicionará um erro
        if (!filter_var(($login), FILTER_VALIDATE_EMAIL)){
            $erros[] = "E-mail inválido!";
        }
        if ($senha != $getSenha){
            $erros[] = "Senha inválida!";
        }

        // Se os campos estiverem vazios também adicionará um erro
        if (empty($login)){
            $erros[] = "Necessário preencher o e-mail!";
        } 
        if (empty($senha)){
            $erros[] = "Necessário preencher a senha!";
        }
        // Se tiver erros irá exibi-los senão estará tudo certo
        if (!empty($erros)){
            foreach ($erros as $erro){
                echo "<li class='erros'>$erro</li>";
            }
        }
    }

    // Pesquisando tudo do usuário caso seu e-mail e senha digitados sejam os mesmos cadastrados no banco
    $logar = $sql -> query("SELECT * FROM usuario WHERE email = '$login' AND senha = '$senha' ");

    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
    while ($linha = mysqli_fetch_array($logar)){
        $id_usuario = $linha["id_usuario"];
        $nome = $linha["nome"];
        $idade = $linha["idade"];
        $email = $linha["email"];
        $senha = $linha["senha"];
        $avatar = $linha["avatar"];
        $tipo = $linha["id_tipo"];
    }

    // Se existir um login e senha com os mesmos dados vai criar um acesso de acordo com o tipo do usuário
    // Lógica para contar se existe um registro
    // Obtém o número de linhas no conjunto de resultados
    $contagem = mysqli_num_rows($logar);

    if ($contagem > 0 AND $tipo == 1){
        // Um array associativo contendo variáveis ​​de sessão disponíveis para o script atual
        $_SESSION["login_session"] = $login;
        $_SESSION["senha_session"] = $senha;
        $_SESSION["id_usuario_session"] = $id_usuario;
        $_SESSION["nome_session"] = $nome;
        $_SESSION["idade_session"] = $idade;
        $_SESSION["avatar_session"] = $avatar;
        $_SESSION["tipo_session"] = $tipo;

        // Vai liberar o acesso à página adm
        header("location: ../view/pagina_perfil_administrador.php");
    }
    else if ($contagem > 0 AND $tipo == 2){
        // Um array associativo contendo variáveis ​​de sessão disponíveis para o script atual
        $_SESSION["login_session"] = $login;
        $_SESSION["senha_session"] = $senha;
        $_SESSION["id_usuario_session"] = $id_usuario;
        $_SESSION["nome_session"] = $nome;
        $_SESSION["idade_session"] = $idade;
        $_SESSION["avatar_session"] = $avatar;
        $_SESSION["tipo_session"] = $tipo;

        // Vai liberar o acesso à página home
        header("location: ../view/pagina_home.php");
    }
    else{
        // Destruir seção (caso algo dê errado), assim desativando as variáveis determinadas/específicas
        unset($_SESSION["login_session"]);
        unset($_SESSION["senha_session"]);
        unset($_SESSION["id_usuario_session"]);
        unset($_SESSION["nome_session"]);
        unset($_SESSION["idade_session"]);
        unset($_SESSION["avatar_session"]);
        unset($_SESSION["tipo_session"]);

        echo '<div class="btns">
            <a href="../index.php" id="btn__voltar--inicio">Voltar ao Início</a>
        </div>';
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Erro</title>
    <link rel="stylesheet" href="../estilizacao/erros.css">
</head>
<body>
    <!-- Estilização dos Erros -->
</body>
</html>