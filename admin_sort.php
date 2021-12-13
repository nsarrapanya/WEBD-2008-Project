<?php
    session_start();
    require('connect.php');

    if(isset($_POST['radPriceASC'])) {
      $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id ORDER BY product_cost ASC';

      $statement = $db->prepare($query);
      $statement->execute();

      echo "Currently sorting: product_cost ASC";
    }
    else if(isset($_POST['radPriceDESC'])) {
      $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id ORDER BY product_cost DESC';

      $statement = $db->prepare($query);
      $statement->execute();

      echo "Currently sorting: product_cost DESC";
    }
    else if(isset($_POST['radProductASC'])) {
      $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id ORDER BY product_name ASC';

      $statement = $db->prepare($query);
      $statement->execute();

      echo "Currently sorting: product_name ASC";
    }
    else if(isset($_POST['radProductDESC'])) {
      $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id ORDER BY product_name DESC';

      $statement = $db->prepare($query);
      $statement->execute();

      echo "Currently sorting: product_name DESC";
    }
    else {
      $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id';

      $statement = $db->prepare($query);
      $statement->execute();
    }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dee's Nuts - Home</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js/bootstrap.bundle.js"></script>
  </head>
  <body>

    <!-- Navbar -->
    <?php
        if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])) {
          include('nav.php');
        }
        else if($_SESSION['user_id'] == 1) {
          include('admin_nav.php');
        }
        else {
          include('user_nav.php');
        }
    ?>

    <!-- Container -->
    <div class="container">
      <!-- Sorting form -->
      <form class="row" action="admin_sort.php" method="post">
        <div class="col gy-3">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="radPriceASC"
            <label class="form-check-label">Price Ascending</label>
          </div>
        </div>
        <div class="col gy-3">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="radPriceDESC">
            <label class="form-check-label">Price Descending</label>
          </div>
        </div>
        <div class="col gy-3">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="radProductASC">
            <label class="form-check-label">Product Ascending</label>
          </div>
        </div>
        <div class="col gy-3">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="radProductDESC">
            <label class="form-check-label">Product Descending</label>
          </div>
        </div>
        <div class="col-1 offset-2 gy-3">
          <button class="btn btn-primary" formaction="admin_sort.php">Sort</button>
        </div>
      </form>
      <div class="row row-cols-3">

        <?php while($row=$statement->fetch(PDO::FETCH_ASSOC)):?>

        <div class="col g-3">

          <?php if(is_null($row['product_image']) && empty($row['product_image'])): ?>

          <h2><?= $row['product_name']?></h2>
          <p><?= $row['product_description']?></p>
          <p>$<?= $row['product_cost']?></p>
          <p>Category:
            <br>
            <a href="#" class="text-decoration-none"><?= $row['category_name']?></a>
          </p>
          <a class="btn btn-success"><i class="bi bi-cart-fill"></i></a>
          <a class="btn btn-primary" href="admin_update.php?product_id=<?= $row['product_id']?>"><i class="bi bi-pencil-square"></i></a>

          <?php else:?>

          <a href="admin_update.php?product_id=<?= $row['product_id']?>">
            <img src="images/<?= $row['product_image']?>" class="img-fluid rounded mx-auto d-block vw-100" alt="">
          </a>
          <h2><?= $row['product_name']?></h2>
          <p><?= $row['product_description']?></p>
          <p>$<?= $row['product_cost']?></p>
          <p>Category:
            <br>
            <a href="#" class="text-decoration-none"><?= $row['category_name']?></a>
          </p>
          <a class="btn btn-success"><i class="bi bi-cart-fill"></i></a>
          <a class="btn btn-primary" href="admin_update.php?product_id=<?= $row['product_id']?>"><i class="bi bi-pencil-square"></i></a>

          <?php endif?>

        </div>

        <?php endwhile?>
      </div>
    </div>
  </body>
</html>
