<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Episódios</title>
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
        <main class="bg-linear-to-b from-stone-950 to-stone-900">
            <?php if ($anime): ?>
                <!-- Exibindo informações do anime -->
                <section class="flex flex-col pb-5 p-2 md:grid md:grid-cols-3 items-center md:max-w-5xl md:mx-auto">
                    <img src="../assets/animes/<?= $anime['imagem_anime'] ?>" alt="<?= $anime['nome_anime'] ?>" class="mx-auto mt-5">
                    <div class="flex justify-center flex-col items-center col-span-2">
                        <h1 class="text-amber-400 text-center pt-2 text-2xl sm:text-3xl xl:text-4xl"><?= $anime['nome_anime'] ?></h1>
                        <p class="text-sm text-justify p-2 sm:text-base xl:text-lg md:w-md xl:w-xl"><?= $anime['descricao_anime'] ?></p>
                    </div>
                </section>

                <section class="episodios">
                    <h2 class="font-[Bebas_Neue] text-2xl text-amber-400 text-center border-y border-amber-400 sm:text-3xl sm:p-2 xl:text-4xl mb-5">Episódios</h2>
                    <!-- Vendo se há episódios cadastrados para este anime -->
                    <?php if (!empty($episodios) && count($episodios) > 0): ?>
                        <ul class="episodios__lista px-2 md:max-w-5xl md:mx-auto">
                            <!-- Pesquisando todos episódios deste anime para pegar suas informações e fazer uma lista -->
                            <?php foreach ($episodios as $episodio): ?>
                                <li class="episodios__lista--episodio bg-linear-to-r from-amber-300 to-orange-400 text-black mt-1 xl:text-lg">
                                    <a href="index.php?page=assistir&id_anime=<?= $episodio['id_anime'] ?>&numero_episodio=<?= $episodio['id_numero_episodio'] ?>" class="block py-1 px-2 xl:py-2 xl:px-4 hover:bg-amber-500">
                                        <?= $episodio['nome_episodio'] ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <!-- Senão mostrará uma mensagem de erro dizendo que não há episódios -->
                    <?php else: ?>
                        <ul class="episodios__lista px-2 md:max-w-5xl md:mx-auto">
                            <li class="episodios__lista--episodio bg-linear-to-r from-amber-300 to-orange-400 text-black mt-1 py-1 px-2 xl:py-2 xl:px-4 xl:text-lg">Nenhum episódio encontrado...</li>
                        </ul>
                    <?php endif; ?>
                </section>
            <!-- Senão mostrará uma mensagem de erro dizendo que o anime não está cadastrado -->
            <?php else: ?>
                <p class="text-base sm:text-lg xl:text-xl text-center p-5 xl:p-10">Este anime não está cadastrado!</p>
                <img src="../assets/imgs/icone-acabou.png" alt="Sem anime" class="p-5 xl:p-10 mx-auto bg-linear-to-r from-amber-300 to-orange-400">
            <?php endif; ?>

            <!-- Banner padrão -->
            <?php include __DIR__ . "/components/banner_padrao.php"; ?>
        </main>
    
        <!-- Rodapé -->
        <?php include __DIR__ . "/components/footer.php"; ?>
    </div>
</body>
</html>
