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
	?>
		
	<form method="post" action="all_users.php">
	
	    <label for="lettre">Start with letter</label>
		<input type="text" id = "lettre" name = "lettre" required maxlength ="1" size="2"/>
		
		<label for="status">and status is</label>
		<select type="select" name = "status"/>
			<option value="1">Waiting for account validation</option>
			<option value="2">Active account</option>
		</select>
		
		<input type="submit" value="Rechercher" />
	
	</form>
	
	<?php
	    if (isset($_POST['lettre'])) {
            $lettre_username = $_POST['lettre'];
        }
		
		if (isset($_POST['status'])) {
            $status_username = $_POST['status'];
        }
	?>
		
	<?php
        echo "<table>";
		echo "<tr>";
			echo "<th>";
				echo 'Id';	
			echo "</th>";
			echo "<th>";
				echo 'Username';	
			echo "</th>";
			echo "<th>";
				echo 'Email';	
			echo "</th>";
			echo "<th>";
				echo 'Status';
			echo "</th>";
		echo "</tr>";
		
		$status_id = 2;
		$username = "e";
		
		if (isset($status_username, $lettre_username)) {
		$stmt = $pdo->query('SELECT users.id, username, email, status.name 
		                     FROM users 
		                     JOIN status 
		                     ON users.status_id = status.id
							 WHERE status.id = "'.$status_username.'"
							 AND username LIKE "'.$lettre_username.'%"
							 ORDER BY username');
	    } else {
		$stmt = $pdo->query('SELECT users.id, username, email, status.name 
		                     FROM users 
		                     JOIN status 
		                     ON users.status_id = status.id
							 ORDER BY username');	
		}
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