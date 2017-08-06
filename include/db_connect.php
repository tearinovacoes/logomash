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
?>