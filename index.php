<?php
    require('connect.php');

    // SQL is written as a String.
    $query= "SELECT * FROM products JOIN categories ON products.Category_Id = categories.Category_Id";

    // A PDO::Statement is prepared from the query.
    $statement = $db->prepare($query);

    // Execution on the DB server is delayed until we execute().
    $statement->execute();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Dee's Nuts</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Botanicals</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Drupes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Gymnosperms</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Angiospems</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Admin</a>
            </li>
          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>
    <div class="container-fluid">
      <div class="row row-cols-4">
        <?php while($row=$statement->fetch()):?>
          <div class="col">
            <!-- <img src="<?=$row['image']?>" alt=""> -->
            <h2><?=$row['Product_Name']?></h2>
            <p><?=$row['Product_Description']?></p>
            <p>Category: <a class="nav-link" href="#"><?=$row['Category_Name']?></a></p>
            <p>$<?=$row['Product_Cost']?></p>
            <button class="btn btn-outline-success" type="submit"><i class="bi bi-bag-fill"></i></i></button>
          </div>
        <?php endwhile?>
      </div>
    </div>
  </body>
</html>
