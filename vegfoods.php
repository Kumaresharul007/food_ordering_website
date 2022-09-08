<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FOODIE - Veg foods</title>
  <link href="dishes.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>
<?php 
        session_start();
        if(isset($_POST["submit"])){
            unset($_SESSION["success"]);
            header("location: homepage.php");
        }
        else if(!isset($_SESSION["success"])){
            header("location: login.php");
        }
?>

<body>
  <div class="hero">
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><span
            style="font-size: 35px;color: red; font-weight: bolder;">FOODIE</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="last navbar-nav">
            <li class="nav-item">
              <a id="link" class="nav-link active" aria-current="page" href="homepage.php">Home</a>
            </li>
            <li class="nav-item">
              <a id="link" class="nav-link active" href="myorders.php">My orders</a>
            </li>
            <li class="nav-item">
              <a id="link" class="nav-link active" href="cart.php">My cart</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="account btn-group">
      <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <?php echo $_SESSION["mail"]; ?>
      </button>
      <ul class="dropdown-menu">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <input class="dropdown-item" type="submit" name="submit" value="Log out">
        </form>
      </ul>
    </div>
    <div align="center">
      <div style="margin-top: 100px;" class="row">
        <h1 style="color: darkorange;">VEG FOODS:</h1>
      </div>
    </div>
  </div>
  <?php include "database.php"; ?>
  <div class="container vegfoods">
    <?php 
      $sql = "SELECT * FROM dishes_2 WHERE category='veg'";
      $execution = mysqli_query($conn, $sql);
      if($execution){?>
    <?php
        while($i = mysqli_fetch_array($execution)){
        $name = $i["name"];
        $image = $i["image"];
        $price = $i["price"];
    ?>
    <div class="card" style="width: 20rem;">
      <img class="card-img-top" src="assets/images/<?php echo $image; ?>" alt="food image">
      <div class="card-body">
        <h5 class="card-title">
          <?php echo $name; ?>
        </h5>
        <b>
          <?php echo "₹ ".$price; ?>
        </b><br><br>
        <a href="dishdetail.php?name=<?php echo $name; ?>" class="btn btn-primary">Order now</a>
      </div>
    </div>
  <?php }
      }?>

  </div>

  <footer>
    <div class="row">
      <div class="col-md-3">
        <h3>Your account:</h3>
        <h5><a href="login.php">Login</a></h5>
        <h5><a href="signup.php">Register</a></h5>
      </div>
      <div class="col-md-3">
        <h3>Categories:</h3>
        <h5><a href="vegfoods.php">Veg foods</a></h5>
        <h5><a href="non-vegfoods.php">Non-veg foods</a></h5>
        <h5><a href="cooldrinks.php">Cool drinks</a></h5>
      </div>
      <div class="col-md-3">
        <h3>Contact details:</h3>
        <h5 style="color: white;">EMAIL ID:</h5>
        <p style="color: white;">kumaresharul2003@gmail.com</p>
        <h5 style="color: white;">CONTACT NO:</h5>
        <p style="color: white;">8903507021</p>
      </div>
      <div class="col-md-3 social text-center">
        <h3>Social media links:</h3>
        <a href="https://www.facebook.com/kumaresh.a.921" target="_blank" class="col-2"><i
            style="font-size: 35px;color: darkblue;" class="bi bi-facebook"></i></a>
        <a href="https://www.instagram.com/kumaresharul/" target="_blank" class="col-2"><i
            style="font-size: 35px;color: darkorchid;" class="bi bi-instagram"></i></a>
        <a href="https://twitter.com/Kumaresharul007" target="_blank" class="col-2"><i
            style="font-size: 35px;color: skyblue;" class="bi bi-twitter"></i></a>
        <a href="https://www.linkedin.com/in/kumaresh-arul-62854321b/" target="_blank" class="col-2"><i
            style="font-size: 35px;color: darkblue;" class="bi bi-linkedin"></i></a>
      </div>
    </div><br>
    <hr><br>
    <h5 align="center">created by <b style="color: white;">Kumaresh Arul</b> | &copy;2022</h5>
  </footer>

  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
    crossorigin="anonymous"></script>
</body>

</html>