<?php
    // Conexão com o Banco de Dados
    include "../model/conectar.php";

    // Pesquisando todos os usuários para pegar suas informações e apresentar
    $result_usuario = ("SELECT * FROM usuario");
    // Executa uma consulta no banco de dados (Query: Parâmetro - A string de consulta)
    $resultado_usuario = mysqli_query($sql, $result_usuario);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Dados Usuários</title>
    <link rel="stylesheet" href="../estilizacao/listar_dados.css">
</head>
<body>
    <a href="../view/pagina_perfil_administrador.php" id="btn__voltar">Voltar</a>

    <h1 class="titulo__usuarios">Dados Usuários</h1>

    <a href="./cadastrar.php" id="btn__cadastrar">Cadastrar</a>

    <!-- Listagem de dados dos usuários -->
    <main class="conteudo__principal">
        <table class="tabela">
            <thead class="tabela__cabecalho">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>E-mail</th>
                    <th>Senha</th>
                    <th>Avatar</th>
                    <th>Tipo</th>
                    <th colspan="2">Ação</th>
                </tr>
            </thead>
    <?php
        // Obtém o número de linhas no resultado
        if (($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
            // Obtém a próxima linha do conjunto de resultados como um array associativo
            while ($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
                echo "<tbody class='tabela__corpo'>
                    <tr>
                        <td>" . $row_usuario['id_usuario'] . "</td>
                        <td>" . $row_usuario['nome'] . "</td>
                        <td>" . $row_usuario['idade'] . "</td>
                        <td>" . $row_usuario['email'] . "</td>
                        <td>" . $row_usuario['senha'] . "</td>"; ?>

                        <td><img src='../avatar/<?php if (empty($row_usuario['avatar'])){echo '../imgs/icone-usuario.png';}else{echo $row_usuario['avatar'];} ?>' class='imagem__usuario'></td>

                        <?php echo "<td>" . $row_usuario['id_tipo'] . "</td>
                        <td class='icones'>
                            <a href='../controller/alterar.php?id_usuario=" . $row_usuario['id_usuario'] . " '><img src='../imgs/icone-edicao.png'></a>
                        </td>
                        <td class='icones'>
                            <a href='../controller/excluir.php?id_usuario=" . $row_usuario['id_usuario'] . " '><img src='../imgs/icone-excluir.png'></a>
                        </td>
                    </tr>
                </tbody>";
            }
        }
        // Senão nenhum usuário foi encontrado
        else{
            echo "<td colspan='8' class='msg__erro'>Nenhum usuário encontrado...</td>";
        }
    ?>
</body>
</html>