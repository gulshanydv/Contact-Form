<?php
session_start();
include 'dbcon.php';


if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

    $pass = password_hash($password, PASSWORD_BCRYPT);
    $cpass = password_hash($cpassword, PASSWORD_BCRYPT);
    $token = bin2hex(random_bytes(15));

    $emailquery = "SELECT * FROM registration WHERE email='$email'";

    $query = mysqli_query($con, $emailquery);

    $emailcount = mysqli_num_rows($query);

    if ($emailcount > 0) {
        echo "Mail already exists!";
    } else {
        if ($password === $cpassword) {
            $insertquery = "INSERT INTO registration(username,email,mobile,password,cpassword, token, status) VALUES ('$username','$email','$mobile','$pass','$cpass','$token','inactice')";

            $iquery = mysqli_query($con, $insertquery);

            if ($iquery) {

                $subject = "Simple Email Test via PHP";
                $body = "Hi, $username. click here to activate your account http://localhost/signuppage/activate.php?token=$token";
                $sender_email = "From: rs90971255@gmail.com";

                if (mail($email, $subject, $body, $sender_email)) {
                    $_SESSION['msg'] = "Check your mail to activate your account $email";
                    header('location: login.php');
                } else {
                    echo "Email Sending failed...";
                }
            } else {
?>
                <script>
                    alert("no insertion successfull");
                </script>
            <?php
            }
        } else {
            ?>
            <script>
                alert("Password are not matching");
            </script>
<?php
        }
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

            <h4 class="card-title mt-3 text-center">Create Account</h4>

            <p class="text-center">Get started with your free account</p>

            <p>
                <a href="" class="btn btn-block btn-gmail"><i class="fa fa-google"></i>Login via Gmail</a>
                <a href="" class="btn btn-block btn-facebook"> <i class="fa fa-facebook-f"></i>Login via facebook</a>
            </p>

            <p class="divider-text">
                <span class="bg-light">OR</span>
            </p>

            <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>">


                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control form-input" name="username" placeholder="Full name" autocomplete="off" required>
                </div>




                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-envelope"></i>
                        </span>
                    </div>
                    <input type="email" name="email" class="form-control form-input" placeholder="Email address" autocomplete="off" required>
                </div>



                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-phone"></i>
                        </span>
                    </div>
                    <input class="form-control form-input" placeholder="Phone number" type="number" name="mobile" value="" autocomplete="off" required>
                </div>



                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <input class="form-control form-input" placeholder="Create password" type="password" name="password" value="" autocomplete="off" required>
                </div><!--form group//-->




                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <input type="password" name="cpassword" class="form-control form-input" placeholder="Repeat password" autocomplete="off" required>
                </div><!--form group//-->




                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit" name="submit">Create Account</button>
                </div><!--form group//-->
                <p class="text-center">Have an account? <a href="login.php">Log In</a></p>


            </form>
        </article>
    </div>

</body>

</html>