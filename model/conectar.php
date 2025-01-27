<?php
    // Conectando ao MySQL utilizando MySQLi
    $sql = new MySQLi('host', 'usuario', 'senha', 'banco-de-dados'); 

    // Falha ao conectar no banco de dados
    if($sql->connect_error){
        echo "Desconectado! Erro: " . $sql->connect_error;
    // Sucesso ao conectar no banco de dados
    }else{
        echo '<script>console.log("Conectado! Sucesso ao conectar com o banco de dados.")</script>';
    }
    
    mysqli_set_charset($sql, "utf8");
?>
