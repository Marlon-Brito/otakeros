<?php
    // Conexão com o Banco de Dados
    include "../../model/conectar.php";

    // Pegando id do anime passado pela url
    $id_anime = $_GET["id_anime"];

    // Pesquisando tudo do anime que tem o mesmo id que veio pela url
    $dados_anime = $sql -> query("SELECT * FROM anime WHERE id_anime = $id_anime");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Cadastrar Episódio</title>
    <link rel="stylesheet" href="../../estilizacao/cadastrar_episodios.css">
</head>
<body>
    <?php
        echo "
            <a href='../controller_episodios/listar_episodios.php?id_anime=$id_anime' id='btn__voltar'>Voltar</a>
        ";
    ?>

    <section class="form">
        <!-- Formulário de Cadastro de Episódio -->
        <form class="formulario" action="../controller_episodios/salvar_episodios.php" method="post" enctype="multipart/form-data">
            <h1 class="titulo">Cadastro de Episódio</h1>

            <div id="formulario__video">
                <video src="./imgs/icone-assistir.png" id="video__icone" controls></video>

                <p>
                    <label for="cVideo" id="label_arquivo">Escolha o vídeo do Episódio:</label>
                    <input type="file" name="video" id="cVideo" onchange="previewVideo()">
                </p>
            </div>

            <div class="formulario__campos">
                <p>
                    <label for="cNumero">Número do Episódio:</label>
                    <input type="number" name="numero" id="cNumero" min="1" max="2000" placeholder="Digite seu Número" autofocus>
                </p>
                <p>
                    <label for="cNome">Nome do Episódio:</label>
                    <input type="text" name="nome" id="cNome" placeholder="Digite seu Nome">
                </p>
                <?php
                    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
                    while ($linha = mysqli_fetch_array($dados_anime)){
                        $id_anime = $linha["id_anime"];
                        $nome_anime = $linha["nome_anime"];

                        // Apresentando o id e o nome do anime cujo o episódio será cadastrado
                        echo "<p>
                            <label for='cIdAnime'>ID do Anime:</label>
                            <input type='text' value='$id_anime' name='anime' id='cIdAnime' readonly>
                        </p>";
                        echo "<p>
                            <label for='cNomeAnime'>Nome do Anime:</label>
                            <input type='text' value='$nome_anime' name='nome_anime' id='cNomeAnime' readonly>
                        </p>";
                    };
                ?>
            </div>

            <p>
                <button type="submit" name="btn_enviar" class="btns" id="btn__cadastrar">Cadastrar</button>
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