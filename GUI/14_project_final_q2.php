
<html lang="en">
<head>
	<title>Query 2</title>
</head>
<body>
	<h1>Search all players under a team</h1>
	<h5>Enter the team name</h5>
	<form method="post" action="14_project_final_q2.php">
		<p><input type="text" name="tname">
		<input type="submit" value="Submit" name="button"><p>
	</form>
</body>
</html>

<?php
	$success = TRUE;
	$db_conn = OCILogon('ora_y8p0b', 'a43736157', "dbhost.ugrad.cs.ubc.ca:1522/ug");

	function printResult($result) { //prints results from a select statement
	echo "<br>Got player data from table players:<br>";
	echo "<table>";
	echo "<tr><th>Player ID</th>
						<th>First Name</th>
						<th>Last Name</th></tr>";

  $count = 0;
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		$count = $count + 1;
		echo "<tr><td>" . $row["PID"] . "</td>
							<td>" . $row["PFNAME"] . "</td>
							<td>" . $row["PLNAME"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	if($count == 0){
		echo "<br><br><br><br><br><br><br><br><br><br>";

		echo "Data is not found!";
		echo "<br><br><br><br><br><br><br><br><br><br>";

	}
	echo "</table>";

}

	if($db_conn){
		if(array_key_exists('button', $_POST)){

			$sql = "select p.pid, p.pfname, p.plname from players p, playerteams pt, teams t where p.pid = pt.pid and t.tid = pt.tid and t.tname = :userInput";
			$stm = oci_parse($db_conn, $sql);
			$tname = trim($_POST['tname']);
			oci_bind_by_name($stm, ':userInput', $tname);

			if (!$stm) {
				echo "<br>Cannot parse the following command: " . $sql . "<br>";
				$e = OCI_Error($db_conn);
				echo htmlentities($e['message']);
				echo "<br><br><br><br><br><br><br><br><br><br>";

				echo "Wrong Input! Please try again with another input!!!!!";
				echo "<br><br><br><br><br><br><br><br><br><br>";

				$success = False;
			}

			$r = OCIExecute($stm);
			if (!$r) {
				echo "<br>Cannot execute the following command: " . $sql . "<br>";
				$e = OCI_Error($stm); // For OCIExecute errors pass the statementhandle
				echo htmlentities($e['message']);
				echo "<br>";
				echo "<br><br><br><br><br><br><br><br><br><br>";

				echo "Wrong Input Please try again with another input!!!!!";
				echo "<br><br><br><br><br><br><br><br><br><br>";

				$success = False;
			}
			printResult($stm);

		}


		OCILogoff($db_conn);
	} else {
		echo "cannot connect";
		$e = OCI_Error(); // For OCILogon errors pass no handle
		echo htmlentities($e['message']);
	}

 ?>
