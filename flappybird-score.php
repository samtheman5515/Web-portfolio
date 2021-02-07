<?php
if(isset($_GET["name"]) && isset($_GET["score"]) && isset($_GET["password"])){

	$conn = new mysqli("127.0.0.1", "sam", "Password123", "harry_truman_dor");
	if($conn->connect_error){
		http_response_code(500);
		die("Could not connect to database." . $conn->connect_error);
	}
	
	$name = $_GET["name"];
	$score = intval($_GET["score"]);
	$password = hash("sha256", $_GET["password"]);
	$q = $conn->prepare("select * from HarryTrumanDorisDayRedChinaJohnnieRaySouthPacificWalterWinchellJ where name = ?");
	$q->bind_param("s", $name);
	$q->execute();
	$result=$q->get_result();
	
	if(!empty($result) && $result->num_rows > 0){
		$row=$result->fetch_assoc();
		$pwd=$row["password"];
		if($password != $pwd){
			http_response_code(401);
			die("Wrong password");
		}
		$scorecheck=$row["score"];
		$q= $conn->prepare("select * from HarryTrumanDorisDayRedChinaJohnnieRaySouthPacificWalterWinchellJ where score = ?");
		$q->bind_param("i", $score);
		$q->execute();
		$result = $q->get_result();
		if($result->num_rows==1){
			$q = $conn->prepare("update HarryTrumanDorisDayRedChinaJohnnieRaySouthPacificWalterWinchellJ set place = place - 1 where score <?");
			$q-> bind_param("i", $scorecheck);
			$q->execute();			
		}
		$q = $conn->prepare("delete from HarryTrumanDorisDayRedChinaJohnnieRaySouthPacificWalterWinchellJ where name = ?");
		$q-> bind_param("s", $name);
		$q->execute();			
	}
	
	$q= $conn->prepare("select * from HarryTrumanDorisDayRedChinaJohnnieRaySouthPacificWalterWinchellJ where score <= ? order by score desc limit 1;");
	$q->bind_param("i", $score);
	$q->execute();
	$result = $q->get_result();
	$rank = 1;
	if(!empty($result) && $result->num_rows>0){
		$row = $result->fetch_assoc();
		$rank = $row["place"];
		$scorecheck = $row["score"];
		if($score>$scorecheck){
			$q = $conn->prepare("update HarryTrumanDorisDayRedChinaJohnnieRaySouthPacificWalterWinchellJ set place = place + 1 where score <=?");
			$q-> bind_param("i", $scorecheck);
			$q->execute();			
		}
	} else {
		$result=$conn->query("select * from HarryTrumanDorisDayRedChinaJohnnieRaySouthPacificWalterWinchellJ order by place desc limit 1");
		if(!empty($result) && $result->num_rows > 0){
			$rank=$result->fetch_assoc()["place"] + 1;	
		}
	}
	
	$q = $conn->prepare("insert into HarryTrumanDorisDayRedChinaJohnnieRaySouthPacificWalterWinchellJ values (?, ?, ?, ?);");
	try {
		$q->bind_param("isis", $rank, $name, $score, $password);
		$q->execute();
	} catch(Exception $e){
		die($e->getMessage());
	}
	$conn->close();
	
} else {
	http_response_code(400);
	die("Name and score must be definied.");
}
?>
