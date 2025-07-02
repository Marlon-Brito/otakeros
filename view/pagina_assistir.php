<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Assistir</title>
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
            <section class="episodio">
                <h1 class="text-amber-400 text-center py-2 text-2xl sm:text-3xl sm:py-4 xl:text-4xl xl:py-6"><?= $anime['nome_anime']; ?></h1>
                <h2 class="font-[Bebas_Neue] text-2xl text-amber-400 text-center border-y border-amber-400 sm:text-3xl xl:text-4xl sm:p-2 mb-5 sm:mb-7 xl:mb-10"><?= $episodio['nome_episodio'] ?? 'Episódio não encontrado...' ?></h2>

                <!-- Vídeo do episódio -->
                <div class="flex justify-center">
                    <?php if (isset($episodio['video_url_episodio'])): ?>
                        <video src="../assets/videos/<?= $episodio['video_url_episodio']; ?>" controls class="w-full max-w-5xl mx-auto h-auto"></video>
                    <?php else: ?>
                        <div class="bg-red-500/70 w-full max-w-5xl">
                            <img src="../assets/imgs/icone-acabou.png" class="mx-auto">
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Menu/barra de navegação dos episódios de um anime -->
                <nav class="md:max-w-5xl md:mx-auto">
                    <ul class="flex justify-evenly items-center bg-linear-to-r from-amber-300 to-orange-400 text-black mb-5 sm:mb-7 xl:mb-10">
                        <!-- Botão "Anterior": só é clicável se estiver acima do primeiro episódio -->
                        <li class="flex w-1/3">
                            <?php if ($episodio_atual > 1): ?>
                                <a href="index.php?page=assistir&numero_episodio=<?= $episodio_anterior; ?>&id_anime=<?= $id_anime; ?>" class="flex items-center justify-center size-full py-1 px-2 xl:py-2 xl:px-4 hover:bg-amber-500">
                                    <img src="../assets/imgs/icone-antes.png" class="m-2 select-none">
                                    <span class="hidden sm:block sm:text-lg xl:text-xl">Anterior</span>
                                </a>
                            <?php else: ?>
                                <a class="flex items-center justify-center size-full py-1 px-2 xl:py-2 xl:px-4 cursor-not-allowed">
                                    <img src="../assets/imgs/icone-antes.png" class="m-2">
                                    <span class="hidden sm:block sm:text-lg xl:text-xl">Anterior</span>
                                </a>
                            <?php endif; ?>
                        </li>
                        
                        <!-- Botão "Lista de Episódios": redireciona para a lista de episódios do anime -->
                        <li class="flex w-1/3">
                            <a href="index.php?page=episodios&id_anime=<?= $anime['id_anime']; ?>" class="flex items-center justify-center size-full py-1 px-2 xl:py-2 xl:px-4 hover:bg-amber-500">
                                <img src="../assets/imgs/icone-lista.png" class="m-2">
                                <span class="hidden sm:block sm:text-lg xl:text-xl">Lista de Episódios</span>
                            </a>
                        </li>

                        <!-- Botão "Próximo": só é clicável até chegar no último episódio -->
                        <li class="flex w-1/3">
                            <?php if ($episodio_atual < $total_episodios): ?>
                                <a href="index.php?page=assistir&numero_episodio=<?= $episodio_posterior ?>&id_anime=<?= $id_anime?>" class="flex items-center justify-center size-full py-1 px-2 xl:py-2 xl:px-4 hover:bg-amber-500">
                                    <span class="hidden sm:block sm:text-lg xl:text-xl">Próximo</span>
                                    <img src="../assets/imgs/icone-depois.png" class="m-2">
                                </a>
                            <?php else: ?>
                                <a class="flex items-center justify-center size-full py-1 px-2 xl:py-2 xl:px-4 cursor-not-allowed">
                                    <span class="hidden sm:block sm:text-lg xl:text-xl">Próximo</span>
                                    <img src="../assets/imgs/icone-depois.png" class="m-2">
                                </a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </nav>

                <!-- Informações descritivas -->
                <div class="flex flex-col items-center">
                    <h2 class="w-full font-[Bebas_Neue] text-2xl text-amber-400 text-center border-y border-amber-400 sm:text-3xl sm:p-2 xl:text-4xl mb-5">Informações</h2>
                    <p class="text-sm text-justify p-2 sm:text-base xl:text-lg md:w-2xl xl:w-5xl"><?= $anime['descricao_anime'] ?></p>
                </div>
            </section>

            <!-- Banner padrão -->
            <?php include __DIR__ . "/components/banner_padrao.php"; ?>
        </main>

        <!-- Rodapé -->
        <?php include __DIR__ . "/components/footer.php"; ?>
    </div>
</body>
</html>
