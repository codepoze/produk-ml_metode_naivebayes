<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_consultation extends CI_Model
{
    public function get_all()
    {
        $result = $this->db->query("SELECT c.id_consultation, c.created_at FROM tb_consultation AS c ORDER BY c.created_at DESC");
        return $result;
    }

    public function get_all_data_dt()
    {
        $this->datatables->select('c.id_consultation, c.created_at');
        $this->datatables->order_by('c.created_at', 'desc');
        $this->datatables->from('tb_consultation AS c ');
        return print_r($this->datatables->generate());
    }
}
