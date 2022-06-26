<?php
include "config.php";

date_default_timezone_set("Asia/Dhaka");
$date = date('Y-m-d');

$sql_emp = "SELECT * FROM attendance a JOIN employees e ON a.employee_id=e.employee_id WHERE date='$date';";
$emp_res = $db->conn->query($sql_emp);

if ($emp_res->num_rows == 0) {
    $absent_emp = $db->getEmployees();
} else {
    $absent_emp = $db->conn->query("SELECT * FROM employees e WHERE e.employee_id NOT IN (SELECT employee_id FROM attendance WHERE date='$date');");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <script type="text/javascript" src="index.js"></script>
</head>

<body>
    <?php
    include "navbar.php";
    ?>
    <div>
        <div class="container" style="margin-top: 100px;">
            <h2>Employees</h2>
            <table id="presentTable" class="table table-bordered">
                <?php if (mysqli_num_rows($emp_res) > 0) { ?>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Working Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                <?php } ?>
                <tbody>
                    <?php
                    if ($emp_res->num_rows > 0) {
                        $i = 0;
                        while ($row = $emp_res->fetch_assoc()) {
                    ?>
                            <tr>
                                <td class="id-value"><?php echo $row['employee_id']; ?></td>
                                <td class="name-value"><?php echo $row['employee_name']; ?></td>
                                <td class="date-value"><input type="date" id="current-date" name="current-date" value="<?php echo $date; ?>" /></td>
                                <td class="status-value">
                                    <input id="<?php echo "present" . $i ?>" type="radio" name="<?php echo "present-group" . $i; ?>" value="1" <?php echo ($row['working_status'] == "1" ? 'checked="checked"': ''); ?> />Present
                                    <input id="<?php echo "absent" . $i ?>" type="radio" name="<?php echo "present-group" . $i; ?>" value="0" <?php echo ($row['working_status'] == "0" ? 'checked="checked"': ''); ?> />Absent
                                </td>
                                <td class="button-value"><button onclick="saveSingleData(this)" class="btn btn-info">Save</button></td>
                            </tr>
                    <?php $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>
            <table id="absentTable" class="table table-bordered">
                <?php if (mysqli_num_rows($emp_res) == 0) { ?>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Working Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                <?php } ?>

                <tbody>
                    <?php
                    if (mysqli_num_rows($absent_emp) > 0) {
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($absent_emp)) {
                    ?>
                            <tr>
                                <td class="id-value"><?php echo $row['employee_id']; ?></td>
                                <td class="name-value"><?php echo $row['employee_name']; ?></td>
                                <td class="date-value"><input type="date" id="current-date" name="current-date" value="<?php echo $date; ?>" /></td>
                                <td class="status-value">
                                    <input type="radio" name="<?php echo "absent-group" . $i; ?>" onclick="" value="1" />Present
                                    <input type="radio" name="<?php echo "absent-group" . $i; ?>" onclick="" value="0" checked="checked" />Absent
                                </td>
                                <td class="button-value"><button onclick="saveSingleData(this)" class="btn btn-info">Save</button></td>
                            </tr>
                    <?php $i++;
                        }
                    }
                    ?>
                </tbody>

            </table>

            <button onclick="saveAllData()" class="btn btn-danger" type="submit" name="saveall" value="submit">Save</button>

        </div>

    </div>
</body>

</html>