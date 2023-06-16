<?php
include "functions.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || !isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

include "connection.php";
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['save_excel_data'])) {

    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = array('xls', 'csv', 'xlsx');

    if (in_array($file_ext, $allowed_ext)) {

        $inputFileNamePAth = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePAth);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = "0";
        foreach ($data as $row) {
            if ($count > 0) {
                $s_no = $row['0'];
                $name = $row['1'];
                $phone_number = $row['2'];
                $email = $row['3'];
                $state = $row['4'];
                $gender = $row['5'];
                $age = $row['6'];
                $height = $row['7'];
                $weight = $row['8'];
                $looking_for = $row['9'];
                $attended_dc = $row['10'];
                $expected_dc = $row['11'];
                $attended_mhf = $row['12'];
                $expected_mhf = $row['13'];
                $current_status = $row['14'];
                $lead_date = $row['15'];
                $comment = $row['16'];
                $follow_up_date = $row['17'];
                $assigned_to = $row['18'];
                $caller_id = $row['19'];

                $mysqli = connect();

                $sql = "INSERT INTO `data` (`s_no`, `name`, `phone`, `email`, `state`, `gender`, `age`, `height`, `weight`, `looking_for`, `attended_dc`, `exp_date_dc`, `attended_mhf`, `exp_date_mhf`, `current_status`, `lead_date`, `comments`, `followup_date`, `assigned_to`,`id`) VALUES 
                                            (null ,'$name' ,'$phone_number' ,'$email' , '$state' ,'$gender' ,'$age' ,'$height' ,'$weight' ,'$looking_for' ,'$attended_dc' ,'$expected_dc' ,'$attended_mhf' ,'$expected_mhf' , '$current_status' ,'$lead_date' ,'$comment' ,'$follow_up_date' ,'$assigned_to','$caller_id')";


                $stmt = $mysqli->prepare($sql);

                $stmt->execute();

                $result = $stmt->get_result();

                $msg = true;
            } else {
                $count = "1";
            }
        }
        if (isset($msg)) {
            $_SESSION['message'] = 'Successfully Imported';
            header('location: import.php');
            exit(0);
        } else {
            $_SESSION['message'] = 'Not Imported';
            header('location: import.php');
            exit(0);
        }

    } else {
        $_SESSION['message'] = 'invalid file extension';
        header('location: import.php');
        exit(0);
    }
}
?>