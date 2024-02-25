<?php
    // Conexão com o Banco de Dados
    include "./model/conectar.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Entre ou Cadastre-se</title>
    <link rel="stylesheet" href="./estilizacao/login.css">
</head>
<body>
    <div class="fundo">
        <!-- Cabeçalho -->
        <header class="cabecalho">
            <a href="./index.php" class="logotipo">
                <img class="logo__img" src="./imgs/logo-otakeros-p.png">
                <div class="logo__nome">Otakeros</div>
            </a>
        </header>

        <!-- Conteúdo Principal -->
        <main class="conteudo__principal">
            <div class="saudacao">
                <h1 class="titulo">Seja bem-vindo a 
                    <span class="titulo--destaque">OTAKEROS</span>!
                </h1>
                <p class="texto">Assista animes de forma online e gratuita a qualquer momento, basta acessar nossa plataforma!</p>
            </div>

            <section class="form">
                <div class="fundo__poster">
                    <img src="./imgs/poster-otakeros.png" alt="Poster Otakeros" class="poster">
                </div>

                <!-- Formulário de login -->
                <form action="../controller/login.php" class="formulario" method="post">
                    <label for="cLogin">E-mail:</label>
                    <input type="email" name="login" id="cLogin" autofocus>
                    
                    <label for="cSenha">Senha:</label>
                    <input type="password" name="senha" id="cSenha">

                    <input type="submit" name="btn_entrar" value="Entrar" class="btns" id="btn__entrar">
                </form>
            </section>

            <!-- Formulário de cadastro -->
            <div class="formulario__cadastro">
                <span class="formulario__cadastro--alternativa">Não possui um acesso? É só se cadastrar!</span>
                <a href="./controller/controller_perfil/cadastrar_perfil.php">
                    <button class="btns" id="btn__cadastrar">Cadastrar</button>
                </a>
            </div>

            <h2 class="subtitulo">Animes</h2>
            <p class="texto">Se quiser verificar alguns dos animes de nosso arsenal, basta prosseguir para conhecer mais...</p>

            <section class="animes">
                <ul class="lista__animes">
                    <?php
                        // Pesquisando todos os animes para pegar suas informações
                        $arrayAnime = $sql -> query("SELECT * FROM anime ORDER BY nome_anime");
                                    
                        // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
                        while ($linha = mysqli_fetch_array($arrayAnime)){
                            $nome_anime = $linha["nome_anime"];
                            $imagem_anime = $linha["imagem_anime"];
                
                            echo '<li class="lista__item--animes">
                                <figure>
                                    <img class="imagem--anime" src="./controller/controller_animes/imagem/'.$imagem_anime.'" alt="'.$nome_anime.'">
                                    <figcaption class="nome--anime">'.$nome_anime.'</figcaption>
                                </figure>
                            </li>';
                        }
                    ?>
                </ul>
            </section>
        </main>

        <!-- Rodapé -->
        <footer class="rodape">
            <p>© Copyright Otakeros. Todos os direitos reservados.</p>
        </footer>
    </div>
</body>
</html>