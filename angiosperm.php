<?php
    require('connect.php');

    $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id WHERE products.category_id = 4';

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
    <title>Angiosperm nuts</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
  </head>
  <body>
    <!-- Navbar -->
    <?php include('header.php')?>

    <!-- Container -->
    <div class="container">
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
