<?php
	//Declare DB connection properties
	/*$server = "localhost: 3306";
	$username = "root";
	$password = "";
	$database_name = "aws_attendance";
	*/
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
		
		header("Location: index.php");
		die();
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
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$sql = "INSERT INTO attendance(lname, fname, regisType, isMonday, isTuesday, isWednesday, isThursday, isFriday) VALUES(?,?,?,?,?,?,?,?)";
		$con = mysqli_connect($GLOBALS['server'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database_name']);
		if (!$con) {
			die ("Connetion failed!");
		}
		echo "test1";
		$stmt = $con->prepare($sql);
		echo "test2";
		$stmt->bind_param("sssiiiii", $lname, $fname, $type, $isMonday, $isTuesday, $isWed, $isThursday, $isFriday);
		echo "test3";
		$stmt->execute();
		echo "test4";
		$stmt->close();
		echo "test5";
		$con->close();
	}
	
	function updateRecord($id, $lname, $fname, $type, $isMonday, $isTuesday, $isWed, $isThursday, $isFriday){
		$sql = "UPDATE attendance SET lname=?, fname=?, ";
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