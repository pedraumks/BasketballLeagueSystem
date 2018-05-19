<html>
<head>
	<title>Nested Aggregation</title>
</head>
<body>
	<h1>Find Max/Min Score Per Match </h1>
	<form method="post" action="14_project_final_nestedagg.php">
    <input type="submit" value="Max" name="max"><br>
		<input type="submit" value="Min" name="min">
	</form>
</body>
</html>

<?php
  $success = TRUE;
  $db_conn = OCILogon('ora_y2l0b', 'a57023153', "dbhost.ugrad.cs.ubc.ca:1522/ug");

  function printResultAvg($result) { //prints results from a select statement
    echo "<br>Got player data from table playerstats:<br>";
    echo "<table>";


    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
      echo "<tr><td>" . $row["SPM"] . "</td></tr>"; //or just use "echo $row[0]"
    }
    echo "</table>";

  }



  if($db_conn){
    if(array_key_exists('max', $_POST)){

      $sql = "select avg(tscore) as spm from teams t, matchstats ms where t.tid = ms.tid group by t.tid having avg(tscore)>=all(select avg(ms.tscore) from teams t, matchstats ms where t.tid = ms.tid group by t.tid)";
			echo $sql;
			echo "<br>";
			$stm = oci_parse($db_conn, $sql);

      OCIExecute($stm);
			echo "<tr><th>Max Score Per Match</th></tr>";
      printResultAvg($stm);
    } else
		if(array_key_exists('min', $_POST)){

			$sql = "select avg(tscore) as spm from teams t, matchstats ms where t.tid = ms.tid group by t.tid having avg(tscore)<=all(select avg(ms.tscore) from teams t, matchstats ms where t.tid = ms.tid group by t.tid)";
			echo $sql;
			echo "<br>";
			$stm = oci_parse($db_conn, $sql);

			OCIExecute($stm);
			echo "<tr><th>Min Score Per Match</th></tr>";
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
