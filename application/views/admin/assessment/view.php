<!-- begin:: breadcumb -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h4 class="m-b-10"><?= $title ?></h4>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= admin_url() ?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#!"><?= $title ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end:: breadcumb -->

<!-- begin:: content -->
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <?php foreach ($assessment as $row) : ?>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="w-75 p-2">Tabel <?= $row['nama'] ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block table-border-style">
                                    <table class="table table-striped table-bordered nowrap dataTables" style="width: 100%;">
                                        <thead align="center">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody align="center">
                                            <?php foreach ($row['sub_criteria'] as $key => $value) : ?>
                                                <tr>
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= $value['nama'] ?></td>
                                                    <td><?= $value['nilai'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end:: content -->