<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Statistic extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModel', 'dm');
        $this->load->model('StatisticModel', 'sm');
        CekLoginAkses();
    }

    public function index()
    {
        $data = [
            'title' => 'Statistik Pendapatan | StarJaya',
            'data' => $this->sm->analytic()
        ];
        $this->load->view('statistic/statistic', $data);
    }
}
