<?php
    session_start();
    require('connect.php');

    if(isset($_GET['product_id']) && !empty($_GET['product_id'])) {
      $product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_NUMBER_INT);

      $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id WHERE product_id=:product_id';
      $statement = $db->prepare($query);

      $statement->bindParam(':product_id', $product_id, PDO::PARAM_INT);

      $statement->execute(array(':product_id'=>$product_id));

      $row = $statement->fetch(PDO::FETCH_ASSOC);
    }
?>
 <!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?= $row['product_name']?></title>

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
      <div class="row row-cols-2">

        <?php if($statement->rowCount() >=1):?>

            <?php if(is_null($row['product_image'])): ?>

              <div class="col g-3">
                <h2><?= $row['product_name']?></h2>
                <p><?= $row['product_description']?></p>
                <p>$<?= $row['product_cost']?></p>
                <p>Category:
                  <br>
                  <a href="<?= $row['category_href']?>.php" class="text-decoration-none"><?= $row['category_name']?></a>
                </p>
              </div>

            <?php else:?>

              <div class="col g-3">
                <img src="images/<?= $row['product_image']?>" class="img-fluid rounded mx-auto d-block vw-100" alt="">
                <h2><?= $row['product_name']?></h2>
                <p><?= $row['product_description']?></p>
                <p>$<?= $row['product_cost']?></p>
                <p>Category:
                  <br>
                  <a href="select_where.php?category_id=<?= $row['category_id']?>" class="text-decoration-none"><?= $row['category_name']?></a>
                </p>
              </div>
            <?php endif?>

        <?php else:?>

            <div class="col">
              <h1 class="display-6">There are no product in-stock. Please check back at a later date!</h1>
            </div>

        <?php endif?>

        <div class="col g-3">
          <?php include('review.php')?>
        </div>
      </div>
    </div>
    <!-- Bootstrap scripts -->
    <script src="js/bootstrap.bundle.js"></script>
    <!-- Custom scripts -->
    <!-- <script src="js/scripts.js"></script> -->
  </body>
</html>
