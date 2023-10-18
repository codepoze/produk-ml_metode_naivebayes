<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Assessment extends MY_Controller
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
            'assessment' => $this->_get_assessment()
        ];
        // untuk load view
        $this->template->load('admin', 'Assessment', 'assessment', 'view', $data);
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
}
