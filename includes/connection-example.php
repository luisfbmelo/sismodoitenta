<?php
//CHANGE DB CONFIG
$servidor = '';
$usuario = '';
$senha = '';
$banco = '';

// Conecta-se ao banco de dados MySQL
$mysqli = new \mysqli($servidor, $usuario, $senha, $banco);
 
// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_error()) trigger_error(mysqli_connect_error());

date_default_timezone_set('Atlantic/Azores');
?>
