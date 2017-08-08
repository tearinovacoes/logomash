<?php
include("include/db_connect.php");
include("include/consult.php");
?>

<!DOCTYPE html>
<html>
	<head><title>Logomash</title>
		<script type='text/javascript'>window.onbeforeunload=function(){}</script>
		<link rel="stylesheet" href="css/main.css"/>
		<link href="css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="jumbotron">
						<img style="float: left;" src="img/site/logo.png" alt="Tear Inovações" height="150" width="150"><h2 style="text-align: left;"><strong>Seleção - Logo Projeto AURORA</strong></h2>
						<div style="margin-left: 150px;">
							<p style="text-align: justify; width: 90%;">
								<!--A escolha será feita observados os seguintes itens: representação da identidade do Projeto, identificação da missão e valores do Projeto, participação colaborativa dos envolvidos, criatividade, inovação. Qual desenho melhor representa a identidade do Projeto Aurora?-->
								Escolha a imagem que melhor represente: </br><strong>Caráter inovador, criatividade e a identidade do projeto.</strong>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-4">
							<a href='index.php?<?php echo "w=$random1&l=$random2"; ?>'><img src="img/image(<?php echo $random1; ?>).jpg" class="img-rounded" style="height:300px; max-width: 400px;"/></a>
						</div>
						<div class="col-md-2">
							<p style='font-size: 18px; text-align: center; vertical-align: middle; margin-top: 130px; margin-bottom: 130px;'>
								<strong>OU</strong>
							</p>
						</div>
						<div class="col-md-4">
							<a href='index.php?<?php echo "w=$random1&l=$random2"; ?>'><img src="img/image(<?php echo $random2; ?>).jpg" class="img-rounded" style="height:300px; max-width: 400px;"/></a>
						</div>
						<div class="col-md-1"></div>
					</div>
					<img style="padding-top: 30px;" src="img/site/sombra.png"/>
					<!--<div style="padding-top: 15px;" class="rating">Rating:<?php //echo $ratingA; ?>/ Rating: <?php //echo $ratingB; ?></div>-->
					<div class="footer">
						<h4><strong>Escolas Inovadoras de Viamão</strong></h4>
						<p style="text-align: center;">
							<strong>Como funciona: </strong>As imagens são exibidas aleatóriamente, vote quantas vezes considerar necessário, </br>pois as escolhas não acumulam pontos, o cálculo realizado é uma média específica para votação em massa.
						</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
