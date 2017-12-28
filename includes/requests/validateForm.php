<?php
include "../connection.php";
include "../functions.php";
include "../classes/testemunho.class.php";
var_dump($_POST);
if (isset($_POST["checkData"])){
    $date = $_POST["ano"]."-".$_POST["mes"]."-".$_POST["dia"];
    $newCritic = new critic($_POST["nome"],$_POST["sobrenome"],$_POST["contacto"],$date,$_POST["freguesia"],$_POST["testemunho"],"NULL",1,1,"NULL",$_POST["status"]);
    $allErrors = $newCritic->returnErrors();

    echo json_encode($allErrors);
}