<?php
$id    = $_POST['id'];
$count = $_POST['count'];

$sql = "DELETE FROM tb_evaluasi WHERE id_alternatif = '$id' AND count = '$count'";
$pdo->Query($sql);

exit(json_encode(array('title' => 'Berhasil!', 'text' => 'Data berhasil dihapus.', 'type' => 'success', 'button' => 'Ok!')));
