<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'DB.php');

class UserModel
{

    /**
     * Get user by username.
     */
    public function getByUsername($username)
    {
        $db = DB::connect();
        $sql = "SELECT * from users WHERE username=:username";
        $query = $db->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchObject();
        return $results;
    }

    /**
     * User Login.
     */
    public function login($data){
        $db = DB::connect();
        $status = 1;
        $email = $_POST['username'];
        $password = md5($_POST['password']);
        $sql = "SELECT username,password FROM users WHERE username=:username and password=:password and status=:status";
        $query = $db->prepare($sql);
        $query->bindParam(':username', $data['username'], PDO::PARAM_STR);
        $query->bindParam(':password', $data['password'], PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            session_start();
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $_POST['username'];
            echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
        } else {
            echo "<script>alert('Invalid Details Or Account Not Confirmed');</script>";

        }
    }

    /**
     * User register function.
     */
    public function register($data)
    {
        $db = DB::connect();
        // First we need to verify that the provided email is not taken.
        $verify_input = $this->checkUsersByNameEmail($data['email'], $data['username']);

        if ($verify_input == '') {
            // Insert records into table.
            $role = array_key_exists('role', $data) ? $data['role'] : 'employee';
            $sql = "INSERT INTO users(username, email, password, role, status) VALUES(:name, :email, :password, :role, 1)";
            $query = $db->prepare($sql);
            $query->bindParam(':name', $data['username'], PDO::PARAM_STR);
            $query->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $query->bindParam(':password', $data['password'], PDO::PARAM_STR);
            $query->bindParam(':role', $role, PDO::PARAM_STR);
            $query->execute();
            // Get results to verify it was registered successfully.
            $result = $this->getByUsername($data['username']);
            if ($result) {
                echo "<script type='text/javascript'>alert('Registration Sucessfull!');</script>";
            } else {
                echo "<script type='text/javascript'>alert('There was some error inserting the data!!!!!');</script>";
            }
        }

    }

    public function checkUsersByNameEmail($email, $username)
    {
        $db = DB::connect();
        $check_email = $db->query('SELECT * FROM users WHERE email=\'' . $email . '\'');
        $email_result = $check_email->fetchObject();
        if ($email_result) {
            echo "<script type='text/javascript'>alert('Email is already taken!!!');</script>";
        }
        // Check if username is already taken.
        $check_username = $db->query('SELECT * FROM users WHERE username=\'' . $username . '\'');
        $username_result = $check_username->fetchObject();
        if ($username_result) {
            echo "<script type='text/javascript'>alert('Username is already taken!!!');</script>";
        }
        if ($email_result || $username_result) {
            return 'Email or username is already taken.';
        } else {
            return '';
        }
    }


}