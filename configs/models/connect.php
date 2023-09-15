<?php
/*
* Sistem ini menggunakan koneksi database PHP PDO yang dapat menggunakan berbagai jenis Driver SQL
*/

class Koneksi
{

  // public $host = 'localhost';
  // public $user = 'my_root';
  // public $pass = 'my_pass';
  // public $dbnm = 'codepoz_spk_naivebayes';
  public $host = 'sql208.epizy.com';
  public $user = 'epiz_34009463';
  public $pass = 'bMgmwLP66Mei4';
  public $dbnm = 'epiz_34009463_naivebayes';
  public $kon;

  // fungsi untuk koneksi ke database menggunakan pdo
  public function kondb()
  {
    try {

      $this->kon = new PDO("mysql:host=$this->host;dbname=$this->dbnm", $this->user, $this->pass);
      $this->kon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->kon->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $this->kon->setAttribute(PDO::MYSQL_ATTR_DIRECT_QUERY, false);
      // echo "Koneksi Berhasil";

    } catch (PDOException $e) {
      die("Gagal Koneksi " . $e->getMessage());
    }

    return $this->kon;
    $this->kon->close();
  }
}
