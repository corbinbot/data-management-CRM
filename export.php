<?php
include "functions.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || !isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

?>
<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

if (isset($_POST['export_excel_btn'])) {

    $mysqli = connect();
    $file_ext_name = $_POST['export_file_type'];
    $fileName = "Data-management";
    $username = $_SESSION["username"];
    $sql = "SELECT * FROM data WHERE assigned_to = '$username'";
    $stmt = $mysqli->prepare($sql);

    $stmt->execute();

    $result = $stmt->get_result();

    $num = $stmt->affected_rows;

    if ($num > 0) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'S_No');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Phone');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'state');
        $sheet->setCellValue('F1', 'Gender');
        $sheet->setCellValue('G1', 'Age');
        $sheet->setCellValue('H1', 'Height');
        $sheet->setCellValue('I1', 'Weight');
        $sheet->setCellValue('J1', 'Looking For');
        $sheet->setCellValue('K1', 'Attended Demo Club');
        $sheet->setCellValue('L1', 'Expected Date Demo club');
        $sheet->setCellValue('M1', 'Attended MHF');
        $sheet->setCellValue('N1', 'Expected Date MHF');
        $sheet->setCellValue('O1', 'Current Status');
        $sheet->setCellValue('P1', 'Lead Date');
        $sheet->setCellValue('Q1', 'Comments');
        $sheet->setCellValue('R1', 'Follow Up Date');
        $sheet->setCellValue('S1', 'Assigned To');

        $rowCount = 2;
        $i = 1;
        foreach ($result as $data) {
            $sheet->setCellValue('A' . $rowCount, $i);
            $sheet->setCellValue('B' . $rowCount, $data['name']);
            $sheet->setCellValue('C' . $rowCount, $data['phone']);
            $sheet->setCellValue('D' . $rowCount, $data['email']);
            $sheet->setCellValue('E' . $rowCount, $data['state']);
            $sheet->setCellValue('F' . $rowCount, $data['gender']);
            $sheet->setCellValue('G' . $rowCount, $data['age']);
            $sheet->setCellValue('H' . $rowCount, $data['height']);
            $sheet->setCellValue('I' . $rowCount, $data['weight']);
            $sheet->setCellValue('J' . $rowCount, $data['looking_for']);
            $sheet->setCellValue('K' . $rowCount, $data['attended_dc']);
            $sheet->setCellValue('L' . $rowCount, $data['exp_date_dc']);
            $sheet->setCellValue('M' . $rowCount, $data['attended_mhf']);
            $sheet->setCellValue('N' . $rowCount, $data['exp_date_mhf']);
            $sheet->setCellValue('O' . $rowCount, $data['current_status']);
            $sheet->setCellValue('P' . $rowCount, $data['lead_date']);
            $sheet->setCellValue('Q' . $rowCount, $data['comments']);
            $sheet->setCellValue('R' . $rowCount, $data['followup_date']);
            $sheet->setCellValue('S' . $rowCount, $data['assigned_to']);
            $rowCount++;
            $i++;
        }

        if ($file_ext_name == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
            $final_filename = $fileName . '.xlsx';
        } elseif ($file_ext_name == 'xls') {
            $writer = new Xls($spreadsheet);
            $final_filename = $fileName . '.xls';
        } elseif ($file_ext_name == 'csv') {
            $writer = new Csv($spreadsheet);
            $final_filename = $fileName . '.csv';
        }

        // $writer->save($final_filename);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attactment; filename="' . urlencode($final_filename) . '"');
        $writer->save('php://output');

    } else {
        $_SESSION['message'] = "No Record Found";
        header('Location: data.php');
        exit(0);
    }
}

?>