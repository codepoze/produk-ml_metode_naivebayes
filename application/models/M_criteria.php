<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_criteria extends CI_Model
{
    public function get_all()
    {
        $result = $this->db->query("SELECT c.id_criteria, c.nama FROM tb_criteria AS c ORDER BY c.updated_at DESC");
        return $result;
    }

    public function get_all_data_dt()
    {
        $this->datatables->select('c.id_criteria, c.nama');
        $this->datatables->order_by('c.updated_at', 'desc');
        $this->datatables->from('tb_criteria AS c');
        return print_r($this->datatables->generate());
    }
}