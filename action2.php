<?php
	//Declare DB connection properties
	$server = "phpmyadmin.cslpamwvqkbt.ap-southeast-2.rds.amazonaws.com: 3306";
	$username = "phpmyadmin";
	$password = "phpmyadmin";
	$database_name = "aws_attendance";

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$lname = isset($_POST['lastName'])?$_POST['lastName']:"";
		$fname = isset($_POST['firstName'])?$_POST['firstName']:"";
		$type = isset($_POST['attType'])?$_POST['attType']:"";
		$isMonday = isset($_POST['isMonday'])?(bool)$_POST['isMonday']:false;
		$isTuesday = isset($_POST['isTuesday'])?(bool)$_POST['isTuesday']:false;
		$isWed = isset($_POST['isWednesday'])?(bool)$_POST['isWednesday']:false;
		$isThurs = isset($_POST['isThursday'])?(bool)$_POST['isThursday']:false;
		$isFriday = isset($_POST['isFriday'])?(bool)$_POST['isFriday']:false;
		
		insertRecord($lname, $fname, $type, $isMonday, $isTuesday, $isWed, $isThurs, $isFriday);
		
		//header("Location: index.php");
		//die();
	}
	
	function retrieveRecords(){
		$sql = "SELECT * FROM attendance";
		$con = mysqli_connect($GLOBALS['server'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database_name']);
		$result = null;
		if(!$con){
			die ("Connetion failed!");
		}
		$result = mysqli_query($con, $sql);
		$con->close();
		return $result;
	}
	
	function insertRecord($lname, $fname, $type, $isMonday, $isTuesday, $isWed, $isThursday, $isFriday){
		//mysqli_report(MYSQLI_REPORT_ERROR, MYSQLI_REPORT_STRICT);
		mysqli_report(MYSQLI_REPORT_ALL);
		$sql = "INSERT INTO Attendance(lname, fname, regisType, isMonday, isTuesday, isWednesday, isThursday, isFriday)";
		$sql = $sql."VALUES ('".$lname."', '".$fname."','".$type."','".$isMonday."','".$isTuesday."','".$isWed."','".$isThursday."','".$isFriday."') ";
		$con = mysqli_connect($GLOBALS['server'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database_name']);
		if (!$con) {
			die ("Connetion failed!");
		}
		echo $sql;
		//mysqli_query($con, $sql);
		//mysqli_close($con);
	}
	
	function updateRecord($id, $lname, $fname, $type, $isMonday, $isTuesday, $isWed, $isThursday, $isFriday){
		$sql = "UPDATE Attendance SET lname=?, fname=?, ";
		$con = mysqli_connect($GLOBALS['server'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database_name']);
		if (!$con) {
			die ("Connetion failed!");
		}
		$stmt = $con->prepare($sql);
		$stmt->bind_param("sssiiiii", $lname, $fname, $type, $isMonday, $isTuesday, $isWed, $isThursday, $isFriday);
		$stmt->execute();
		$stmt->close();
		$con->close();
	}
?>
