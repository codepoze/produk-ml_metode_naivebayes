<?php
// untuk alternatif
$sql_alternatif = "SELECT id_alternatif, nama FROM tb_alternatif";
$res_alternatif = $pdo->Query($sql_alternatif);
$alternatif     = [];
while ($row_a = $res_alternatif->fetch(PDO::FETCH_OBJ)) {
    $alternatif[$row_a->id_alternatif] = $row_a->nama;
}

// untuk kriteria
$sql_kriteria = "SELECT id_kriteria, nama FROM tb_kriteria";
$res_kriteria = $pdo->Query($sql_kriteria);
$kriteria     = [];
while ($row_k = $res_kriteria->fetch(PDO::FETCH_OBJ)) {
    $kriteria[$row_k->id_kriteria] = [
        'nama'  => $row_k->nama,
    ];
}

// untuk kriteria sub
$sql_kriteria_sub = "SELECT id_kriteria_sub, id_kriteria, nama, nilai FROM tb_kriteria_sub";
$res_kriteria_sub = $pdo->Query($sql_kriteria_sub);
$kriteria_sub     = [];
while ($row_s = $res_kriteria_sub->fetch(PDO::FETCH_OBJ)) {
    $kriteria_sub[$row_s->id_kriteria][$row_s->nilai] = $row_s->nama;
}

// untuk ambil data evaluasi
$sql_evaluasi = "SELECT e.id_alternatif, e.count FROM tb_evaluasi AS e GROUP BY e.count, e.id_alternatif ORDER BY e.id_alternatif, e.count";
$res_evaluasi = $pdo->Query($sql_evaluasi);
$evaluasi     = [];
while ($row_e = $res_evaluasi->fetch(PDO::FETCH_OBJ)) {
    $sql_evaluasi_detail = "SELECT e.id_alternatif, e.id_kriteria, e.count, e.nilai FROM tb_evaluasi AS e WHERE e.id_alternatif = '$row_e->id_alternatif' AND e.count = '$row_e->count'";
    $res_evaluasi_detail = $pdo->Query($sql_evaluasi_detail);
    while ($row_d = $res_evaluasi_detail->fetch(PDO::FETCH_OBJ)) {
        $getAtribut[$row_e->id_alternatif][$row_e->count][$row_d->id_kriteria] = [
            'label' => $kriteria_sub[$row_d->id_kriteria][$row_d->nilai],
            'nilai' => $row_d->nilai,
        ];
    }

    $evaluasi[] = [
        'id_alternatif' => $row_e->id_alternatif,
        'alternatif'    => $alternatif[$row_e->id_alternatif],
        'count'         => $row_e->count,
        'atribut'       => $getAtribut[$row_e->id_alternatif][$row_e->count]
    ];
}
?>


<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Algoritma</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="dashboard">Dashboard</a></li>
                    <li class="active">Algoritma</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Data Training</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead align="center">
                                <tr>
                                    <th>No.</th>
                                    <?php foreach ($kriteria as $key => $value) : ?>
                                        <th><?= $value['nama'] ?></th>
                                    <?php endforeach; ?>
                                    <th>Alternatif (Kelas)</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php
                                $no = 1;
                                foreach ($evaluasi as $key => $value) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <?php foreach ($value['atribut'] as $row) : ?>
                                            <td><?= $row['label'] ?></td>
                                        <?php endforeach; ?>
                                        <td><?= $alternatif[$value['id_alternatif']] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                // untuk kelas
                foreach ($evaluasi as $key => $value) {
                    foreach ($alternatif as $key_alternatif => $value_alternatif) {
                        if ($value['id_alternatif'] === $key_alternatif) {
                            $kelas[$value_alternatif][] = $value['alternatif'];
                        }
                    }
                }

                // untuk atribut
                foreach ($evaluasi as $key => $value) {
                    foreach ($kelas as $key_kelas => $value_kelas) {
                        for ($i = 1; $i <= count($kriteria); $i++) {
                            if ($value['alternatif'] === $key_kelas && $value['atribut'][$i]['label'] === $kriteria_sub[$i][$value['atribut'][$i]['nilai']]) {
                                $freg[$i][$key_kelas][$kriteria_sub[$i][$value['atribut'][$i]['nilai']]][] = 'test';
                            }
                        }
                    }
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h5>Menghitung Class</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead align="center">
                                <tr>
                                    <th>Alternatif (Kelas)</th>
                                    <th>Jumlah</th>
                                    <th>Total Data</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php foreach ($kelas as $keyKelas => $valueKelas) : ?>
                                    <tr>
                                        <td><?= $keyKelas ?></td>
                                        <td><?= count($valueKelas) ?></td>
                                        <td><?= count($evaluasi) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php for ($i = 1; $i <= count($kriteria); $i++) { ?>
                    <div class="card">
                        <div class="card-header">
                            <h5>Jumlah Data Atribut <?= $kriteria[$i]['nama'] ?></h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hover">
                                <thead align="center">
                                    <tr>
                                        <th>Alternatif (Kelas)</th>
                                        <?php foreach ($kriteria_sub[$i] as $nilai => $param) { ?>
                                            <th><?= $param ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody align="center">
                                    <?php foreach ($kelas as $keyKelas => $valueKelas) { ?>
                                        <tr>
                                            <td><?= $keyKelas ?></td>
                                            <?php foreach ($kriteria_sub[$i] as $nilai => $param) { ?>
                                                <td><?= (empty($freg[$i][$keyKelas][$param]) ? 0 : count($freg[$i][$keyKelas][$param])) ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>

                <div class="card">
                    <div class="card-header">
                        <h5>Probabilitas Kelas</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead align="center">
                                <tr>
                                    <th>Alternatif (Kelas)</th>
                                    <th>Hasil</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php foreach ($kelas as $keyKelas => $valueKelas) { ?>
                                    <tr>
                                        <td><?= $keyKelas ?></td>
                                        <td><?= round(count($valueKelas) / count($evaluasi), 2) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php for ($i = 1; $i <= count($kriteria); $i++) { ?>
                    <div class="card">
                        <div class="card-header">
                            <h5>Probabilitas Atribut <?= $kriteria[$i]['nama'] ?></h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hover">
                                <thead align="center">
                                    <tr>
                                        <th>Alternatif (Kelas)</th>
                                        <?php foreach ($kriteria_sub[$i] as $nilai => $param) { ?>
                                            <th><?= $param ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody align="center">
                                    <?php foreach ($kelas as $keyKelas => $valueKelas) { ?>
                                        <tr>
                                            <td><?= $keyKelas ?></td>
                                            <?php foreach ($kriteria_sub[$i] as $nilai => $param) {
                                                $hasil_sebelum = (empty($freg[$i][$keyKelas][$param]) ? 0 : count($freg[$i][$keyKelas][$param]));
                                                $jumlah_kelas  = count($valueKelas);
                                                $hitung        = ($hasil_sebelum !== 0 ? ($hasil_sebelum / $jumlah_kelas) : 0);
                                                $hasil         = number_format(round($hitung, 1), 1);
                                                // untuk ambil hasil akhir
                                                $last[$keyKelas][$i][$param] = $hasil;
                                            ?>
                                                <td><?= $hasil ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>

                <?php
                foreach ($evaluasi as $key => $value) {
                    foreach ($kelas as $keyKelas => $valueKelas) {
                        foreach ($value['atribut'] as $keyAtribut => $row) {
                            $countDetail[$value['id_alternatif']][$value['count']][$keyKelas][] = $last[$keyKelas][$keyAtribut][$row['label']];
                        }
                    }

                    $result[] = [
                        'id_alternatif' => $value['id_alternatif'],
                        'count'         => $countDetail[$value['id_alternatif']][$value['count']]
                    ];
                }
                ?>

                <div class="card">
                    <div class="card-header">
                        <h5>Hasil</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead align="center">
                                <tr>
                                    <th>Alternatif (Kelas)</th>
                                    <?php foreach ($kriteria as $key => $value) : ?>
                                        <th><?= $value['nama'] ?></th>
                                    <?php endforeach; ?>
                                    <?php foreach ($kriteria as $key => $value) : ?>
                                        <th><?= $value['nama'] ?></th>
                                    <?php endforeach; ?>
                                    <?php foreach ($kelas as $keyKelas => $valueKelas) { ?>
                                        <th><?= $keyKelas ?></th>
                                    <?php } ?>
                                    <th>Prediksi</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php foreach ($evaluasi as $key => $value) { ?>
                                    <tr>
                                        <td><?= $value['alternatif'] ?></td>
                                        <?php foreach ($value['atribut'] as $row) { ?>
                                            <td><?= $row['label'] ?></td>
                                        <?php } ?>
                                        <?php foreach ($value['atribut'] as $keyAtribut => $row) { ?>
                                            <td><?= $last[$value['alternatif']][$keyAtribut][$row['label']] ?></td>
                                        <?php } ?>
                                        <?php foreach ($kelas as $keyKelas => $valueKelas) {
                                            $hitung = array_product($result[$key]['count'][$keyKelas]);
                                            $hasil  = round($hitung, 2);
                                            $rank[$value['id_alternatif']][$value['count']][$keyKelas] = $hasil;
                                        ?>
                                            <td><?= $hitung ?></td>
                                        <?php } ?>
                                        <td>
                                            <?php
                                            $maxVal = max($rank[$value['id_alternatif']][$value['count']]);
                                            $maxValKeys = array_keys($rank[$value['id_alternatif']][$value['count']], $maxVal);
                                            echo ($value['alternatif'] !== $maxValKeys[0] ? '<span style="color: yellow; background-color: red">' . $maxValKeys[0] . '</span>' : '<span>' . $maxValKeys[0] . '</span>');
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>