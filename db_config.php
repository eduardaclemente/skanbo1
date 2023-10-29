<?php
$SERVIDOR = "localhost";
$USUARIO= "root";
$SENHA = "";
$BASE = "skanbo";

try {
    $conn = new PDO("mysql:host=$SERVIDOR;dbname=$BASE", $USUARIO, $SENHA);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
}
?>
