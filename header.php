<?php
    require('login.php');
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Dee's Nuts</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="botanical.php">Botanical Nuts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="drupes.php">Drupes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="gymnosperm.php">Gymnosperm</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="angiosperm.php">Angiosperm</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#adminModal">Admin</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Almonds..." aria-label="Search" list="exampleOptions" id="exampleDataList">
        <button class="btn btn-outline-light" type="submit">Search</button>
        <datalist id="exampleOptions">
          <option value="Almonds"></option>
          <option value="Brazil nuts"></option>
          <option value="Cashews"></option>
          <option value="Chestnuts"></option>
        </datalist>
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
<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="modal-body" action="login.php" method="post">
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Username</label>
          <div class="col-sm-10">
            <input type="text" name="username" class="form-control">
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Password</label>
          <div class="col-sm-10">
            <input type="password" name="password" class="form-control">
          </div>
        </div>
        <div class="row mb-3">
          <p>Don't have an account? <a href="register.php" class="text-decoration-none">Register</a></p>
        </div>
      </form>
      <!-- Buttons -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" name="btnLogin">Login</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
