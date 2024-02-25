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

    // Conexão com o Banco de Dados
    include "../../model/conectar.php";

    // Selecionando os campos através dos arrays de POST que vem com as propriedades NAME do form
    $id_usuario = $_POST["id"];
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Pesquisando o avatar do usuário que tem o mesmo id que veio do form
    $dados = $sql -> query("SELECT avatar FROM usuario WHERE id_usuario = $id_usuario");

    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
    while ($linha = mysqli_fetch_array($dados)){
        $avatar = $linha["avatar"];
    }

    // Isso tudo para deletar sua imagem atual e fazer upload da nova ao alterar
    unlink("../../avatar/$avatar");
     
    // Controle do envio do arquivo de upload
    if(isset($_POST['btn_enviar'])){
        $tipos_permitidos = ['jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG'];
        $extensao = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

        // Verificar no array de tipos permitidos se existe a extensão do arquivo
        if (in_array($extensao, $tipos_permitidos)){
            $uploaddir = '../../avatar/';
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
           $uploadfile = '';
        }
    }

    // Alterar os dados do perfil do usuário no banco
    $sql -> query("UPDATE usuario SET
        nome = '$nome', 
        idade = '$idade', 
        email = '$email', 
        senha = '$senha', 
        avatar = '$uploadfile'
        WHERE id_usuario = $id_usuario
    ");

    // Um array associativo contendo variáveis ​​de sessão disponíveis para o script atual
    // Atualizando as variáveis de sessão com os novos dados do perfil do usuário
    $_SESSION["id_usuario_session"] = $id_usuario;
    $_SESSION["nome_session"] = $nome;
    $_SESSION["idade_session"] = $idade;
    $_SESSION["login_session"] = $email;
    $_SESSION["senha_session"] = $senha;
    $_SESSION["avatar_session"] = $uploadfile;

    // Redirecionar para a página home
    echo "<script>alert('Perfil alterado com sucesso!');</script>";
    echo "<script>location.href='../../view/pagina_home.php';</script>";
?>