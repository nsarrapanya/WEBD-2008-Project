<?php
    require('connect.php');

    $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id WHERE products.category_id = 3';

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
    <title>Gymnosperm nuts</title>
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
