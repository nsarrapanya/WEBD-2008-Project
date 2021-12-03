<?php
    require('authenticate.php');
    require('connect.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dee's Nuts - Admin categories insert</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
  </head>
  <body>
    <!-- Navbar -->
    <?php include('admin_nav.php')?>

    <!-- Form -->
    <div class="container">
      <form class="post" method="post">
        <h1 class="display-6">Add a new category</h1>
        <div class="mb-3">
          <label>Category name</label>
          <input type="text" class="form-control" name="category_name" placeholder="Botanical">
        </div>
        <div class="mb-3">
          <label>Category description</label>
          <input type="text" class="form-control" name="category_description" placeholder="Dry, hard-shelled, compartmentalized fruit that do not split on maturity to release seeds.">
        </div>
        <div class="mb-3">
          <label>Category href</label>
          <input type="text" class="form-control" name="category_href" placeholder="botanical">
        </div>
        <button type="submit" class="btn btn-success" name="btnSubmit">Submit</button>
        <button type="button" class="btn btn-warning" name="btnCancel" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel</button>
      </form>
    </div>

    <!-- Cancel Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cancelModal">Warning!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to cancel?
          </div>
          <!-- Buttons -->
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="window.location.href='index.php'">Yes</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap scripts -->
    <script src="js/bootstrap.bundle.js"></script>

    <!-- Custom scripts -->
    <!-- <script src="js/scripts.js"></script> -->
  </body>
</html>
