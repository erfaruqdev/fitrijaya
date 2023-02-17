<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>" class="brand-link">
        <img src="<?= base_url() ?>assets/images/logo.jpg" alt="e-bms Sistem" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">FITRI JAYA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item mb-1">
                    <a href="<?= base_url() ?>" class="nav-link <?= ($class ?? '') ?>">
                        <i class="nav-icon fas fa-home" style="margin-top: 0.28rem!important"></i>
                        <p>Beranda</p>
                    </a>
                </li>
                <li class="nav-header">MENU</li>
                <?php
                $uri = $this->uri->segment(1);
                $menus = getMenu();
                if ($menus) {
                    foreach ($menus as $menu) {
                ?>
                        <li class="nav-item mb-1">
                            <a href="<?= base_url($menu->url) ?>" class="nav-link <?= ($uri == $menu->url) ? 'active' : '' ?>">
                                <i class="nav-icon <?= $menu->icon ?>" style="margin-top: 0.28rem!important"></i>
                                <p><?= $menu->name ?></p>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>
                <li class="nav-header">UTILITY</li>
                <li class="nav-item mb-1">
                    <a href="<?= base_url() ?>profile" class="nav-link <?= ($classProfile ?? '') ?>">
                        <i class="nav-icon fas fa-user-circle" style="margin-top: 0.28rem!important"></i>
                        <p>Profil</p>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="<?= base_url() ?>about" class="nav-link <?= ($classAbout ?? '') ?>">
                        <i class="nav-icon fas fa-info-circle" style="margin-top: 0.28rem!important"></i>
                        <p>Tentang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>auth/logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt" style="margin-top: 0.28rem!important"></i>
                        <p>Sign Out</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>