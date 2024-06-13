<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky">
        <ul class="nav flex-column">

            <?php if ($_SESSION['role'] == 1): ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('dashboard') ?>">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('dashboard/golongan') ?>">
                        Golongan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('dashboard/karyawan') ?>">
                        Karyawan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= base_url('dashboard/gaji') ?>">
                        Gaji
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= base_url('dashboard/usermanage') ?>">
                        Manajemen Akun
                    </a>
                </li>
            <?php elseif($_SESSION['role'] == 2):?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('dashboard') ?>">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('dashboard/golongan') ?>">
                        Golongan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('dashboard/karyawan') ?>">
                        Karyawan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= base_url('dashboard/gaji') ?>">
                        Gaji
                    </a>
                </li>
            <?php else:?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('dashboard') ?>">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= base_url('dashboard/gaji') ?>">
                        Gaji
                    </a>
                </li>
            <?php endif;?>
        </ul>
    </div>
</nav>
