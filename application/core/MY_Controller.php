<?php
defined('BASEPATH') or exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller
{
    public $id;
    public $id_users;
    public $username;
    public $password;
    public $role;

    public function __construct()
    {
        parent::__construct();

        // untuk variabel global
        $this->id       = $this->session->userdata('id');
        $this->id_users = $this->session->userdata('id_users');
        $this->username = $this->session->userdata('username');
        $this->password = $this->session->userdata('password');
        $this->role     = $this->session->userdata('role');
    }

    // untuk respon json
    public function _response($data)
    {
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit();
    }

    // untuk response message
    public function _response_message($message)
    {
        $message['csrf'] = $this->security->get_csrf_hash();
        $this->_response($message);
    }

    // untuk simpan riwayat barang masuk keluar
    public function _get_datatraining()
    {
        $datatraining = $this->db->query("SELECT d.id_classification, d.count, c.nama FROM tb_datatraining AS d LEFT JOIN tb_classification AS c ON c.id_classification = d.id_classification GROUP BY d.count, d.id_classification ORDER BY d.count, d.id_classification ASC");
        $result = [];
        foreach ($datatraining->result() as $k_a => $v_a) {
            $datatraining_detail = $this->db->query("SELECT d.id_classification, d.id_criteria, d.count, d.nilai FROM tb_datatraining AS d WHERE d.count = '$v_a->count' AND d.id_classification = '$v_a->id_classification'");
            foreach ($datatraining_detail->result() as $k_b => $v_b) {
                $data[$v_a->id_classification][$v_a->count][$v_b->id_criteria] = [
                    'label' => $this->_criteria_sub()[$v_b->id_criteria][$v_b->nilai],
                    'nilai' => $v_b->nilai
                ];
            }

            $result[] = [
                'classification' => $v_a->id_classification,
                'count'          => $v_a->count,
                'kriteria'       => $data[$v_a->id_classification][$v_a->count],
                'nama'           => $v_a->nama,
            ];
        }
        return $result;
    }

    public function _criteria_sub()
    {
        $criteria_sub = $this->m_criteria_sub->get_all()->result();

        $result = [];

        foreach ($criteria_sub as $key => $value) {
            $result[$value->id_criteria][$value->nilai] = $value->nama;
        }

        return $result;
    }
}
