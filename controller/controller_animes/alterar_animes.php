<?php
    // Conexão com o Banco de Dados
    include "../../model/conectar.php";

    // Pegando id do anime passado pela url
    $id_anime = $_GET["id_anime"];

    // Pesquisando tudo do anime que tem o mesmo id passado pela url
    $dados = $sql -> query("SELECT * FROM anime WHERE id_anime = $id_anime");

    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
    while ($linha = mysqli_fetch_array($dados)){
        $id_anime = $linha["id_anime"];
        $nome = $linha["nome_anime"];
        $descricao = $linha["descricao_anime"];
        $imagem = $linha["imagem_anime"];
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Editar Anime</title>
    <link rel="stylesheet" href="../../estilizacao/alterar_animes.css">
</head>
<body>
    <a href="../controller_animes/listar_animes.php" id="btn__voltar">Voltar</a>

    <section class="form">
        <!-- Formulário de Alteração de Anime -->
        <form class="formulario" action="../controller_animes/salvar_alteracao_animes.php" method="post" enctype="multipart/form-data">
            <h1 class="titulo">Edição de Anime</h1>
            
            <div class="formulario__anime">
                <div id="formulario__avatar">
                    <img src="./imagem/<?php echo "$imagem"; ?>" id="anime__icone">

                    <p>
                        <label for="cImagem" id="label_arquivo">Escolha a imagem do Anime</label>
                        <input type="file" name="imagem" id="cImagem" onchange="previewImagem()">
                    </p>
                </div>
                
                <div class="formulario__campos">
                    <p>
                        <label for="cID">ID:</label>
                        <input type="text" name="id" id="cID" placeholder="Digite seu ID" value="<?php echo "$id_anime"; ?>" readonly>
                    </p>
                    <p>
                        <label for="cNome">Nome:</label>
                        <input type="text" name="nome" id="cNome" placeholder="Digite seu Nome" value="<?php echo "$nome"; ?>" autofocus>
                    </p>
                    <p>
                        <label for="cDescricao">Descrição:</label>
                        <textarea name="descricao" id="cDescricao" cols="50" rows="10" placeholder="Digite sua Descrição"><?php echo "$descricao" ?></textarea>
                    </p>
                </div>
            </div>

            <p>
                <button type="submit" name="btn_enviar" class="btns" id="btn__cadastrar">Alterar</button>
                <button type="reset" value="Limpar" class="btns" id="btn__limpar">Limpar</button>
            </p>
        </form>
    </section>

    <script>
        // Prévia de vizualização da imagem do anime
        function previewImagem() {
            var imagem = document.querySelector('input[name=imagem]').files[0];
            var preview = document.querySelector('img#anime__icone');

            var reader = new FileReader();

            reader.onloadend = function(){
                preview.src = reader.result;
            }

            if(imagem){
                reader.readAsDataURL(imagem);
            }
            else{
                preview.src = "";
            }
        }
    </script>
</body>
</html>