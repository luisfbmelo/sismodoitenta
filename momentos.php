<?php
include "includes/global.inc.php";
?>
<?php $page=3;?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">

	<head>
		<?php include 'includes/header.php'; ?>
		
	</head>

	<body>
    <!--FACEBOOK COMMENTS-->
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_PT/all.js#xfbml=1&appId=172358519486036";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <!--END-->

		<div class="container">
			<div class="pageHeaderMoments">

                <div class="header">
					<a href="/">
						<div class="logo fLeft"></div>
						<div class="logoTxt fLeft"></div>
					</a>
					
					<div class=clearAll></div>
					
					<?php include 'includes/menu.php'; ?>
                    <div class=clearAll></div>
				</div>

                <!--MAP CONSTRUCTION-->
                <div class="mapItems">
                    <div id="map"></div>

                    <!--IMAGES-->
                    <div style="display:none;" class="picBoxesMoments">

                    </div>
                    <!--END IMAGES-->
                </div>
                <!--END MAP CONSTRUCTION-->

			</div>

            <!--CONTENT-->
			<div class="bodyContentMoments">
                <div class="pageDesc">
                    <div class="momentTitle">
                        O Sismo d'Oitenta em imagens
                    </div>
                    <div class="momentCaption">
                        Clique sobre o icone<span class="pic"></span>para ver as “fotos” ou sobre<span class="compare"></span>e veja o “antes e depois” de alguns dos edificíos que foram afetados pelo sismo e como se encontram atualmente.<br/>
                        Utilize a roda de deslocamento (scroll) do rato para controlar o zoom do mapa.
                    </div>
                    <div class="momentContr">
                        Tem imagens desta época? Gostaríamos muito que as partilha-se connosco! Envie para: <a href="mailto:sismodoitenta@gmail.com">sismodoitenta@gmail.com</a>.
                    </div>

                </div>
			</div>
		</div>
	</body>
</html>