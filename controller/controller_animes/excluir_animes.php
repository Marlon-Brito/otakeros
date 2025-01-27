<?php
    // Conexão com o Banco de Dados
    include "../../model/conectar.php";

    // Pegando id do anime passado pela url
    $id_anime = $_GET["id_anime"];

    // Pesquisando a imagem do anime que tem o mesmo id passado pela url
    $dados = $sql -> query("SELECT imagem_anime FROM anime WHERE id_anime = $id_anime");

    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
    while ($linha = mysqli_fetch_array($dados)){
        $imagem = $linha["imagem_anime"];
    }

    // Executa uma consulta no banco de dados (Query: Parâmetro - A string de consulta)
    // Deletando anime usando seu id como recurso. E fazendo o mesmo com sua imagem
    mysqli_query($sql, "DELETE FROM anime WHERE id_anime = '$id_anime' ");
    unlink("./imagem/$imagem");

    // Redirecionar para a lista de animes
    echo "<script>alert('Anime excluído com sucesso!');</script>";
    echo "<script>location.href='../controller_animes/listar_animes.php';</script>";
?>