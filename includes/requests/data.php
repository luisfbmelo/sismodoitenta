<?php
include "../connection.php";
include "../functions.php";
//echo printSelectionDate(2,2013);
if (isset($_POST["type"])){
    if ($_POST["type"]=="mes"){
        $data = returnSelectionDate(2,$_POST["sel"]);
        echo json_encode($data);
    }
    if ($_POST["type"]=="dia"){
        $data = returnSelectionDate(1,$_POST["ano"],$_POST["sel"]);
        echo json_encode($data);
    }
}
?>