<?php
include "../connection.php";
include "../functions.php";

if (isset($_POST["id"])){
    $data = printTestimonial($_POST["id"]);

    echo json_encode($data);
}
?>