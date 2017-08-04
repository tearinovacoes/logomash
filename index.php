<?php
	
	//die(getenv("DATABASE_URL"));
	$dbopts=parse_url(getenv("DATABASE_URL"));
	
    $host = $dbopts["host"];
    $user = $dbopts["user"];
    $dbname = ltrim($dbopts["path"],'/');
    $pass = $dbopts["pass"];
    $port = $dbopts["port"];
	
	new PDO('pgsql:port='.$port.' sslmode=require host='.$host.' user='.$user.' dbname='.$dbname.' password='.$pass);  
	
	$using="use logomashed";
	$query=pg_query($dbopts, "select * from logomashed") or die ("Here it broke");
		if($_REQUEST!=NULL){
		$winner=$_REQUEST['won'];
		$loser=$_REQUEST['lost'];
		$base_rating=1400;
		$query2=pg_fetch_array(pg_query($dbopts, "select rating from logomashed where id=$winner"));
		$query3=pg_fetch_array(pg_query($dbopts, "select rating from logomashed where id=$loser"));
		$winner_rating=$query2['rating'];
		$loser_rating=$query3['rating'];

		if($winner_rating<=2100){ $Kw=32;} elseif($winner_rating>2100&&$winner_rating<2400){ $Kw=24;}elseif($winner_rating>2400){$Kw=16;}
		if($loser_rating<=2100){ $Kl=32;} elseif($loser_rating>2100&&$loser_rating<2400){ $Kl=24;}elseif($loser_rating>2400){$Kl=16;}

		$diff_w=($loser_rating-$winner_rating)/400;
		$diff_l=($winner_rating-$loser_rating)/400;
		
		$prob_winner=1/(1+pow(10,$diff_w));
		$prob_loser=1/(1+pow(10,$diff_w));

			$winner_rating = $winner_rating + $Kw*(1-$prob_winner);
			$loser_rating = $loser_rating + $Kw*(0-$prob_loser);

		$updatequery=pg_query($dbopts,"update logomashed set rating=$winner_rating where id=$winner") or die(pg_error($dbopts));
		$updatequery=pg_query($dbopts,"update logomashed set rating=$loser_rating where id=$loser") or die(pg_error($dbopts));
	}
		
		//This variable tells the total number of pics. Update it.
		$max_ppl=6;

		$random1= rand(1,$max_ppl);
		$random2=rand(1,$max_ppl);
		while($random1===$random2)
		{ 
			$random1=rand(1,$max_ppl);
			$random2=rand(1,$max_ppl);
		}

		$rating1=pg_fetch_array(pg_query($dbopts,"select rating from logomashed where id=$random1"));
		$rating2=pg_fetch_array(pg_query($dbopts,"select rating from logomashed where id=$random2"));
		$ratingA=$rating1['rating'];
		$ratingB=$rating2['rating'];

?>
<!DOCTYPE html>
<html>
<head><title>Facemash</title>
<script type='text/javascript'>window.onbeforeunload=function(){}</script>
<link rel="stylesheet" href="main.css"/>
</head>
<body>
<div class="container">
	<div class="header"><img style='float: left;' src="img/logo.png" alt="Tear Inovações" height="100" width="100"><h1>Votação de logo Projeto AURORA</h1></div>

	<div class="description">
	<p style='text-align: justify; margin-left: 20%; margin-right: 20%;'>A escolha será feita observados os seguintes itens: representação da identidade do Projeto, identificação da missão e valores do Projeto, participação colaborativa dos envolvidos, criatividade, inovação.
Qual desenho melhor representa a identidade do Projeto Aurora?</p>
	<h3>Qual desenho melhor representa a identidade do Projeto Aurora?</p>
	</div>
	<div class="pics-container">
	<table class="pics">
		<tr>
			<td><a href='main.php?<?php echo "won=$random1&lost=$random2"; ?>'><img src="img/image(<?php echo $random1; ?>).jpg" class="images"/></a></td>
			<td>OU</td>
			<td><a href='main.php?<?php echo "won=$random1&lost=$random2"; ?>'><img src="img/image(<?php echo $random2; ?>).jpg" class="images"/></a></td>
		<tr>
			<td>Rating:<?php echo $ratingA; ?></td><td></td><td>Rating: <?php echo $ratingB; ?></td>
	</table>
	</div>

	<div class="footer"><h4><strong>Escolas Inovadoras de Viamão</strong></h4></div>
</div>
</body>

</html>
