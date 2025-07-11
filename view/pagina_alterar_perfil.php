<?php
    // Trazendo os dados do perfil do usuário
    $nome = $_SESSION["nome_session"];
    $idade = $_SESSION["idade_session"];
    $email = $_SESSION["login_session"];
    $senha = $_SESSION["senha_session"];
    $avatar = $_SESSION["avatar_session"];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakeros - Editar Perfil</title>
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
            <a href="?page=home" id="btn__voltar" class="block p-1 mt-5 border-1 border-stone-500 text-stone-500 w-20 text-center mx-auto hover:bg-stone-500 hover:text-stone-900 xl:text-xl xl:px-2 duration-500 ease-in-out">Voltar</a>

            <h1 class="font-[Bebas_Neue] text-2xl text-amber-400 text-center border-y border-amber-400 mt-5 sm:text-3xl sm:p-2 xl:text-4xl">Edição de Perfil</h1>

            <!-- Formulário de Alteração de Perfil -->
            <form class="flex flex-col items-center justify-center" action="?page=salvar_edicao_perfil" method="post" enctype="multipart/form-data">
                <div class="flex flex-col w-60">
                    <img src="../assets/avatar/<?= !empty($avatar) ? $avatar : 'icone-usuario.jpg'; ?>" id="usuario__icone" class="rounded-full w-25 h-25 my-2 mx-auto xl:w-50 xl:h-50 xl:my-4" title="Avatar">

                    <div class="flex flex-col items-center">
                        <label for="cAvatar" id="label_arquivo" class="text-amber-400 sm:text-lg xl:text-xl">Escolha o seu Avatar:</label>
                        <!-- Pré-visualização do avatar do perfil do usuário -->
                        <input type="file" name="avatar" id="cAvatar" onchange="previewAvatar()" class="text-center cursor-pointer border-1 border-stone-500 text-stone-500 mt-4 py-1 px-2 hover:text-black hover:bg-stone-500 xl:py-2 xl:px-4 xl:text-xl duration-500 ease-in-out w-60 sm:w-xs xl:w-md">
                    </div>
                </div>

                <div class="flex mt-4 justify-center">
                    <i class="bi bi-person-fill bg-linear-to-r from-amber-300 to-orange-400 text-black p-1 text-xl xl:px-2 xl:text-2xl" title="Nome"></i>
                    <input class="bg-white text-black py-1 px-2 focus:outline-none sm:text-lg sm:w-xs xl:w-md xl:text-xl xl:py-2 xl:px-4" type="text" name="nome" id="cNome" placeholder="Digite seu Nome" value="<?= $nome; ?>" autofocus>
                </div>

                <div class="flex mt-4 justify-center">
                    <i class="bi bi-123 bg-linear-to-r from-amber-300 to-orange-400 text-black p-1 text-xl xl:px-2 xl:text-2xl" title="Idade"></i>
                    <input class="bg-white text-black py-1 px-2 focus:outline-none sm:text-lg sm:w-xs xl:w-md xl:text-xl xl:py-2 xl:px-4" type="number" name="idade" id="cIdade" placeholder="Digite sua Idade" value="<?= $idade; ?>">
                </div>

                <div class="flex mt-4 justify-center">
                    <i class="bi bi-envelope-fill bg-linear-to-r from-amber-300 to-orange-400 text-black p-1 text-xl xl:px-2 xl:text-2xl" title="E-mail"></i>
                    <input class="bg-white text-black py-1 px-2 focus:outline-none sm:text-lg sm:w-xs xl:w-md xl:text-xl xl:py-2 xl:px-4" type="email" name="email" id="cEmail" placeholder="Digite seu E-mail" value="<?= $email; ?>">
                </div>

                <div class="flex mt-4 justify-center">
                    <i class="bi bi-lock-fill bg-linear-to-r from-amber-300 to-orange-400 text-black p-1 text-xl xl:px-2 xl:text-2xl" title="Senha"></i>
                    <input class="bg-white text-black py-1 px-2 focus:outline-none sm:text-lg sm:w-xs xl:w-md xl:text-xl xl:py-2 xl:px-4" type="password" name="senha" id="cSenha" placeholder="Digite sua Senha" value="<?= $senha; ?>">
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
        // Prévia de vizualização do avatar do perfil do usuário
        function previewAvatar() {
            // Pega o primeiro arquivo de imagem selecionado como entrada
            var avatar = document.querySelector('input[name=avatar]').files[0];
            // Pega o elemento que mostrará a prévia da imagem
            var preview = document.querySelector('img#usuario__icone');
            // Cria um objeto FileReader para ler o conteúdo do arquivo
            var reader = new FileReader();

            // Ao a leitura do arquivo terminar, define o src do elemento de prévia com o conteúdo lido, retornando os dados da imagem em base64 (podendo exibir na img)
            reader.onloadend = function(){
                preview.src = reader.result;
            }

            // Se uma imagem foi selecionada, lê a imagem e a converte para base64, isso dispara o onloadend que troca o src do elemento de prévia
            if(avatar){
                reader.readAsDataURL(avatar);
            }
            // Mas se nenhum arquivo foi selecionado se limpa o src do elemento de prévia
            else{
                preview.src = "";
            }
        }
    </script>
</body>
</html>
