<?php
    $navbar = 'SELECT * FROM categories';

    $navbar_statement = $db->prepare($navbar);
    $navbar_statement->execute();
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
          <a class="nav-link" href="login.php">Login</a>
        </li>
      </ul>
      <form class="d-flex" method="post" action="search.php">
        <input class="form-control me-2" type="search" name="bxQuery" placeholder="Almonds..." list="Options">
        <button class="btn btn-outline-light" type="submit" name="btnSearch">Search</button>
        <datalist id="Options">
          <option value="Almonds"></option>
          <option value="Brazil nuts"></option>
          <option value="Cashews"></option>
          <option value="Chestnuts"></option>
        </datalist>
      </form>
    </div>
  </div>
</nav>
