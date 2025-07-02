<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../controller/funcoes.php';

    protegerPagina(1); // Só adms são permitidos nesta página

    $nome = $_SESSION["nome_session"] ?? "Administrador"; // Trazendo o nome do adm
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Administrador</title>
    <link rel="shortcut icon" href="../assets/imgs/favicon-16x16.png" type="image/x-icon">
    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter&display=swap" rel="stylesheet">
    <!-- TailswindCSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="text-white text-base font-[Inter]">
    <div class="bg-stone-900">
        <!-- Cabeçalho Admin -->
        <?php include __DIR__ . "/components/header_admin.php"; ?>

        <!-- Conteúdo Principal -->
        <main class="bg-linear-to-b from-stone-950 to-stone-900 pt-5 xl:pt-10">
            <h1 class="font-[Bebas_Neue] text-2xl text-amber-400 text-center border-y border-amber-400 sm:text-3xl sm:p-2 xl:text-4xl">Dashboard</h1>
            <!-- Interface de gerenciamento e monitoramento dos dados -->
            <div class="flex flex-col mx-auto w-full max-w-6xl md:flex-row md:justify-evenly md:py-16 md:items-center">
                <section class="flex flex-col md:px-2">
                    <p class="text-center my-5 text-base sm:text-lg xl:text-xl max-w-sm mx-auto">Seja bem-vindo adm. 
                        <span class="font-[Bebas_Neue] text-lg text-amber-400 sm:text-xl xl:text-2xl"><?= $nome; ?></span>!
                        O que deseja fazer dessa vez?
                    </p>

                    <img src="../assets/imgs/icone-admin.png" alt="Administrador" class="w-48 my-2 mx-auto xl:w-64 xl:my-4">

                    <!-- Ver dados de usuários ou de animes -->
                    <div class="flex flex-col justify-center items-center">
                        <a href="../index.php?page=dados_usuarios" class="block text-center cursor-pointer border-1 border-green-500 text-green-500 mt-4 py-1 px-2 hover:text-black hover:bg-green-500 xl:py-2 xl:px-4 xl:text-xl duration-500 ease-in-out w-60 sm:w-xs xl:w-md" id="btn__cadastrar">
                            Usuários
                        </a>

                        <a href="../index.php?page=dados_animes" class="block text-center cursor-pointer border-1 border-blue-500 text-blue-500 mt-4 py-1 px-2 hover:text-black hover:bg-blue-500 xl:py-2 xl:px-4 xl:text-xl duration-500 ease-in-out w-60 sm:w-xs xl:w-md">
                            Animes
                        </a>
                    </div>
                </section>

                <section class="my-8 text-justify md:px-2">
                    <h2 class="font-[Bebas_Neue] text-2xl text-amber-400 text-center border-y border-amber-400 sm:text-3xl sm:p-2 xl:text-4xl">Usuários:</h2>
                    <p class="p-4 max-w-md mx-auto xl:p-8 sm:text-lg xl:text-xl xl:max-w-xl">Esta é a área de informações de Usuários, podendo-se: cadastrar, alterar, visualizar e deletar seus dados.</p>

                    <h2 class="font-[Bebas_Neue] text-2xl text-amber-400 text-center border-y border-amber-400 sm:text-3xl sm:p-2 xl:text-4xl">Animes:</h2>
                    <p class="p-4 max-w-md mx-auto xl:p-8 sm:text-lg xl:text-xl xl:max-w-xl">Esta é a área de informações de Animes, podendo-se: cadastrar, alterar, visualizar e deletar seus dados. Podendo-se também fazer o mesmo para os seus respectivos Episódios.</p>
                </section>
            </div>

            <!-- Banner padrão -->
            <?php include __DIR__ . "/components/banner_padrao.php"; ?>
        </main>

        <!-- Rodapé -->
        <?php include __DIR__ . "/components/footer.php"; ?>
    </div>
</body>
</html>
