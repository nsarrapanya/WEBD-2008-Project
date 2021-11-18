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
