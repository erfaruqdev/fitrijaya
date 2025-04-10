<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('ProductModel', 'pm');
        CekLoginAkses();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Produk',
            'brands' => $this->pm->brands(),
            'categories' => $this->pm->categories(),
            'packages' => $this->pm->packages(),
            'units' => $this->pm->units(),
            'colors' => $this->pm->colors(),
        ];
        $this->load->view('product/product', $data);
    }

    public function loadData()
    {
        $data = [
            'product' => $this->pm->loadData()[0],
            'amount' => $this->pm->loadData()[1]
        ];
        $this->load->view('product/ajax-data', $data);
    }

    public function print()
    {
        $data = [
            'title' => 'Print Out Data Produk',
            'data' => $this->pm->print()[0],
            'amount' => $this->pm->print()[1]
        ];
        $this->load->view('print/product', $data);
    }

    public function pdf()
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');

        // title dari pdf
        $data = [
            'title' => 'Data Produk',
            'data' => $this->pm->print()[0],
            'amount' => $this->pm->print()[1]
        ];
        // $this->load->view('product/pdf', $data);

        // filename dari pdf ketika didownload
        $file_pdf = 'daftar-produk-star-jaya';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";

        $html = $this->load->view('product/pdf', $data, true);
        //$this->load->view('registration/invoice',$data);	    

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function save()
    {
        $result = $this->pm->save();

        echo json_encode($result);
    }

    public function edit()
    {
        $result = $this->pm->edit();

        echo json_encode($result);
    }

    public function delete()
    {
        $result = $this->pm->delete();

        echo json_encode($result);
    }

	public function setEngine()
	{
		$this->db->select('a.id, a.color, a.size, a.category_id, b.name');
		$this->db->from('products as a')->join('brands as b', 'b.id = a.brand_id');
		$data = $this->db->get()->result_object();
		foreach ($data as $d) {
			$size = convertSizePrint($d->size, $d->category_id);

			$this->db->where('id', $d->id)->update('products', [
				'keyword' => "$size $d->name"
			]);
		}
		redirect('product');
	}

	public function setPrice()
	{
		$data = $this->db->get('products')->result_object();
		foreach ($data as $item) {
			$price = $item->price_three;
			$this->db->where('id', $item->id)->update('products', [
				'price' => $price + 10000,
				'price_two' => $price + 3000
			]);
		}

		redirect('product');
	}

	public function setPriceFitri()
	{
		$data = $this->db->get('products')->result_object();
		foreach ($data as $item) {
			$price = $item->price_three;
			$this->db->where('id', $item->id)->update('products', [
				'price' => $price + 10000,
				'price_two' => $price + 4000
			]);
		}

		redirect('product');
	}

	public function setSizeChange($brandId)
	{
		$products = $this->db->where('brand_id', $brandId)->get('products')->result_object();
		foreach ($products as $product) {
			$size = $product->size + 1;
			$this->db->where('id', $product->id)->update('products', [
				'size' => $size
			]);
		}
		redirect('product');
	}

	public function setPricePlus($brandId, $number)
	{
		$products = $this->db->where('brand_id', $brandId)->get('products')->result_object();
		foreach ($products as $product) {
			$price = $product->price + $number;
			$this->db->where('id', $product->id)->update('products', [
				'price' => $price
			]);
		}
		redirect('product');
	}

	public function setPriceMinus($brandId, $number)
	{
		$products = $this->db->where('brand_id', $brandId)->get('products')->result_object();
		foreach ($products as $product) {
			$price = $product->price - $number;
			$this->db->where('id', $product->id)->update('products', [
				'price' => $price
			]);
		}
		redirect('product');
	}

	public function setStock()
	{
		$this->db->update('products', [
			'stock' => 10000
		]);

		redirect('product');
	}
}
