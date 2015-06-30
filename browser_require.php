    <html>
        <head>
            <?php include 'includes/header.php'; ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    var counter=15;
                    $(".redirectCounter span").append(counter);
                    function countDown(){
                        counter--;
                        $(".redirectCounter span").text(parseInt(counter));
                        if (counter==0){
                            window.location = "https://www.facebook.com/sismodoitenta";
                            clearInterval(redInt);
                        }
                    }

                    //set an interval
                    var redInt = setInterval(countDown, 1000);
                });
            </script>
        </head>
        <body>
        <div>


        </div>
            <div class="requireContainer">
                <div class="requireBox">
                    <div><img src="img/miniLogo.png"/></div>
                    <p>O seu navegador não é suportado pelo website que está a tentar aceder.</p>
                    <p>Recomenda-se que atualize o seu navegador para obter acesso aos conteúdos do projeto Sismo d'Oitenta.</p>
                    <p class="redirectCounter">Será redirecionado para a página Facebook do projeto em <span></span> segundos.</p>

                    <div class="contact">
                        <p><a href="http://www.facebook.com/sismodoitenta" target="_blank">facebook.com/sismodoitenta</a></p>
                        <p><a href="http://www.sismodoitenta.com" target="_blank">www.sismodoitenta.com</a></p>
                    </div>
                </div>
            </div>
        </body>
    </html>
