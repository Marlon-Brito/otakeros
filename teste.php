<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/controller/funcoes.php';

    iniciarSessao(); // Inicia a sessão senão existir uma

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Fallback se não tiver ?page=... mas talvez esteja usando URL amigável
    $page = $_GET['page'] ?? null;

    // Se a URL amigável falhou (não setou $_GET), tenta pegar a última página usada
    if (!$page) {
        if (isset($_SESSION['pagina_ativa'])) {
            $page = $_SESSION['pagina_ativa'];
        } elseif (isset($_SESSION['tipo_session']) && $_SESSION['tipo_session'] == 1) {
            $page = 'dashboard';
        } else {
            $page = 'home';
        }
    } else {
        // Se foi definida, salva na sessão
        $_SESSION['pagina_ativa'] = $page;
    }

    // Roteamento simples
    switch ($page) {
        // Página inicial (Home)
        case 'home':
            require_once './controller/home_controller.php';
            break;
        // Fazer login ou entrar/acessar o site com uma conta
        case 'login':
            require_once './view/pagina_login.php';
            break;
        // Episódios dos animes
        case 'episodios':
            require_once './controller/episodios_controller.php';
            break;
        // Assistir episódios específicos de um anime
        case 'assistir':
            require_once './controller/assistir_controller.php';
            break;
        // Assistir episódios específicos de um anime
        case 'pesquisar':
            require_once './controller/pesquisar_controller.php';
            break;

        // Cadastrar e salvar perfil de usuário
        case 'cadastrar_perfil':
            require_once './view/pagina_cadastrar_perfil.php';
            break;
        case 'salvar_perfil':
            require_once './controller/controller_perfis/cadastrar_perfil_controller.php';
            break;
        // Editar e salvar edição de perfil de usuário
        case 'editar_perfil':
            require_once './view/pagina_alterar_perfil.php';
            break;
        case 'salvar_edicao_perfil':
            require_once './controller/controller_perfis/alterar_perfil_controller.php';
            break;

        // Erro de url
        case 'erro_url':
            require_once './view/pagina_erro_url.html';
            break;
        // Dashboard do administrador
        case 'dashboard':
            require_once './view/pagina_perfil_administrador.php';
            break;

        // Listar dados dos usuários
        case 'dados_usuarios':
            require_once './controller/controller_usuarios/listar_usuario_controller.php';
            break;
        // Cadastrar e salvar dados de usuários
        case 'cadastrar_usuario':
            require_once './view/pagina_cadastrar_usuario.php';
            break;
        case 'salvar_usuario':
            require_once './controller/controller_usuarios/cadastrar_usuario_controller.php';
            break;
        // Alterar dados dos usuários
        case 'editar_usuario':
            require_once './controller/controller_usuarios/alterar_usuario_controller.php';
            break;
        // Excluir dados dos usuários
        case 'excluir_usuario':
            require_once './controller/controller_usuarios/excluir_usuario_controller.php';
            break;

        // Listar dados dos animes
        case 'dados_animes':
            require_once './controller/controller_animes/listar_anime_controller.php';
            break;
        // Cadastrar e salvar dados de animes
        case 'cadastrar_anime':
            require_once './view/pagina_cadastrar_anime.php';
            break;
        case 'salvar_anime':
            require_once './controller/controller_animes/cadastrar_anime_controller.php';
            break;
        // Alterar dados dos animes
        case 'editar_anime':
            require_once './controller/controller_animes/alterar_anime_controller.php';
            break;
        // Excluir dados dos animes
        case 'excluir_anime':
            require_once './controller/controller_animes/excluir_anime_controller.php';
            break;

        // Listar dados dos episódios
        case 'dados_episodios':
            require_once './controller/controller_episodios/listar_episodio_controller.php';
            break;
        // Cadastrar e salvar dados de episódios
        case 'cadastrar_episodio':
            require_once './view/pagina_cadastrar_episodio.php';
            break;
        case 'salvar_episodio':
            require_once './controller/controller_episodios/cadastrar_episodio_controller.php';
            break;
        // Alterar dados dos episódios
        case 'editar_episodio':
            require_once './controller/controller_episodios/alterar_episodio_controller.php';
            break;
        // Excluir dados dos episódios
        case 'excluir_episodio':
            require_once './controller/controller_episodios/excluir_episodio_controller.php';
            break;

        // Redirecionar para página própria de NOT FOUND
        default:
            require_once './view/pagina_erro_404.html';
            break;
    }
?>
