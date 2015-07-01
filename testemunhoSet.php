<?php
include "includes/connection.php";
include "includes/functions.php";
$logged=false;

//34anosdepois
$password = '';
    if (isset($_POST['password']) && sha1($_POST['password']) == $password){
        if ($_POST['b'] == 0){
            changeStatus($_POST['a'],0);
            die("Testemunho recusado com sucesso");
        }else if (isset($_POST['a'])){
            changeStatus($_POST['a'],1);
            die("Testemunho aceite com sucesso");
        }

       /* $logged=true;
        if ($_POST['b'] == 0){
            changeStatus($_POST['a'],0);
            die("Testemunho recusado com sucesso");
        }*/

    }

    /*if (isset($a)){
        if (isset($_POST['a'])){
            changeStatus($_POST['a'],1);
            die("Testemunho aceite com sucesso");
        }
    }*/

function getData(){

    $bodyHtml="";

    global $mysqli;
    $sql = "SELECT
                *
            FROM
                testemunhos
            WHERE
                id_testemunhos = ".$_POST['a'];

    $query = $mysqli->query($sql);

    if ($query->num_rows>0){
        while ($dados = $query->fetch_assoc()) {
            $testemunhoTxt = html_entity_decode($dados["testemunho"], ENT_NOQUOTES, 'UTF-8');
            $testemunhoTxt = str_replace(array("&lt;br/&gt;"), array("<br/>"), $testemunhoTxt);

            $nomeUser = mb_strtoupper(html_entity_decode($dados["nome"], ENT_NOQUOTES, 'UTF-8'), "UTF-8");
            $sobreNome = mb_strtoupper(html_entity_decode($dados["sobrenome"], ENT_NOQUOTES, 'UTF-8'), "UTF-8");


            $bodyHtml.='
            <label>Nome:</label>
                    <input type="text" name="nome" id="nome" value="'.$nomeUser.'"/><br/>

                    <label>Sobrenome:</label>
                    <input type="text" name="sobrenome" id="sobrenome" value="'.$sobreNome.'"/><br/>

                    <label>Contacto:</label>
                    <input type="text" name="contacto" id="contacto" value="'.$dados["contato"].'"/><br/>

                    <label>Testemunho:</label><br/>
                    <textarea cols="50" rows="10">'.$testemunhoTxt.'</textarea> <br />
                    <input type="hidden" name="a" value="'.$dados["id_testemunhos"].'" />

            ';
        }
        return $bodyHtml;
    }


}
?>

<html>
<head>
    <?php include 'includes/header.php'; ?>
</head>
<body>
<div>


</div>

<?php if (!$logged){ ?>
<div class="loginContainer">
    <div class="loginBox">
        <div><img src="img/miniLogo.png"/></div>
        <p>&Eacute; necess&aacute;rio login para entrar.</p>
        <form name="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <label>Password:</label><br/>
            <input type="password" name="password"> <br />
            <input type="hidden" name="a" value="<?php echo $_GET['sda'];?>" />
            <input type="hidden" name="b" value="<?php if(isset($_GET['ac']) && $_GET['ac']==1){echo $_GET['ac'];}else{echo 0;}?>" />
            <input type="submit" name="submit" value="Login">
        </form>
    </div>
</div>
<?php }else{ ?>
    <div class="">
        <div class="">
            <div><img src="img/miniLogo.png"/></div>
            <p>Corpo do testemunho</p>
            <form name="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

                <?php echo getData();?>

                <input type="submit" name="submit" value="Aceitar">
            </form>
        </div>
    </div>
<?php } ?>
</body>
</html>
