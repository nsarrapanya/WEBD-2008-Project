<?php
    require('connect.php');

    if(isset($_GET['product_id']) && !empty($_GET['product_id']))
    {
      // $id = $_GET['product_id'];
      $product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_NUMBER_INT);

      $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id WHERE product_id=:product_id';
      $statement = $db->prepare($query);

      $statement->bindParam(':product_id', $product_id, PDO::PARAM_INT);

      $statement->execute(array(':product_id'=>$product_id));

      // $row = $statement->fetch(PDO::FETCH_ASSOC);
      // extract($row);
    }
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
    <!-- Navbar -->
    <?php include('header.php')?>
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
      <div class="row row-cols-2">
        <?php include('review_container.php')?>
        <?php include('review.php')?>
      </div>
    </div>
    <!-- Bootstrap scripts -->
    <script src="js/bootstrap.bundle.js"></script>
    <!-- Custom scripts -->
    <!-- <script src="js/scripts.js"></script> -->
  </body>
</html>
