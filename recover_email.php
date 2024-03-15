<?php
session_start();
include 'dbcon.php';

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $emailquery = "SELECT * FROM registration WHERE email='$email'";
    $query = mysqli_query($con, $emailquery);

    $emailcount = mysqli_num_rows($query);

    if ($emailcount) {

        $userdata = mysqli_fetch_array($query);
        $username = $userdata['username'];
        $token = $userdata['token'];



        $subject = "Password Reset";
        $body = "Hi, $username. click here to reset your password   http://localhost/signuppage/reset_password.php?token=$token";
        $sender_email = "From: rs90971255@gmail.com";

        if (mail($email, $subject, $body, $sender_email)) {
            $_SESSION['msg'] = "Check your mail to reset your password $email";
            header('location: login.php');
        }
    } else {
        echo "Email not matched!";
    }
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

            <h3 class="card-title mt-3 text-center " style="color: darkgreen;"><b>Recover Your Account</b></h3>
            <p class="text-center">Provide Your E-mail</p>


            <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>">


                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-envelope"></i>
                        </span>
                    </div>
                    <input type="email" name="email" class="form-control form-input" placeholder="Email address" autocomplete="off" required>
                </div>


                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit" name="submit">Send Mail</button>
                </div><!--form group//-->
                <p class="text-center">Remember your password? <a href="login.php">Log In</a></p>


            </form>
        </article>
    </div>

</body>

</html>