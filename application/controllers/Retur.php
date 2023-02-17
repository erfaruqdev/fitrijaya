<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Retur extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModel', 'dm');
        $this->load->model('ReturModel', 'rm');
        CekLoginAkses();
    }

    public function index()
    {
        $data = [
            'title' => 'Retur Barang',
            'customer' => $this->rm->customer()
        ];
        $this->load->view('retur/retur', $data);
    }

    public function loadData()
    {
        $data = [
            'datas' => $this->rm->loadData()[0],
            'amount' => $this->rm->loadData()[1],
            'total' => $this->rm->loadData()[2]
        ];
        $this->load->view('retur/ajax-data', $data);
    }

    public function checkTransaction()
    {
        $result = $this->rm->checkTransaction();

        echo json_encode($result);
    }

    public function loadTransaction()
    {
        $data = [
            'data' => $this->rm->loadTransaction()
        ];
        $this->load->view('retur/ajax-add', $data);
    }

    public function returOrder()
    {
        $result = $this->rm->returOrder();

        echo json_encode($result);
    }

    public function detail()
    {
        $data = [
            'data' => $this->rm->detail()
        ];
        $this->load->view('retur/ajax-detail', $data);
    }
}
