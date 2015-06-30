<?php
include "../connection.php";
include "../functions.php";

if (isset($_POST["fotoId"])){
    $data = printPicBoxes($_POST["fotoId"]);
    echo json_encode($data);
}
?>