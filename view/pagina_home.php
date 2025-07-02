<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Home</title>
    <!-- Favicon -->
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
        <!-- Cabeçalho -->
        <?php include __DIR__ . "/components/header.php"; ?>

        <!-- Conteúdo Principal -->
        <main>
            <div class="bg-linear-to-b from-stone-950 to-stone-900 text-center py-10 px-2">
                <h1 class="text-2xl sm:text-3xl xl:text-4xl text-amber-400">Seja bem-vindo a 
                    <span class="font-[Bebas_Neue] text-3xl text-white sm:text-4xl xl:text-5xl">OTAKEROS</span>!
                </h1>
                <p class="my-5 text-base sm:text-lg xl:text-xl">Assista animes de forma online e gratuita a qualquer momento e lugar!</p>
            </div>

            <section class="flex flex-col">
                <h2 class="font-[Bebas_Neue] text-2xl text-amber-400 text-center border-y border-amber-400 sm:text-3xl sm:p-2 xl:text-4xl">Lista de Animes</h2>

                <!-- Campo de pesquisa de animes -->
                <form action="../index.php?page=pesquisar" method="post" class="flex justify-center my-5">
                    <div class="flex items-stretch">
                        <input type="text" name="pesquisar" class="bg-white text-black py-1 px-2 sm:text-lg sm:w-lg xl:w-6xl xl:text-xl xl:py-2 xl:px-4 focus:outline-none" placeholder="Digite o nome de um anime..." required>
                        <button type="submit">
                            <img src="../assets/imgs/icone-lupa.png" alt="Pesquisar" class="px-2 py-1 xl:px-4 xl:py-2 bg-linear-to-r from-amber-300 to-orange-400 cursor-pointer">
                        </button>
                    </div>
                </form>

                <!-- Lista de animes -->
                <nav>
                    <ul class="grid grid-cols-2 max-w-sm sm:max-w-3xl xl:max-w-7xl mx-auto sm:grid-cols-2 justify-items-center items-center lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 2xl:max-w-[1500px]">
                        <!-- Percorrendo por cada um dos animes da lista para exibir suas informações -->
                        <?php foreach ($animes as $anime): ?>
                            <li class="w-32 h-60 sm:w-48 sm:h-[320px] xl:w-60 xl:h-[400px] flex items-center justify-center bg-gradient-to-b from-amber-300 via-orange-400 via-15% to-stone-950 to-85% text-center my-5 hover:grayscale overflow-hidden duration-500 ease-in-out">
                                <a href="index.php?page=episodios&id_anime=<?= $anime["id_anime"] ?>" class="w-full h-full">
                                    <figure class="w-full h-full flex flex-col justify-between items-center p-2">
                                        <img class="w-full h-[75%]" src="../assets/animes/<?= $anime["imagem_anime"] ?>" alt="<?= $anime["nome_anime"] ?>">
                                        <figcaption class="text-amber-400 text-sm h-[25%] flex items-center justify-center sm:text-base xl:text-lg">
                                            <?= $anime["nome_anime"] ?>
                                        </figcaption>
                                    </figure>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </section>

            <!-- Banner padrão -->
            <?php include __DIR__ . "/components/banner_padrao.php"; ?>
        </main>

        <!-- Rodapé -->
        <?php include __DIR__ . "/components/footer.php"; ?>
    </div>

    <!-- Usando a biblioteca SweetAlert2, que oferece alertas super estilosos -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Alterando com um alerta personalizado -->
    <?php if (isset($_GET['alteracao']) && $_GET['alteracao'] === 'ok'): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Seu perfil foi atualizado com sucesso!',
                confirmButtonColor: '#3085d6'
            });

            // Limpa os parâmetros da URL depois
            if (window.location.search.includes('alteracao=ok')) {
                window.history.replaceState(null, '', window.location.pathname);
            }
        </script>
    <?php endif; ?>
</body>
</html>
