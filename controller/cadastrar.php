<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Cadastrar Usuário</title>
    <link rel="stylesheet" href="../estilizacao/cadastrar.css">
</head>
<body>
    <a href="./listar.php" id="btn__voltar">Voltar</a>

    <section class="form">
        <!-- Formulário de Cadastro de Usuário -->
        <form class="formulario" action="../controller/salvar.php" method="post" enctype="multipart/form-data">
            <h1 class="titulo">Cadastro de Usuário</h1>
            
            <div id="formulario__avatar">
                <img src="../imgs/icone-usuario.png" id="usuario__icone">

                <p>
                    <label for="cAvatar" id="label_arquivo">Escolha o seu Avatar</label>
                    <input type="file" name="avatar" id="cAvatar" onchange="previewImagem()">
                </p>
            </div>

            <div class="formulario__campos">
                <p>
                    <label for="cNome">Nome:</label>
                    <input type="text" name="nome" id="cNome" placeholder="Digite seu Nome" autofocus>
                </p>
                <p>
                    <label for="cIdade">Idade:</label>
                    <input type="number" name="idade" id="cIdade" placeholder="Digite sua Idade" min="1" max="150" step="1">
                </p>
                <p>
                    <label for="cEmail">E-mail:</label>
                    <input type="email" name="email" id="cEmail" placeholder="Digite seu E-mail">
                </p>
                <p>
                    <label for="cSenha">Senha:</label>
                    <input type="password" name="senha" id="cSenha" placeholder="Digite sua Senha">
                </p>
            </div>

            <p>
                <button type="submit" name="btn_enviar" class="btns" id="btn__cadastrar">Cadastrar</button>
                <button type="reset" value="Limpar" class="btns" id="btn__limpar">Limpar</button>
            </p>
        </form>
    </section>

    <script>
        // Prévia de vizualização da imagem do usuário
        function previewImagem() {
            var imagem = document.querySelector('input[name=avatar]').files[0];
            var preview = document.querySelector('img#usuario__icone');

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