<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('MasterModel', 'mm');
        CekLoginAkses();
    }

    public function index()
    {
        $data = [
            'title' => 'Master Data | StarJaya'
        ];
        $this->load->view('master/master', $data);
    }

    public function loadData()
    {
        $data = [
            'customer' => $this->mm->loadData()[0],
            'amountCustomer' => $this->mm->loadData()[1],
            'market' => $this->mm->loadData()[2],
            'amountMarket' => $this->mm->loadData()[3]
        ];
        $this->load->view('master/ajax-data', $data);
    }

    public function loadCategory()
    {
        $data = [
            'category' => $this->mm->loadCategory()
        ];
        $this->load->view('master/ajax-category', $data);
    }

    public function loadColor()
    {
        $data = [
            'color' => $this->mm->loadColor()
        ];
        $this->load->view('master/ajax-color', $data);
    }

    public function loadPackage()
    {
        $data = [
            'package' => $this->mm->loadPackage()
        ];
        $this->load->view('master/ajax-package', $data);
    }

    public function loadUnit()
    {
        $data = [
            'unit' => $this->mm->loadUnit()
        ];
        $this->load->view('master/ajax-unit', $data);
    }

    public function loadMarket()
    {
        $data = [
            'market' => $this->mm->loadMarket()
        ];
        $this->load->view('master/ajax-market', $data);
    }

    public function loadCustomer()
    {
        $data = [
            'customer' => $this->mm->loadCustomer()
        ];
        $this->load->view('master/ajax-customer', $data);
    }

    public function save()
    {
        $result = $this->mm->save();

        echo json_encode($result);
    }

    public function edit()
    {
        $result = $this->mm->edit();

        echo json_encode($result);
    }

    public function editOther()
    {
        $result = $this->mm->editOther();

        echo json_encode($result);
    }

    public function saveOther()
    {
        $result = $this->mm->saveOther();

        echo json_encode($result);
    }
}
