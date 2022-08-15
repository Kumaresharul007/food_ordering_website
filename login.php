<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOODIE - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">
</head>

<?php 
    session_start();
    include "database.php";
    $success = " ";
    $failure = " ";
    if(isset($_POST["login"])){
        $email = $_POST["email"];
        $password = $_POST["pass"];
        $hashed = md5($password);
        $sql = "SELECT * FROM account_2 WHERE email = '$email' AND pass = '$hashed'";
        $execution = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($execution);
        if($rows == 1){
            unset($_SESSION["success"]);
            $_SESSION["success"] = "Logged in successfully!";
            $_SESSION["mail"] = $email;
            header("location: homepage.php");
        }
        else{
            $failure = "Wrong email and password pair!";
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
    <form class="loginform" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <h3 align="center">LOG IN</h3><br>
        <label for="input1">EMAIL-ID:</label>
        <input class="form-control" type="email" id="input1" name="email" placeholder="Email" required><br>
        <label for="input2">PASSWORD:</label>
        <input class="form-control" type="password" id="input2" name="pass" placeholder="Password" required><br>
        <input style="width: 100%;" type="submit" class="btn btn-primary" name="login" value="LOG IN">
    </form><br>
    <h5 align="center">Don't have an account? <a href="signup.php">CREATE AN ACCOUNT</a></h5>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
</body>

</html>