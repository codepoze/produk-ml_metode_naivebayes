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
                        <a href="<?= admin_url('consultation') ?>">Consultation</a>
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
                <!-- begin:: card -->
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="w-75 p-2">Data Training</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-block table-border-style">
                        <table class="table table-striped table-bordered nowrap" style="width: 100%;">
                            <thead>
                                <tr align="center">
                                    <?php foreach ($criteria as $key => $value) : ?>
                                        <th><?= $value->nama ?></th>
                                    <?php endforeach; ?>
                                    <th>Klastifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_training as $key => $value) : ?>
                                    <tr align="center">
                                        <?php foreach ($value['kriteria'] as $row) : ?>
                                            <td><?= $row['label'] ?></td>
                                        <?php endforeach; ?>
                                        <td><?= $value['nama'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="w-75 p-2">Menghitung Classification</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-block table-border-style">
                        <table class="table table-striped table-bordered nowrap" style="width: 100%;">
                            <thead>
                                <tr align="center">
                                    <th>Klastifikasi</th>
                                    <th>Jumlah</th>
                                    <th>Total Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $a = $ini->processCountClassification($data_training);

                                foreach ($a as $key => $value) : ?>
                                    <tr align="center">
                                        <td><?= $key ?></td>
                                        <td><?= count($value) ?></td>
                                        <td><?= count($data_training) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php foreach ($criteria as $k_c => $v_c) : ?>
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h5 class="w-75 p-2">Menghitung Classification Atribut <?= $v_c->nama ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-block table-border-style">
                            <table class="table table-striped table-bordered nowrap" style="width: 100%;">
                                <thead>
                                    <tr align="center">
                                        <th>Klastifikasi</th>
                                        <?php foreach ($ini->_criteria_sub()[$v_c->id_criteria] as $nilai => $param) { ?>
                                            <th><?= $param ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $b = $ini->processCountCriteriaClassification($data_training, $a);

                                    foreach ($a as $key => $value) : ?>
                                        <tr align="center">
                                            <td><?= $key ?></td>
                                            <?php foreach ($ini->_criteria_sub()[$v_c->id_criteria] as $nilai => $param) { ?>
                                                <td>
                                                    <?= (empty($b[$v_c->id_criteria][$key][$param]) ? 0 : count($b[$v_c->id_criteria][$key][$param])) ?>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="card">
                    <div class="card-header">
                        <h5>Probabilitas Kelas</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered nowrap" style="width: 100%;">
                            <thead align="center">
                                <tr>
                                    <th>Klastifikasi</th>
                                    <th>Hasil</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php foreach ($a as $key => $value) : ?>
                                    <tr align="center">
                                        <td><?= $key ?></td>
                                        <td><?= round(count($value) / count($data_training), 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php foreach ($criteria as $k_c => $v_c) : ?>
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h5 class="w-75 p-2">Menghitung Probabilitas Atribut <?= $v_c->nama ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-block table-border-style">
                            <table class="table table-striped table-bordered nowrap" style="width: 100%;">
                                <thead>
                                    <tr align="center">
                                        <th>Klastifikasi</th>
                                        <?php foreach ($ini->_criteria_sub()[$v_c->id_criteria] as $nilai => $param) { ?>
                                            <th><?= $param ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $c = $ini->processCountCriteriaProbabilitas($a, $b);

                                    foreach ($a as $key => $value) : ?>
                                        <tr align="center">
                                            <td><?= $key ?></td>
                                            <?php foreach ($ini->_criteria_sub()[$v_c->id_criteria] as $nilai => $param) { ?>
                                                <td>
                                                    <?= $c[$v_c->id_criteria][$key][$param] ?>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="w-75 p-2">Data Test</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-block table-border-style">
                        <table class="table table-striped table-bordered" style="width: 100%;">
                            <thead>
                                <tr align="center">
                                    <?php foreach ($criteria as $key => $value) : ?>
                                        <th><?= $value->nama ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr align="center">
                                    <?php foreach ($criteria as $k_c => $v_c) : ?>
                                        <th><?= $ini->_criteria_sub()[$v_c->id_criteria][$data_test[$v_c->id_criteria]] ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                $d = $ini->processGetResultProbabilitas($a, $c);
                foreach ($a as $k_a => $v_a) :
                    foreach ($criteria as $k_c => $v_c) :
                        $konsultasiResult[$k_a][$v_c->id_criteria] = $d[$k_a][$v_c->id_criteria][$ini->_criteria_sub()[$v_c->id_criteria][$data_test[$v_c->id_criteria]]];
                    endforeach;
                endforeach;
                ?>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="w-75 p-2">Hasil Konsultasi</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-block table-border-style">
                        <table class="table table-striped table-bordered" style="width: 100%;">
                            <thead>
                                <tr align="center">
                                    <?php foreach ($criteria as $key => $value) : ?>
                                        <th><?= $value->nama ?></th>
                                    <?php endforeach; ?>
                                    <?php foreach ($a as $key => $value) : ?>
                                        <th><?= $key ?></th>
                                    <?php endforeach; ?>
                                    <th>Prediksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr align="center">
                                    <?php foreach ($criteria as $k_c => $v_c) : ?>
                                        <td><?= $ini->_criteria_sub()[$v_c->id_criteria][$data_test[$v_c->id_criteria]] ?></td>
                                    <?php endforeach; ?>
                                    <?php foreach ($a as $k_a => $v_a) :
                                        $hitung = array_product($konsultasiResult[$k_a]);
                                        $hasil  = round($hitung, 2);
                                        $rank[$k_a] = $hasil;
                                    ?>
                                        <td><?= $hasil ?></td>
                                    <?php endforeach; ?>
                                    <td>
                                        <?php
                                        $maxVal = max($rank);
                                        $maxValKeys = array_keys($rank, $maxVal);
                                        echo '<span style="color: yellow; background-color: green">' . $maxValKeys[0] . '</span>'
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end:: card -->
            </div>
        </div>
    </div>
</div>
<!-- end:: content -->