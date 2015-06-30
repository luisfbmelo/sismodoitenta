<?php
$servidor = '61794hpv086012.ikoula.com';
$usuario = 'c6geol0g0';
$senha = 'kWPBC3SgLGCO';
$banco = 'c6az0re5';

// Conecta-se ao banco de dados MySQL
$mysqli = new mysqli($servidor, $usuario, $senha, $banco);
 
// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
?>