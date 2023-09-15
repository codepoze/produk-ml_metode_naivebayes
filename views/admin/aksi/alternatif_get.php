<?php
$id  = $_GET['id'];
$qry = $pdo->GetWhere('tb_alternatif', 'id_alternatif', $id);
$row = $qry->fetch(PDO::FETCH_OBJ);

$result = [];
$result = [
    "id_alternatif" => $row->id_alternatif,
    "nama"          => $row->nama,
];

echo json_encode($result);
