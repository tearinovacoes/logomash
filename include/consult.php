<?php
	
	require("db_connect.php");
	$consulta = $pdo->query("select * from logomashed");
	
	$using="use logomashed";
	//$query=pg_query($dbopts, "select * from logomashed") or die ("Here it broke");
	$consulta = $pdo->query("select * from logomashed");
		if($_REQUEST!=NULL){
		$winner=$_REQUEST['w'];
		$loser=$_REQUEST['l'];
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