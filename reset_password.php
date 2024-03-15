<?php
session_start();
ob_start();
include 'dbcon.php';

if (isset($_POST['submit'])) {

    if (isset($_GET['token'])) {
        $token = $_GET['token'];
    }

    $newpassword = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

    $pass = password_hash($newpassword, PASSWORD_BCRYPT);
    $cpass = password_hash($cpassword, PASSWORD_BCRYPT);

    if ($newpassword == $cpassword) {

        $updatequery = "update registration set password = '$pass' where token='$token'";

        $iquery = mysqli_query($con, $updatequery);

        if ($iquery) {
            $_SESSION['msg'] = "Congratulations! Your password has been updated";
            header('location:login.php');
            die();
        } else {
            $_SESSION['passmsg'] = "Sorry! Your password is not updated";
            header('location:reset_password.php');
            die();
        }
    } else {
        $_SESSION['passmsg'] = "Your password is not matching";
    }
} else {
    echo "No token found!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <?php include 'css/style.php' ?>
    <?php include 'links/links.php' ?>
</head>

<body>


    <div class="card bg-light">


        <article class="card-body mx-auto" style="max-width: 400px;">

            <h3 class="card-title mt-3 text-center" style="color: darkgreen;"><b>Change Password</b></h3>

            <p class="text-center" style="color: red;">Make a strong password</p>

            <p class="bg-info text-white px-5"><?php
                                                if (isset($_SESSION['passmsg'])) {
                                                    echo $_SESSION['passmsg'];
                                                } else {
                                                    echo $_SESSION['passmsg'] = "";
                                                }
                                                ?>
            </p>

            <form method="post" action="">



                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <input class="form-control form-input" placeholder="New password" type="password" name="password" value="" autocomplete="off" required>
                </div><!--form group//-->





                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <input type="password" name="cpassword" class="form-control form-input" placeholder="Confirm New password" autocomplete="off" required>
                </div><!--form group//-->





                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit" name="submit">Save Password</button>
                </div><!--form group//-->
                <p class="text-center">Remember Your Password? <a href="login.php">Log In</a></p>





            </form>
        </article>
    </div>

</body>

</html>