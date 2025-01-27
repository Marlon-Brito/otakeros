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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Episódios</title>
    <link rel="stylesheet" href="../estilizacao/pagina_episodios.css">
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
        <main class="conteudo container">
            <?php
                // Pegando id do anime passado pela url
                $id_anime = $_GET["id_anime"];

                // Pesquisando tudo do anime que tem o mesmo id que veio pela url
                $buscarAnime = $sql -> query("SELECT * FROM anime WHERE id_anime = '$id_anime' ");

                // Obtém o número de linhas no conjunto de resultados
                $check = mysqli_num_rows($buscarAnime);

                // Se a verificação for positiva irá pegar as informações deste anime e apresentar
                if ($check == 1){
                    $arrayAnime = $sql -> query("SELECT * FROM anime WHERE id_anime = $id_anime");
                    
                    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)                                  
                    while ($linha = mysqli_fetch_array($arrayAnime)){
                        $nome_anime = $linha["nome_anime"];
                        $descricao_anime = $linha["descricao_anime"];
                        $imagem_anime = $linha["imagem_anime"];

                        echo '<section class="anime">
                            <img src="../controller/controller_animes/imagem/'.$imagem_anime.'" alt="'.$nome_anime.'" class="anime__imagem">
                            <h1 class="anime__nome">'.$nome_anime.'</h1>
                            <p class="anime__sinopse">'.$descricao_anime.'</p>
                        </section>';
                    }
                // Senão mostrará uma mensagem de erro dizendo que o anime não está cadastrado
                }else{
                    echo "<h1 class='titulo__erro'>Este anime não está cadastrado!</h1>";
                }
            ?>

            <section class="episodios">
                <h2 class="episodios__titulo">Episódios</h2>
                <?php
                    // Pesquisando tudo de episódios que tem o mesmo id do anime para pegar suas informações e fazer uma lista
                    $buscarEpisodio = $sql -> query("SELECT * FROM episodio WHERE id_anime = '$id_anime' ");

                    // Obtém o número de linhas no conjunto de resultados
                    $check2 = mysqli_num_rows($buscarEpisodio);

                    // Se a verificação tiver resultados irá pegar as informações dos episódios e apresentar
                    if ($check2 > 0){
                        $arrayEpisodio = $sql -> query("SELECT * FROM episodio WHERE id_anime = $id_anime");
                                                            
                        // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
                        while ($linha = mysqli_fetch_array($arrayEpisodio)){
                            $id_episodio = $linha["id_episodio"];
                            $numero_episodio = $linha["id_numero_episodio"];
                            $nome_episodio = $linha["nome_episodio"];
                            $video_episodio = $linha["video_url_episodio"];
                            $anime = $linha["id_anime"];

                            echo '
                                <ul class="episodios__lista">
                                    <a href="./pagina_assistir.php?id_anime='.$id_anime.'&id_numero_episodio='.$numero_episodio.'">
                                        <li class="episodios__lista--episodio">'.$nome_episodio.'</li>
                                    </a>
                                </ul>
                            ';
                        }
                    // Senão mostrará uma mensagem de erro dizendo que não há episódios
                    }else{
                        echo '
                            <ul class="episodios__lista">
                                <li class="episodios__lista--episodio">Nenhum episódio encontrado...</li>
                            </ul>
                        ';
                    }
                ?>
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