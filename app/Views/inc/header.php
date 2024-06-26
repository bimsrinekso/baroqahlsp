<header class="py-3 mb-3 border-bottom bg-dark">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button class="btn btn-primary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
             =
            </button>
        </div>
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0 dropdown">
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?= base_url('/assets/images/'.$_SESSION['avatar']) ?>" alt="mdo" width="32" height="32" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small shadow">
                    <li><a class="dropdown-item" href="<?=base_url('/logout')?>">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
