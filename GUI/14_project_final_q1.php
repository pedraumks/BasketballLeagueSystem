<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Query 1</title>
</head>
<body>
	<h1>Search player by jersey number</h1>
	<h5> Enter the jersey number</h5>
	<form method="post" action="14_project_final_q1.php">
		<p><input type="text" name="jerseyno">
		<input type="submit" value="Submit" name="updatesubmit"></p>
	</form>
</body>
</html>

<?php
  $success = TRUE;
  $db_conn = OCILogon('ora_y2l0b', 'a57023153', "dbhost.ugrad.cs.ubc.ca:1522/ug");

	function printResult($result) { //prints results from a select statement
	echo "<br>Got player data from table players:<br>";
	echo "<table>";
	echo "<tr><th>Player ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Date of Birth</th>
						<th>Jersey Number</th>
						<th>Position</th></tr>";

	$count = 0;
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		$count = $count + 1;
		echo "<tr><td>" . $row["PID"] . "</td>
							<td>" . $row["PFNAME"] . "</td>
							<td>" . $row["PLNAME"] . "</td>
							<td>" . $row["DOB"] . "</td>
							<td>" . $row["JNO"] . "</td>
							<td>" . $row["POS"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	if($count == 0){
		echo "<br><br><br><br><br><br><br><br><br><br>";
		echo "Data is not found!";
		echo "<br><br><br><br><br><br><br><br><br><br>";

	}
	echo "</table>";

}


if($db_conn){
  if(array_key_exists('updatesubmit', $_POST)){

		$sql = "select * from players p where p.jno = :jerseyno";
		$stid = oci_parse($db_conn, $sql);
		$jerseyno = $_POST['jerseyno'];
		oci_bind_by_name($stid, ':jerseyno', $jerseyno);

		if (!$stid) {
			echo "<br>Cannot parse the following command: " . $sql . "<br>";
			$e = OCI_Error($db_conn);
			echo htmlentities($e['message']);
			echo "Wrong Input Please try again with another input!!!!!";
			$success = False;
		}


		$r = OCIExecute($stid, OCI_DEFAULT);
		if (!$r) {
			echo $r;
			echo "<br>Cannot execute the following command: " . $sql . "<br>";
			$e = OCI_Error($stid); // For OCIExecute errors pass the statementhandle
			echo htmlentities($e['message']);
			echo "<br>";
			echo "<br><br><br><br><br><br><br><br><br><br>";

			echo "Wrong Input Please try again with another input!!!!!";
			echo "<br><br><br><br><br><br><br><br><br><br>";

			$success = False;
		}
		printResult($stid);
	}


	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

?>
