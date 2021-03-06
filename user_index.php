<?php
    session_start();
    require('connect.php');

    $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id ORDER BY product_id';

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
  </head>
  <body>
    <?php
        if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in']))
        {
          include('nav.php');
        }
        else if($_SESSION['user_id'] == 1 || $_SESSION['user_id'] == 5)
        {
          include('admin_nav.php');
        }
        else
        {
          include('user_nav.php');
        }
    ?>

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
