<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
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
            'criteria'       => $this->m_criteria->get_all()->num_rows(),
            'criteria_sub'   => $this->m_criteria_sub->get_all()->num_rows(),
            'classification' => $this->m_criteria_sub->get_all()->num_rows(),
            'consultation'   => $this->m_consultation->get_all()->num_rows(),
            'datatraining'   => count($this->_get_datatraining()),
        ];
        // untuk load view
        $this->template->load('admin', 'Dashboard Admin', 'dashboard', 'view', $data);
    }
}
