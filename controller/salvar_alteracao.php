<?php
    // Conexão com o Banco de Dados
    include "../model/conectar.php";

    // Selecionando os campos através dos arrays de POST que vem com as propriedades NAME do form
    $id_usuario = $_POST["id"];
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $tipo = $_POST["tipo"];

    // Pesquisando o avatar do usuário que tem o mesmo id que veio do form
    $dados = $sql -> query("SELECT avatar FROM usuario WHERE id_usuario = $id_usuario");

    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
    while ($linha = mysqli_fetch_array($dados)){
        $avatar = $linha["avatar"];
    }

    // Isso tudo para deletar sua imagem atual e fazer upload da nova ao alterar
    unlink("../avatar/$avatar");
     
    // Controle do envio do arquivo de upload
    if(isset($_POST['btn_enviar'])){
        $tipos_permitidos = ['jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG'];
        $extensao = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

        // Verificar no array de tipos permitidos se existe a extensão do arquivo
        if (in_array($extensao, $tipos_permitidos)){
            $uploaddir = '../avatar/';
            $temporario = $_FILES['avatar']['tmp_name'];
            $uploadfile = $nome . '.' . $extensao;

            // Fazer upload do arquivo de fato
            if (move_uploaded_file($temporario, $uploaddir.$uploadfile)){
                echo '<p>Upload realizado!</p>';
            }else{
                echo '<p>Falha no Upload!</p>';
            }
        }else{
            // Senão é porque o seu tipo não é permitido
            echo "<script>alert('Sem imagem ou Tipo do arquivo não é permitido! Não foi possível concluir o upload da imagem...');</script>";
        }
    }

    // Alterar os dados do usuário no banco
    $sql -> query("UPDATE usuario SET
        nome = '$nome', 
        idade = '$idade', 
        email = '$email', 
        senha = '$senha', 
        avatar = '$uploadfile'
        WHERE id_usuario = $id_usuario
    ");

    // Redirecionar para a lista de usuários
    echo "<script>alert('Usuário alterado com sucesso!');</script>";
    echo "<script>location.href='../controller/listar.php';</script>";
?>