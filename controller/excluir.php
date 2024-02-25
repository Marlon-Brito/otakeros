<?php
    // Conexão com o Banco de Dados
    include "../model/conectar.php";

    // Pegando id do usuário passado pela url
    $id_usuario = $_GET["id_usuario"];

    // Pesquisando o avatar do usuário que tem o mesmo id passado pela url
    $dados = $sql -> query("SELECT avatar FROM usuario WHERE id_usuario = $id_usuario");

    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
    while ($linha = mysqli_fetch_array($dados)){
        $avatar = $linha["avatar"];
    }

    // Executa uma consulta no banco de dados (Query: Parâmetro - A string de consulta)
    // Deletando usuário usando seu id como recurso. E fazendo o mesmo com sua imagem
    mysqli_query($sql, "DELETE FROM usuario WHERE id_usuario = '$id_usuario' ");
    unlink("../avatar/$avatar");

    // Redirecionar para a lista de usuários
    echo "<script>alert('Usuário excluído com sucesso!');</script>";
    echo "<script>location.href='../controller/listar.php';</script>";
?>