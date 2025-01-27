<?php
    // Conexão com o Banco de Dados
    include "../../model/conectar.php";

    // Pegando id do episódio passado pela url
    $id_episodio = $_GET["id_episodio"];

    // Pesquisando o vídeo do episódio que tem o mesmo id passado pela url
    $dados = $sql -> query("SELECT * FROM episodio WHERE id_episodio = $id_episodio");

    // Busca uma linha de dados do conjunto de resultados e a retorna como uma matriz (seja array associativo, numérico ou ambos)
    while ($linha = mysqli_fetch_array($dados)){
        $video = $linha["video_url_episodio"];
        $id_anime = $linha["id_anime"];
    }

    // Executa uma consulta no banco de dados (Query: Parâmetro - A string de consulta)
    // Deletando episódio usando seu id como recurso. E fazendo o mesmo com seu vídeo
    mysqli_query($sql, "DELETE FROM episodio WHERE id_episodio = '$id_episodio' ");
    unlink("./video/$video");

    // Redirecionar para a lista de episódios
    echo "<script>alert('Episódio excluído com sucesso!');</script>";
    echo "<script>location.href='../controller_episodios/listar_episodios.php?id_anime=$id_anime';</script>";
?>