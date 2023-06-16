<?php
require "functions.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || !isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
?>

<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="css/homestyle.css">
    </head>

    <body>
        <?php
        include 'navbar.php';
        ?>
        <div class="">
            <form class="search" action="data.php" method="post">
                <input type="text" id="search" name="search"
                    style="margin: 10px 20px;padding:10px;border-radius:10px;width:100%">
                <div class="input-group date_search" id="date_search"
                    style="padding:10px;border-radius:10px;width:100%;align-items: center;">
                    <span style="margin:5px">From :</span>
                    <input type="date" name="from" id="date1" class="form-select" />
                    <span style="margin:5px">To :</span>
                    <input type="date" name="to" id="date2" onInput={search} class="form-select" />

                </div>
                <select onclick="date()" name="select" class="form-select" style="width:65%;margin: 10px;"
                    aria-label="Default select example" style="margin: 10px;padding:10px;" id="searchselect">
                    <option value="looking_for">Looking For</option>
                    <option value="attended_dc">Attended Demo Club</option>
                    <option value="attended_mhf">Attended Mission Healthy Family</option>
                    <option value="current_status">Current Status</option>
                    <option value="exp_date_dc">Expected Date Demo club</option>
                </select>
                <button type="submit" class="btn btn-outline-light"
                    style="margin: 10px;padding:6px 40px;font-weight:700">Search</button>
            </form>
        </div>

        <div class="container1">
            <?php

            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $mysqli = connect();
                $sql = "SELECT * from data WHERE assigned_to=?";
                $stmt = $mysqli->prepare($sql);

                $stmt->bind_param('s', $_SESSION['username']);
                $stmt->execute();

                $result = $stmt->get_result();

                $num = $stmt->affected_rows;




                if ($num > 0) {
                    ?>
            <table id='table' class='table table-hover  table-light table-bordered border-primary my-4'>
                <thead class='table-info'>
                    <tr>
                        <th scope='col'>S_No</th>
                        <th scope='col'>Name</th>
                        <th scope='col'>Phone Number</th>
                        <th scope='col'>Email</th>
                        <th scope='col'>State</th>
                        <th scope='col'>Gender</th>
                        <th scope='col'>Age</th>
                        <th scope='col'>Height</th>
                        <th scope='col'>Weight</th>
                        <th scope='col'>Looking For</th>
                        <th scope='col'>Attended Demo Club</th>
                        <th scope='col'>Expected Date Demo club</th>
                        <th scope='col'>Attended MHF</th>
                        <th scope='col'>Expected Date MHF</th>
                        <th scope='col'>Current Status</th>
                        <th scope='col'>Lead Date</th>
                        <th scope='col'>Comments</th>
                        <th scope='col'>Follow Up Date</th>

                        <th scope='col'>Assigned To</th>
                        <?php



                                echo "<th scope='col'></th>";
                                echo "</tr>";
                                echo "</thead>";
                                $i = 0;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                    <tr>
                        <th scope='row'><?php echo $i + 1 ?></th>
                        <td colspan='1'><?php echo $row['name'] ?></td>
                        <td><?php echo $row['phone'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['state'] ?></td>
                        <td><?php echo $row['gender'] ?></td>
                        <td><?php echo $row['age'] ?></td>
                        <td><?php echo $row['height'] ?></td>
                        <td><?php echo $row['weight'] ?></td>
                        <td><?php echo $row['looking_for'] ?></td>
                        <td><?php echo $row['attended_dc'] ?></td>
                        <td><?php echo $row['exp_date_dc'] ?></td>
                        <td><?php echo $row['attended_mhf'] ?></td>
                        <td><?php echo $row['exp_date_mhf'] ?></td>
                        <td><?php echo $row['current_status'] ?></td>
                        <td><?php echo $row['lead_date'] ?></td>
                        <td><?php echo $row['comments'] ?></td>
                        <td><?php echo $row['followup_date'] ?></td>

                        <td><?php echo $row['assigned_to'] ?></td>

                        <td>
                            <div class="dropdown">



                                <form action="update.php" method="get"><input style="display:none" name="s_no"
                                        value="<?php echo $row["s_no"] ?>"><button class="btn btn-outline-dark"
                                        type="submit">Update</button></form>




                            </div>
                        </td>

                        <?php
                                    $i++;
                                }
                                echo "</table>";
                                ?>
                        <form action="export.php" method="POST" style="display:flex;margin:35px 0">
                            <select name="export_file_type" class="form-control" style="width:25%">
                                <option value="xlsx">XLSX</option>
                                <option value="xls">XLS</option>
                                <option value="csv">CSV</option>
                            </select>
                            <button type="submit" name="export_excel_btn" class="btn  btn-outline-light"
                                style="padding:10px 40px;font-weight:700;margin-left:10px">Export</button>
                        </form><?php
                } else {
                    echo "No Data Found";
                }
            }
            if
            ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $mysqli = connect();
                $search = $_POST['search'];
                $select = $_POST['select'];
                $from = $_POST['from'];
                $to = $_POST['to'];
                if (
                    $from != "" && $to != ""
                ) {



                    $sql = "SELECT * from data where $select >= '{$from}%' AND $select <= '{$to}%' AND assigned_to=?";

                    $stmt = $mysqli->prepare($sql);

                    $stmt->bind_param('s', $_SESSION['username']);


                    $stmt->execute();

                    $result = $stmt->get_result();

                    $num = $stmt->affected_rows;

                } elseif

                ($search != "" && $select != "") {


                    $sql = "SELECT * FROM data WHERE $select LIKE '{$search}%'  AND assigned_to=?";

                    $stmt = $mysqli->prepare($sql);

                    $stmt->bind_param('s', $_SESSION['username']);

                    $stmt->execute();

                    $result = $stmt->get_result();

                    $num = $stmt->affected_rows;
                } else {
                    echo "<script>alert('Field Empty')</script>";
                    header("Refresh:0");
                }
                if
                (isset($num)) {
                    if ($num > 0) {

                        ?>
                        <table id='table' class='table  table-light table-bordered table-striped my-4'>
                            <thead class='table-primary'>
                                <tr>
                                    <th scope='col'>S_No</th>
                                    <th scope='col'>Name</th>
                                    <th scope='col'>Phone Number</th>
                                    <th scope='col'>Email</th>
                                    <th scope='col'>State</th>
                                    <th scope='col'>Gender</th>
                                    <th scope='col'>Age</th>
                                    <th scope='col'>Height</th>
                                    <th scope='col'>Weight</th>
                                    <th scope='col'>Looking For</th>
                                    <th scope='col'>Attended Demo Club</th>
                                    <th scope='col'>Expected Date Demo club</th>
                                    <th scope='col'>Attended MHF</th>
                                    <th scope='col'>Expected Date MHF</th>
                                    <th scope='col'>Current Status</th>
                                    <th scope='col'>Lead Date</th>
                                    <th scope='col'>Comments</th>
                                    <th scope='col'>Follow Up Date</th>
                                    <th scope='col'>Assigned To</th>
                                    <th scope='col'></th>
                                </tr>
                            </thead>
                            <?php
                                        $i = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            ?>

                            <tr>
                                <th scope='row'><?php echo $i + 1 ?></th>
                                <td colspan='1'><?php echo $row['name'] ?></td>
                                <td><?php echo $row['phone'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['state'] ?></td>
                                <td><?php echo $row['gender'] ?></td>
                                <td><?php echo $row['age'] ?></td>
                                <td><?php echo $row['height'] ?></td>
                                <td><?php echo $row['weight'] ?></td>
                                <td><?php echo $row['looking_for'] ?></td>
                                <td><?php echo $row['attended_dc'] ?></td>
                                <td><?php echo $row['exp_date_dc'] ?></td>
                                <td><?php echo $row['attended_mhf'] ?></td>
                                <td><?php echo $row['exp_date_mhf'] ?></td>
                                <td><?php echo $row['current_status'] ?></td>
                                <td><?php echo $row['lead_date'] ?></td>
                                <td><?php echo $row['comments'] ?></td>
                                <td><?php echo $row['followup_date'] ?></td>

                                <td><?php echo $row['assigned_to'] ?></td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Select
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <form action="update.php" method="get"><input style="display:none"
                                                        name="s_no" value="<?php echo $row["s_no"] ?>"><button
                                                        class="dropdown-item" type="submit">Update</button></form>
                                            </li>


                                        </ul>
                                    </div>
                                </td>

                                <?php
                                                $i++;
                                        }
                                        echo "</table>";
                                        ?>

                                <form action="export.php" method="POST">
                                    <select name="export_file_type" class="form-control">
                                        <option value="xlsx">XLSX</option>
                                        <option value="xls">XLS</option>
                                        <option value="csv">CSV</option>
                                    </select>
                                    <button type="submit" name="export_excel_btn"
                                        class="btn btn-primary mt-3">Export</button>
                                </form><?php
                    } else {
                        echo "Data Not found";
                    }
                } else {
                    header('Location:data.php');
                }

            }

            ?>

        </div>
        <?php
        include "footer.php";

        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.6.4.js"
            integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous">
        </script>
        <script src="js/index.js"></script>
    </body>

</html>