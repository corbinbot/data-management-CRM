<?php
require 'functions.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $mysqli = connect();

    $s_no = $_GET['s_no'];

    $sql = "DELETE from data WHERE s_no = '$s_no'";

    $stmt = $mysqli->prepare($sql);

    $stmt->execute();

    // $result = $stmt->get_result();

    $num = $stmt->affected_rows;

    if ($num == 1) {
        header('location:data.php');
    } else {
        echo "<script>
alert('Error')
</script>";
    }
} else {
    echo "<script>
alert('connection Error')
</script>";
}


?>