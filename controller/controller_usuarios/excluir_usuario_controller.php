<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../../model/usuario_model.php';

    // Começará a exclusão caso tenha encontrado o ID do usuário
    if (isset($_GET['id_usuario']) && !empty($_GET['id_usuario'])) {
        $id = $_GET['id_usuario'];
    
        // Buscar o usuário para pegar o seu avatar
        $usuario = buscarUsuarioPorId($pdo, $id);
        $avatar = $usuario['avatar'];
    
        // Excluir usuário
        $sucesso = excluirUsuario($pdo, $id);
    
        if ($sucesso) {
            // Excluir o avatar se existir e não for vazio
            if (!empty($avatar) && file_exists(__DIR__ . "/../../assets/avatar/$avatar")) {
                unlink(__DIR__ . "/../../assets/avatar/$avatar");
            }

            // Redireciona com feedback caso a exclusão dê certo
            header('Location: ../../index.php?page=dados_usuarios&excluido=1');
            exit;
        } else {
            // Redireciona com feedback caso a exclusão dê errado
            header('Location: ../../index.php?page=dados_usuarios&erro=1');
            exit;
        }
    // Caso contrário não vai excluir e dará erro
    } else {
        header('Location: ../../index.php?page=dados_usuarios&erro=1');
        exit;
    }
?>
