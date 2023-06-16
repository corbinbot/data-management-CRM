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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="css/homestyle.css">
        <title>Import</title>
    </head>

    <body>
        <?php
        include 'navbar.php';
        ?>
        <div class="wrapper">
            <?php
            if (isset($_SESSION['message'])) {
                echo "<h4>" . $_SESSION['message'] . "</h4>";
                unset($_SESSION['message']);
            }

            ?>
            <div class="container my-4">
                <form action="code.php" method="POST" enctype="multipart/form-data">

                    <input type="file" name="import_file" class="form-control" />
                    <button type="submit" name="save_excel_data" class="btn btn-outline-dark mt-3">Import</button>

                </form>
            </div>
        </div>

        <?php
        include_once 'footer.php';

        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
    </body>

</html>