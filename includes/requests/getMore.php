<?php
include "../connection.php";
include "../functions.php";

if (isset($_POST["totalItems"])){
    $data = getTestimonies($_POST["totalItems"]);


    echo json_encode($data);
}
?>