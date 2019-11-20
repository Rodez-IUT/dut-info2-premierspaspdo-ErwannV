<!DOCTYPE html>
<html lang="fr">
    <head>
		<meta charset="utf-8">
		<title>Utilisateurs</title>				
    </head>

    <body>
	
	<?php
        $host = 'localhost';
		$db = 'my_activities'; 
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

        echo "All users";
		echo "<br/>";
 
        echo "<table>";
		$stmt = $pdo->query('SELECT users.id, username, email, status.name FROM users JOIN status ON users.status_id = status.id ORDER BY username');
			while ($row = $stmt->fetch()) {
				echo "<tr>";
				    echo "<td>";
						echo $row['id']. "\n";
					echo "</td>";
					echo "<td>";
						echo $row['username']. "\n";
					echo "</td>";
					echo "<td>";
						echo $row['email']. "\n";
					echo "</td>";
					echo "<td>";
						echo $row['name']. "\n";
					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
	?>
	</body>
</html>