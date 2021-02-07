<?php
if(!isset($_GET["name"])){
	http_response_code(400);
	die("Requires name");
}	
$conn = new mysqli("127.0.0.1", "sam", "Password123", "harry_truman_dor");
if($conn->connect_error){
	http_response_code(500);
	die("Could not connect to database." . $conn->connect_error);

}
$q = $conn->prepare("select * from HarryTrumanDorisDayRedChinaJohnnieRaySouthPacificWalterWinchellJ where name = ?");
$q->bind_param("s", $_GET["name"]);
$q->execute();
$result=$q->get_result();
if(!empty($result) && $result->num_rows>0){
	$row=$result->fetch_assoc();
	exit($row["place"] . "," . $row["score"]);
} else {
	http_response_code(404);
	die("Name not found");
}
























?>