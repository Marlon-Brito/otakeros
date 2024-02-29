<?php
    // Conexão com o Banco de Dados
    include "../../model/conectar.php";

    // Pegando id do anime passado pela url
    $id_anime = $_GET["id_anime"];

    // Pesquisando todos os episódios que tem o mesmo id do anime para pegar suas informações e apresentar
    $result_episodio = ("SELECT * FROM episodio WHERE id_anime = $id_anime");
    // Executa uma consulta no banco de dados (Query: Parâmetro - A string de consulta)
    $resultado_episodio = mysqli_query($sql, $result_episodio);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Dados Episódios</title>
    <link rel="stylesheet" href="../../estilizacao/listar_dados.css">
</head>
<body>
    <a href="../controller_animes/listar_animes.php" id="btn__voltar">Voltar</a>

    <h1 class="titulo__episodios">Dados Episódios</h1>

    <!-- Listagem de dados dos episódios -->
    <main class="conteudo__principal">
        <table class="tabela">
            <thead class="tabela__cabecalho">
                <tr>
                    <th>ID do Episódio</th>
                    <th>Número</th>
                    <th>Nome</th>
                    <th colspan="2">Vídeo</th>
                    <th>ID do Anime</th>
                    <th colspan="2">Ação</th>
                </tr>
            </thead>
    <?php
        // Obtém o número de linhas no resultado
        if (($resultado_episodio) AND ($resultado_episodio->num_rows != 0)){
            // Obtém a próxima linha do conjunto de resultados como um array associativo
            while ($row_episodio = mysqli_fetch_assoc($resultado_episodio)){
                echo "<tbody class='tabela__corpo'>
                    <tr>
                        <td>" . $row_episodio['id_episodio'] . "</td>
                        <td>" . $row_episodio['id_numero_episodio'] . "</td>
                        <td>" . $row_episodio['nome_episodio'] . "</td>
                        <td>
                            <a href='./video/'>" . $row_episodio['video_url_episodio'] . "</a>
                        </td>
                        <td>
                            <video src='./video/" . $row_episodio['video_url_episodio'] . "' class='imagem__episodio' controls></video>
                        </td>
                        <td>" . $row_episodio['id_anime'] . "</td>
                        <td class='icones'>
                            <a href='../controller_episodios/alterar_episodios.php?id_episodio=" . $row_episodio['id_episodio'] . " '><img src='../../imgs/icone-edicao.png'></a>
                        </td>
                        <td class='icones'>
                            <a href='../controller_episodios/excluir_episodios.php?id_episodio=" . $row_episodio['id_episodio'] . " '><img src='../../imgs/icone-excluir.png'></a>
                        </td>
                    </tr>
                </tbody>";
            }
        }
        // Senão nenhum episódio foi encontrado
        else{
            echo "<td colspan='6' id='msg_erro'>Nenhum episódio encontrado...</td>";
        }

        echo "
            <a href='../controller_episodios/cadastrar_episodios.php?id_anime=$id_anime' id='btn__cadastrar'>Cadastrar</a>
        ";
    ?>

</body>
</html>