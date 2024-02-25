<?php
    // Conexão com o Banco de Dados
    include "../../model/conectar.php";

    // Pesquisando todos os animes para pegar suas informações e apresentar
    $result_anime = ("SELECT * FROM anime");
    // Executa uma consulta no banco de dados (Query: Parâmetro - A string de consulta)
    $resultado_anime = mysqli_query($sql, $result_anime);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Dados Animes</title>
    <link rel="stylesheet" href="../../estilizacao/listar_dados.css">
</head>
<body>
    <a href="../../view/pagina_perfil_administrador.php" id="btn__voltar">Voltar</a>

    <h1 class="titulo__animes">Dados Animes</h1>

    <a href="../controller_animes/cadastrar_animes.php" id="btn__cadastrar">Cadastrar</a>
    
    <!-- Listagem de dados dos animes -->
    <main class="conteudo__principal">
        <table class="tabela">
            <thead class="tabela__cabecalho">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Imagem</th>
                    <th colspan="3">Ação</th>
                </tr>
            </thead>
    <?php
        // Obtém o número de linhas no resultado
        if (($resultado_anime) AND ($resultado_anime->num_rows != 0)){
            // Obtém a próxima linha do conjunto de resultados como um array associativo
            while ($row_anime = mysqli_fetch_assoc($resultado_anime)){
                echo "<tbody class='tabela__corpo'>
                    <tr>
                        <td>" . $row_anime['id_anime'] . "</td>
                        <td>" . $row_anime['nome_anime'] . "</td>
                        <td>" . $row_anime['descricao_anime'] . "</td>
                        <td><img src='./imagem/" . $row_anime['imagem_anime'] . "' style='width: 100px;'></td>
                        <td class='icones'>
                            <a href='../controller_animes/alterar_animes.php?id_anime=" . $row_anime['id_anime'] . " '>
                                <img src='../../imgs/icone-edicao.png'>
                            </a>
                        </td>
                        <td class='icones'>
                            <a href='../controller_animes/excluir_animes.php?id_anime=" . $row_anime['id_anime'] . " '>
                                <img src='../../imgs/icone-excluir.png'>
                            </a>
                        </td>
                        <td class='icones'>
                            <a href='../controller_episodios/listar_episodios.php?id_anime=" . $row_anime['id_anime'] . " '>
                                <img src='../../imgs/icone-episodios.png'>
                            </a>
                        </td>
                    </tr>
                </tbody>";  
            }
        }
        // Senão nenhum anime foi encontrado
        else{
            echo "<td colspan='5' id='msg_erro'>Nenhum anime encontrado...</td>";
        }
    ?>
</body>
</html>