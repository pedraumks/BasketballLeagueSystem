<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Update</title>
</head>
<body>
	<h1>Update player salary</h1>
	<form method="post" action="14_project_final_update.php">
		<h5>Enter player id</h5><br>
		<input type="text" name = "pid">
		<h5>Enter new player salary amount</h5>
		<input type="text" name = "newsalary"><br>
		<input type="submit" value = "submit" name="button">
	</form>
</body>
</html>

<?php
	$success = TRUE;
	$db_conn = OCILogon('ora_y8p0b', 'a43736157', "dbhost.ugrad.cs.ubc.ca:1522/ug");

	function printResult($oldresult) { //prints results from a select statement
	echo "<br>Got player data from table players:<br>";
	echo "<table>";
	echo "<tr><th>Player ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Salary</th></tr>";

	$count = 0;
	while ($row = OCI_Fetch_Array($oldresult, OCI_BOTH)) {
		$count = $count + 1;
		echo "<tr><td>" . $row["PID"] . "</td>
							<td>" . $row["PFNAME"] . "</td>
							<td>" . $row["PLNAME"] . "</td>
							<td>" . $row["SALARY"] . "</td></tr>"; //or just use "echo $row[0]"
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
			//echo "key pressed";

			$sql = "select p.pid, p.pfname, p.plname, pt.salary from players p, playerteams pt where p.pid = pt.pid and p.pid = :userInput1";


			$stm = oci_parse($db_conn, $sql);
			$pid = trim($_POST['pid']);
			oci_bind_by_name($stm, ':userInput1', $pid);

			$r = OCIExecute($stm);
			if (!$r) {
				echo "<br>Cannot execute the following command: " . $sql . "<br>";
				$e = OCI_Error($stm); // For OCIExecute errors pass the statementhandle
				echo htmlentities($e['message']);
				echo "<br><br><br><br><br><br><br><br><br>";
				echo "Wrong Input Please try again with another input!!!!!";
				echo "<br><br><br><br><br><br><br><br><br>";

				$success = False;
			}
			echo "Player and his old salary";
			printResult($stm);

			$updatesql = "update playerteams pt set pt.salary=:userInput2 where pt.pid= :userInput3";
			$updatestm = oci_parse($db_conn, $updatesql);
			$pid = trim($_POST['pid']);
			$newsalary = trim($_POST['newsalary']);
			oci_bind_by_name($updatestm, ':userInput3', $pid);
			oci_bind_by_name($updatestm, ':userInput2', $newsalary);
			$t = OCIExecute($updatestm);
			if (!$t) {
				echo "<br>Cannot execute the following command: " . $updatesql . "<br>";
				$e = OCI_Error($updatestm); // For OCIExecute errors pass the statementhandle
				echo htmlentities($e['message']);
				echo "<br><br><br><br><br><br><br><br><br><br>";
				echo "Wrong Input Please try again with another input!!!!!";
				echo "<br><br><br><br><br><br><br>";
				$success = False;
			}

			OCIExecute($stm);

			echo "Player and his new salary";
			printResult($stm);

		}


		OCILogoff($db_conn);
	} else {
		echo "cannot connect";
		$e = OCI_Error(); // For OCILogon errors pass no handle
		echo htmlentities($e['message']);
	}

 ?>
