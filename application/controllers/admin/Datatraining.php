<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datatraining extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // untuk mengecek status login
        checking_session($this->username, $this->role, ['admin']);
    }

    // untuk default
    public function index()
    {
        $data = [
            'criteria'       => $this->m_criteria->get_all()->result(),
            'assessment'     => $this->_get_assessment(),
            'datatraining'   => $this->_get_datatraining(),
            'classification' => $this->m_classification->get_all()->result(),
        ];
        // untuk load view
        $this->template->load('admin', 'Data Training', 'datatraining', 'view', $data);
    }

    public function save()
    {
        $post = $this->input->post(NULL, TRUE);

        $id_classification = $post['id_classification'];

        $get_data = $this->db->query("SELECT MAX( datas.count) AS max FROM( SELECT d.id_classification, d.count FROM tb_datatraining AS d WHERE d.id_classification = '$id_classification' GROUP BY d.count, d.id_classification) AS datas");
        $row_data = $get_data->row();
        $count    = ($row_data->max !== NULL ? $row_data->max + 1 : 0);

        $this->db->trans_start();
        for ($i = 0; $i < count($post['id_criteria']); $i++) {
            $data = [
                'id_classification' => $post['id_classification'],
                'id_criteria'       => $post['id_criteria'][$i],
                'count'             => $count,
                'nilai'             => $post['nilai'][$i],
            ];

            $this->crud->i('tb_datatraining', $data);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $response = ['title' => 'Gagal!', 'text' => 'Gagal Simpan!', 'type' => 'error', 'button' => 'Ok!'];
        } else {
            $response = ['title' => 'Berhasil!', 'text' => 'Berhasil Simpan!', 'type' => 'success', 'button' => 'Ok!'];
        }

        $this->_response_message($response);
    }

    public function _get_assessment()
    {
        $criteria = $this->m_criteria->get_all()->result();
        $result = [];
        foreach ($criteria as $key => $value) {
            $criteria_sub = $this->m_criteria_sub->get_detail($value->id_criteria)->result_array();
            $result[] = [
                'id_criteria'  => $value->id_criteria,
                'nama'         => $value->nama,
                'sub_criteria' => $criteria_sub
            ];
        }
        return $result;
    }

    function _get_datatraining()
    {
        $datatraining = $this->db->query("SELECT d.id_classification, d.count, c.nama FROM tb_datatraining AS d LEFT JOIN tb_classification AS c ON c.id_classification = d.id_classification GROUP BY d.count, d.id_classification ORDER BY d.count, d.id_classification ASC");
        $result = [];
        foreach ($datatraining->result() as $k_a => $v_a) {
            $datatraining_detail = $this->db->query("SELECT d.id_classification, d.id_criteria, d.count, d.nilai FROM tb_datatraining AS d WHERE d.count = '$v_a->count' AND d.id_classification = '$v_a->id_classification'");
            foreach ($datatraining_detail->result() as $k_b => $v_b) {
                $data[$v_a->id_classification][$v_a->count][$v_b->id_criteria] = $v_b->nilai;
            }

            $result[] = [
                'classification' => $v_a->nama,
                'data'           => $data[$v_a->id_classification][$v_a->count]
            ];
        }
        return $result;
    }
}
