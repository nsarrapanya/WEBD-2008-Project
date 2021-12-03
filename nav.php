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

          <?php if(is_null($nav_row['category_href']) && empty($nav_row['category_href'])):?>

          <?php else:?>

          <li>
            <a class="nav-link" href="<?= $nav_row['category_href']?>.php"><?= $nav_row['category_name']?></a>
          </li>

          <?php endif?>

        <?php endwhile?>

        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
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
