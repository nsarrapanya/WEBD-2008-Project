<?php
    session_start();
    require('connect.php');

    $query = 'SELECT * FROM categories';

    $statement = $db->prepare($query);
    $statement->execute();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dee's Nuts - Edit categories</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
  </head>
  <body>

    <!-- Navbar -->
    <?php include('admin_nav.php')?>

    <!-- Container -->
    <div class="container">
      <div class="row g-3">

        <div class="col offset-md-10 g-3">
          <br>
          <a href="admin_insert_categories.php" class="btn btn-success">Add new category</a>
        </div>
      </div>

      <div class="row g-3">
        <table class="table table-hover table-borderless">
          <thead>
            <tr>
              <th>Category ID</th>
              <th>Category</th>
              <th>Description</th>
            </tr>
          </thead>
        <?php if($statement->rowCount() >=1):?>
          <?php while($row=$statement->fetch(PDO::FETCH_ASSOC)):?>
          <tbody>
            <tr>
              <td><?= $row['category_id']?></td>
              <td><?= $row['category_name']?></td>
              <td><?= $row['category_description']?></td>
              <td>
                <form method="post">
                  <a class="btn btn-warning btn-sm" href="admin_categories_edit.php?category_id=<?= $row['category_id']?>">Edit</a>
                  <a class="btn btn-danger btn-sm" href="admin_category_delete.php?category_id=<?= $row['category_id']?>">Delete</a>
                </form>
              </td>
            </tr>
          </tbody>
          <?php endwhile?>
        <?php else:?>

          <tbody>
            <tr>
              <td>There are currently no categories.</td>
            </tr>
          </tbody>

        <?php endif?>

        </table>
      </div>
    </div>

    <!-- Bootstrap scripts -->
    <script src="js/bootstrap.bundle.js"></script>

    <!-- Custom scripts -->
    <!-- <script src="js/scripts.js"></script> -->
  </body>
</html>
