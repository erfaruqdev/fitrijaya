<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModel', 'dm');
        $this->load->model('HomeModel', 'hm');
        CekLogin();
    }

	public function index()
    {
        $data = [
            'title' => 'Star Jaya',
            'class' => 'active',
            'data' => $this->hm->topFive()
        ];
        $this->load->view('home/home', $data);
    }

    public function coba()
    {
        $this->db->select('SUM(a.qty) AS amount, b.name')->from('order_detail AS a');
        $this->db->join('products AS b', 'b.id = a.product_id');
        $this->db->group_by('a.product_id')->limit(5)->order_by('amount', 'DESC');
        $this->db->get()->result_object();

        echo $this->db->last_query();
    }
}
