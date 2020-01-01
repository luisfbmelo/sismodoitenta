<?php
$servidor = 'localhost';
$usuario = 'luisfbm1_sismo';
$senha = 'kWPBC3SgLGCO';
$banco = 'luisfbm1_sismodoitenta';

// Conecta-se ao banco de dados MySQL
$mysqli = new mysqli($servidor, $usuario, $senha, $banco);

// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");
?>