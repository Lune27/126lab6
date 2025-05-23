<?php
include 'DBConnector.php';

$empID = null;
$employee = null;
$updateMessage = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['EmpID']) && is_numeric($_POST['EmpID']) && isset($_POST['submit'])) {
    $empID = $_POST['EmpID'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $salary = $_POST['salary'];
    $percent_time = $_POST['percent_time'];
    $HireDate = $_POST['date-hired'];
    $deptID = $_POST['department'];
    $designation = $_POST['designation'];

    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if ($age <= 0) {
        $errors[] = "Age must be positive.";
    }
    if ($salary < 0) {
        $errors[] = "Salary cannot be negative.";
    }
    if ($percent_time < 0 || $percent_time > 100) {
        $errors[] = "Percent Time must be between 0 and 100.";
    }
    if (empty($HireDate)) {
        $errors[] = "Hire Date is required.";
    }
    if ($deptID <= 0) {
        $errors[] = "Please select a department.";
    }

    if (empty($errors)) {
        $conn->begin_transaction();

        try {
            //update employee table
            $sql_employee = "UPDATE employee SET EmpName = '$name', Age = $age, Salary = $salary, HireDate = '$HireDate' WHERE EmpID = $empID";
            $conn->query($sql_employee);

            //update work table
            $sql_work = "UPDATE work SET DeptID = $deptID, Percent_Time = $percent_time WHERE EmpID = $empID";
            $conn->query($sql_work);

            //update department manager if designation is Manager
            if ($designation == 1) {
                $sql_dept = "UPDATE department SET MgrEmpID = $empID WHERE DeptID = $deptID";
                $conn->query($sql_dept);

            } else {
                $sql_dept = "UPDATE department SET MgrEmpID = NULL WHERE MgrEmpID = $empID AND DeptID = $deptID";
                $conn->query($sql_dept);
            }

            //commit transaction
            $conn->commit();

            header("Location: employees.php");
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            $errors[] = "Error updating employee: " . $e->getMessage();
        }
    }
}

//cancel button
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel'])) {
    header("Location: employees.php");
    exit();
}

//employee details
if (isset($_POST['EmpID']) && is_numeric($_POST['EmpID'])) {
    $empID = $_POST['EmpID'];

    //get employee details
    $sql_employee = "
        SELECT e.EmpID, e.EmpName, e.Age, e.Salary, e.HireDate, w.DeptID, w.Percent_Time, d.MgrEmpID
        FROM employee e
        JOIN work w ON e.EmpID = w.EmpID
        JOIN department d ON w.DeptID = d.DeptID
        WHERE e.EmpID = $empID";
    
        $result = $conn->query($sql_employee);

        if ($result->num_rows > 0) {
            $employee = $result->fetch_assoc();
        } else {
            echo "Employee not found.";
        }
} else {
    echo "Invalid employee ID.";
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html>
<style>
    body {
        font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
        background-image: url('background.png');
        background-repeat: no-repeat;
        background-size: cover;
        color: white;
    }
    td.tlabel {
        width: 90px;
        text-align: right;
        padding-right: 10px;
    }
    .expand {
        width: 170px;
    }
    .error {
        color: #FF6347;
        margin-bottom: 10px;
    }
</style>
<body>
    <h1>Edit Employee</h1>
    <br>
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo ($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="editEmployee.php" method="post">
        <input type="hidden" name="EmpID" value="<?php echo ($employee['EmpID']); ?>">
        <table style="width:100%">
            <tr>
                <td class="tlabel">Name</td>
                <td><input type="text" name="name" value="<?php echo ($employee['EmpName']); ?>" required></td>
            </tr>
            <tr>
                <td class="tlabel">Age</td>
                <td><input type="number" name="age" value="<?php echo ($employee['Age']); ?>" required></td>
            </tr>
            <tr>
                <td class="tlabel">Salary</td>
                <td><input type="number" step=".01" name="salary" value="<?php echo ($employee['Salary']); ?>" required></td>
            </tr>
            <tr>
                <td class="tlabel">Percent Time</td>
                <td><input type="number" name="percent_time" value="<?php echo ($employee['Percent_Time']); ?>" required></td>
            </tr>
            <tr>
                <td class="tlabel">Date Hired</td>
                <td><input class="expand" type="date" name="date-hired" value="<?php echo ($employee['HireDate']); ?>" required></td>
            </tr>
            <tr>
                <td class="tlabel">Department</td>
                <td>
                    <select class="expand" name="department" required>
                        <option value="" disabled>--Select Department--</option>
                        <?php
                        $sql = "SELECT DeptID, DeptName FROM department";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            $selected = ($row['DeptID'] == $employee['DeptID']) ? 'selected' : '';
                            echo "<option value='{$row['DeptID']}' $selected>" . ($row['DeptName']) . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tlabel">Designation</td>
                <td>
                    <input type="radio" name="designation" value="1" <?php echo ($employee['EmpID'] == $employee['MgrEmpID']) ? 'checked' : ''; ?>>Manager<br>
                    <input type="radio" name="designation" value="2" <?php echo ($employee['EmpID'] != $employee['MgrEmpID'] || $employee['MgrEmpID'] === null) ? 'checked' : ''; ?>>Employee<br>
                </td>
            </tr>
            <tr>
                <td class="tlabel"></td>
                <td>
                    <input type="submit" name="submit" value="Submit">
                    <button type="submit" name="cancel">Cancel</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>

<?php
$conn->close();
?>