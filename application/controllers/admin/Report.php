<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends MY_Controller
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
        // untuk load view
        $this->template->load('admin', 'Report History Consultation', 'report', 'view');
    }

    public function get_data_dt()
    {
        $this->m_consultation->get_all_data_dt();
    }
}
