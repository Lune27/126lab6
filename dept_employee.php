<?php
include 'DBConnector.php';

$sql = "SELECT DeptID, DeptName FROM department";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $deptID = $row['DeptID'];
        $deptName = $row['DeptName'];

        echo "<h2 style='color: silver;'>$deptName</h2>";
        echo "<table style='width:100%'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Salary</th>
                    <th>Hire Date</th>
                </tr>";

        $emp_sql = "
            SELECT e.EmpID, e.EmpName, e.Age, e.Salary, e.HireDate
            FROM employee e
            JOIN work w ON e.EmpID = w.EmpID
            WHERE w.DeptID = ?";
        $stmt = $conn->prepare($emp_sql);
        $stmt->bind_param("i", $deptID);
        $stmt->execute();
        $emp_result = $stmt->get_result();

        if ($emp_result->num_rows > 0) {
            while ($row = $emp_result->fetch_assoc()) {
                echo "<tr>".
                    "<td align='center'>".$row['EmpID']."</td>".
                    "<td align='center'>".$row['EmpName']."</td>".
                    "<td align='center'>".$row['Age']."</td>".
                    "<td align='center'>".$row['Salary']."</td>".
                    "<td align='center'>".$row['HireDate']."</td>".
                    "</tr>";
            }
        } else {
            echo "<tr>".
                "<td align='center'>--</td>".
                "<td align='center'>--</td>".
                "<td align='center'>--</td>".
                "<td align='center'>--</td>".
                "<td align='center'>--</td>".
                "</tr>";
        }
        echo "</table><br>";
        $stmt->close();
    }
} else {
    echo "<p>No departments found.</p>";
}

$conn->close();
?>