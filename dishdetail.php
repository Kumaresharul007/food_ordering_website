<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FOODIE - Veg foods</title>
  <link href="dishdetail.css" rel="stylesheet">
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
    if(!isset($_GET["name"])){
      die("This page is not found!");
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
        <h1 style="color: darkorange;">DISH DETAILS:</h1>
      </div>
    </div>
  </div>
  <?php 
      include "database.php";
      $name = $_GET["name"];
      $sql = "SELECT * FROM dishes_2 WHERE name='$name'";
      $execute = mysqli_query($conn, $sql);
      if($execute){
        while($i = mysqli_fetch_array($execute)){ ?>
  <div style="margin-top: 50px;" class="container">
    <div class="row justify-content-around">
      <div class="col-md-4 text-center">
        <img class="img-fluid" src="<?php echo $i["image"]; ?>" alt="dish image">
      </div>
      <div class="col-md-6">
        <h5>Dish name: </h5>
        <?php echo $i["name"] ?><br><br>
        <h5>Dish description: </h5>
        <?php echo $i["description"]; ?><br><br>
        <h5>Price:</h5>
        <h1 style="color: darkorange;">
          <?php echo "₹ ".$i["price"]; ?>
        </h1><br><br>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <button type="submit" name="addtoorders" value="order" style="width: 100%;" class="btn btn-success">Buy now</button>
        </form><br>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <button type="submit" name="addtocart" value="cart" style="width: 100%;" class="btn btn-success">Add to cart</button>
        </form>
        <?php
        if(isset($_POST["addtocart"])){
        $_SESSION["cart"][] = array();
        array_push($_SESSION["cart"], $i["name"]);?>
        <script>alert("This dish has been added to the cart!");</script>
        <?php }
        ?>
        <?php 
        if(isset($_POST["addtoorders"])){
        $_SESSION["orders"][] = array();
        array_push($_SESSION["orders"], $i["name"]);?>
        <script>alert("Order placed successfully!");</script>
        <?php }
        ?>
      </div>
    </div>
  </div><br><br>
  <?php  } 
      } ?>

  <?php
      include "database.php";
      if(isset($_POST["review"])){
        $cname = $_POST["cname"];
        $creview = $_POST["creview"];
        $sql = "INSERT INTO feedback_2 (name, review, dishname) VALUES ('$cname', '$creview', '$name')";
        $execute = mysqli_query($conn, $sql);
        if($execute){ ?>
            <script>alert("Your comment has been posted successfully!");</script>
      <?php  }
      }?>

  <div class="container" id="review_submit">
    <h2 align="center" style="color: orange;">Review about this dish:</h2><br><br>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
      <div class="form-floating mb-3">
        <input name="cname" type="text" class="form-control" id="floatingName" placeholder="Name" required>
        <label for="floatingName">Name</label>
      </div><br>
      <div class="form-floating">
        <textarea name="creview" style="height: 200px;" class="form-control" cols="30" rows="10" id="floatingReview" placeholder="Review" required></textarea>
        <label for="floatingReview">Your review</label>
      </div><br>
      <button class="btn btn-primary" type="submit" name="review" value="Post">Post review</button>
    </form>
  </div><br><br>
  <div class="container" style="box-shadow: 1px 1px 10px black; padding: 25px;">
      <?php 
          $sql = "SELECT * FROM feedback_2 WHERE dishname = '$name'";
          $execute = mysqli_query($conn, $sql);?>
          <h2 align="center" style="color: orange;">Customer reviews:</h2>
          <div align="center">
          <b style="margin-right: 20px;"><?php echo mysqli_num_rows($execute)." reviews"; ?></b>
          <a style="margin-right: 20px;" href="#review_submit" class="btn btn-success">Post your review</a>
          </div><br>
          <?php
          if($execute){
            if(mysqli_num_rows($execute) == 0){?>
              <h4 align="center"><?php echo "No reviews yet!"; ?></h4>
            <?php } ?>
            <?php
            while($val = mysqli_fetch_array($execute)){ ?>
              <div>
              <b style="font-size: 20px;">Customer name: </b><?php echo $val["name"]; ?><br>
              <b style="font-size: 20px;">Customer review: </b><?php echo $val["review"]; ?><br><br>
              <?php if(mysqli_num_rows($execute) > 1){ ?>
              <hr><br>
              <?php } ?>
              </div>
          <?php  }
          }
      ?>
  </div><br><br><br>

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