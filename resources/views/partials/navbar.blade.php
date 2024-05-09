<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/">AFLIX</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <form class="d-flex" role="search" action="/index.php" method="get">
                <input class="form-control me-2 border border-success" type="search" autofocus placeholder="taroh pencarian..." aria-label="Search" name="keyword" autocomplete="off" id="keyword">
            </form>
            <div class="navbar-nav ms-auto">
                <?php if (!isset($_SESSION["login"])) : ?>
                    <a class="nav-link" href="/register">Registrasi</a>
                    <a class="nav-link" href="/login">Login</a>
                <?php else : ?>
                    <a class="nav-link" href="/login/logout">Logout</a>
                <?php endif; ?>
                <!-- <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> -->
            </div>
        </div>
    </div>
</nav>