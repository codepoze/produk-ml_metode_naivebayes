<?php
$id    = $_GET['id'];
$count = $_GET['count'];

$sql  = "SELECT e.id_alternatif, e.id_kriteria, e.count, e.nilai FROM tb_evaluasi AS e WHERE e.id_alternatif = '$id' AND e.count = '$count'";
$qry1 = $pdo->Query($sql);
$qry2 = $pdo->Query($sql);

$result = [];
$row = $qry1->fetch(PDO::FETCH_OBJ);
$result['id_alternatif'] = $row->id_alternatif;
$result['count'] = $row->count;

$cow = 0;
while ($rows = $qry2->fetch(PDO::FETCH_OBJ)) {
    $result['nilai_' . $cow++] = $rows->nilai;
}

echo json_encode($result);
