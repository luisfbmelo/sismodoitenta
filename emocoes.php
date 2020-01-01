<?php
include "includes/global.inc.php";

?>
<?php $page=2;?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">

	<head>
		<?php include 'includes/header.php'; ?>
        <script type="text/javascript" src="scripts/youtube.js"></script>
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
			<div class="pageHeader noBack">

				
				<div class="header">
					<a href="/">
						<div class="logo fLeft"></div>
						<div class="logoTxt fLeft"></div>
					</a>
					
					<div class=clearAll></div>
					
					<?php include 'includes/menu.php'; ?>
                    <div class=clearAll></div>
				</div>
			</div>

            <!--CONTENT-->
			<div class="bodyContentProjeto emocoes__container">

                <!--YOUTUBE VIDEOS-->
                <div class="sectionTitle">Assista aos vídeos que desenvolvemos</div>
                <div class="youtubeVideos">
                    <?php getYoutubeVideos();?>
                </div>
                <!--END YOUTUBE VIDEOS-->

                <!--TESTEMUNHOS-->
                <div class="sectionTitle" style="margin-top:0;">Visualize alguns testemunhos reais</div>
                <div class="testemunhosBody">
                    <!--ADD TESTIMONIAL-->
                    <div class="newPost rmar">
                        <div class="boxText">
                            <div class="textTop">Clique aqui para escrever o seu testemunho</div>
                            <div class="textBottom">A sua história é importante</div>
                        </div>
                        <div class="boxPlus"><i class="fa fa-plus"></i></div>
                    </div>
                    <!--END ADD-->

                    <?php echo getTestimonies();?>
                    <div class="clearAll"></div>
                </div>

                <!--END TESTEMUNHOS-->

			</div>
            <div class="clearAll"></div>
		</div>
        <div class="clearAll"></div>
        <!--IMAGES-->
        <div style="display:none;" class="boxEmotions">

        </div>
        <!--END IMAGES-->
        <!--TESTFORM-->
        <div class="testForm" style="display:none;">

        </div>
        <div class="statusMessage sucesso">Testemunho adicionado para aprovação com sucesso</div>
        <!--END TESTFORM-->
	</body>
</html>