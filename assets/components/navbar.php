<nav class="navbar navbar-expand-lg bg-danger fixed-top">
  <div class="container">
    <a class="navbar-brand fs-3 text-secondary semibold-header text-white" href="/">Yo<span class="text-secondary">ex</span>to</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav d-flex column-gap-4 justify-content-end w-100 mb-2 mb-lg-0 medium-header">
        <li class="nav-item">
          <a class="nav-link text-white" href="/#about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="/#information">Information</a>
        </li>
        <?php if (isset($_SESSION["user_login"]["username"])) : ?>
          <li class="nav-item">
            <a class="nav-link text-white" href="create-form-expression">Create FX</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="result">Result FX</a>
          </li>
          <li class="nav-item">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?= $_SESSION["user_login"]["username"] ?>
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" onclick="return confirm('Yakin ingin logout?')" href="logout">Logout</a></li>
              </ul>
            </div>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a class="nav-link text-white" href="login">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>