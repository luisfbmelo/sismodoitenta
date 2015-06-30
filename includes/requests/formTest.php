<?php
include "../connection.php";
include "../functions.php";

if (isset($_POST["form"])){
    $data = returnTestForm();

    echo json_encode($data);
}
?>