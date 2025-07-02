<?php
    // Inclui e verifica se o arquivo já foi incluído, caso sim, não o exigirá novamente
    require_once __DIR__ . '/../../controller/funcoes.php';
    
    iniciarSessao();

    $usuarioLogado = false;

    if (isset($_SESSION["id_usuario_session"])){
        $usuarioLogado = true;
        $id_usuario = $_SESSION["id_usuario_session"];
        $nome = $_SESSION["nome_session"];
        $avatar = $_SESSION["avatar_session"];
    }

    realizarLogout();
?>

<header>
    <a href="?page=home" class="flex justify-center items-center py-2 sm:py-4 select-none">
        <img class="w-[48px] mr-1 rounded-sm xl:w-[60px]" src="../assets/imgs/logo-otakeros-p.png">
        <div class="font-[Bebas_Neue] text-3xl ml-1 xl:text-4xl">Otakeros</div>
    </a>

    <nav class="h-full">
        <ul class="flex justify-center items-stretch bg-linear-to-r from-amber-300 to-orange-400 text-black xl:text-lg">
            <li class="hover:bg-amber-500">
                <a href="../../index.php?page=home" class="h-full flex items-center py-1 px-3 xl:py-2 xl:px-5">Home</a>
            </li>

            <li class="hover:bg-amber-500">
                <a href="<?= $usuarioLogado ? "../../index.php?page=editar_perfil" : '../../index.php?page=login'; ?>" class="h-full flex items-center py-1 px-3 xl:py-2 xl:px-5">
                    <div class="flex items-center">
                        <img src="../../assets/avatar/<?= ($usuarioLogado && !empty($avatar)) ? $avatar : 'icone-usuario.jpg'; ?>" class="display-none h-15 w-15 rounded-full mr-1 xl:h-20 xl:w-20">
                        <span class="text-shadow-xs text-shadow-black hidden ml-1 text-white sm:block xl:text-shadow-sm"><?= $usuarioLogado ? $nome : ''; ?></span>
                    </div>
                </a>
            </li>

            <?php if ($usuarioLogado): ?>
                <li class="hover:bg-amber-500">
                    <a href="#" class="h-full flex items-center py-1 px-3 xl:py-2 xl:px-5" onclick="deslogar()">Sair</a>
                </li>
            <?php else: ?>
                <li class="hover:bg-amber-500">
                    <a href="?page=login" class="h-full flex items-center py-1 px-3 xl:py-2 xl:px-5">Entrar</a>
                </li>
            <?php endif; ?>
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
