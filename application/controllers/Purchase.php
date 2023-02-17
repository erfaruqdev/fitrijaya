<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchase extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModel', 'dm');
        $this->load->model('PurchaseModel', 'pm');
        CekLoginAkses();
    }

    public function index()
    {
        $setting = $this->pm->setting();

        if ($setting['invoice'] != 0) {
            redirect('purchase/add');
        } else {
            $data = [
                'title' => 'Transaksi Pembelian',
                'market' => $this->pm->market()
            ];
            $this->load->view('purchase/purchase', $data);
        }
    }

    public function loadData()
    {
        $data = [
            'datas' => $this->pm->loadData()[0],
            'amount' => $this->pm->loadData()[1],
            'total' => $this->pm->loadData()[2]
        ];
        $this->load->view('purchase/ajax-data', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Transaksi Pembelian',
            'setting' => $this->pm->setting(),
            'market' => $this->pm->market()
        ];
        $this->load->view('purchase/purchase-add', $data);
    }

    public function loadAdd()
    {
        $data = [
            'status' => $this->pm->loadAdd()['status'],
            'data' => $this->pm->loadAdd()['data'],
            'amount' => $this->pm->loadAdd()['amount'],
            'item' => $this->pm->loadAdd()['item']
        ];
        $this->load->view('purchase/ajax-add', $data);
    }

    public function detail()
    {
        $data = [
            'status' => $this->pm->loadAdd()['status'],
            'data' => $this->pm->loadAdd()['data'],
            'amount' => $this->pm->loadAdd()['amount'],
            'item' => $this->pm->loadAdd()['item']
        ];
        $this->load->view('purchase/ajax-detail', $data);
    }

    public function setInvoice()
    {
        $result = $this->pm->setInvoice();

        echo json_encode($result);
    }

    public function getProduct()
    {
        $result = $this->pm->getProduct();

        echo json_encode($result);
    }

    public function save()
    {
        $result = $this->pm->save();

        echo json_encode($result);
    }

    public function deleteDetail()
    {
        $result = $this->pm->deleteDetail();

        echo json_encode($result);
    }

    public function deleteTransaction()
    {
        $result = $this->pm->deleteTransaction();

        echo json_encode($result);
    }

    public function saveTransaction()
    {
        $result = $this->pm->saveTransaction();

        echo json_encode($result);
    }

    public function print()
    {
        $invoice = $this->input->post('invoice', true);

        redirect('payment/printout/' . encrypt_url($invoice));
    }

    public function printOut($invoice)
    {
        $invoice = decrypt_url($invoice);
        $data = [
            'title' => 'Print',
            'data' => $this->pm->dataPrint($invoice)
        ];
        $this->load->view('print/invoice', $data);
    }

    public function coba()
    {
        $price = 4900000;
        $unit = 6;
        // $priceUnit = $price / $unit;

        // $amount = ceil($priceUnit * 2);
        $amount = 7500;
        $end = substr($amount, -3);
        echo $end . '<br>';

        if ($end != 000) {
            if ($end < 500) {
                echo 'Di bawah 500';
            } else if ($end > 500) {
                echo 'Di atas 500';
            } else {
                echo '500';
            }
        } else {
            echo 'Genap';
        }
    }
}
