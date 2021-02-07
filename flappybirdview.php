<!DOCTYPE html>

<style>

</style>
<html>
<head> 
<title> Flappy bird highscores</title>
<link rel="stylesheet" type="text/css" href="main.css"> 
</head>
<body>
<h1>Flappy bird High Scores</h1>

<table>
<TR>
<th> rank </th> <th>Name </th> <th>Score </th> 
</tr>
<?php
/*	$highscoresfile = fopen("highscores.txt", "r");
	if(!$highscoresfile){
		http_response_code(500);
		die("Could not find highscores file");
	}
	$highscores = [];

	while(!feof($highscoresfile)){
		$line=fgets($highscoresfile);
		if(!empty($line)){
		echo "<tr>";
		$index=strpos($line, ",");
		$name = substr($line, 0, $index);
		$score=intval(substr($line, $index + 1));
		array_push($highscores, [$name, $score]);
		echo "<td>".$name . "</td><td> " . $score . "</td></tr>";
		}
	}
	fclose($highscoresfile);
*/
	$page = 0;
	if(isset($_GET["page"])) {
		$page = intval($_GET["page"]);
	}
	$conn = new mysqli("127.0.0.1", "sam", "Password123", "harry_truman_dor");
	if($conn->connect_error){
		http_response_code(500);
		die("Could not connect to MySql server " . $conn->connect_error);
	}
	$stmt= $conn->prepare("select * from harrytrumandorisdayredchinajohnnieraysouthpacificwalterwinchellj order by score desc limit ?,100");
	$offset = $page * 100;
	$stmt->bind_param("i", $offset);
	$stmt->execute();
	$result = $stmt->get_result();
	if(!empty($result) && $result->num_rows>0){
		while($row=$result->fetch_assoc()){
			echo "<tr> <td>" . $row["place"] . " </td> <td>". $row["name"]."</td> <td>".$row["score"]."</td> </tr>";
		}
	}
?>
</table>
<a href="index.html">Back to index. </a>
</body>
</html>