<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Dados Animes</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/imgs/favicon-16x16.png" type="image/x-icon">
    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter&display=swap" rel="stylesheet">
    <!-- TailswindCSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="text-white text-base font-[Inter] bg-stone-900">
    <!-- Cabeçalho admin -->
    <?php include __DIR__ . "/components/header_admin.php"; ?>

    <h1 class="text-center text-2xl sm:text-3xl xl:text-4xl text-amber-400 my-5 xl:my-10">Dados Animes</h1>

    <a href="../index.php?page=cadastrar_anime" id="btn__cadastrar" class="block  mx-auto text-center cursor-pointer border-1 border-blue-500 text-blue-500 mt-4 py-1 px-2 hover:text-black hover:bg-blue-500 xl:py-2 xl:px-4 xl:text-xl duration-500 ease-in-out w-60 sm:w-xs xl:w-md">Cadastrar</a>

    <!-- Conteúdo Principal -->
    <main>
        <div class="overflow-x-auto w-full p-5 xl:p-10">
            <!-- Tabela de dados dos animes -->
            <table class="table-auto w-full min-w-[900px] max-w-6xl border-separate border-spacing-y-1 xl:border-spacing-y-2 text-center mx-auto text-xs xl:text-sm">
                <caption class="caption-top">
                    Tabela de Animes: Contém todos os dados de animes do sistema.
                </caption>
                <thead class="bg-black">
                    <tr>
                        <th class="px-2 py-1 xl:px-4 xl:py-2">ID</th>
                        <th class="px-2 py-1 xl:px-4 xl:py-2">Nome</th>
                        <th class="px-2 py-1 xl:px-4 xl:py-2">Descrição</th>
                        <th class="px-2 py-1 xl:px-4 xl:py-2">Imagem</th>
                        <th class="px-2 py-1 xl:px-4 xl:py-2" colspan="3">Ação</th>
                    </tr>
                </thead>

                <tbody class='tabela__corpo'>
                    <!-- Percorrendo por cada um dos animes da lista para exibir suas informações -->
                    <?php if (!empty($animes)): ?>
                        <?php foreach ($animes as $anime):
                            // Forçar a atualização da imagem alterando a URL toda vez que ela é carregada, pois o navegador costuma armazená-la em cache
                            $imagem = $anime['imagem_anime'];
                            // Pega o caminho do arquivo no servidor
                            $imagem_file = __DIR__ . "/../assets/avatar/$imagem";
                            // Verifica a data da última modificação do arquivo caso ele exista, senão dá um fallback/retorno com o momento atual
                            // É isso que gera uma versão nova da URL do avatar no navegador ao alterá-lo, o forçando a buscá-la e evitando cache
                            $timestamp = file_exists($imagem_file)
                                ? filemtime($imagem_file)
                                : time()
                            ;
                            // Exibindo a imagem com o parâmetro de tempo, baixando no navegador a nova versão da imagem sempre que for alterada
                            // Caso ela esteja indefinido, vazia ou inexistente irá usar a imagem padrão
                            $caminho_imagem = (!isset($imagem) || empty($imagem) || !file_exists(__DIR__ . "/../assets/animes/$imagem")) 
                                ? "../assets/imgs/icone-quadro.png" 
                                : "../assets/animes/$imagem?t=$timestamp"
                            ; // Pega o caminho da URL para a interface
                        ?>
                            <tr class="bg-gradient-to-r from-amber-300 to-orange-400 text-black h-12 xl:h-16">
                                <td class="px-2 py-1 xl:px-4 xl:py-2"><?= $anime['id_anime'] ?></td>
                                <td class="px-2 py-1 xl:px-4 xl:py-2"><?= $anime['nome_anime'] ?></td>
                                <td class="px-2 py-1 xl:px-4 xl:py-2 max-w-xl"><?= $anime['descricao_anime'] ?></td>
                                <td class="px-2 py-1 xl:px-4 xl:py-2">
                                    <img src="<?= $caminho_imagem ?>" class='h-auto w-16 xl:w-20'>
                                </td>
                                <td class="px-2 py-1 xl:px-4 xl:py-2">
                                    <a href="../index.php?page=editar_anime&id_anime=<?= $anime['id_anime'] ?>" class="flex justify-center items-center">
                                        <img src='../assets/imgs/icone-edicao.png' class="size-[2rem] xl:size-[3rem]">
                                    </a>
                                </td>
                                <td class="px-2 py-1 xl:px-4 xl:py-2">
                                    <a href="#" onclick="excluirAnime(<?= $anime['id_anime'] ?>)" class="flex justify-center items-center">
                                        <img src='../assets/imgs/icone-excluir.png' class="size-[2rem] xl:size-[3rem]">
                                    </a>
                                </td>
                                <td class="px-2 py-1 xl:px-4 xl:py-2">
                                    <a href="../index.php?page=dados_episodios&id_anime=<?= $anime['id_anime'] ?>" class="flex justify-center items-center">
                                        <img src='../assets/imgs/icone-episodios.png' class="size-[2rem] xl:size-[3rem]">
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <!-- Mas caso a lista esteja vazia exibirá uma mensagem de erro dizendo que não há animes -->
                    <?php else: ?>
                        <tr class="bg-gradient-to-r from-amber-300 to-orange-400 text-black h-12 xl:h-16">
                            <td colspan='7' class="px-2 py-1 xl:px-4 xl:py-2">Nenhum anime encontrado...</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Banner padrão -->
        <?php include __DIR__ . "/components/banner_padrao.php"; ?>
    </main>

    <!-- Rodapé -->
    <?php include __DIR__ . "/components/footer.php"; ?>

    <!-- Usando a biblioteca SweetAlert2, que oferece alertas super estilosos -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Cadastrando com um alerta personalizado -->
    <?php if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'ok'): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Anime cadastrado com sucesso!',
                confirmButtonColor: '#3085d6'
            });

            // Limpa os parâmetros da URL depois
            if (window.location.search.includes('cadastro=ok')) {
                window.history.replaceState(null, '', window.location.pathname);
            }
        </script>
    <?php endif; ?>

    <!-- Alterando com um alerta personalizado -->
    <?php if (isset($_GET['alteracao']) && $_GET['alteracao'] === 'ok'): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Anime atualizado com sucesso!',
                confirmButtonColor: '#3085d6'
            });

            // Limpa os parâmetros da URL depois
            if (window.location.search.includes('alteracao=ok')) {
                window.history.replaceState(null, '', window.location.pathname);
            }
        </script>
    <?php endif; ?>

    <!-- Excluindo com um alerta personalizado -->
    <script>
        function excluirAnime(id){
            Swal.fire({
                title: 'Tem certeza que deseja excluir o anime de ID ' + id + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Excluir',
                cancelButtonText: 'Cancelar'
            }).then((resultado) => {
                if (resultado.isConfirmed){
                    window.location.href = '../index.php?page=excluir_anime&id_anime=' + id;
                }
            });
        }

        // Alerta de sucesso após exclusão e alteração
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('excluido') === '1'){
            Swal.fire({
                title: 'Anime excluído com sucesso!',
                icon: 'success',
                confirmButtonColor: '#3085d6'
            });

            // Remove o parâmetro da URL sem recarregar
            urlParams.delete('excluido');
            const novaURL = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
            window.history.replaceState(null, '', novaURL);
        }
    </script>
</body>
</html>
