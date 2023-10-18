<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <!-- begin:: profil sidebar -->
        <div class="">
            <div class="main-menu-header">
                <img class="img-menu-user img-radius" src="<?= (get_users_detail($this->session->userdata('id'))->foto !== null ? upload_url('gambar') . '' . get_users_detail($this->session->userdata('id'))->foto : "//placehold.co/150") ?>" alt="User-Profile-Image">
                <div class="user-details">
                    <p id="more-details"><?= get_users_detail($this->session->userdata('id'))->nama ?></p>
                </div>
            </div>
        </div>
        <!-- end:: profil sidebar -->
        <!-- begin:: menu sidebar -->
        <ul class="pcoded-item pcoded-left-item">
            <li class="<?= ($this->uri->segment(2) === null ? 'active' : '') ?>">
                <a href="<?= admin_url() ?>">
                    <span class="pcoded-micon">
                        <i class="fa fa-dashboard"></i>
                    </span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigation-label">Master</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="<?= ($this->uri->segment(2) === 'criteria' ? 'active' : '') ?>">
                <a href="<?= admin_url() ?>criteria">
                    <span class="pcoded-micon">
                        <i class="fa fa-list"></i>
                    </span>
                    <span class="pcoded-mtext">Criteria</span>
                </a>
            </li>
            <li class="<?= ($this->uri->segment(2) === 'criteria_sub' ? 'active' : '') ?>">
                <a href="<?= admin_url() ?>criteria_sub">
                    <span class="pcoded-micon">
                        <i class="fa fa-list"></i>
                    </span>
                    <span class="pcoded-mtext">Sub Criteria</span>
                </a>
            </li>
            <li class="<?= ($this->uri->segment(2) === 'assessment' ? 'active' : '') ?>">
                <a href="<?= admin_url() ?>assessment">
                    <span class="pcoded-micon">
                        <i class="fa fa-list"></i>
                    </span>
                    <span class="pcoded-mtext">Assessment</span>
                </a>
            </li>
            <li class="<?= ($this->uri->segment(2) === 'classification' ? 'active' : '') ?>">
                <a href="<?= admin_url() ?>classification">
                    <span class="pcoded-micon">
                        <i class="fa fa-list"></i>
                    </span>
                    <span class="pcoded-mtext">Classification</span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigation-label">Pustaka</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="<?= ($this->uri->segment(2) === 'datatraining' ? 'active' : '') ?>">
                <a href="<?= admin_url() ?>datatraining">
                    <span class="pcoded-micon">
                        <i class="fa fa-list"></i>
                    </span>
                    <span class="pcoded-mtext">Data Training</span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigation-label">Metode</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="<?= ($this->uri->segment(2) === 'consultation' ? 'active' : '') ?>">
                <a href="<?= admin_url() ?>consultation">
                    <span class="pcoded-micon">
                        <i class="fa fa-list"></i>
                    </span>
                    <span class="pcoded-mtext">Consultation</span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigation-label">Laporan</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="<?= ($this->uri->segment(2) === 'report' ? 'active' : '') ?>">
                <a href="<?= admin_url() ?>report">
                    <span class="pcoded-micon">
                        <i class="fa fa-list"></i>
                    </span>
                    <span class="pcoded-mtext">History Consultation</span>
                </a>
            </li>
        </ul>
        <!-- end:: menu sidebar -->
    </div>
</nav>