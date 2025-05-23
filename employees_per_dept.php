<style>

.action-btn {
    width: 50px;
    height: 35px;
    margin: 5px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    transition: background-color 0.3s, transform 0.1s;
}

.delete-btn {
    background-color: #dc3545;
    color: white;
}

.edit-btn {
    background-color: #007bff;
    color: white;
}


td form {
    display: inline-block;
}
</style>

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
                    <th>Designations</th>
                    <th>Actions</th>
                </tr>";
            
        $emp_sql = "
            SELECT e.EmpID, e.EmpName, e.Age, e.Salary, e.HireDate, d.MgrEmpID
            FROM employee e
            JOIN work w ON e.EmpID = w.EmpID
            JOIN department d ON w.DeptID = d.DeptID
            WHERE w.DeptID = $deptID";
        $emp_result = $conn->query($emp_sql);

        if ($emp_result->num_rows > 0) {
            while ($row = $emp_result->fetch_assoc()) {
                echo "<tr>".
                    "<td align='center'>".$row['EmpID']."</td>".
                    "<td align='center'>".$row['EmpName']."</td>".
                    "<td align='center'>".$row['Age']."</td>".
                    "<td align='center'>".$row['Salary']."</td>".
                    "<td align='center'>".$row['HireDate']."</td>";
        
                if ($row["MgrEmpID"] == $row["EmpID"]) {
                    echo "<td align='center'>Manager</td>";
                } else {
                    echo "<td align='center'>Employee</td>";
                }
        
                echo "<td align='center'>".
                    "<form action='deleteEmployee.php' method='post'>".
                        "<input type='hidden' name='EmpID' value='".$row["EmpID"]."'>".
                        "<button type='submit' class='action-btn delete-btn' onclick='return confirmDelete()'>Delete</button>".
                    "</form>".
                    "<form action='editEmployee.php' method='post'>".
                        "<input type='hidden' name='EmpID' value='".$row["EmpID"]."'>".
                        "<button type='submit' class='action-btn edit-btn'>Edit</button>".
                    "</form>".
                "</td>".
                "</tr>";
            }
        } else {
            echo "<tr>".
                "<td align='center'>--</td>".
                "<td align='center'>--</td>".
                "<td align='center'>--</td>".
                "<td align='center'>--</td>".
                "<td align='center'>--</td>".
                "<td align='center'>--</td>".
                "</tr>";
        }
        echo "</table><br>";
     } }
 else {
    echo "<p>No departments found.</p>";
}
?>

<script>
function confirmDelete() {
    if (confirm("Are you sure you want to delete this employee?")) {
        return true;
    } else {
        return false;
    }
}
</script>
<?php
$conn->close();
?>