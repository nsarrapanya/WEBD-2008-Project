<?php
    session_start();
    require('authenticate.php');
    require('connect.php');

    $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id';

    $statement = $db->prepare($query);
    $statement->execute();
?>
 <!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dee's Nuts</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js/bootstrap.bundle.js"></script>
  </head>
  <body>

    <!-- Navbar -->
    <?php include('admin_nav.php')?>

    <!-- Container -->
    <div class="container">
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
          <button class="btn btn-success" type="button" name="btnBuy"><i class="bi bi-cart-fill"></i></button>
          <button class="btn btn-primary" type="button" name="btnEdit" onclick="window.location.href='admin_update.php?product_id=<?= $row['product_id']?>'"><i class="bi bi-pencil-square"></i></button>

          <?php else:?>

          <img src="images/<?= $row['product_image']?>" class="img-fluid rounded mx-auto d-block" alt="">
          <h2><?= $row['product_name']?></h2>
          <p><?= $row['product_description']?></p>
          <p>$<?= $row['product_cost']?></p>
          <p>Category:
            <br>
            <a href="#" class="text-decoration-none"><?= $row['category_name']?></a>
          </p>
          <button class="btn btn-success" type="button" name="btnBuy"><i class="bi bi-cart-fill"></i></button>
          <button class="btn btn-primary" type="button" name="btnEdit" onclick="window.location.href='admin_update.php?product_id=<?= $row['product_id']?>'"><i class="bi bi-pencil-square"></i></button>

          <?php endif?>

        </div>

        <?php endwhile?>
      </div>
    </div>
  </body>
</html>
