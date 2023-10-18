<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_classification extends CI_Model
{
    public function get_all()
    {
        $result = $this->db->query("SELECT c.id_classification, c.nama, c.deskripsi FROM tb_classification AS c ORDER BY c.created_at DESC");
        return $result;
    }

    public function get_all_data_dt()
    {
        $this->datatables->select('c.id_classification, c.nama, c.deskripsi');
        $this->datatables->order_by('c.updated_at', 'desc');
        $this->datatables->from('tb_classification AS c');
        return print_r($this->datatables->generate());
    }
}
