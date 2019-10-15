<?php
	session_start();
	
	function retrieveRecords(){
		$sql = "SELECT * FROM attendance";
		$con = mysqli_connect("phpmyadmin.cslpamwvqkbt.ap-southeast-2.rds.amazonaws.com: 3306", "phpmyadmin", "phpmyadmin", "aws_attendance");
		$result = null;
		if(!$con){
			die ("Connetion failed!");
		}
		$result = mysqli_query($con, $sql);
		$con->close();
		return $result;
	}
	
	function insertRecords($lname, $fname, $type, $isMonday, $isTuesday, $isWed, $isThursday, $isFriday){
		$sql = "INSERT INTO Attendance VALUES(?,?,?,?,?,?,?,?,?)";
		$con = mysqli_connect("localhost: 3306", "root", "", "aws_attendance");
		if (!$con) {
			die ("Connetion failed!");
		}
		$stmt = $con->prepare($sql);
		$stmt->bind_param("sssiiiii", $lname, $fname, $type, $isMonday, $isTuesday, $isWed, $isThursday, $isFriday);
		$stmt->execute();
		$stmt->close();
		$con->close();
	}
	
	function printCheckBox($value){
		$checkHTML = "";
		if ($value == 1){
			$checkHTML = "<input type='checkbox' checked/>";
		} else {
			$checkHTML = "<input type='checkbox'/>";
		}
		return $checkHTML;
	}
?>

<html>
	<style>
		.formDiv{
			margin-right:auto;
			margin-left:auto;
			margin-bottom:20px;
			border: 0.5px solid gray;
			border-radius: 10px;
			width: 50%;
			height: 380px;
			padding: 20px;
		}
	</style>
	<head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</head>
	<body>
		<h1>This is a demo page hosted on <?php echo $_SERVER['REMOTE_ADDR'];  ?></h1>	
		<div class="formDiv">
			<form>
				<div class="form-group">
					<label for="firstName"> First Name </label>
					<input type="text" id="firstName" name="firstName" class="form-control"/>
				</div>
				<div class="form-group">
					<label for="lastName"> Last Name </label>
					<input type="text" id="lastName" name="lastName" class="form-control"/>
				</div>
				<div class="form-group">
					<label for="attType"> AttendeeType</label>
					<input type="text" id="attType" name="attType" class="form-control"/>
				</div>
				<div class="form-group">
					<div><label> Weekly Attendance:</label></div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" id="isMonday" name="isMonday" value=""/>
						<label class="form-check-label">Monday</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" id="isTuesday" name="isTuesday" value=""/>
						<label class="form-check-label">Tuesday</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" id="isWednesday" name="isWednesday" value=""/>
						<label class="form-check-label">Wednesday</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" id="isThursday" name="isThursday" value=""/>
						<label class="form-check-label">Thursday</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" id="isFriday" name="isFriday" value=""/>
						<label class="form-check-label">Friday</label>
					</div>
				</div>
			</form>
		</div>
		<div>
			<table class="table table-striped">
				<thead class="thead-dark">
					<td scope="col">ID</td>
					<td scope="col">Last Name</td>
					<td scope="col">First Name</td>
					<td scope="col">Attendee Type</td>
					<td scope="col">Monday</td>
					<td scope="col">Tuesday</td>
					<td scope="col">Wednesday</td>
					<td scope="col">Thursday</td>
					<td scope="col">Friday</td>
				</thead>
				<tbody>
					<?php
						$result = retrieveRecords();
						while($row = $result->fetch_assoc()){
							$id = $row["regisID"];
							$lname = $row["lname"];
							$fname = $row["fname"];
							$type = $row["regisType"];
							$isMonday = $row["isMonday"];
							$isTuesday = $row["isTuesday"];
							$isWed = $row["isWednesday"];
							$isThursday = $row["isThursday"];
							$isFriday = $row["isFriday"];
							
							echo '<tr>'.
								'<td>'.$id.'</td>'.
								'<td>'.$lname.'</td>'.
								'<td>'.$fname.'</td>'.
								'<td>'.$type.'</td>'.
								'<td>'.printCheckBox($isMonday).'</td>'.
								'<td>'.printCheckBox($isTuesday).'</td>'.
								'<td>'.printCheckBox($isWed).'</td>'.
								'<td>'.printCheckBox($isThursday).'</td>'.
								'<td>'.printCheckBox($isFriday).'</td>'.
							'</tr>';
						}
						$result->free();
					?>
				</tbody>	
			</table>
		</div>
	</body>
</html>
