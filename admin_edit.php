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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Dee's Nuts</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Botanical Nuts</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Drupes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Gymnosperm</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Angiosperm</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#adminModal">Admin</a>
            </li>
          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>
    <!-- Modal -->
    <div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Administrator</h5>
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
