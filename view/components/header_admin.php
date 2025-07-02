<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../../controller/funcoes.php';
    
    iniciarSessao();

    $nome = $_SESSION["nome_session"];
    $avatar = $_SESSION["avatar_session"];
    $caminho_avatar = (!empty($avatar) && file_exists(__DIR__ . "/../../assets/avatar/$avatar"))
        ? "../assets/avatar/$avatar"
        : "../assets/imgs/icone-usuario.jpg";

    realizarLogout();
?>

<header>
    <a href="../index.php?page=dashboard" class="flex justify-center items-center py-2 sm:py-4 select-none">
        <img class="w-[48px] mr-1 rounded-sm xl:w-[60px]" src="../assets/imgs/logo-otakeros-p.png">
        <div class="font-[Bebas_Neue] text-3xl ml-1 xl:text-4xl">Otakeros</div>
    </a>

    <nav class="h-full">
        <ul class="flex justify-center items-stretch bg-linear-to-r from-amber-300 to-orange-400 text-black xl:text-lg">
            <li class="hover:bg-amber-500">
                <a href="../index.php?page=dashboard" class="h-full flex items-center py-1 px-3 xl:py-2 xl:px-5">Área ADM</a>
            </li>

            <li class="hover:bg-amber-500">
                <a class="h-full flex items-center py-1 px-3 xl:py-2 xl:px-5">
                    <div class="flex items-center">
                    <img src="<?= $caminho_avatar ?>" class="display-none h-15 w-15 rounded-full mr-1 xl:h-20 xl:w-20">
                    <span class="text-shadow-xs text-shadow-black hidden ml-1 text-white sm:block xl:text-shadow-sm"><?= $nome ?></span>
                </div>
                </a>
            </li>

            <li class="hover:bg-amber-500">
                <a href="#" class="h-full flex items-center py-1 px-3 xl:py-2 xl:px-5" onclick="deslogar()">Sair</a>
            </li>
        </ul>
    </nav>
</header>

<!-- Usando a biblioteca SweetAlert2, que oferece alertas super estilosos -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Deslogando com um alerta personalizado -->
<script>
    function deslogar(){
        Swal.fire({
            title: 'Tem certeza que deseja sair?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sair',
            cancelButtonText: 'Cancelar'
        }).then((resultado) => {
            if (resultado.isConfirmed){
                window.location.href = '?logout'; // Redireciona para o logout
            }
        });
    }
</script>
