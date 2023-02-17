<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Block extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'title' => 'Akses Dicegah'
        ];
        $this->load->view('block/block', $data);
    }
}
