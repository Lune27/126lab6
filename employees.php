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
    table, th, td {
        border: 1px solid silver;
    }
</style>
<body>
    <h1 style="color: darkgrey;"> This page will display the content of each table in the <i style = "color: gold;"> sample</i> database.</h1>
    <p style="color: grey;"> Typing tutorial 2.0 </p>
    <br>
    <h2 style = "color: silver;"> Department Table:</h2>
    <table style="width:100%">
        <tr>
            <th>Department ID</th>
            <th>Department Name</th>
            <th>Manager Name</th>
            <th>Budget</th>
            <th>City</th>
        </tr>
    <?php
        include 'department.php';
    ?>
    </table>

    <?php
        include 'dept_employee.php';
    ?>
    
</body>
</html>