<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Division</title>
</head>
<body>
	<h1>Show players that played in all the matches in a team</h1>
	<form method="post" action="14_project_final_division.php">
		<input type="submit" value = "ForGSW" name="button1">
		<input type="submit" value = "ForBOS" name="button2">
		<input type="submit" value = "ForHOU" name="button3">
		<input type="submit" value = "ForTOR" name="button4">
    <h1>Show all the matches that a player played in </h1>
    <input type="text" name = "pid"><br>
    <input type="submit" value = "Get Matches" name="button5">
    <h1> Insert player stats for a player</h1>
    <h3>Match ID</h3><input type="text" name = "psmid"><br>
    <h3>Player ID</h3><input type="text" name = "pspid"><br>
    <h3>Points Scored</h3><input type="text" name = "psps"><br>
    <input type="submit" value = "Insert" name="button6">
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
						<th>Last Name</th></tr>";

	while ($row = OCI_Fetch_Array($oldresult, OCI_BOTH)) {
		echo "<tr><td>" . $row["PID"] . "</td>
							<td>" . $row["PFNAME"] . "</td>
							<td>" . $row["PLNAME"] . "</td></tr>"; //or just use "echo $row[0]"
	}

	echo "</table>";

}


function printPS($result){
  echo "<br>Got player data from table playerstats:<br>";
  echo "<table>";
  echo "<tr><th>Player ID</th>
            <th>Match ID</th></tr>";

  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    echo "<tr><td>" . $row["PID"] . "</td>
              <td>" . $row["MID"] . "</td></tr>"; //or just use "echo $row[0]"
  }

  echo "</table>";
}


function executeBoundSQL($cmdstr, $list) {
	/* Sometimes a same statement will be excuted for severl times, only
	 the value of variables need to be changed.
	 In this case you don't need to create the statement several times;
	 using bind variables can make the statement be shared and just
	 parsed once. This is also very useful in protecting against SQL injection. See example code below for       how this functions is used */

	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr);

	if (!$statement) {
		echo "<br><br><br><br><br><br><br><br><br><br>";

		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
		$success = False;
		echo "<br><br><br><br><br><br><br><br><br><br>";

	}

	foreach ($list as $tuple) {
		foreach ($tuple as $bind => $val) {
			//echo $val;
			//echo "<br>".$bind."<br>";
			OCIBindByName($statement, $bind, $val);
			unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

		}
		$r = OCIExecute($statement, OCI_DEFAULT);
		echo $r;
		if (!$r) {
			echo "<br><br><br><br><br><br><br><br><br><br>";

			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
			echo htmlentities($e['message']);
			echo "<br>";
			$success = False;
			echo "<br><br><br><br><br><br><br><br><br><br>";

		}
    else{
			echo "<br><br><br><br><br><br><br><br><br><br>";

          echo "Tuple is inserted successfully!";
					echo "<br><br><br><br><br><br><br><br><br><br>";

    }
	}

}



	if($db_conn){
		if(array_key_exists('button1', $_POST)){

      		$updatesql = "select GSWTemp.pid, GSWTemp.pfname, GSWTemp.plname from GSWTemp where not exists (select m.mid from matches m, matchstats ms where m.mid = ms.mid and ms.tid= 'gsw' minus (select pp.mid from playerstats pp where pp.pid = GSWTemp.pid))";
			$updatestm = oci_parse($db_conn, $updatesql);
			OCIExecute($updatestm);
      		printResult($updatestm);

		} else if(array_key_exists('button2', $_POST)){

      		$updatesql = "select BOSTemp.pid, BOSTemp.pfname, BOSTemp.plname from BOSTemp where not exists (select m.mid from matches m, matchstats ms where m.mid = ms.mid and ms.tid= 'bos' minus (select pp.mid from playerstats pp where pp.pid = BOSTemp.pid))";
			$updatestm = oci_parse($db_conn, $updatesql);
			OCIExecute($updatestm);
      		printResult($updatestm);

		} else if(array_key_exists('button3', $_POST)){

      		$updatesql = "select HOUTemp.pid, HOUTemp.pfname, HOUTemp.plname from HOUTemp where not exists (select m.mid from matches m, matchstats ms where m.mid = ms.mid and ms.tid= 'hou' minus (select pp.mid from playerstats pp where pp.pid = HOUTemp.pid))";
			$updatestm = oci_parse($db_conn, $updatesql);
			OCIExecute($updatestm);
      		printResult($updatestm);

		} else if(array_key_exists('button4', $_POST)){

      		$updatesql = "select TORTemp.pid, TORTemp.pfname, TORTemp.plname from TORTemp where not exists (select m.mid from matches m, matchstats ms where m.mid = ms.mid and ms.tid= 'tor' minus (select pp.mid from playerstats pp where pp.pid = TORTemp.pid))";
			$updatestm = oci_parse($db_conn, $updatesql);
			OCIExecute($updatestm);
      		printResult($updatestm);
		}
    else if(array_key_exists('button5', $_POST)){
      $sql = "select pp.pid, pp.mid from playerstats pp where pp.pid = :userInput1";
      $stm = oci_parse($db_conn, $sql);
			$pid = $_POST['pid'];
			oci_bind_by_name($stm, ':userInput1', $pid);
      OCIExecute($stm);
      printPS($stm);
    }
    else if(array_key_exists('button6', $_POST)){
      $tuple = array (
      ":bind1" => $_POST['psmid'],
      ":bind2" => $_POST['pspid'],
      ":bind3" => $_POST['psps']
    );
    $alltuples = array (
      $tuple
    );
    executeBoundSQL("insert into playerstats values (:bind1, :bind2, :bind3)", $alltuples);
    OCICommit($db_conn);
    }


		OCILogoff($db_conn);
	} else {
		echo "cannot connect";
		$e = OCI_Error(); // For OCILogon errors pass no handle
		echo htmlentities($e['message']);
	}

 ?>
