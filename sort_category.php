<?php
    session_start();
    require('connect.php');

    if(isset($_GET['category_id']) && !empty($_GET['category_id'])) {
      $category_id = filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT);

      if(isset($_POST['radPriceASC'])) {
        $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id WHERE categories.category_id =:category_id ORDER BY product_cost ASC';

        $statement = $db->prepare($query);

        $statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);

        $statement->execute(array(':category_id'=>$category_id));

        echo "Currently sorting: product_cost ASC";
      }
      else if(isset($_POST['radPriceDESC'])) {
        $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id WHERE categories.category_id =:category_id ORDER BY product_cost DESC';

        $statement = $db->prepare($query);

        $statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);

        $statement->execute(array(':category_id'=>$category_id));

        echo "Currently sorting: product_cost DESC";
      }
      else if(isset($_POST['radProductASC'])) {
        $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id WHERE categories.category_id =:category_id ORDER BY product_name ASC';

        $statement = $db->prepare($query);

        $statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);

        $statement->execute(array(':category_id'=>$category_id));

        echo "Currently sorting: product_name ASC";
      }
      else if(isset($_POST['radProductDESC'])) {
        $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id WHERE categories.category_id =:category_id ORDER BY product_name DESC';

        $statement = $db->prepare($query);

        $statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);

        $statement->execute(array(':category_id'=>$category_id));

        echo "Currently sorting: product_name DESC";
      }
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
      <form class="row" action="sort.php" method="post">
        <div class="col gy-3">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="radPriceASC">
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

          <?php if(isset($_GET['category_id']) && !empty($_GET['category_id'])):?>

          <button class="btn btn-primary" formaction="sort_category.php?category_id=<?= $_GET['category_id']?>">Sort</button>

          <?php else:?>

          <button class="btn btn-primary" formaction="sort.php">Sort</button>

          <?php endif?>

        </div>
      </form>
      <div class="row row-cols-3">
        <?php include('container.php')?>
      </div>
    </div>

    <!-- Bootstrap scripts -->
    <script src="js/bootstrap.bundle.js"></script>

    <!-- Custom scripts -->
    <!-- <script src="js/scripts.js"></script> -->
  </body>
</html>
