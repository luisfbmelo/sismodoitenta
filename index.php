<?php
include "includes/global.inc.php";
?>
<?php $page=0; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">

	<head>
		<?php include 'includes/header.php'; ?>
	</head>

	<body>
		<div class="container">
			<div class="frame">
				<div class="topBar"></div>

                <div class="header">
					<a href="/">
						<div class="logo fLeft"></div>
						<div class="logoTxt fLeft"></div>
					</a>

					<div class=clearAll></div>

					<?php include 'includes/menu.php'; ?>
                    <div class=clearAll></div>
				</div>
				
				<div class="quote">
					<div class="article">"<?php $result = quotesPrint(); echo $result[1];?>"</div>
					<br/>
					<div class="summary"><?php echo $result[0];?></div>
	
				</div>
				
				<div class="bottomBar"></div>
			</div>
		</div>
	</body>
</html>

<?php //$_SESSION['loggedIn'] = false;?>