<?php
    require_once __DIR__ . '/../controller/login_controller.php';

    // Captura os erros da sessão (vindos do controller) para exibição
    $erros = $_SESSION['erros_login'] ?? [];
    unset($_SESSION['erros_login']); // Limpa os erros após exibir
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Entrar</title>
    <link rel="shortcut icon" href="../assets/imgs/favicon-16x16.png" type="image/x-icon">
    <!-- Ícones -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter&display=swap" rel="stylesheet">
    <!-- TailswindCSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gradient-to-b from-stone-950 to-stone-900 text-white text-base font-[Inter]">
    <main class="flex flex-col mt-5 justify-center items-center md:my-0 md:grid md:grid-cols-2">
        <div class="min-w-3xs max-w-[300px] mx-auto">
            <a href="?page=home" class="block p-1 mt-5 border-1 border-stone-500 text-stone-500 w-20 text-center mx-auto hover:bg-stone-500 hover:text-stone-900 xl:text-xl xl:px-2 duration-500 ease-in-out">Voltar</a>

            <h1 class="font-[Bebas_Neue] text-2xl text-amber-400 text-center border-y border-amber-400 mt-5 sm:text-3xl sm:p-2 xl:text-4xl">Login</h1>

            <!-- Formulário de login -->
            <form action="" class="flex flex-col rounded-md mx-auto py-5" method="post">
                <img src="../assets/imgs/icone-usuario.jpg" alt="Ícone de Usuário" class="rounded-full w-25 mx-auto xl:w-50">

                <div class="flex mt-4 justify-center">
                    <i class="bi bi-person-fill bg-linear-to-r from-amber-300 to-orange-400 text-black p-1 text-xl xl:px-2 xl:text-2xl"></i>
                    <input type="email" name="login" id="cLogin" autofocus placeholder="Digite seu e-mail" class="bg-white text-black py-1 px-2 focus:outline-none sm:text-lg sm:w-lg xl:w-6xl xl:text-xl xl:py-2 xl:px-4">
                </div>

                <div class="flex mt-4 justify-center">
                    <i class="bi bi-lock-fill bg-linear-to-r from-amber-300 to-orange-400 text-black p-1 text-xl xl:px-2 xl:text-2xl"></i>
                    <input type="password" name="senha" id="cSenha" placeholder="Digite sua senha" class="bg-white text-black py-1 px-2 focus:outline-none sm:text-lg sm:w-lg xl:w-6xl xl:text-xl xl:py-2 xl:px-4">
                </div>

                <input type="submit" name="btn_entrar" value="Entrar" class="cursor-pointer border-1 border-green-500 text-green-500 mt-4 py-1 hover:text-black hover:bg-green-500 xl:py-2 xl:text-xl duration-500 ease-in-out" id="btn__entrar">
            </form>

            <!-- Formulário de cadastro -->
            <div class="text-center">
                <span class="text-sm xl:text-lg">Não possui uma conta? É só se cadastrar!</span>
                <a href="../index.php?page=cadastrar_perfil" class="block text-center mb-5 cursor-pointer border-1 border-blue-500 text-blue-500 mt-4 py-1 hover:text-black hover:bg-blue-500 xl:py-2 xl:text-xl duration-500 ease-in-out">Cadastrar</a>
            </div>
        </div>

        <!-- Banner responsivo -->
        <?php include __DIR__ . "/components/banner_responsivo.php"; ?>
    </main>

    <!-- Usando a biblioteca SweetAlert2, que oferece alertas super estilosos -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Erros de login -->
    <?php if (!empty($erros)): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro ao fazer login',
                html: `<?= implode('<br>', array_map('htmlspecialchars', $erros)) ?>`,
                confirmButtonColor: '#d33'
            });
        </script>
    <?php endif; ?>

    <!-- Cadastrando com um alerta personalizado -->
    <?php if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'ok'): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Você foi cadastrado com sucesso!',
                confirmButtonColor: '#3085d6'
            });

            // Limpa os parâmetros da URL depois
            if (window.location.search.includes('cadastro=ok')) {
                window.history.replaceState(null, '', window.location.pathname);
            }
        </script>
    <?php endif; ?>
</body>
</html>
