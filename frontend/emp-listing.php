<?php
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../api/shared/EmployeeModel.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../api/shared/UserModel.php');
session_start();
if ($_SESSION["loggedin"] == 'true') {
    $user_model = new UserModel();
    $username = $_SESSION['username'];
    $current_user = $user_model->getByUsername($username);
    $is_admin = FALSE;
    if ($current_user->role == 'admin') {
        $is_admin = TRUE;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Listing</title>
</head>
<body>
<h1>Employee Listing</h1>
<table>
    <thead>
    <tr>
        <td>Username</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Date of Birth</td>
        <td>Phone Number</td>
        <td>Office Number</td>
        <td>Employee Category</td>
        <td>Operation</td>
    </tr>
    </thead>
    <tbody>
    <?php
    $employee_model = new EmployeeModel();
    $employee_listing = $employee_model->getEmployeeListing();
    if (!empty($employee_listing)) {
        $result = '';
        foreach ($employee_listing as $key => $emp_data) {
          $result .= '<tr>
           <td>'.$emp_data['username'].'</td>
           <td>'.$emp_data['first_name'].'</td>
           <td>'.$emp_data['last_name'].'</td>
           <td>'.$emp_data['dob'].'</td>
           <td>'.$emp_data['phone'].'</td>
           <td>'.$emp_data['office_number'].'</td>
           <td>'.$emp_data['emp_category'].'</td>
           <td><a target="_blank" href="emp-profile.php?username='.$emp_data['username'].'">Edit</a></td>
          </tr>';
        }
        print $result;
    }
    else {
        echo "No data found";
    }

    ?>

    </tbody>
</table>
</body>
</html>

