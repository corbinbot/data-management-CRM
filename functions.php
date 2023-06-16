<?php
require "config.php";

function connect()
{
    $mysqli = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);

    if ($mysqli->connect_errno != 0) {

        $error = $mysqli->connect_error;

        $error_date = date('Y-m-d H:i:s');

        $message = "{$error} | {$error_date} \r\n";

        file_put_contents('db-log.txt', $message, FILE_APPEND);

        return false;

    } else {

        return $mysqli;

    }
}





function registerUser($email, $username, $password, $confirm_password)
{

    $mysqli = connect();

    $args = func_get_args();

    $args = array_map(function ($value) {

        return trim($value);

    }, $args);

    foreach ($args as $value) {

        if (empty($value)) {

            return "All Fields are required";

        }

    }

    foreach ($args as $value) {

        if (preg_match("/([<|>])/", $value)) {

            return "<> Characters are not allowed";

        }

    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        return "Email is not valid";

    }

    $sql = "SELECT email FROM user where email = ?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param('s', $email);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    if ($data != NULL) {

        return "email already exists Please use different email";

    }

    if (strlen($username) > 50) {

        return "Username is too long";

    }

    $stmt = $mysqli->prepare("SELECT username FROM user WHERE username = ?");

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    if ($data != null) {
        return "Username already exists.";
    }

    if (strlen($password) > 50) {

        return "Password is too long";

    }

    if ($password != $confirm_password) {

        return "Passwords do not match";

    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO user(username, password, email) VALUES(?,?,?)");

    $stmt->bind_param("sss", $username, $hashed_password, $email);

    $stmt->execute();

    if ($stmt->affected_rows != 1) {

        return "An error occurred,Please try again";

    } else {

        return "success";

    }

}






function login($username, $password)
{

    $mysqli = connect();

    $username = trim($username);

    $password = trim($password);

    if ($username == "" || $password == "") {

        return "Both fields are required";

    }

    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    $sql = "SELECT username, password FROM user WHERE username=?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    if ($data == null) {

        return "wrong username or password";

    }

    if (
        $password != $data['password']
    ) {

        return "Wrong username or password";

    } else {

        $_SESSION['user_id'] = $data['s_no'];
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: data.php');

    }

}






function logout()
{

    session_destroy();

    header("location:login.php");

    exit();

}



?>