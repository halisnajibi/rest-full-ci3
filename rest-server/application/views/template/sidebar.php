<aside class="aside bg-dark-700">
    
    <div class="simplebar-wrapper">
        <div data-pixr-simplebar>
            <div class="pb-6 pb-sm-0 position-relative">

                <!-- Mobile close btn-->
                <div class="cursor-pointer close-menu me-4 text-primary-hover transition-color disable-child-pointer position-absolute end-0 top-0 mt-3 pt-1 d-xl-none">
                    <i class="ri-close-circle-line ri-lg align-middle me-n2"></i>
                </div>
                <!-- / Mobile close btn-->

                <!-- Mobile Logo-->
                <div class="d-flex justify-content-center align-items-center py-3">
                    <a class="m-0" href="<?= base_url('rest-server') ?>">
                        <div class="d-flex align-items-center justify-content-center">
                            <svg class="f-w-6 me-2 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 398.39 353.81"><polygon points="228.38 33.94 0 262.32 0 0 119.61 0 119.61 43.01 101.9 60.73 86.02 76.61 86.02 33.6 33.6 33.6 33.6 181.2 214.46 0.34 390.66 0.34 242.09 148.91 218.73 124.76 309.55 33.94 228.38 33.94" fill="currentColor"/><polygon points="398.39 353.81 217.51 353.81 131.04 261.75 45.09 353.81 0 353.81 0 353.49 131.26 212.91 232.05 320.21 317.27 320.21 170.28 173.21 194.19 149.29 194.19 149.55 254.9 210.51 254.97 210.39 398.39 353.81" fill="currentColor"/></svg>
                            <span class="fw-bold fs-3 text-white">Rest Server</span>
                        </div>                    </a>
                </div>
                <!-- / Mobile Logo-->

                <!-- User Details-->
                <div class="border-bottom pt-3 pb-5 mb-6 d-flex flex-column align-items-center">
                    <div class="position-relative">
                        <picture class="avatar avatar-profile">
                            <img class="avatar-profile-img" src="<?= base_url('rest-server') ?>/assets/images/user.png"
                              alt="HTML Bootstrap Admin Template by Pixel Rocket">
                        </picture>
                        <span class="dot bg-success avatar-dot"></span>
                    </div>
                    <p class="mb-0 mt-3 text-white"><?= $profiel['nama'] ?></p>
                    <small><?= $profiel['email'] ?></small>
                </div>
                <!-- User Details-->

                <ul class="list-unstyled mb-6 aside-menu">

                    <!-- Dashboard Menu Section-->
                    <li class="menu-section">Menu</li>
                    <li class="menu-item"><a class="d-flex align-items-center menu-link" href="<?= base_url('rest-server') ?>"><i
                                class="ri-home-4-line me-3"></i> <span>Dashboard</span></a></li>
                    <!-- / Dashboard Menu Section-->

                    <!-- UI Kit Menu Section-->
                    <li class="menu-section mt-5">Konfigurasi</li>
                    <li class="menu-item"><a class="d-flex align-items-center collapsed  menu-link" href="#"
                            data-bs-toggle="collapse" data-bs-target="#collapseMenuItemUI" aria-expanded="false"
                            aria-controls="collapseMenuItemUI"><i class="ri-shape-fill me-3"></i>
                            <span>Cara Penggunaan</span></a>
                        <div class="collapse" id="collapseMenuItemUI">
                            <ul class="submenu">
                                <li><a class="submenu-link" href="<?= base_url('rest-server/user/semua') ?>">Semua Data</a></li>
                                <li><a class="submenu-link" href="<?= base_url('rest-server/user/satu') ?>">Data Berdasarkan ID</a></li>
                                <li><a class="submenu-link" href="<?= base_url('rest-server/user/tambah') ?>">Tambah Data</a></li>
                                <li><a class="submenu-link" href="<?= base_url('rest-server/user/hapus') ?>">Hapus Data</a></li>
                                <li><a class="submenu-link" href="<?= base_url('rest-server/user/edit') ?>">Edit Data</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</aside>  