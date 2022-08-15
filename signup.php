<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOODIE - Create an account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="signup.css">
</head>
<?php
    session_start();
    include "database.php";
    $p1err = " ";
    $p2err = " ";
    $success = " ";
    $failure = " ";
    if(isset($_POST["register"])){
        $user = $_POST["username"];
        $mail = $_POST["email"];
        $p1 = $_POST["pass1"];
        $p2 = $_POST["pass2"];
        $error = false;
        $uppercase = preg_match('@[A-Z]@', $p1);
        $lowercase = preg_match('@[a-z]@', $p1);
        $number    = preg_match('@[0-9]@', $p1);
        $specialChars = preg_match('@[^\w]@', $p1);

        if(strlen($p1) < 8){
            $p1err = "Your password should be at least 8 characters in length!";
            $error = true;
        }
        if(!$uppercase){
            $p1err = "Your password should have atleast one uppercase character!";
            $error = true;
        }
        if(!$lowercase){
            $p1err = "Your password should have atleast one lowercase character!";
            $error = true;
        }
        if(!$number){
            $p1err = "Your password should have atleast one number!";
            $error = true;
        }
        if(strlen($p1) != strlen($p2)){
            $p2err = "This password should be same as the above entered!";
            $error = true;
        }
        if($error == false){
            $hashed = md5($p2);
            $sql = "SELECT * FROM account_2 WHERE username = '$user'";
            $execution = mysqli_query($conn, $sql);
            $rows = mysqli_num_rows($execution);
            $sql2 = "SELECT * FROM account_2 WHERE email = '$mail'";
            $execution2 = mysqli_query($conn, $sql2);
            $rows2 = mysqli_num_rows($execution2);
            if($rows > 0 and $rows2 > 0){
                $failure = "Choose any other username and email!";
            }
            elseif($rows > 0){
                $failure = "This username has already been taken!";
            }
            elseif($rows2 > 0){
                $failure = "This email has already been taken!";
            }
            else{
                $sql3 = "INSERT INTO account_2 (username, email, pass) VALUES ('$user', '$mail', '$hashed')";
                if(mysqli_query($conn, $sql3)){
                    $_SESSION["success"] = "Account has been created successfully!";
                    $_SESSION["mail"] = $mail;
                    header("location: homepage.php");
                }
                else{
                    $failure = "There is a problem in submitting the form!";
                }
            }
        }
    }
?>
<body>
    <?php if($failure != " "){?>
    <div align="center" class="alert alert-danger" role="alert">
        <?php echo $failure; ?>
    </div>
    <?php } ?>
    <p align="center" style="font-weight: bolder; font-size: 35px; color: red;text-decoration: underline;">FOODIE</p>
    <form class="signupform" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h3 align="center">CREATE AN ACCOUNT</h3><br>
        <label for="input1">USERNAME:</label>
        <input class="form-control" type="text" id="input1" name="username" placeholder="Username" required><br>
        <label for="input2">EMAIL-ID:</label>
        <input class="form-control" type="email" id="input2" name="email" placeholder="Email" required><br>
        <label for="input3">PASSWORD:</label> <span style="color: red;"><?php echo $p1err;?></span>
        <input class="form-control" type="password" id="input3" name="pass1" placeholder="Password" required>
        <ul>
            <li>Your password must be atleast 8 characters long.</li>
            <li>Your password should consists of different type of characters.</li>
        </ul>
        <label for="input4">CONFIRM PASSWORD:</label> <span style="color: red;"><?php echo $p2err;?></span>
        <input class="form-control" type="password" id="input4" name="pass2" placeholder="Re-type password" required><br>
        <input style="width: 100%;" type="submit" class="btn btn-primary" name="register" value="REGISTER">
    </form><br>
    <h5 align="center">Already have an account? <a href="login.php">LOG IN</a></h5>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
</body>

</html>