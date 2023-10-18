<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Criteria_sub extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // untuk mengecek status login
        checking_session($this->username, $this->role, ['admin']);
    }

    public function index()
    {
        $data = [
            'criteria' => $this->m_criteria->get_all(),
        ];

        // untuk load view
        $this->template->load('admin', 'Criteria Sub', 'criteria_sub', 'view', $data);
    }

    public function get_data_dt()
    {
        $this->m_criteria_sub->get_all_data_dt();
    }

    public function show()
    {
        $post = $this->input->post(NULL, TRUE);

        $response = $this->crud->gda('tb_criteria_sub', ['id_criteria_sub' => $post['id']]);

        $this->_response_message($response);
    }

    public function save()
    {
        $post = $this->input->post(NULL, TRUE);

        $data = [
            'id_criteria' => $post['id_criteria'],
            'nama'        => $post['nama'],
            'nilai'       => $post['nilai'],
        ];

        $this->db->trans_start();
        if (empty($post['id_criteria_sub'])) {
            $this->crud->i('tb_criteria_sub', $data);
        } else {
            $this->crud->u('tb_criteria_sub', $data, ['id_criteria_sub' => $post['id_criteria_sub']]);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $response = ['title' => 'Gagal!', 'text' => 'Gagal Simpan!', 'type' => 'error', 'button' => 'Ok!'];
        } else {
            $response = ['title' => 'Berhasil!', 'text' => 'Berhasil Simpan!', 'type' => 'success', 'button' => 'Ok!'];
        }

        $this->_response_message($response);
    }

    public function del()
    {
        $post = $this->input->post(NULL, TRUE);

        $check = checking_data($this->db->database, 'tb_criteria_sub', 'id_criteria_sub', $post['id']);

        if ($check > 0) {
            $response = ['title' => 'Gagal!', 'text' => 'Maaf data yang Anda hapus masih digunakan!', 'type' => 'error', 'button' => 'Ok!'];
        } else {
            $this->db->trans_start();
            $this->crud->d('tb_criteria_sub', $post['id'], 'id_criteria_sub');
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $response = ['title' => 'Gagal!', 'text' => 'Gagal Hapus!', 'type' => 'error', 'button' => 'Ok!'];
            } else {
                $response = ['title' => 'Berhasil!', 'text' => 'Berhasil Hapus!', 'type' => 'success', 'button' => 'Ok!'];
            }
        }

        $this->_response_message($response);
    }
}