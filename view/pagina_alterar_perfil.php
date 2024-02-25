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
    <title>Otakeros - Editar Perfil</title>
    <link rel="stylesheet" href="../estilizacao/alterar.css">
</head>
<body>
    <a href="./pagina_home.php" id="btn__voltar">Voltar</a>

    <section class="form">
        <!-- Formulário de Alteração de Perfil -->
        <form class="formulario" action="../controller/controller_perfil/salvar_alteracao_perfil.php" method="post" enctype="multipart/form-data">
            <h1 class="titulo">Edição de Perfil</h1>

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
                    <input type="text" name="id" id="cID" placeholder="Digite seu ID" value="<?php echo $id_usuario; ?>" readonly>
                </p>
                <p>
                    <label for="cNome">Nome:</label>
                    <input type="text" name="nome" id="cNome" placeholder="Digite seu Nome" value="<?php echo $nome; ?>" autofocus>
                </p>
                <p>
                    <label for="cIdade">Idade:</label>
                    <input type="number" name="idade" id="cIdade" placeholder="Digite sua Idade" value="<?php echo $idade; ?>">
                </p>
                <p>
                    <label for="cEmail">E-mail:</label>
                    <input type="email" name="email" id="cEmail" placeholder="Digite seu E-mail" value="<?php echo $email; ?>">
                </p>
                <p>
                    <label for="cSenha">Senha:</label>
                    <input type="password" name="senha" id="cSenha" placeholder="Digite sua Senha" value="<?php echo $senha; ?>">
                </p>    
                <p>
                    <label for="cTipo">Tipo:</label>
                    <?php
                        // Pesquisando o tipo de usuário para pegar suas informações e apresentar
                        $dados_tipo_usuario = $sql -> query("SELECT * FROM tipo_usuario");

                        // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)                                  
                        while ($linha = mysqli_fetch_array($dados_tipo_usuario)){
                            $id_tipo = $linha["id_tipo"];
                            $nome_tipo = $linha["nome_tipo"];

                            // Verificando se o tipo de usuário que está vindo é o mesmo do banco de dados
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
        // Prévia de vizualização da imagem do perfil do usuário
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