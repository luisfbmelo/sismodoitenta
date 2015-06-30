<?php
/*
 * SEND EMAIL WITH LOGIN INFO
 *
 */
function sendEmail(){
    date_default_timezone_set('Europe/Lisbon');

    $ip = $_SERVER['REMOTE_ADDR'];

    $url = json_decode(file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=2b3d7d0ad1a285279139487ce77f3f58d980eea9546b5ccc5d08f5ee62ce7471&ip=".$ip."&format=json"));

    $date = date("d:m:Y H:i:s");

    $to="luisfbmelo91@gmail.com, rtqramos@gmail.com";
    $subject="Notificação de acesso";
    $fullMessage="O IP ".$ip." efetuou login na demo às ".$date." a partir do país ".$url->countryName.", cidade ".$url->cityName.", região ".$url->regionName.", com latitude ".$url->latitude." e longitude ".$url->longitude.".";
    $to=strip_tags($to);
    $email=strip_tags($email);
    $message = stripslashes($message);
    $message=strip_tags($message);
    $fullMessage.=$message;

    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=ISO-8859-1' . "\r\n";

    /*$headers .= 'To: Luis <luisfbmelo91@gmail.com>'. "\r\n";*/
    $headers .= 'From: Sismo d\'Oitenta <sismodoitenta@gmail.com>' . "\r\n";

    mail($to,$subject,$fullMessage,$headers);

}

//34anosdepois
$password = 'b61575e887749cf5d43f19fcd6d091ebbbfdac8b';
$username = 'convidado';
session_start();
if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = false;
}

if (isset($_POST['password'])) {
    if (sha1($_POST['password']) == $password && ($_POST['username']==$username || $_POST['username']=="adminsismo")) {
        $_SESSION['loggedIn'] = true;
        if ($_POST['username']!="adminsismo"){
            sendEmail();
        }

    } else {
        die ('Utilizador ou password incorreta');
    }
}

if (!$_SESSION['loggedIn']): ?>

    <html>
        <head>
            <?php include 'includes/header.php'; ?>
        </head>
        <body>
        <div>


        </div>
            <div class="loginContainer">
                <div class="loginBox">
                    <div><img src="img/miniLogo.png"/></div>
                    <p>A p&aacute;gina estar&aacute; dispon&iacute;vel a partir das <b>21:00h</b> do dia <b>3 de Janeiro de 2013</b>.</p>
                    <!--<p>&Eacute; necess&aacute;rio login para entrar.</p>-->
                    <form method="post">
                        <label>Nome de utilizador:</label><br/>
                        <input type="text" name="username"> <br />
                        <label>Password:</label><br/>
                        <input type="password" name="password"> <br />
                        <input type="submit" name="submit" value="Login">
                    </form>
                    <div class="contact">
                        <p><a href="http://www.facebook.com/sismodoitenta" target="_blank">facebook.com/sismodoitenta</a></p>
                        <p><a href="http://www.sismodoitenta.com" target="_blank">www.sismodoitenta.com</a></p>
                    </div>
                </div>
            </div>
        </body>
    </html>

<?php
exit();
endif;
?>