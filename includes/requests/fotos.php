<?php include "../connection.php";
if ($_POST["get"]=="maps"){
    $sql = "SELECT 
                *
            FROM 
                fotos";
    $query = $mysqli->query($sql);
    
    if ($query->num_rows>0){
        $count=0;
        $result= array();
        while ($dados = $query->fetch_assoc()) {
            $result[$count]['id'] = $dados['id_fotos'];
            $result[$count]['type'] = $dados['type'];
            
            $result[$count]['foto1']=$dados['foto_1'];    
            if ($dados['type']==1){
               $result[$count]['foto2']=$dados['foto_2']; 
            }

            $result[$count]['titulo']=$dados['titulo'];
            $result[$count]['lat']=$dados['lat'];
            $result[$count]['lon']=$dados['long'];
            $result[$count]['fonte']=$dados['fonte'];
            $result[$count]['descricao']=$dados['descricao'];
            $result[$count]['thumbnail']=$dados['thumbnail'];
            $count++;
        }   
        echo json_encode($result);
    }else{
        echo json_encode("erro");
    }
}

?>