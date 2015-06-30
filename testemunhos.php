<?php
include "includes/global.inc.php";
//include "classes/testemunho.class.php";
?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'includes/header.php'; ?>
    <?php
    if (isset($_POST["submeter"])){

        $date = $_POST["ano"]."-".$_POST["mes"]."-".$_POST["dia"];
        $newCritic = new critic($_POST["name"],$_POST["surname"],$_POST["contact"],$date,$_POST["freguesias"],$_POST["testemunhoTXT"],"NULL",1,1,"NULL");
        $errors = $newCritic->returnErrors();
print_r($errors);
        //$_FILES["newImg"]
        //if (isset($_FILES["newImg"])) echo "1";
        //$cri->uploadPic($_FILES["newImg"]);
    }
    ?>
    <script src="scripts/validate.js"></script>
</head>

<body>
    <form id="testemunhos" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
        <label>Nome</label>
        <input type="text" name="name" id="name"/>
        <label>Apelido</label>
        <input type="text" name="surname" id="surname"/>

        <label>Contacto</label>
        <input type="text" name="contact" id="contact"/>

        <label>Data de nascimento</label>

        <?php printSelectionDate("3");?>

        <select id="mes" name="mes" disabled>
            <option value="0">Selecione o mês</option>
        </select>
        <select id="dia" name="dia" disabled>
            <option value="0">Selecione o dia</option>
        </select><br/>

        <label>Freguesia</label>
        <?php printFreguesia();?>

        <label>Testemunho</label>
        <textarea name="testemunhoTXT" id="testemunhoTXT" cols="50" rows="10"></textarea>
        <div id="characters" style="margin-bottom:15px;"><span>4500</span></div>

        <!--<input type="file" name="newImg[]"/><br/>-->

        <input type="submit" name="submeter" id="submeter" value="Submeter"/>
    </form>

</body>
</html>