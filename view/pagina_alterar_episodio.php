<?php
    // Captura os erros (se existirem) para exibir
    $erros = $_SESSION['erros_atualizar'] ?? [];
    unset($_SESSION['erros_atualizar']); // Limpa os erros após exibir
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Alterar Vídeo do Episódio</title>
    <!-- Favicon -->
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
<body class="min-h-screen bg-gradient-to-b from-stone-950 to-stone-900 text-white text-base font-[Inter]">
    <!-- Conteúdo Principal -->
    <main class="flex flex-col mt-5 justify-center items-center md:my-0 md:grid md:grid-cols-2">
        <div class="min-w-3xs max-w-[300px] mx-auto">
            <a href="../../index.php?page=dados_episodios&id_anime=<?= $anime['id_anime'] ?>" id="btn__voltar" class="block p-1 mt-5 border-1 border-stone-500 text-stone-500 w-20 text-center mx-auto hover:bg-stone-500 hover:text-stone-900 xl:text-xl xl:px-2 duration-500 ease-in-out">Voltar</a>

            <h1 class="font-[Bebas_Neue] text-2xl text-amber-400 text-center border-y border-amber-400 mt-5 sm:text-3xl sm:p-2 xl:text-4xl">Edição de Episódio</h1>

            <!-- Formulário de Alteração de Episódio -->
            <form class="flex flex-col items-center justify-center" action="" method="post" enctype="multipart/form-data">
                <div id="formulario__video" class="flex flex-col w-60">
                    <video src="<?= $caminho_video ?>" id="video__icone" controls class="w-20 h-20 my-2 mx-auto xl:w-40 xl:h-40 xl:my-4" title="Vídeo"></video>

                    <div class="flex flex-col items-center">
                        <label for="cVideo" class="text-amber-400 sm:text-lg xl:text-xl text-center">Escolha o vídeo do episódio:</label>
                        <!-- Pré-visualização de vídeo do episódio -->
                        <input type="file" name="video" id="cVideo" onchange="previewVideo()" required class="text-center cursor-pointer border-1 border-stone-500 text-stone-500 mt-4 py-1 px-2 hover:text-black hover:bg-stone-500 xl:py-2 xl:px-4 xl:text-xl duration-500 ease-in-out w-60 sm:w-xs xl:w-md">
                    </div>
                </div>

                <div class="flex mt-4 justify-center">
                    <i class="bi bi-list-ol bg-linear-to-r from-amber-300 to-orange-400 text-black p-1 text-xl xl:px-2 xl:text-2xl" title="ID do episódio"></i>
                    <input type="text" name="id" id="cID" readonly value="<?= $episodio['id_episodio'] ?>" class="bg-white text-black py-1 px-2 focus:outline-none sm:text-lg sm:w-xs xl:w-md xl:text-xl xl:py-2 xl:px-4">
                </div>

                <div class="flex mt-4 justify-center">
                    <i class="bi bi-123 bg-linear-to-r from-amber-300 to-orange-400 text-black p-1 text-xl xl:px-2 xl:text-2xl" title="Número do episódio"></i>
                    <input type="number" name="numero" id="cNumero" readonly value="<?= $episodio['id_numero_episodio'] ?>" class="bg-white text-black py-1 px-2 focus:outline-none sm:text-lg sm:w-xs xl:w-md xl:text-xl xl:py-2 xl:px-4">
                </div>

                <div class="flex mt-4 justify-center">
                    <i class="bi bi-play-btn-fill bg-linear-to-r from-amber-300 to-orange-400 text-black p-1 text-xl xl:px-2 xl:text-2xl" title="Nome do episódio"></i>
                    <input type="text" name="nome" id="cNome" readonly value="<?= $episodio['nome_episodio'] ?>" class="bg-white text-black py-1 px-2 focus:outline-none sm:text-lg sm:w-xs xl:w-md xl:text-xl xl:py-2 xl:px-4">
                </div>

                <div class="flex mt-4 justify-center">
                    <i class="bi bi-list-ol bg-linear-to-r from-amber-300 to-orange-400 text-black p-1 text-xl xl:px-2 xl:text-2xl" title="ID do Anime"></i>
                    <input type="text" value="<?= $anime['id_anime'] ?>" name="id_anime" id="cAanime" readonly class="bg-white text-black py-1 px-2 focus:outline-none sm:text-lg sm:w-xs xl:w-md xl:text-xl xl:py-2 xl:px-4">
                </div>

                <div class="flex flex-col justify-center items-center">
                    <button type="submit" name="btn_enviar" class="text-center cursor-pointer border-1 border-green-500 text-green-500 mt-4 py-1 px-2 hover:text-black hover:bg-green-500 xl:py-2 xl:px-4 xl:text-xl duration-500 ease-in-out w-60 sm:w-xs xl:w-md" id="btn__cadastrar">Alterar</button>

                    <button type="reset" value="Limpar" class="text-center cursor-pointer border-1 border-blue-500 text-blue-500 mt-4 py-1 px-2 hover:text-black hover:bg-blue-500 xl:py-2 xl:px-4 xl:text-xl duration-500 ease-in-out w-60 sm:w-xs xl:w-md" id="btn__limpar">Limpar</button>
                </div>
            </form>
        </div>

        <!-- Banner responsivo -->
        <?php include __DIR__ . "/components/banner_responsivo.php"; ?>
    </main>

    <!-- Usando a biblioteca SweetAlert2, que oferece alertas super estilosos -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Erros de alteração -->
    <?php if (!empty($erros)): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro ao atualizar',
                html: `<?= implode('<br>', array_map('htmlspecialchars', $erros)) ?>`,
                confirmButtonColor: '#d33'
            });
        </script>
    <?php endif; ?>

    <script>
        // Prévia de vizualização do vídeo do episódio
        function previewVideo() {
            // Pega o primeiro arquivo de vídeo selecionado como entrada
            var video = document.querySelector('input[name=video]').files[0];
            // Pega o elemento que mostrará a prévia do vídeo
            var preview = document.querySelector('video#video__icone');

            // Se um vídeo foi selecionado, cria-se uma URL temporária representando o arquivo, então se atribui a URL ao src do elemento de prévia
            if (video) {
                const videoURL = URL.createObjectURL(video);
                preview.src = videoURL;
            // Mas se nenhum arquivo foi selecionado se limpa o src do elemento de prévia
            } else {
                preview.src = "";
            }
        }
    </script>
</body>
</html>
