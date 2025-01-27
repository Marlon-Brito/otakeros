<?php
    // Conexão com o Banco de Dados
    include "../../model/conectar.php";

    // Selecionando os campos através dos arrays de POST que vem com as propriedades NAME do form
    $id_anime = $_POST["id"];
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];

    // Pesquisando a imagem do anime que tem o mesmo id que veio do form
    $dados = $sql -> query("SELECT imagem_anime FROM anime WHERE id_anime = $id_anime");

    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
    while ($linha = mysqli_fetch_array($dados)){
        $imagem = $linha["imagem_anime"];
    }

    // Isso tudo para deletar sua imagem atual e fazer upload da nova ao alterar
    unlink("./imagem/$imagem");
   
    // Controle do envio do arquivo de upload
    if(isset($_POST['btn_enviar'])){
        $tipos_permitidos = ['jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG'];
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);

        // Verificar no array de tipos permitidos se existe a extensão do arquivo
        if (in_array($extensao, $tipos_permitidos)){
            $uploaddir = './imagem/';
            $temporario = $_FILES['imagem']['tmp_name'];
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

    // Alterar os dados do anime no banco
    $sql -> query("UPDATE anime SET
        nome_anime = '$nome', 
        descricao_anime = '$descricao', 
        imagem_anime = '$uploadfile'
        WHERE id_anime = $id_anime
    ");
    
    // Redirecionar para a lista de animes
    echo "<script>alert('Anime alterado com sucesso!');</script>";
    echo "<script>location.href='../controller_animes/listar_animes.php';</script>";
?>