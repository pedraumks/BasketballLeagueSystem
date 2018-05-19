<html>
<head>
	<title>Query 3</title>
</head>
<body>
	<h1>Search how many matches a player played in (press count)</h1>
  <h1>Calculate player's points per game (press avg)</h1>
	<form method="post" action="14_project_final_q3.php">
		<h5>Enter player first name</h5>
		<input type="text" name="pfname">
		<h5>Enter player last name</h5>
		<input type="text" name="plname"> <br>
		<input type="submit" value="Count" name="button1">
    <input type="submit" value="Avg" name="button2">
	</form>
</body>
</html>

<?php
  $success = TRUE;
  $db_conn = OCILogon('ora_y8p0b', 'a43736157', "dbhost.ugrad.cs.ubc.ca:1522/ug");

  function printResultCount($result) { //prints results from a select statement
    echo "<br>Got player data from table playerstats:<br>";
    echo "<table>";
    echo "<tr><th>Games Played</th></tr>";

		$count = 0;

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
			$count = $count + 1;
     echo "<tr><td>" . $row["GP"] . "</td></tr>"; //or just use "echo $row[0]"
    }
		if($count == 0){
			echo "<br><br><br><br><br><br><br><br><br><br>";

			echo "Data is not found!";
			echo "<br><br><br><br><br><br><br><br><br><br>";

		}
    echo "</table>";
  }


  function printResultAvg($result) { //prints results from a select statement
    echo "<br>Got player data from table playerstats:<br>";
    echo "<table>";
    echo "<tr><th>Points per game</th></tr>";
		$count = 0;
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
			$count = $count + 1;
      echo "<tr><td>" . $row["PPG"] . "</td></tr>"; //or just use "echo $row[0]"
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

      $sql = "select count(ps.mid) as gp from playerstats ps, players p where p.pfname = :userInput1 and p.plname = :userInput2 and p.pid = ps.pid";

      $stm = oci_parse($db_conn, $sql);

      $pfname = trim($_POST['pfname']);
      oci_bind_by_name($stm, ':userInput1', $pfname);
      $plname = trim($_POST['plname']);
      oci_bind_by_name($stm, ':userInput2', $plname);

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
      printResultCount($stm);
    }
    if(array_key_exists('button2', $_POST)){
      //echo "key pressed";

      $sql = "select avg(pp.ps) as ppg from playerstats pp, players p where p.pfname = :userInput1 and p.plname = :userInput2 and p.pid = pp.pid";

      $stm = oci_parse($db_conn, $sql);

      $pfname = trim($_POST['pfname']);
      oci_bind_by_name($stm, ':userInput1', $pfname);
      $plname = trim($_POST['plname']);
      oci_bind_by_name($stm, ':userInput2', $plname);


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
      printResultAvg($stm);
    }

  	OCILogoff($db_conn);
  }
  else {
  	echo "cannot connect";
  	$e = OCI_Error(); // For OCILogon errors pass no handle
  	echo htmlentities($e['message']);
  }


 ?>
