<?php
    error_reporting( ~E_NOTICE ); // avoid notice

    require('authenticate.php');
    require('connect.php');

    $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id';

    $statement = $db->prepare($query);
    $statement->execute();

    // if($statement->rowCount() > 0)
    // {
    //  while($row=$statement->fetch(PDO::FETCH_ASSOC))
    //  {
    //   extract($row);
    //   }
    // }
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
    <?php include('header.php')?>
    <!-- Admin Modal -->
    <div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="adminModal">Administrator</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            What would you like to do? You will be asked for a username and password to make any changes.
          </div>
          <!-- Buttons -->
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="window.location.href='admin_edit.php'">Edit product</button>
            <button type="button" class="btn btn-primary" onclick="window.location.href='admin_insert.php'">Add products</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Container -->
    <div class="container">
      <div class="row row-cols-4 gy-3">
        <?php while($row=$statement->fetch(PDO::FETCH_ASSOC)):?>
        <div class="col">
          <img src="images/<?= $row['product_image']?>" class="img-fluid rounded mx-auto d-block" alt="">
          <h2><?= $row['product_name']?></h2>
          <p><?= $row['product_description']?></p>
          <p>$<?= $row['product_cost']?></p>
          <p>Category:
            <br>
            <a href="#" class="nav-link"><?= $row['category_name']?></a>
          </p>
          <button class="btn btn-success" type="button" name="btnbuy"><i class="bi bi-cart-fill"></i></button>
          <button class="btn btn-primary" type="button" name="btnedit" onclick="window.location.href='admin_update.php?product_id=<?= $row['product_id']?>'"><i class="bi bi-pencil-square"></i></button>
        </div>
        <?php endwhile?>
      </div>
    </div>
  </body>
</html>
