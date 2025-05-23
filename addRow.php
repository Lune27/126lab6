<?php
include 'DBConnector.php';

$sql = "INSERT INTO `employee` (`EmpID`, `EmpName`, `Age`, `Salary`, `HireDate`) VALUES (NULL, 'John Doe', '50', '40000.75', '2012-10-01');";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "New record created successfully. Last inserted ID is: " . $last_id . "<br />";

    echo "Retrieving data of employee with ID". $last_id. "... <br/>";
    $query = "SELECT * FROM `employee` WHERE `EmpID` = '$last_id';";
    $result = $conn->query($query);
    echo "<pre />";
    print_r($result->fetch_assoc());

} else {
    echo "Error: ".$sql."<br>".$conn->error;
}

$conn->close();
?>