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
    // Se o usuário não for um espectador irá para a página de erro
    if ($_SESSION["tipo_session"] != 2){
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

    // Conexão com o Banco de Dados
    include "../model/conectar.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Home</title>
    <link rel="stylesheet" href="../estilizacao/pagina_home.css">
</head>
<body>    
    <div class="fundo">
        <!-- Cabeçalho -->
        <header class="cabecalho">
            <a href="./pagina_home.php" class="logotipo">
                <img class="logo__img" src="../imgs/logo-otakeros-p.png">
                <div class="logo__nome">Otakeros</div>
            </a>

            <nav>
                <ul class="cabecalho__menu">
                    <li class="cabecalho__menu--linha">
                        <a href="./pagina_home.php" class="cabecalho__menu--linha-item">Home</a>
                    </li>
                    <li class="cabecalho__menu--linha">
                        <a href="./pagina_alterar_perfil.php?id_usuario=<?php echo $id_usuario; ?>" class="cabecalho__menu--linha-item">
                            <div class="perfil">
                                <img src="../avatar/<?php if (empty($avatar)){echo "../imgs/icone-usuario.png";}else{echo $avatar;} ?>" class="perfil--usuario">
                                <span class="perfil--usuario-nome"><?php echo $nome ?></span>
                            </div>
                        </a>
                    </li>
                    <li class="cabecalho__menu--linha">
                        <a href="?logout" class="cabecalho__menu--linha-item">Sair</a>
                    </li>
                </ul>
            </nav>
        </header>

        <!-- Conteúdo Principal -->
        <main>
            <section class="entrada container">
                <h1 class="titulo">Lista de Animes</h1>

                <?php
                    // Área de pesquisa de animes -->
                    echo '<form action="./pagina_pesquisar.php" method="post" class="form__pesquisar">
                        <div class="area__pesquisar">
                            <input type="text" name="pesquisar" id="cPesquisar" placeholder="Digite o nome de um anime...">
                            <a href="./pagina_pesquisar.php">
                                <img src="../imgs/icone-lupa.png" alt="Pesquisar" class="pesquisar__icone">
                            </a>
                        </div>
                    </form>';
                ?>

                <nav class="animes">
                    <ul class="lista__animes">
                        <?php
                            // Pesquisando todos os animes em ordem alfábética para pegar suas informações e apresentar
                            $arrayAnime = $sql -> query("SELECT * FROM anime ORDER BY nome_anime");
                                            
                            // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
                            while ($linha = mysqli_fetch_array($arrayAnime)){
                                $id_anime = $linha["id_anime"];
                                $nome_anime = $linha["nome_anime"];
                                $imagem_anime = $linha["imagem_anime"];

                                // Passando id do anime selecionado pela url
                                echo '<li class="lista__animes--item">
                                    <a href="./pagina_episodios.php?id_anime='.$id_anime.'">
                                        <figure>
                                            <img class="imagem--anime" src="../controller/controller_animes/imagem/'.$imagem_anime.'" alt="'.$nome_anime.'">
                                            <figcaption class="nome--anime">'.$nome_anime.'</figcaption>
                                        </figure>
                                    </a>
                                </li>';
                            }
                        ?>
                    </ul>
                </nav>
            </section>

            <picture>
                <source media="(min-width: 1200px)" srcset="../imgs/poster-otakeros-pb-m.png" type="image/png" class="poster--pb">
                <img src="../imgs/poster-otakeros-pb-p.png" alt="Poster Otakeros - Preto e Branco" class="poster--pb">
            </picture>
        </main>

        <!-- Rodapé -->
        <footer class="rodape">
            <p>© Copyright Otakeros. Todos os direitos reservados.</p>
        </footer>
    </div>
</body>
</html>