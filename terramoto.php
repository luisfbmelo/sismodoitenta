<?php
include "includes/global.inc.php";
?>
<?php $page=1;?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">

	<head>
		<?php include 'includes/header.php'; ?>
        <script type="text/javascript" src="scripts/scroller.js"></script>
	</head>

	<body style="background: #f3f3f3;">
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/pt_PT/all.js#xfbml=1&appId=180045438863571";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

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
			<div class="bodyContent">
                <div class="sobreTerr">
                    <div class="box_1">
                        <div class="box1Img">
                            <img src="img/terramoto/cidade_1980.jpg" width="410px" height="210px"/>
                        </div>
                        <div class="box1Text">
                            <span>“Era em contente euforia<br/>
                            Que todos se iam convidando<br/>
                            P’ra passarem bem o dia<br/>
                            Do Ano que esteva entrando”</span>
                        </div>
                    </div>

                    <div class="clearAll"></div>

                    <div class="textBlock">
                        Os anos 70 estavam a terminar e os Açorianos preparavam-se calmamente para uma nova década. Contudo deu-se um <span class="bold">violento terramoto</span> que atingiu todo o Arquipélago dos Açores, tendo forte incidência sobre as ilhas <span class="bold">Graciosa, São Jorge</span> e, principalmente, <span class="bold">Terceira</span>.
                    </div>

                    <div class="clearAll"></div>

                    <div id="box_2">
                        <div class="date fLeft">1980</div>
                        <div class="time fLeft">15H42</div>
                        <div class="stats fRight">
                            <p><span class="richter">0</span> <span class="scalesBold">Escala de Richter</span></p>
                            <p><span class="mercali">0</span>/12 <span class="scalesBold">Escala de Mercalli</span></p>
                        </div>
                    </div>

                    <div class="clearAll"></div>

                    <div id="box_3">
                        <div id="boxMap"></div>
                        <div id="mapEpi"></div>
                    </div>

                    <div class="clearAll"></div>

                    <div class="textBlock">
                        O terramoto deu-se a apenas <span class="bold">35km</span> a sudoeste da cidade de Angra do Heroísmo e provocou a destruição de grande parte da Ilha Terceira, sendo considerado <span class="bold">o mais destrutivo dos últimos duzentos anos</span> em Portugal.
                    </div>

                    <div class="clearAll"></div>

                    <div id="box_4">
                        <img src="img/terramoto/poeira.jpg"/>
                    </div>

                    <div class="clearAll"></div>

                    <div class="textBlock">
                        A catástrofe arrancou a vida de <span class="bold">dezenas de pessoas</span> e fez centenas de feridos, muitos destes ficaram impossibilitados de se deslocar ao hospital devido à quantidade de destroços que impediam o trânsito de circular. Pouco tempo depois, para complementar o hospital, foram criados inúmeros espaços de socorro improvisados como, por exemplo, o Liceu de Angra (atual Escola Secundária Jerónimo Emiliano de Andrade).
                    </div>

                    <div class="clearAll"></div>

                    <div id="box_5">
                        <div id="box5Img1">
                            <img src="img/terramoto/doente.jpg"/>
                        </div>
                        <div id="box5Img2">
                            <img src="img/terramoto/mortos.png"/>
                            <div class="box5Text">
                                <div class="fLeft"><span class="deads">0</span></div>
                                <div class="fLeft">Pessoas<br/>Morreram</div>
                            </div>

                        </div>
                    </div>

                    <div class="clearAll"></div>

                    <div class="textBlock">
                        O parque habitacional e monumental de toda a ilha foi gravemente atingido. Para lá de <span class="bold">12.000 estruturas ficaram destruídas</span> deixando pelo menos <span class="bold">21 296 pessoas desalojadas</span> que se abrigaram durante semanas em barracas (muitas delas improvisadas) ou em casa de amigos.
                    </div>

                    <div class="clearAll"></div>

                    <div class="box_1">
                        <div class="box1Img">
                            <img src="img/terramoto/mulheres.jpg" width="410px" height="210px"/>
                        </div>
                        <div class="box1Text">
                            <span>“Quem abandona o seu lar<br/>
                              E seus haveres principais<br/>
                              Só para salvar a vida<br/>
                              Não podendo salvar mais”
                            </span>
                        </div>
                    </div>

                    <div class="clearAll"></div>

                    <div class="textBlock">
                        Devido à então recente formação do Governo Regional (1976), a cadeia de comando em caso de emergência ainda não estava totalmente organizada. Mesmo assim, as inúmeras identidades formais e informais, como os bombeiros, polícia, militares, escuteiros, etc. começaram, desde logo, a ajudar as populações em choque.
                    </div>

                    <div class="clearAll"></div>

                    <div id="box_6">
                        <div id="box6Text" class="fLeft">
                            <span>Apoio</span>
                            <div>Bombeiros, Militares, Polícias, Escuteiros, Juntas de Freguesia, Rádio Amadores, Etc.</div>

                        </div>
                        <div id="box6Img" class="fLeft">
                            <img src="img/terramoto/militares.jpg" width="410px" height="210px"/>
                        </div>
                    </div>

                    <div class="clearAll"></div>

                    <div class="textBlock">
                        Apenas <span class="bold">4 dias após o terramoto</span>, e para evitar emigrações em massa como havia acontecido anos antes com outras crises geológicas, o Governo Regional criou o <span class="bold">G.A.R. (Gabinete de Apoio e Reconstrução)</span> com o objetivo de organizar os trabalhos de reconstrução, nomeadamente, a estruturação da <span class="bold">cedência de materiais</span> e regulando <span class="bold">linhas de crédito acessíveis</span> destinados aos sinistrados.
                    </div>

                    <div class="clearAll"></div>

                    <div id="box_7">
                        <img src="img/terramoto/triade.png"/>
                    </div>

                    <div class="clearAll"></div>

                    <div class="textBlock">
                        Em vez de a população ficar à espera de que o Governo reconstruísse as suas casa, optou-se por fornecer os materiais e crédito aos cidadãos para que eles próprios reconstruissem em sua casa, a apelidada <span class="bold">“auto-reconstrução”</span> (1992). Isto despertou um sentido de empenho e entreajuda nos Açorianos que foi falado em todo mundo.
                    </div>

                    <div class="clearAll"></div>

                    <div id="box_8">
                        <div id="box8Img" class="fLeft">
                            <img src="img/terramoto/idosa.jpg"/>
                        </div>
                        <div id="box8Text" class="fLeft">
                            <div style="width:380px;padding: 0 20px;">
                                Além da ajuda nacional, o arquipélago também contou com doações externas. No total, mais de <span class="bold">257 608 914$50</span> (duzentos e sete milhões seiscentos e oito mil novecentos e catorze escudos e cinquenta centavos) assim como <span class="bold">inúmeros materiais e alimentos foram doados</span> a partir de todo o mundo, por exemplo, Inglaterra, Alemanha, França, Japão, etc.
                            </div>
                            <div id="box8Stats">
                                <span class="escudos">0</span> Escudos<br/>
                                <span class="euros">0</span> Euros
                            </div>

                        </div>
                    </div>

                    <div class="clearAll"></div>

                    <div class="textBlock">
                        Devido à abundância de trabalho da construção, vieram imensos estrangeiros participar na construção que mais tarde trouxeram as suas famílias. Alguns acabaram por se estabelecer na ilha.
                    </div>

                    <div class="clearAll"></div>

                    <div class="box_1">
                        <div class="box1Img">
                            <img src="img/terramoto/estrangeiro.jpg" width="410px" height="210px"/>
                        </div>
                        <div class="box1Text">
                            <span>“Todos foram boas gentes<br/>
                              Que merecem ser louvados<br/>
                              Estes tão dignos valentes<br/>
                              Que valeram aos sinistrados”
                            </span>
                        </div>
                    </div>

                    <div class="clearAll"></div>

                    <div class="textBlock">
                        Passo a passo, a vida foi voltando à normalidade. Apenas <span class="bold">três anos</span> depois, Angra está praticamente reconstruida e recebe o título de Património Mundial da Humanidade pela Unesco em 1983.
                    </div>

                    <div class="clearAll"></div>

                    <div id="box_9">
                        <div id="box9Img1">
                            <img src="img/terramoto/cidade_2013.jpg"/>
                        </div>
                        <div id="box9Img2">
                            <img src="img/terramoto/patrimonio.jpg"/>
                        </div>
                    </div>

                    <div class="clearAll"></div>

                    <div class="textBlock">
                        <p>Ainda hoje se fala no terramoto que marcou o tempo dizendo que “há uma vida antes do sismo e há uma vida depois do sismo” (Helder Medeiros, 2013).</p>

                        <p>A natuzera que forma os Açores é munida de uma imprevisibilidade destrutiva e eventos como o sismo de 1 de janeiro de 1980 irão acontecer de novo. Assim, torna-se importante registar o que ainda existe para que sirva de base para eventos futuros, como inspiração ou consolo.</p>

                        <span style="color:#f38237;font-weight:bold;">
                            “O nosso objetivo consiste na criação de um inventário com o maior número possível de testemunhos de sobreviventes do terramoto ocorrido a 1 de Janeiro de 1980 dos Açores.”
                        </span>
                    </div>

                    <div class="clearAll"></div>

                    <div class="videoBoxFinal">
                        <iframe width="820" height="482" src="//www.youtube.com/embed/d59GQ9Lg4HY" frameborder="0" allowfullscreen></iframe>
                    </div>

                    <div class="fb-like" data-href="http://sismodoitenta.com/terramoto" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>

                    <div class="clearAll"></div>
                </div>
            </div>
		</div>
        <div class="clearAll"></div>
	</body>
</html>