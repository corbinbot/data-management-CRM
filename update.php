<?php

require "functions.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || !isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

if (!isset($_GET['s_no'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];

if (isset($_POST['submit'])) {
    $mysqli = connect();
    $id = $_POST['s_no'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $state = $_POST['state'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $lookingfor = $_POST['lookingfor'];
    $attended_dc = $_POST['attended_dc'];
    $exp_date_dc = $_POST['exp_date_dc'];
    $attended_mhf = $_POST['attended_mhf'];
    $exp_date_mhf = $_POST['exp_date_mhf'];
    $followupdate = $_POST['followupdate'];
    $currentstatus = $_POST['currentstatus'];
    $leaddate = $_POST['leaddate'];
    $comments = $_POST['comments'];


    $sql = "SELECT username from user where s_no = ?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param('s', $caller_id);

    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    $caller_name = $row['username'];

    $sql = "UPDATE `data` SET `name` = '$name', `phone` = '$number', `email` = '$email', `state` = '$state', `gender` = '$gender', `age` = '$age', `height` = '$height', `weight` = '$weight', `looking_for` = '$lookingfor', `attended_dc` = '$attended_dc', `exp_date_dc` = '$exp_date_dc', `attended_mhf` = '$attended_mhf', `exp_date_mhf` = '$exp_date_mhf', `current_status` = '$currentstatus', `lead_date` = '$leaddate', `comments` = '$comments', `followup_date`= '$followupdate',`id` = '$caller_id' WHERE `data`.`s_no` = '$id';";


    $stmt = $mysqli->prepare($sql);

    // $stmt->bind_param('s', $_SESSION['user_id']);

    $stmt->execute();

    $result = $stmt->get_result();

    $num = $stmt->affected_rows;
    // $numExistRows = mysqli_num_rows($result);////
    if ($num == 1) {
        echo "<script>alert('data Inserted')</script>";

    }

    header('location: data.php');

}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="css/homestyle.css">
        <title>form</title>
    </head>

    <body>
        <?php
        include 'navbar.php';
        ?>
        <div class="wrapper">
            <div class="title">User Details</div>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                // include "connection.php";
                $mysqli = connect();

                $sql = "SELECT * from data where s_no = ?";

                $stmt = $mysqli->prepare($sql);

                $stmt->bind_param('s', $_GET['s_no']);

                $stmt->execute();

                $result = $stmt->get_result();


                if ($result) {
                    $row = $result->fetch_assoc();
                    // echo "<script>alert('" . $row['name'] . "')</script>";
                    ?>
            <form action="" method="post">
                <div class=" user-details">
                    <div class="input-box">
                        <span class="details">Name</span>
                        <input style="display:none" name="s_no" type="text" value="<?php echo $_GET['s_no'] ?>"
                            placeholder="Enter your name" required>
                        <input name="name" type="text" value="<?php echo $row['name'] ?>" placeholder="Enter your name"
                            readonly="readonly">
                    </div>
                    <div class="input-box">
                        <span class="details">Phone Number</span>
                        <input name="number" type="number" value="<?php echo $row['phone'] ?>"
                            placeholder="Enter your number">
                    </div>
                    <div class="input-box">
                        <span class="details">E-Mail</span>
                        <input name="email" type="text" value="<?php echo $row['email'] ?>"
                            placeholder="Enter your email" readonly="readonly">
                    </div>
                    <div class="input-box">
                        <span class="details">State</span>
                        <input name="state" type="text" value="<?php echo $row['state'] ?>"
                            placeholder="Enter your state">
                    </div>

                    <div class="input-box">
                        <span class="details">Age</span>
                        <input name="age" type="Number" value="<?php echo $row['age'] ?>" placeholder="Enter Your Age">
                    </div>
                    <div class="input-box">
                        <span class="details">Height(cms)</span>
                        <input name="height" type="Number" value="<?php echo $row['height'] ?>"
                            placeholder="Enter Your Height">
                    </div>
                    <div class="input-box">
                        <span class="details">Weight(Kg)</span>
                        <input name="weight" type="Number" value="<?php echo $row['weight'] ?>"
                            placeholder="Enter Your Weight">
                    </div>
                    <div class="input-box">
                        <span class="details">Looking For</span>
                        <select name="lookingfor" value="<?php echo $row['looking_for'] ?>" type="text"
                            placeholder="Looking For?">
                            <option value="<?php echo $row['looking_for'] ?>"><?php echo $row['looking_for'] ?>
                            </option>
                            <?php
                                    if ($row['looking_for'] == "Healthy Weight Loss") {
                                        ?>
                            <option value="Healthy Weight Gain">Healthy Weight Gain</option>
                            <option value="Overall Health">Overall Health</option>
                            <?php
                                    } else if ($row['looking_for'] == "Healthy Weight Gain") {
                                        ?>

                            <option value="Healthy Weight Loss">Healthy Weight Loss</option>
                            <option value="Overall Health">Overall Health</option>
                            <?php
                                    } else {
                                        ?>
                            <option value="Healthy Weight Loss">Healthy Weight Loss</option>
                            <option value="Healthy Weight Gain">Healthy Weight Gain</option>
                            <?php
                                    }
                                    ?>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Attended "Demo Club"</span>
                        <select name="attended_dc" value="<?php echo $row['attended_dc'] ?>" type="text">
                            <option value="<?php echo $row['attended_dc'] ?>"><?php echo $row['attended_dc'] ?></option>
                            ';
                            <?php
                                    if ($row['attended_dc'] == "No") {
                                        ?>
                            <option value="Yes">Yes</option>
                            <?php
                                    } else {
                                        ?>
                            <option value="No">No</option>
                            <?php
                                    }
                                    ?>

                        </select>
                    </div>


                    <div class="input-box">
                        <span class="details">Expected Date "Demo Club"</span>
                        <input name="exp_date_dc" value="<?php echo $row['exp_date_dc'] ?>" type="date"
                            placeholder="Enter Expected Date">
                    </div>
                    <div class="input-box">
                        <span class="details">Attended "Mission Healthy Family"</span>
                        <select name="attended_mhf" value="<?php echo $row['attended_mhf'] ?>" type="text"
                            placeholder="">
                            <option value="<?php echo $row['attended_mhf'] ?>"><?php echo $row['attended_mhf'] ?>
                            </option>


                            <?php
                                    if ($row['attended_mhf'] == "No") {
                                        ?>
                            <option value="Yes">Yes</option>
                            <?php } else {
                                        ?>
                            <option value="No">No</option>
                            <?php }
                                    ?>

                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Expected Date "Mission Healthy Family"</span>
                        <input name="exp_date_mhf" value="<?php echo $row['exp_date_mhf'] ?>" type="date"
                            placeholder="Enter Expected Date">
                    </div>

                    <div class="input-box">
                        <span class="details">Current Status</span>
                        <select name="currentstatus" value="<?php echo $row['current_status'] ?>" type="text">
                            <option value="<?php echo $row['current_status'] ?>"><?php echo $row['current_status'] ?>
                            </option>';
                            <?php
                                    if ($row['current_status'] == "Just Landed") {
                                        ?>
                            <option value="Call Not Picked">Call Not Picked</option>
                            <option value="Wrong/Invalid Number">Wrong/Invalid Number</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Session attended but not replying">Session attended but not replying</option>
                            <option value="Interested but didn't join">Interested but didn't join</option>
                            <option value="Joined Club Membership">Joined Club Membership</option>
                            <?php } else if ($row['current_status'] == "Call Not Picked") {
                                        ?>
                            <option value=" Just Landed"> Just Landed</option>
                            <option value="Wrong/Invalid Number">Wrong/Invalid Number</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Session attended but not replying">Session attended but not replying</option>
                            <option value="Interested but didn't join">Interested but didn't join</option>
                            <option value="Joined Club Membership">Joined Club Membership</option>
                            <?php } else if ($row['current_status'] == "Wrong/Invalid Number") {
                                        ?>
                            <option value=" Just Landed"> Just Landed</option>
                            <option value="Call Not Picked">Call Not Picked</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Session attended but not replying">Session attended but not replying</option>
                            <option value="Interested but didn't join">Interested but didn't join</option>
                            <option value="Joined Club Membership">Joined Club Membership</option>
                            <?php } else if ($row['current_status'] == "Not Interested") {
                                        ?>

                            <option value=" Just Landed"> Just Landed</option>
                            <option value="Call Not Picked">Call Not Picked</option>
                            <option value="Wrong/Invalid Number">Wrong/Invalid Number</option>
                            <option value="Session attended but not replying">Session attended but not replying</option>
                            <option value="Interested but didn't join">Interested but didn't join</option>
                            <option value="Joined Club Membership">Joined Club Membership</option>
                            <?php } else if ($row['current_status'] == "Session attended but not replying") {
                                        ?>

                            <option value=" Just Landed"> Just Landed</option>
                            <option value="Call Not Picked">Call Not Picked</option>
                            <option value="Wrong/Invalid Number">Wrong/Invalid Number</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Interested but didn't join">Interested but didn't join</option>
                            <option value="Joined Club Membership">Joined Club Membership</option>
                            <?php } else if ($row['current_status'] == "Interested but didn't join") {
                                        ?>

                            <option value=" Just Landed"> Just Landed</option>
                            <option value="Call Not Picked">Call Not Picked</option>
                            <option value="Wrong/Invalid Number">Wrong/Invalid Number</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Session attended but not replying">Session attended but not replying</option>

                            <option value="Joined Club Membership">Joined Club Membership</option>

                            <?php } else {
                                        ?>
                            <option value=" Just Landed"> Just Landed</option>
                            <option value="Call Not Picked">Call Not Picked</option>
                            <option value="Wrong/Invalid Number">Wrong/Invalid Number</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Session attended but not replying">Session attended but not replying</option>
                            <option value="Interested but didn't join">Interested but didn't join</option>

                            <?php }
                                    ?>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Lead Date</span>
                        <input name="leaddate" value="<?php echo $row['lead_date'] ?>" type="date"
                            placeholder="Enter Lead Date">
                    </div>
                    <div class="input-box">
                        <span class="details">Comments</span>
                        <input name="comments" value="<?php echo $row['comments'] ?>" type="text"
                            placeholder="Enter comment">
                    </div>
                    <div class="input-box">
                        <span class="details">Follow Up Date</span>
                        <input name="followupdate" value="<?php echo $row['followup_date'] ?>" type="date"
                            placeholder="Enter date">
                    </div>
                    <div class="input-box">
                        <span class="details">Gender</span>
                        <select name="gender" value="<?php echo $row['gender'] ?>" type="text">
                            <option value="<?php echo $row['gender'] ?>"><?php echo $row['gender'] ?></option>
                            <?php
                                    if ($row["gender"] == "Male") {
                                        ?>
                            <option value="Female">Female</option>
                            <?php } else {
                                        ?>
                            <option value="Male">Male</option>
                            <?php }
                                    ?>

                        </select>
                    </div>




                </div>
                <div class="button">
                    <input type="submit" name="submit" placeholder="Update Your Details">
                </div>
            </form>
            <?php
                } else {
                    echo "<script>
            alert('Error')
            </script>";

                }
            } ?>

        </div>
        <?php
        include "footer.php";

        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
    </body>

</html>