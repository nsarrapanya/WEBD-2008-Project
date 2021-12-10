<?php
    $query = 'SELECT * FROM categories';

    $navbar_statement = $db->prepare($query);
    $navbar_statement->execute();

    $form_statement = $db->prepare($query);
    $form_statement->execute();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Dee's Nuts</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>

        <?php while($nav_row=$navbar_statement->fetch(PDO::FETCH_ASSOC)):?>

          <li>
            <a class="nav-link" href="index.php?category_id=<?= $nav_row['category_id']?>"><?= $nav_row['category_name']?></a>
          </li>

        <?php endwhile?>

        <li class="nav-item">
          <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#adminModal">Admin</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
        </li>
      </ul>
      <form class="d-flex" method="post" action="search.php">
        <div class="input-group">
          <select class="input-group-text form-select" name="drpdwnCategory">

            <option value="" selected>All</option>

            <?php while($form_row=$form_statement->fetch(PDO::FETCH_ASSOC)):?>

              <option value="<?= $form_row['category_name']?>"><?= $form_row['category_name']?></option>

            <?php endwhile?>

          </select>
          <input class="form-control me-2" type="search" name="bxQuery" placeholder="Almonds..." list="Options">
        </div>

        <button class="btn btn-outline-light" type="submit" name="btnSearch">Search</button>
      </form>
    </div>
  </div>
</nav>

<!-- Admin Modal -->

<div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Administrator</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        What changes would you like to make? You will be asked for an admin credential to make any changes.
      </div>
      <!-- Buttons -->
      <div class="modal-footer">
        <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#productModal">Product</a>
        <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#categoriesModal">Categories</a>
        <a class="btn btn-primary" href="admin_edit_user.php">Users</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Product Modal -->

<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancelModal">Products</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        What would you like to do to products?
      </div>
      <!-- Buttons -->
      <div class="modal-footer">
        <a class="btn btn-primary" href="admin_edit.php">Edit</a>
        <a class="btn btn-primary" href="admin_insert.php">Add</a>
        <button type="button" class="btn btn-secondary" data-bs-target="#adminModal" data-bs-toggle="modal">Back</button>
      </div>
    </div>
  </div>
</div>

<!-- Categories Modal -->

<div class="modal fade" id="categoriesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancelModal">Categories</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        What would you like to do to categories?
      </div>
      <!-- Buttons -->
      <div class="modal-footer">
        <a class="btn btn-primary" href="admin_categories.php">Edit</a>
        <a class="btn btn-primary" href="admin_insert_categories.php">Add</a>
        <button type="button" class="btn btn-secondary" data-bs-target="#adminModal" data-bs-toggle="modal">Back</button>
      </div>
    </div>
  </div>
</div>

<!-- Logout Modal -->

<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancelModal">Warning!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to logout?
      </div>
      <!-- Buttons -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="window.location.href='logout.php'">Yes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
