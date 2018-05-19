<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Delete</title>
</head>
<body>
	<h1>Delete a player from his current team</h1>
	<form method="post" action="14_project_final_delete.php">
    <h5>Enter player first name</h5>
		<input type="text" name="pfname">
		<h5>Enter player last name</h5>
		<input type="text" name="plname"> <br>
    <input type="submit" value="Delete" name="button1"><br>



    <h1>Show all the players of a team</h1>
    <p><input type="text" name="tname">
    <input type="submit" value="Submit" name="button2"><p><br>


      <h1>Show all the stats of a player</h1>
      <h5>Enter player first name</h5>
  		<input type="text" name="pfname2">
  		<h5>Enter player last name</h5>
  		<input type="text" name="plname2"> <br>
      <input type="submit" value="Submit" name="button3"><p><br>


        <h1> Delete a stadium of a team </h1>
        <h5> Enter Stadium Name </h5>
        <input type="text" name="locname"> <br>
        <input type="submit" value="Delete" name="button4"><br>

        <h1> Show Team Information </h1>
        <p><input type="text" name="tname2">
        <input type="submit" value="Submit" name="button5"><p><br>
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

function printPlayerStats($result) { //prints results from a select statement
echo "<br>Got player stats data from table playerstats:<br>";
echo "<table>";
echo "<tr><th>Player ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Match ID</th>
          <th>Points Scored</th></tr>";

$count = 0;
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
	$count = $count + 1;
  echo "<tr><td>" . $row["PID"] . "</td>
            <td>" . $row["PFNAME"] . "</td>
            <td>" . $row["PLNAME"] . "</td>
            <td>" . $row["MID"] . "</td>
            <td>" . $row["PS"] . "</td></tr>"; //or just use "echo $row[0]"
}
if($count == 0){
	echo "<br><br><br><br><br><br><br><br><br><br>";

	echo "Data is not found!";
	echo "<br><br><br><br><br><br><br><br><br><br>";

}

echo "</table>";

}




function printTeamInfo($result) { //prints results from a select statement
echo "<br>Got Team Information from table Teams:<br>";
echo "<table>";
echo "<tr><th>Team ID</th>
          <th>Location ID</th>
          <th>Team Name</th>></tr>";

$count = 0;
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
	$count = $count + 1;
  echo "<tr><td>" . $row["TID"] . "</td>
            <td>" . $row["LOCAT"] . "</td>
            <td>" . $row["TNAME"] . "</td></tr>"; //or just use "echo $row[0]"
}
if($count == 0){
	echo "<br><br><br><br><br><br><br><br><br><br>";

	echo "Data is not found!";
	echo "<br><br><br><br><br><br><br><br><br><br>";

}

echo "</table>";

}

  if($db_conn){
    if(array_key_exists('button1', $_POST)){
  		//echo "key pressed";

      $sql = "delete from players p where p.pfname = :userInput1 and p.plname = :userInput2";
      //delete from players p where p.pfname = 'Chris' and p.plname = 'Paul'";
      $stm = oci_parse($db_conn, $sql);
      $pfname = trim($_POST['pfname']);
      oci_bind_by_name($stm, ':userInput1', $pfname);
      $plname = trim($_POST['plname']);
      oci_bind_by_name($stm, ':userInput2', $plname);
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

    } else
    if(array_key_exists('button2', $_POST)){
      //echo "key pressed";
      $sql = "select p.pid, p.pfname, p.plname from players p, playerteams pt, teams t where p.pid = pt.pid and t.tid = pt.tid and t.tname = :userInput";
			$stm = oci_parse($db_conn, $sql);
			$tname = trim($_POST['tname']);
			oci_bind_by_name($stm, ':userInput', $tname);

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
    else
    if(array_key_exists('button3', $_POST)){
      //echo "key pressed";
      $sql = "select p.pid, p.pfname, p.plname, ps.mid, ps.ps from players p, playerstats ps where p.pid = ps.pid and p.pfname = :userInput3 and p.plname = :userInput4";
      $stm = oci_parse($db_conn, $sql);
      $pfname2 = trim($_POST['pfname2']);
      oci_bind_by_name($stm, ':userInput3', $pfname2);
      $plname2 = trim($_POST['plname2']);
      oci_bind_by_name($stm, ':userInput4', $plname2);

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

			printPlayerStats($stm);
    } else
    if(array_key_exists('button4', $_POST)){
      $sql = "delete from locations loc where loc.stadium = :userInput5";
      // $sql = "delete from locations loc where loc.stadium = 'Oracle Arena'";

      $stm = oci_parse($db_conn, $sql);
      $pfname = trim($_POST['locname']);
      oci_bind_by_name($stm, ':userInput5', $pfname);

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
    } else
    if(array_key_exists('button5', $_POST)){
      //echo "key pressed";
      $sql = "select t.tid, NVL(t.locid,t.tid) as locat, t.tname from teams t where t.tname = :userInput6";
			$stm = oci_parse($db_conn, $sql);
			$tname = trim($_POST['tname2']);
			oci_bind_by_name($stm, ':userInput6', $tname);

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
			printTeamInfo($stm);
    }

  	OCILogoff($db_conn);
  }
  else {
  	echo "cannot connect";
  	$e = OCI_Error(); // For OCILogon errors pass no handle
  	echo htmlentities($e['message']);
  }


 ?>
