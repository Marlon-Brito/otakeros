<?php
    // Conectando ao MySQL utilizando MySQLi
    $sql = new MySQLi('sql305.infinityfree.com', 'if0_38182847', 'AomY4FYdDGhadM', 'if0_38182847_bd_otakeros'); 

    // Falha ao conectar no banco de dados
    if($sql->connect_error){
        echo "Desconectado! Erro: " . $sql->connect_error;
    // Sucesso ao conectar no banco de dados
    }else{
        echo '<script>console.log("Conectado! Sucesso ao conectar com o banco de dados.")</script>';
    }
    
    mysqli_set_charset($sql, "utf8");
?>