<?php
include 'config.php';

$db = new Database();

$all_records = $db->select("SELECT * FROM `employees`");

if(isset($_POST['submit'])) {
    $employee_name = $_POST['employee_name'];
    $designation = $_POST['designation'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $salary = $_POST['salary'];
    $status = $_POST['status'];
    $resignation_date = (empty($_POST['resignation_date'])) ? '0000-00-00 00:00:00' : $_POST['resignation_date'];
    $password = $_POST['password'];

    $record_exist = $db->select("SELECT * FROM `employees` WHERE `email`='$email' LIMIT 1;");

    if ($record_exist) {
        $update_sql = "UPDATE `employees` SET `employee_name`='$employee_name',`designation`='$designation',`role`='$role',`email`='$email',`phone`='$phone',`salary`='$salary',`status`='$status',`resignation_date`='$resignation_date',`password`='$password' WHERE `email`='$email';";
        $db->update($update_sql);
    } else {
        $insert_sql = "INSERT INTO `employees`(`employee_name`, `designation`, `role`, `email`, `phone`, `salary`, `status`, `resignation_date`, `password`) VALUES ('$employee_name','$designation','$role','$email','$phone','$salary','$status','$resignation_date','$password');";
        $db->insert($insert_sql);
    }
}

// Edit
if(isset($_GET['action']) && $_GET['action'] == 'edit') {
    $email = $_GET['email'];
    $exist = $db->select("SELECT * FROM `employees` WHERE `email`='$email' LIMIT 1;");

    if ($exist->num_rows > 0) {
        $data = $exist->fetch_assoc();
        $edit_name = $data['employee_name'];
        $edit_designation = $data['designation'];
        $edit_role = $data['role'];
        $edit_email = $data['email'];
        $edit_phone = $data['phone'];
        $edit_salary = $data['salary'];
        $edit_status = $data['status'];
        $edit_resignation_date = $data['resignation_date'];
        $edit_password = $data['password'];
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee System</title>
    <script src="./index.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <div>
        <div class="container mt-5">
            <h2 style="margin-top: 100px;">Employee Information</h2>

            <form action="" method="POST">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-3">
                            Employee Name:<br>
                            <input type="text" name="employee_name" value="<?php echo $edit_name; ?>" />
                        </div>
                        <div class="col-lg-3">
                            Designation:<br>
                            <input type="text" name="designation" value="<?php echo $edit_designation; ?>" />
                        </div>
                        <div class="col-lg-2">
                            Role:<br>
                            <select name="role" id="role" value="<?php echo $edit_role; ?>">
                                <option <?php echo ($edit_role == "1" ? 'selected': ''); ?> value="1">Admin</option>
                                <option <?php echo ($edit_role == "2" ? 'selected': ''); ?> value="2">Dev</option>
                                <option <?php echo ($edit_role == "3" ? 'selected': ''); ?> value="3">User</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Email:<br>
                            <input type="email" name="email" value="<?php echo $edit_email; ?>" />
                        </div>
                        <div class="col-lg-2">
                            Phone:<br>
                            <input type="text" name="phone" value="<?php echo $edit_phone; ?>" />
                        </div>

                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-3">
                            Salary:<br>
                            <input type="text" name="salary" value="<?php echo $edit_salary; ?>" />
                        </div>
                        <div class="col-lg-3">
                            Status:<br>
                            <input type="radio" id="not-resigned" name="status" onclick="checkStatus(this);" value="0" checked <?php echo ($edit_status == "0" ? 'checked="checked"': ''); ?>/>Not Resigned
                            <input type="radio" id="resigned" name="status" onclick="checkStatus(this);" value="1" <?php echo ($edit_status == "1" ? 'checked="checked"': ''); ?> />Resigned
                        </div>
                        <div class="col-lg-3">
                            Resignation Date:<br>
                            <input type="datetime-local" id="resignation_date" name="resignation_date" disabled />
                        </div>
                        <div class="col-lg-3">
                            Password:<br>
                            <input type="password" id="password" name="password" value="<?php echo $edit_password; ?>" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <input type="submit" name="submit" value="submit">
                    </div>

                </fieldset>
            </form>

        </div>

        <div class="container mt-5">
            <h2>Employees</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Salary</th>
                        <th>Status</th>
                        <th>Resignation Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        if ($all_records) {
                            while ($row = $all_records->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $row['employee_id']; ?></td>
                                    <td><?php echo $row['employee_name']; ?></td>
                                    <td><?php echo $row['designation']; ?></td>
                                    <td><?php echo $row['role']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['salary']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td><?php echo $row['resignation_date']; ?></td>
                                    <td><a class="btn btn-info" href="index.php?action=edit&email=<?php echo $row['email']; ?>">Edit</a>&nbsp;<button id="<?php echo $row['email'] ?>" onclick="deleteRecordAlert(this)" class="btn btn-danger">Delete</button></td>
                                </tr>
                        <?php   }
                        }
                    ?>

                </tbody>
            </table>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script>

        deleteRecordAlert = (e) => {

            if (confirm('Are you sure?')) {
                $.ajax({
                    url: 'delete.php',
                    type: 'POST',
                    data: {emailId: e.id},
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = "index.php";
                    },
                    error: function() {
                        alert('Something is wrong');
                    }
                });
            }
        }

    </script>
</body>

</html>