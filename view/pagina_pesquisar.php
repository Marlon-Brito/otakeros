<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Pesquisar</title>
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
           <section class="flex flex-col">
                <!-- Exibindo resultado da pesquisa -->
                <div class="flex flex-col items-center py-5 xl:py-10 bg-linear-to-b from-stone-950 to-stone-900">
                    <h1 class="text-2xl sm:text-3xl xl:text-4xl text-amber-400 text-center">Resultado da Pesquisa</h1>
                    <p class="mt-5 text-base sm:text-lg xl:text-xl">Você pesquisou por:</p>
                    <span class="mt-5 text-base sm:text-lg xl:text-xl bg-white text-black py-2 px-4 border-2 border-black rounded-full">
                        <!-- Percorrendo por cada um dos animes da lista para exibir suas informações -->
                        <!-- Converte caracteres especiais em entidades HTML -->
                        <?= htmlspecialchars($pesquisa ?? '') ?>
                    </span>
                </div>

                <!-- Lista de animes pesquisados -->
                <nav>
                    <!-- Se a lista de animes estiver vazia mostrará uma mensagem de erro dizendo que não há animes -->
                    <?php if (empty($animes)): ?>
                        <p class="text-base sm:text-lg xl:text-xl text-center text-amber-400">Nenhum anime encontrado com esse nome.</p>
                    <!-- Mas se tiver animes na lista percorrerá por cada um para exibir as informações dos que foram pesquisados -->
                    <?php else: ?>
                        <ul class="flex flex-row flex-wrap justify-center items-center max-w-sm sm:max-w-3xl xl:max-w-7xl mx-auto 2xl:max-w-[1500px]">
                            <?php foreach ($animes as $anime): ?>
                                <li class="w-32 h-60 sm:w-48 sm:h-[320px] xl:w-60 xl:h-[400px] flex items-center justify-center bg-gradient-to-b from-amber-300 via-orange-400 via-15% to-stone-950 to-85% text-center m-5 hover:grayscale overflow-hidden duration-500 ease-in-out">
                                    <a href="index.php?page=episodios&id_anime=<?= $anime['id_anime'] ?>" class="w-full h-full">
                                        <figure class="w-full h-full flex flex-col justify-between items-center p-2">
                                            <img class="imagem--anime" src="../assets/animes/<?= $anime['imagem_anime']; ?>" alt="<?= $anime['nome_anime']; ?>" class="w-full h-[75%]">
                                            <figcaption class="text-amber-400 text-sm h-[25%] flex items-center justify-center sm:text-base xl:text-lg"><?= $anime['nome_anime']; ?></figcaption>
                                        </figure>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </nav>
           </section>

           <!-- Banner padrão -->
            <?php include __DIR__ . "/components/banner_padrao.php"; ?>
        </main>

        <!-- Rodapé -->
        <?php include __DIR__ . "/components/footer.php"; ?>
    </div>
</body>
</html>