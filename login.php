<?php
session_start();
ob_start();
?>

<?php

include 'dbcon.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email_search = "SELECT * FROM registration WHERE email='$email' and status='active'";
    $query = mysqli_query($con, $email_search);

    $email_count = mysqli_num_rows($query);
    if ($email_count > 0) {
        $email_pass = mysqli_fetch_assoc($query);
        $db_pass = $email_pass['password'];

        $_SESSION['username'] = $email_pass['username'];
        $_SESSION['mobile'] = $email_pass['mobile'];

        $pass_decode = password_verify($password, $db_pass);

        if ($pass_decode) {
            if (isset($_POST['rememberme'])) {
                setcookie('emailcookie', $email, time() + 86400);
                setcookie('passwordcookie', $password, time() + 86400);
                header('location:homepage.php');
            } else {
                header('location:homepage.php');
            }
        } else {
?>
            <script>
                alert("Password Incorrect");
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            alert("Invalid Email");
        </script>
<?php
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

            <h4 class="card-title mt-3 text-center">Log In Account</h4>

            <p class="text-center">Get started with your free account</p>

            <p>
                <a href="" class="btn btn-block btn-gmail"><i class="fa fa-google"></i>Login via Gmail</a>
                <a href="" class="btn btn-block btn-facebook"> <i class="fa fa-facebook-f"></i>Login via facebook</a>
            </p>

            <p class="divider-text">
                <span class="bg-light">OR</span>
            </p>





            <div>
                <p class="bg-success text-white px-4"><?php
                                                        if (isset($_SESSION['msg'])) {
                                                            echo $_SESSION['msg'];
                                                        } else {
                                                            echo $_SESSION['msg'] = "You are logged Out. Please login again.";
                                                        }
                                                        ?></p>
            </div>









            <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>">



                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-envelope"></i>
                        </span>
                    </div>
                    <input type="email" name="email" class="form-control form-input" placeholder="Your Email address" autocomplete="off" value="<?php if (isset($_COOKIE['emailcookie'])) {
                                                                                                                                                    echo $_COOKIE['emailcookie'];
                                                                                                                                                } ?>" required>
                </div>




                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <input class="form-control form-input" placeholder="Enter password" type="password" name="password" value="<?php if (isset($_COOKIE['passwordcookie'])) {
                                                                                                                                    echo $_COOKIE['passwordcookie'];
                                                                                                                                } ?>" autocomplete="off" required>
                </div><!--form group//-->


                <div class="form-group ">
                    <input type="checkbox" name="rememberme" autocomplete="off" required>Remember Me
                </div><!--form group//-->



                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit" name="submit">Login Account</button>
                </div><!--form group//-->

                <p class="text-center"> <a href="recover_email.php">Forget Password</a></p>

                <p class="text-center">Not have an account? <a href="registration.php">Register here</a></p>


            </form>
        </article>
    </div>

</body>

</html>