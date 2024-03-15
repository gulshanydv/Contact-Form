<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "Session Destroyed";
    header('location:login.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <!-- Thank you message -->
                <div class="alert alert-success" role="alert">
                    Thank you <?php echo  $_SESSION['username'] ?> for visiting our page! You are welcome again.

                </div>
                <!-- Logout button -->
                <form method="post" action="logout.php">
                    <button type="submit" class="btn btn-primary btn-block">Logout</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>