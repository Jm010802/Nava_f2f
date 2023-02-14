<!DOCTYPE html>
<html>

<head> </head>

	<body>
	<form name= "employee" method ="POST"> <!--method = request , post =encrypted ung data na papasok-->
	<table cellpadding="5" cellspacing="3" align="center">

	<tr>
		<td>Employee ID:</td>
		<td><input type="text" name="empID" maxlength="20" placeholder = "Enter Employee ID:"></td>
	</tr>

	<tr>
		<td>Employee Name:</td>
		<td><input type="text" name="empName" maxlength="20" placeholder="Enter Employee Name:"></td>
	</tr>

	<tr>
		<td>Employee Salary:</td>
		<td><input type="text" name="empSalary" maxlength="20" placeholder="Enter Employee Salary:"></td>
	</tr>

	</table>
	<center>
	<input type = "submit" name="insertSub" value ="INSERT" onclick ="insertFunc()">
	<input type = "submit" name="deleteSub" value ="DELETE" onclick ="deleteFunc()">
	<input type = "submit" name="insertSub" value ="UPDATE" onclick ="updateFunc()">
	<input type = "submit" name="viewSub" value ="VIEW">
	<input type = "submit" name="searchSub" value ="SEARCH">
	</form>


	<form class= "form-horizoontal" action="" method="post" name="uploadCsv" enctype="multipart/form-data">

	 
	 

	<div>
	<label> Choose CSV File </label>
	<input type = "file" name="file" accept= ".csv">
	<button type="submit" name="import">Import</button>
	</div>

	</center>
	</form>


	

<?php
$DBHost = "localhost"; //hostname
$DBUser = "root"; //username
$DBPass= "Jmnicolas08"; //password
$DBName= "db_employee"; //database name

$conn = mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);
//my sql connection string

if(!$conn){
die("Connection failed: " . mysqli_error()); //check connection
}


//to insert
if(isset($_POST['insertSub'])!=''){
// update all column
$sql = "INSERT into tbl_employee (emp_ID, emp_Name, emp_Salary) values
('$_POST[empID]','$_POST[empName]','$_POST[empSalary]')";
$result = mysqli_query($conn,$sql);
echo "<br>Record Updated";
}


if(isset($_POST['deleteSub'])!=''){
// delete specific row
if($_POST['empID']==""){
//validate
}else{
$sql = "DELETE from tbl_employee WHERE emp_ID='$_POST[empID]'";
$result = mysqli_query($conn,$sql);
if($result){
echo "<br>Record Deleted";
}else{
die ("Record can not find in the database". mysqli_error());
}
}}

//UPDATE
if(isset($_POST['updateSub'])!=''){
// update specific column
if($_POST['empID']=="" && $_POST['empSalary']==""){
//validate
}else{
$sql = "UPDATE employee SET `emp_Salary`='$_POST[empSalary]' WHERE
`emp_ID`='$_POST[empID]'";
$result = mysqli_query($conn,$sql);
echo "<br>Record Updated";
}
}


//DELETE
if(isset($_POST['deleteSub'])!=''){
// delete specific row
if($_POST['empID']==""){
//validate
}else{
$sql = "DELETE from employee WHERE `emp_ID`='$_POST[empID]'";
$result = mysqli_query($conn,$sql);
if($result){
echo "<br>Record Deleted";
}else{
die ("Record can not find in the database". mysqli_error());
}}}

//view
if(isset($_POST['viewSub'])!=''){
// delete specific row
echo "<center>";
$sql = "SELECT * from tbl_employee";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0 ){
echo "<table border = 3>" . "<th>Employee ID</th> <th>Employee Name</th>
<th>Employee Salary</th>";
while($rows = mysqli_fetch_assoc($result)){
echo "
<tr>
<td>" . $rows['emp_ID'] ." </td>
<td> ". $rows['emp_Name'] ."</td>
<td> ". $rows['emp_Salary'] . "</td>
</tr>";
}
echo "</table>";
}
if($result){
echo "<br>Record View";
}else{
die ("Record can not find in the database". mysqli_error());
}
echo "</center>";
}

//SEARCH
if(isset($_POST['searchSub'])!=''){
// search data
if($_POST['empName']==""){
//validate empty field
echo "Fill Employee Name field you want to search.";
}else{
//if(preg_match("/^d{5}/", $_POST['empID'])){
if(preg_match("/[A-Z | a-z]+/", $_POST['empName'])){
$empname = $_POST['empName'];
//$empid = $_POST['empID'];
//$sql = "SELECT `emp_ID`, `emp_name`, `emp_Salary` FROM employee WHERE
//`Firstname` LIKE '%". $empname . "%' OR `Lastname` LIKE '%" . $empname ."%'";
//$sql = "SELECT * FROM employee WHERE `emp_ID`=" . $empid ;
$sql = "SELECT `emp_ID`, `emp_Name`, `emp_Salary` FROM tbl_employee WHERE
`emp_Name` LIKE '%". $empname ."%'";
$result = mysqli_query($conn,$sql);

echo "<table align=center border=1 cellspacing=3 cellpadding=5>";
echo "<th>Employee ID</th><th>Employee Name</th><th>Employee Salary</th>";
while($row = mysqli_fetch_assoc($result)){
$empid_ = $row["emp_ID"];
$empname_ = $row["emp_Name"];
$empsalary_ = $row["emp_Salary"];
echo "

<tr>
<td>" . $empid_ ." </td>
<td> ". $empname_ ."</td>
<td> ". $empsalary_ . "</td>
</tr>";
}
echo "</table>";
}
echo "Record Searched";
}
}

if(isset($_POST['import'])){
	echo $fileName = $_FILES ["file"]["tmp_name"]; 
	
		if ($_FILES["file"]["size"] > null){
			
			$file = fopen($filename, "r");

			while(($column = fgetcsv($file, 10000, ",")) !== FALSE) {

				$sqlInsert = "INSERT into tbl_employee (`emp_ID`,`emp_Name`,`emp_Salary`) VALUES ('$column[0]','$column[1]','$column[2]')";

				$result = mysqli_query($conn, $sqlInsert);
				if (!empty($result)){
					echo "CSV Data Imported into the database";
				}
				else{
					echo "Problem in importing csv";
			}
		}
	}
}
?>
</body>
</html>