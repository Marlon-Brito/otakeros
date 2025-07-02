<?php
    // Verifica se a sessão está iniciada, senão irá iniciar uma nova, assim impedindo a abertura de múltiplas sessões
    function iniciarSessao(){
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    // Verifica se a sessão está ativa, senão estiver redireciona para a página de erro
    function verificarSessao(){
        if (
            empty($_SESSION["id_usuario_session"]) ||
            empty($_SESSION["tipo_session"])
        ) {
            header("location: ../view/pagina_erro_url.html");
            exit;
        }
    }

    // Verificando se o tipo de usuário é válido (admin ou expectador)
    function verificarTipoUsuario($tipoEsperado){
        if ($_SESSION["tipo_session"] != $tipoEsperado) {
            header("location: ../view/pagina_erro_url.html");
            exit;
        }
    }

    // Ao deslogar se destrói a sessão
    function realizarLogout(){
        if (isset($_GET['logout'])) {
            session_destroy();
            header('location: ../index.php');
            exit;
        }
    }

    // Protegendo a página para somente um nicho específico de usuários poder acessá-la
    function protegerPagina($tipoEsperado = null){
        // Garantindo que tenha uma sessão
        iniciarSessao();

        // Impedir cache de páginas protegidas
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // Confirmando que a sessão é válida
        verificarSessao();

        // Vendo se o tipo do usuário não está nulo
        if (!is_null($tipoEsperado)) {
            verificarTipoUsuario($tipoEsperado);
        }
    }

    // Tirando acentos para uma melhor nomeação de arquivos
    function removerAcentos($string){
        $acentos = array(
            'á','à','ã','â','ä',
            'é','è','ê','ë',
            'í','ì','î','ï',
            'ó','ò','õ','ô','ö',
            'ú','ù','û','ü',
            'ç','ñ',
            'Á','À','Ã','Â','Ä',
            'É','È','Ê','Ë',
            'Í','Ì','Î','Ï',
            'Ó','Ò','Õ','Ô','Ö',
            'Ú','Ù','Û','Ü',
            'Ç','Ñ'
        );
    
        $sem_acentos = array(
            'a','a','a','a','a',
            'e','e','e','e',
            'i','i','i','i',
            'o','o','o','o','o',
            'u','u','u','u',
            'c','n',
            'A','A','A','A','A',
            'E','E','E','E',
            'I','I','I','I',
            'O','O','O','O','O',
            'U','U','U','U',
            'C','N'
        );

        // Substitui os caracteres com acentos pelos sem acentos numa determinada string
        return str_replace($acentos, $sem_acentos, $string);
    }
?>
