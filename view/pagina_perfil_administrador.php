<?php
    // Determina se uma variável é considerada definida, isto é, está declarada e é diferente de null
    // Se a variável tornou-se indefinida com a função unset() , ela não é mais considerada definida
    if (!isset($_SESSION)){
        session_start();
    }

    // Não permite acessar a página principal pelo navegador
    // Senão existir a seção volta pela página de erro
    if (!isset($_SESSION["login_session"])       AND
        !isset($_SESSION["senha_session"])       AND

        !isset($_SESSION["id_usuario_session"]) AND
        !isset($_SESSION["nome_session"])        AND
        !isset($_SESSION["idade_session"])         AND
        !isset($_SESSION["avatar_session"])      AND
        !isset($_SESSION["tipo_session"])
    ){
        header("location: ../view/erro_url.html");
        exit;
    }
    // Bloquear página ao tentar ir pela url sem logar
    if (isset($_GET['logout'])){
        unset($_SESSION['login_session']);
        unset($_SESSION['senha_session']);
        session_destroy();
        header('location: ../index.php');
    }
    // Se o usuário não for um administrador irá para a página de erro
    if ($_SESSION["tipo_session"] != 1){
        session_destroy();
        header("location: ../view/erro_url.html");
    }

    $id_usuario = $_SESSION["id_usuario_session"];
    $nome = $_SESSION["nome_session"];
    $idade = $_SESSION["idade_session"];
    $email = $_SESSION["login_session"];
    $senha = $_SESSION["senha_session"];
    $avatar = $_SESSION["avatar_session"];
    $tipo = $_SESSION["tipo_session"];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Administrador</title>
    <link rel="stylesheet" href="../estilizacao/pagina_perfil_administrador.css">
</head>
<body>
    <div class="fundo">
        <!-- Cabeçalho -->
        <header class="cabecalho">
            <a href="./pagina_perfil_administrador.php" class="logotipo">
                <img class="logo__img" src="../imgs/logo-otakeros-p.png">
                <div class="logo__nome">Otakeros</div>
            </a>
    
            <nav>
                <ul class="cabecalho__menu">
                    <li class="cabecalho__menu--linha">
                        <a href="./pagina_perfil_administrador.php" class="cabecalho__menu--linha-item">Área Administrativa</a>
                    </li>
                    <li class="cabecalho__menu--linha">
                        <a href="?logout" class="cabecalho__menu--linha-item">Sair</a>
                    </li>
                </ul>
            </nav>
        </header>

        <!-- Conteúdo Principal -->
        <main class="conteudo__principal">
            <!-- Interface de gerenciamento e monitoramento dos dados -->
            <section class="administrador container">
                <h1 class="titulo">Administrador</h1>
                <p class="texto">Seja bem-vindo adm 
                    <span class="texto--destaque"><?php echo $nome; ?></span>.
                    O que deseja fazer dessa vez?
                </p>

                <img src="../imgs/icone-admin.png" alt="Administrador" class="administrador__icone">

                <div class="dados">
                    <a href="../controller/listar.php">
                        <button type="submit" class="btns" id="btn__usuarios">Usuários</button>
                    </a>
                
                    <a href="../controller/controller_animes/listar_animes.php">
                        <button type="submit" class="btns" id="btn__animes">Animes</button>
                    </a>
                </div>
            </section>

            <section class="informacoes">
                <h2 class="subtitulo">Usuários:</h2>
                <p class="informacoes__detalhes">Esta é a área de informações de Usuários, podendo-se: cadastrar, alterar, visualizar e deletar seus dados. Além da possibilidade de filtrá-los para uma maior análise de suas informações.</p>

                <h2 class="subtitulo">Animes:</h2>
                <p class="informacoes__detalhes">Esta é a área de informações de Animes, podendo-se: cadastrar, alterar, visualizar e deletar seus dados. Além da possibilidade de filtrá-los para uma maior análise de suas informações. E ainda fazendo o mesmo para os seus respectivos episódios.</p>
            </section>
        </main>

        <!-- Rodapé -->
        <footer class="rodape">
            <p>© Copyright Otakeros. Todos os direitos reservados.</p>
        </footer>
    </div>
</body>
</html>