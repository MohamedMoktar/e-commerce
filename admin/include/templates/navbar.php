<?php
include 'footer.php';
include 'header.php'
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
  <a class="navbar-brand" href="#"><?php echo lang('HOME_ADMIN')?></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="dashbord.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="categories.php">categoris</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="items.php">items</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="comments.php">comments</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="members.php">members</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">logs</a>
      </li>
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
         mokhtar
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="../../../index.php">visit shop</a></li>
          <li><a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['id']?>">Editprofile</a></li>
          <li><a class="dropdown-item" href="#">Setting</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="logout.php">logout</a></li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>
    </ul>
    
  </div>
</div>
</nav>