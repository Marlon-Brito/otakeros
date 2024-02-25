<?php
    // Conexão com o Banco de Dados
    include "../../model/conectar.php";

    // Pegando id do episódio passado pela url
    $id_episodio = $_GET["id_episodio"];

    // Pesquisando tudo do episódio que tem o mesmo id passado pela url
    $dados = $sql -> query("SELECT * FROM episodio WHERE id_episodio = $id_episodio");

    // Pesquisando tudo do episódio que tem relação com um anime através do id de ambos
    $dados_anime = $sql -> query("SELECT * FROM episodio INNER JOIN anime ON episodio.id_anime = anime.id_anime WHERE id_episodio = $id_episodio");

    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
    while ($linha = mysqli_fetch_array($dados)){
        $id_episodio = $linha["id_episodio"];
        $id_numero_episodio = $linha["id_numero_episodio"];
        $nome_episodio = $linha["nome_episodio"];
        $video_url_episodio = $linha["video_url_episodio"];
        $id_anime = $linha["id_anime"];
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Editar Episódio</title>
    <link rel="stylesheet" href="../../estilizacao/alterar_episodios.css">
</head>
<body>
    <?php
        echo "<a href='../controller_episodios/listar_episodios.php?id_anime=$id_anime' id='btn__voltar'>Voltar</a>";
    ?>

    <section class="form">
        <!-- Formulário de Alteração de Episódio -->
        <form class="formulario" action="../controller_episodios/salvar_alteracao_episodios.php" method="post" enctype="multipart/form-data">
            <h1 class="titulo">Edição de Episódio</h1>

            <div id="formulario__video">
                <video src="./video/<?php echo "$video_url_episodio"; ?>" id="video__icone" controls></video>

                <p>
                    <label for="cVideo" id="label_arquivo">Escolha o vídeo do Episódio:</label>
                    <input type="file" name="video" id="cVideo" value="<?php echo "$video_url_episodio"; ?>" onchange="previewVideo()">
                </p>
            </div>

            <div class="formulario__campos">
                <p>
                    <label for="cID">ID:</label>
                    <input type="text" name="id" id="cID" value="<?php echo "$id_episodio"; ?>" readonly>
                </p>
                <p>
                    <label for="cNumero">Número:</label>
                    <input type="number" name="numero" id="cNumero" min="1" max="2000" placeholder="Digite seu Número" value="<?php echo "$id_numero_episodio"; ?>" autofocus>
                </p>
                <p>
                    <label for="cNome">Nome:</label>
                    <input type="text" name="nome" id="cNome" placeholder="Digite seu Nome" value="<?php echo "$nome_episodio"; ?>">
                </p>
                <?php
                    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
                    while ($linha = mysqli_fetch_array($dados_anime)){
                        $nome_anime = $linha["nome_anime"];
            
                        // Apresentando o id e o nome do anime cujo o episódio será alterado
                        echo "<p>
                            <label for='cAanime'>ID do Anime:</label>
                            <input type='text' value='$id_anime' name='id_anime' id='cAanime' readonly>
                        </p>";
                        echo "<p id='ultimo--campo'>
                            <label for='cNomeAnime'>Nome do Anime:</label>
                            <input type='text' value='$nome_anime' name='nome_anime' id='cNomeAnime' readonly>
                        </p>";
                    };
                ?>
            </div>
            
            <p>
                <button type="submit" name="btn_enviar" class="btns" id="btn__cadastrar">Alterar</button>
                <button type="reset" value="Limpar" class="btns" id="btn__limpar">Limpar</button>
            </p>
        </form>
    </section>

    <script>
        // Prévia de vizualização do vídeo do episódio
        function previewVideo() {
            var video = document.querySelector('input[name=video]').files[0];
            var preview = document.querySelector('video#video__icone');

            var reader = new FileReader();

            reader.onloadend = function(){
                preview.src = reader.result;
            }

            if(video){
                reader.readAsDataURL(video);
            }
            else{
                preview.src = "";
            }
        }
    </script>
</body>
</html>