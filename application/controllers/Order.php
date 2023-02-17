<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModel', 'dm');
        $this->load->model('OrderModel', 'om');
        CekLoginAkses();
    }

    public function index()
    {
        $setting = $this->om->setting();

        if ($setting['invoice'] != 0) {
            redirect('order/add');
        } else {
            $data = [
                'title' => 'Transaksi Pemesanan',
                'customer' => $this->om->customer()
            ];
            $this->load->view('order/order', $data);
        }
    }

    public function loadData()
    {
        $data = [
            'datas' => $this->om->loadData()[0],
            'amount' => $this->om->loadData()[1],
            'total' => $this->om->loadData()[2]
        ];
        $this->load->view('order/ajax-data', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Transaksi Pemesanan',
            'setting' => $this->om->setting(),
            'customer' => $this->om->customer()
        ];
        $this->load->view('order/order-add', $data);
    }

    public function loadAdd()
    {
        $data = [
            'status' => $this->om->loadAdd()['status'],
            'data' => $this->om->loadAdd()['data'],
            'amount' => $this->om->loadAdd()['amount'],
            'item' => $this->om->loadAdd()['item']
        ];
        $this->load->view('order/ajax-add', $data);
    }

    public function detail()
    {
        $data = [
            'status' => $this->om->loadDetail()['status'],
            'data' => $this->om->loadDetail()['data'],
            'amount' => $this->om->loadDetail()['amount'],
            'item' => $this->om->loadDetail()['item']
        ];
        $this->load->view('order/ajax-detail', $data);
    }

    public function setInvoice()
    {
        $result = $this->om->setInvoice();

        echo json_encode($result);
    }

    public function getProduct()
    {
        $result = $this->om->getProduct();

        echo json_encode($result);
    }

    public function getDetailProduct()
    {
        $result = $this->om->getDetailProduct();

        echo json_encode($result);
    }

    public function save()
    {
        $result = $this->om->save();

        echo json_encode($result);
    }

    public function deleteDetail()
    {
        $result = $this->om->deleteDetail();

        echo json_encode($result);
    }

    public function deleteOrder()
    {
        $result = $this->om->deleteOrder();

        echo json_encode($result);
    }

    public function saveOrder()
    {
        $result = $this->om->saveOrder();

        echo json_encode($result);
    }

    public function printOut($invoice)
    {
        $invoice = decrypt_url($invoice);
        $data = [
            'title' => 'Print',
            'data' => $this->om->printOut($invoice)
        ];
        $this->load->view('print/invoice', $data);
    }
}
