<?php
	
	//die(getenv("DATABASE_URL"));
	$dbopts=parse_url(getenv("DATABASE_URL"));
	
    $host = $dbopts["host"];
    $user = $dbopts["user"];
    $dbname = ltrim($dbopts["path"],'/');
    $pass = $dbopts["pass"];
    $port = $dbopts["port"];
	
	$pdo = new PDO('pgsql:port='.$port.' sslmode=require host='.$host.' user='.$user.' dbname='.$dbname.' password='.$pass);  
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
	$consulta = $pdo->query("select * from logomashed");
	
	$using="use logomashed";
	//$query=pg_query($dbopts, "select * from logomashed") or die ("Here it broke");
	$consulta = $pdo->query("select * from logomashed");
		if($_REQUEST!=NULL){
		$winner=$_REQUEST['won'];
		$loser=$_REQUEST['lost'];
		$base_rating=1400;
		//$query2=pg_fetch_array(pg_query($dbopts, "select rating from logomashed where id=$winner"));
		$query2=$pdo->query("SELECT rating FROM logomashed where id=$winner");
		//$query3=pg_fetch_array(pg_query($dbopts, "select rating from logomashed where id=$loser"));
		$query3=$pdo->query("SELECT rating FROM logomashed where id=$loser");
		//$winner_rating=$query2['rating'];
		$linha4 = $query2->fetch(PDO::FETCH_ASSOC);
		$winner_rating=$linha4['rating'];
		//$loser_rating=$query3['rating'];
		$linha5 = $query3->fetch(PDO::FETCH_ASSOC);
		$loser_rating=$linha5['rating'];

		if($winner_rating<=2100){ $Kw=32;} elseif($winner_rating>2100&&$winner_rating<2400){ $Kw=24;}elseif($winner_rating>2400){$Kw=16;}
		if($loser_rating<=2100){ $Kl=32;} elseif($loser_rating>2100&&$loser_rating<2400){ $Kl=24;}elseif($loser_rating>2400){$Kl=16;}

		$diff_w=($loser_rating-$winner_rating)/400;
		$diff_l=($winner_rating-$loser_rating)/400;
		
		$prob_winner=1/(1+pow(10,$diff_w));
		$prob_loser=1/(1+pow(10,$diff_w));

			$winner_rating = $winner_rating + $Kw*(1-$prob_winner);
			$loser_rating = $loser_rating + $Kw*(0-$prob_loser);

		//$updatequery=pg_query($dbopts,"update logomashed set rating=$winner_rating where id=$winner") or die(pg_error($dbopts));
		$updatequery=$pdo->query("update logomashed set rating=$winner_rating where id=$winner");
		//$updatequery=pg_query($dbopts,"update logomashed set rating=$loser_rating where id=$loser") or die(pg_error($dbopts));
		$updatequery=$pdo->query("update logomashed set rating=$loser_rating where id=$loser");
	}
		
		//This variable tells the total number of pics. Update it.
		$max_ppl=24;

		$random1= rand(1,$max_ppl);
		$random2=rand(1,$max_ppl);
		while($random1===$random2)
		{ 
			$random1=rand(1,$max_ppl);
			$random2=rand(1,$max_ppl);
		}

		//$rating1=pg_fetch_array(pg_query($dbopts,"select rating from logomashed where id=$random1"));
		$rating1=$pdo->query("SELECT rating FROM logomashed where id=$random1");
		//$rating2=pg_fetch_array(pg_query($dbopts,"select rating from logomashed where id=$random2"));
		$rating2=$pdo->query("SELECT rating FROM logomashed where id=$random2");
		$linha2 = $rating1->fetch(PDO::FETCH_ASSOC);
		$ratingA=$linha2['rating'];
		$linha3 = $rating2->fetch(PDO::FETCH_ASSOC);
		$ratingB=$linha3['rating'];

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
						<img style="float: left;" src="img/logo.png" alt="Tear Inovações" height="150" width="150"><h2 style="text-align: left;"><strong>Votação de logo Projeto AURORA</strong></h2>
						<div style="margin-left: 150px;">
							<p style="text-align: justify; width: 90%;">
								A escolha será feita observados os seguintes itens: representação da identidade do Projeto, identificação da missão e valores do Projeto, participação colaborativa dos envolvidos, criatividade, inovação. Qual desenho melhor representa a identidade do Projeto Aurora?
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-4">
							<a href='index.php?<?php echo "won=$random1&lost=$random2"; ?>'><img src="img/image(<?php echo $random1; ?>).jpg" class="img-rounded" style="float: right; height:300px; max-width: 400px;"/></a>
						</div>
						<div class="col-md-2">
							<p style='text-align: center; vertical-align: middle; margin-top: 150px;'>
								<strong>OU</strong>
							</p>
						</div>
						<div class="col-md-4">
							<a href='index.php?<?php echo "won=$random1&lost=$random2"; ?>'><img  src="img/image(<?php echo $random2; ?>).jpg" class="img-rounded" style="float: left; height:300px; max-width: 400px;"/></a>
						</div>
						<div class="col-md-1"></div>
					</div>
				</div>
				</br></br></br></br>
				<div class="rating">Rating:<?php echo $ratingA; ?>/ Rating: <?php echo $ratingB; ?></div>
				<div class="footer"><h4><strong>Escolas Inovadoras de Viamão</strong></h4></div>
			</div>
		</div>
	</body>
</html>
