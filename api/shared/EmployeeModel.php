<?php

require_once( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'DB.php');

class EmployeeModel {

    /**
     * Get employee by id
     */
    public function getByUsername($username) {
        $db = DB::connect();
        $sql = "SELECT * from employees WHERE username=:username";
        $query = $db->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchObject();
        return $results;
    }

    /**
     * Get employee listing
     */
    public function getEmployeeListing() {
        $db = DB::connect();
        $sql = "SELECT * from employees";
        $query = $db->prepare($sql);
        $query->execute();
        $results = $query->fetchAll();
        return $results;
    }

    /**
     * Update employee profile.
     */
    public function profileUpdate($data) {
        $db = DB::connect();
        // First check if the employee data already exists.
        $record_exists = $this->getByUsername($data['username']);
        if ($record_exists != NULL) {
            // Update records.
            $sql="UPDATE employees SET username=(:username), first_name=(:first_name), last_name=(:last_name), dob=(:dob), phone=(:phone), office_number=(:office_number), emp_category=(:emp_category) WHERE username=(:username)";
        }
        else {
            // Insert records into table.
            $sql = "INSERT INTO employees(username, first_name, last_name, dob, phone, office_number, emp_category) VALUES(:username, :first_name, :last_name, :dob, :phone, :office_number,  :emp_category)";
        }

        $query = $db->prepare($sql);
        $query->bindParam(':username', $data['username'], PDO::PARAM_STR);
        $query->bindParam(':first_name', $data['fname'], PDO::PARAM_STR);
        $query->bindParam(':last_name', $data['lname'], PDO::PARAM_STR);
        $query->bindParam(':dob', $data['dob']);
        $query->bindParam(':phone', $data['phone']);
        $query->bindParam(':office_number', $data['office_number']);
        $query->bindParam(':emp_category', $data['emp_category'], PDO::PARAM_STR);
        $query->execute();
        $verify_data = $this->getByUsername($data['username']);

        if (isset($verify_data)) {
            echo "<script type='text/javascript'>alert('Profile updated sucessfully!');</script>";
            echo "<script type='text/javascript'> document.location = '../frontend/dashboard.php'; </script>";
        } else {
            echo "<script type='text/javascript'>alert('There was some error inserting the data!!!!!');</script>";
        }
    }

}