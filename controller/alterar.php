<?php
    // Conexão com o Banco de Dados
    include "../model/conectar.php";

    // Pegando id do usuário passado pela url
    $id_usuario = $_GET["id_usuario"];

    // Pesquisando o tipo de usuário para pegar suas informações e apresentar
    $dados_tipo_usuario = $sql -> query("SELECT * FROM tipo_usuario");

    // Pesquisando tudo do usuário que tem o mesmo id passado pela url
    $dados = $sql -> query("SELECT * FROM usuario WHERE id_usuario = $id_usuario");

    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
    while ($linha = mysqli_fetch_array($dados)){
        $id_usuario = $linha["id_usuario"];
        $nome = $linha["nome"];
        $idade = $linha["idade"];
        $email = $linha["email"];
        $senha = $linha["senha"];
        $avatar = $linha["avatar"];
        $tipo = $linha["id_tipo"];
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Editar Usuário</title>
    <link rel="stylesheet" href="../estilizacao/alterar.css">
</head>
<body>
    <a href="../controller/listar.php" id="btn__voltar">Voltar</a>

    <section class="form">
        <!-- Formulário de Alteração de Usuário -->
        <form class="formulario" action="../controller/salvar_alteracao.php" method="post" enctype="multipart/form-data">
            <h1 class="titulo">Edição de Usuário</h1>

            <div class="formulario__avatar">
                <img src="../avatar/<?php echo "$avatar"; ?>" id="usuario__icone">

                <p>
                    <label for="cAvatar" id="label_arquivo">Escolha o seu Avatar:</label>
                    <input type="file" name="avatar" id="cAvatar" onchange="previewImagem()">
                </p>  
            </div>

            <div class="formulario__campos">
                <p>
                    <label for="cID">ID:</label>
                    <input type="text" name="id" id="cID" placeholder="Digite seu ID" value="<?php echo "$id_usuario"; ?>" readonly>
                </p>
                <p>
                    <label for="cNome">Nome:</label>
                    <input type="text" name="nome" id="cNome" placeholder="Digite seu Nome" value="<?php echo "$nome"; ?>" autofocus>
                </p>
                <p>
                    <label for="cIdade">Idade:</label>
                    <input type="number" name="idade" id="cIdade" placeholder="Digite sua Idade" value="<?php echo "$idade"; ?>">
                </p>
                <p>
                    <label for="cEmail">E-mail:</label>
                    <input type="email" name="email" id="cEmail" placeholder="Digite seu E-mail" value="<?php echo "$email"; ?>">
                </p>
                <p>
                    <label for="cSenha">Senha:</label>
                    <input type="password" name="senha" id="cSenha" placeholder="Digite sua Senha" value="<?php echo "$senha"; ?>">
                </p>      
                <p>
                    <label for="cTipo">Tipo:</label>
                    <?php
                        // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
                        while ($linha = mysqli_fetch_array($dados_tipo_usuario)){
                            $id_tipo = $linha["id_tipo"];
                            $nome_tipo = $linha["nome_tipo"];

                            // Se o tipo do usuário for o mesmo cadastrado no banco irá apresentá-lo
                            if ($id_tipo == $tipo){
                                echo "<input type='text' name='tipo' id='cTipo' value='$id_tipo - $nome_tipo' readonly>";
                            }
                        };
                    ?>
                </p>
            </div>

            <p>
                <button type="submit" name="btn_enviar" class="btns" id="btn__cadastrar">Alterar</button>
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