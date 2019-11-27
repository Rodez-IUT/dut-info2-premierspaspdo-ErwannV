<DOCTYPE HTML>
<head>
	<title>all_users.php</title>

</head>

<body>

<style>
tr {
	border-bottom: 1px solid grey;
}

td {
	padding: 0 10px;
}

table {
	border-collapse: collapse;
	font-family: Arial;
}
</style>

<?php

	$host = 'localhost';
	$db   = 'my_activities';
	$user = 'root';
	$pass = 'root';
	$charset = 'utf8mb4';
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$options = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];
	
	try {
		$pdo = new PDO($dsn, $user, $pass, $options);

	} catch (PDOException $e) {
		throw new PDOException($e->getMessage(), (int)$e->getCode());
	}
	
	
	if (isset($_GET["lettre"])) {
		$maLettre = $_GET["lettre"];
	} else {
		$maLettre = "";
	}
	
	if (isset($_GET["compte"])) {
		$etat = $_GET["compte"];
	}
	
	?>
	<form method="get" action="all_users.php">  
		Lettre: <input type="text" name="lettre"
		<?php 
			if(isset($_GET["lettre"])) {
				echo "value = '$maLettre'";
			}
		?>
		>
		
		<select name="compte">
			<option 				<?php if (isset($_GET["compte"]) and $_GET["compte"] == 2 ) {
										echo ' selected';
									} 
									?>
									value="2">Active account</option>
			<option 				<?php if (isset($_GET["compte"]) and $_GET["compte"] == 1 ) {
										echo ' selected';
									} 
									?> 
									value="1">Waiting for account validation</option>
				
			<option 				<?php if (isset($_GET["compte"]) and $_GET["compte"] == 3 ) {
										echo ' selected';
									} 
									?> 
									value="3">Waiting for account deletion</option>
									
									
		</select>
		<input type="submit" name="submit" value="Search">
		
	</form>
	
	
	
	<?php
	
	
	
	if (isset($maLettre) and isset($etat)) { 
		$stmt = $pdo->prepare("SELECT users.id, username, email, status.name FROM users JOIN status ON users.status_id = status.id WHERE username LIKE :lettre AND status.id = :etat ORDER BY username ");
		$stmt->execute(['lettre' => $maLettre."%", 'etat' => $etat]);
	} else {
		$stmt = $pdo->query("SELECT users.id, username, email, status.name FROM users JOIN status ON users.status_id = status.id ORDER BY username ");
	}
	echo "<table>";
		echo "<tr>";
			echo "<td>";
				echo "ID";
			echo "</td>";
			echo "<td>";
				echo "username";
			echo "</td>";
			echo "<td>";
				echo "email";
			echo "</td>";
			echo "<td>";
				echo "status";
			echo "</td>";
		echo "</tr>";
		
	while ($row = $stmt->fetch())
	{
		echo "<tr>";
			echo "<td>";
				echo $row['id'] . " ";
			echo "</td>";
			echo "<td>";
				echo $row['username'] . " ";
			echo "</td>";
			echo "<td>";
				echo $row['email'] . "<br>";
			echo "</td>";
			echo "<td>";
				echo $row['name'];
			echo "</td>";
			if($row['name'] != "Waiting for account deletion") {
				echo "<td>";
					
					echo "<a href='all_users.php?status_id=3&user_id=".$row['id']."&action=askDeletion'> Ask deletion</a>";
					
				echo "</td>";
			}
			
		echo "</tr>";
	}
	echo "</table>";

?>

</body>

</html>
	
	</body>
</html>