<?php
defined('BASEPATH') or exit('No direct script access allowed');

class About extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        CekLogin();
    }

    public function index()
    {
        $data = [
            'title' => 'Tentang Kami',
            'classAbout' => 'active'
        ];
        $this->load->view('about/about', $data);
    }
}
