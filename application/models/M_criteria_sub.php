<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_criteria_sub extends CI_Model
{
    public function get_all()
    {
        $result = $this->db->query("SELECT cs.id_criteria_sub, cs.id_criteria, c.nama AS criteria, cs.nama, cs.nilai FROM tb_criteria_sub AS cs LEFT JOIN tb_criteria AS c ON c.id_criteria = cs.id_criteria ORDER BY cs.updated_at DESC");
        return $result;
    }

    public function get_detail($id) {
        $result = $this->db->query("SELECT cs.id_criteria_sub, cs.id_criteria, cs.nama, cs.nilai FROM tb_criteria_sub AS cs WHERE cs.id_criteria = '$id' ORDER BY cs.id_criteria_sub DESC");
        return $result;
    }

    public function get_all_data_dt()
    {
        $this->datatables->select('cs.id_criteria_sub, c.nama AS criteria, cs.nama, cs.nilai');
        $this->datatables->join('tb_criteria AS c', 'c.id_criteria = cs.id_criteria', 'left');
        $this->datatables->order_by('cs.updated_at', 'desc');
        $this->datatables->from('tb_criteria_sub AS cs');
        return print_r($this->datatables->generate());
    }
}