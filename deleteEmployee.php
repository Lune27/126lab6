<?php
include 'DBConnector.php';

// Check for valid EmpID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['EmpID']) && is_numeric($_POST['EmpID'])) {
    $empID = $_POST['EmpID'];
    $conn->begin_transaction();

    //remove manager designation
    $sql_clear_manager = "UPDATE department SET MgrEmpID = NULL WHERE MgrEmpID = $empID";
    $conn->query($sql_clear_manager);

    //remove from work table
    $sql_work = "DELETE FROM work WHERE EmpID = $empID";
    $conn->query($sql_work);

    //remove from employee table
    $sql_employee = "DELETE FROM employee WHERE EmpID = $empID";
    if ($conn->query($sql_employee) === TRUE) {
        $conn->commit();
        header("Location: employees.php");
        exit();
    } else {
        throw new Exception("Employee not deleted.");
    }
} else {
    echo "Invalid employee ID.";
}

$conn->close();
?>