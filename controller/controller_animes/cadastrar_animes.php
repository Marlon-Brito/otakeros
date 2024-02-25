<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Cadastrar Anime</title>
    <link rel="stylesheet" href="../../estilizacao/cadastrar_animes.css">
</head>
<body>
    <a href="../controller_animes/listar_animes.php" id="btn__voltar">Voltar</a>

    <section class="form">
        <!-- Formulário de Cadastro de Anime -->
        <form class="formulario" action="../controller_animes/salvar_animes.php" method="post" enctype="multipart/form-data">
            <h1 class="titulo">Cadastro de Anime</h1>
            
                <div class="formulario__anime">
                    <div id="formulario__avatar">
                        <img src="../../imgs/icone-quadro.png" id="anime__icone">
                        <p>
                            <label for="cImagem" id="label_arquivo">Escolha a imagem do Anime</label>
                            <input type="file" name="imagem" id="cImagem" onchange="previewImagem()">
                        </p>
                    </div>
                    <div class="formulario__campos">
                        <p>
                            <label for="cNome">Nome do Anime:</label>
                            <input type="text" name="nome" id="cNome" placeholder="Digite seu Nome" autofocus>
                        </p>
                        <p>
                            <label for="cDescricao">Descrição do Anime:</label>
                            <textarea name="descricao" id="cDescricao" cols="50" rows="10" placeholder="Digite sua Descrição"></textarea>
                        </p>
                    </div>
                </div>

            <p>
                <button type="submit" name="btn_enviar" class="btns" id="btn__cadastrar">Cadastrar</button>
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