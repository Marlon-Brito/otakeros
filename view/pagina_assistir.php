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
    <title>Otakeros - Assistir</title>
    <link rel="stylesheet" href="../estilizacao/pagina_assistir.css">
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
                                <img src="../avatar/<?php echo $avatar ?>" class="perfil--usuario">
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
        <main class="container">
            <section class="episodio">
                <?php
                    // Pegando id do episódio selecionado que foi passado pela url
                    $id_episodio = $_GET["id_numero_episodio"];
                    // Pegando id do anime passado pela url como recurso para exibir o vídeo do episódio
                    $id_anime = $_GET["id_anime"];

                    // Pesquisando tudo do anime que tem o mesmo id que veio pela url
                    $infoAnime = $sql -> query("SELECT * FROM anime WHERE id_anime = $id_anime");
                                
                    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
                    while ($linha = mysqli_fetch_array($infoAnime)){
                        $nome_anime = $linha["nome_anime"];
                        $descricao_anime = $linha["descricao_anime"];
                    }
                    
                    // Declarando variáveis de episódio: anterior e próximo
                    $episodio_anterior = 0;
                    $proximo_episodio = 0;
                
                    // Pesquisando tudo de episódios que tem o mesmo id do anime e do episódio selecionado
                    $arrayEpisodio = $sql -> query("SELECT * FROM episodio WHERE id_anime = $id_anime AND id_numero_episodio = $id_episodio");

                    // Obtém o número de linhas no conjunto de resultados
                    $check = mysqli_num_rows($arrayEpisodio);
                            
                    // Se a verificação for positiva irá pegar as informações deste episódio e apresentar
                    if ($check == 1){
                        // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
                        while ($linha = mysqli_fetch_array($arrayEpisodio)){
                            $numero_episodio = $linha["id_numero_episodio"];
                            $nome_episodio = $linha["nome_episodio"];
                            $video_episodio = $linha["video_url_episodio"];

                            // Declarando a variável do episódio atual e fazendo a lógica das variáveis de episódio
                            $epAtual = max(array($id_episodio));

                            $episodio_anterior = $numero_episodio - 1;
                            $proximo_episodio = $numero_episodio + 1;

                            // Travando no episódio inicial
                            $epI = 1;

                            $epInicial = $episodio_anterior == 0 ? $epI : $episodio_anterior;

                            // Travando no episódio final
                            $epF = $proximo_episodio - 1;

                            $epFinal = $proximo_episodio == 0 ? $epAtual : $proximo_episodio;
                
                            // Estrutura de visualização
                            echo '<h1 class="episodio__titulo">'.$nome_anime.'</h1>
                                <h2 class="episodio__subtitulo">'.$nome_episodio.'</h2>
                    
                                <div class="episodio__video">
                                    <video src="../controller/controller_episodios/video/'.$video_episodio.'" controls class="episodio__video--assistir"></video>
                                </div>'
                            ;

                            echo '<nav>
                                    <ul class="episodio__video--navegacao">
                            ';

                            if ($epAtual == 1){
                                // Desabilitando o botão de episódio anterior
                                echo '<li class="antes__icone icones" style="background-color: rgb(100, 65, 0);">
                                    <img src="../imgs/icone-antes.png" class="imagem__icone">
                                    <span class="termo__icone">Anterior</span>
                                </li>';
                            }else{
                                echo '<a href="./pagina_assistir.php?id_numero_episodio='.$epInicial.'&id_anime='.$id_anime.'">
                                    <li class="antes__icone icones">
                                        <img src="../imgs/icone-antes.png" class="imagem__icone">
                                        <span class="termo__icone">Anterior</span>
                                    </li>
                                </a>';
                            }

                            echo '
                                    <a href="./pagina_episodios.php?id_anime='.$id_anime.'">
                                        <li class="lista__icone icones">
                                            <img src="../imgs/icone-lista.png" class="imagem__icone">
                                            <span class="termo__icone">Lista de Episódios</span>
                                        </li>
                                    </a>

                                    <a href="./pagina_assistir.php?id_numero_episodio='.$epFinal.'&id_anime='.$id_anime.'">
                                        <li class="depois__icone icones">
                                            <span class="termo__icone">Próximo</span>
                                            <img src="../imgs/icone-depois.png" class="imagem__icone">
                                        </li>
                                    </a>
                                </ul>
                            </nav>';

                            echo '<div class="episodio__info">
                                <h2 class="episodio__info--subtitulo">Informações:</h2>
                                <p class="episodio__info--sinopse">'.$descricao_anime.'</p>
                            </div>';
                        }
                    }
                    // Senão mostrará uma mensagem de erro dizendo que os episódios acabaram
                    else{
                        $epAtual = max(array($id_episodio));

                        $epAnt = $epAtual - 1;
                        
                        echo '<h1 class="episodio__titulo">'.$nome_anime.'</h1>
                            <h2 class="episodio__subtitulo">Os episódios acabaram...</h2>
                
                            <div class="episodio__video">
                                <img src="../imgs/icone-acabou.png" class="acabou__icone">
                            </div>'
                        ;

                        // Desabilitando o botão de próximo episódio
                        echo '<nav>
                            <ul class="episodio__video--navegacao">
                                <a href="./pagina_assistir.php?id_numero_episodio='.$epAnt.'&id_anime='.$id_anime.'">
                                    <li class="antes__icone icones">
                                        <img src="../imgs/icone-antes.png" class="imagem__icone">
                                        <span class="termo__icone">Anterior</span>
                                    </li>
                                </a>

                                <a href="./pagina_episodios.php?id_anime='.$id_anime.'">
                                    <li class="lista__icone icones">
                                        <img src="../imgs/icone-lista.png" class="imagem__icone">
                                        <span class="termo__icone">Lista de Episódios</span>
                                    </li>
                                </a>

                                <li class="depois__icone icones" style="background-color: rgb(100, 65, 0);">
                                    <img src="../imgs/icone-depois.png" class="imagem__icone">
                                    <span class="termo__icone">Próximo</span>
                                </li>
                            </ul>
                        </nav>';

                        echo '<div class="episodio__info">
                            <h2 class="episodio__info--subtitulo">Informações:</h2>
                            <p class="episodio__info--sinopse">'.$descricao_anime.'</p>
                        </div>';
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