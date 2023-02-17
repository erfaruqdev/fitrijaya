<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StatisticModel extends CI_Model
{
    public function analytic()
    {
        $startDate = $this->input->post('startDate', true);
        $endDate = $this->input->post('endDate', true);

        //PENJUALAN
        $this->db->select('SUM(amount) AS amount, SUM(canceled_amount) AS canceled, SUM(discount) AS discount');
        $this->db->from('orders')->where('status', 'DONE');
        if ($startDate != '' && $endDate != '') {
            $start = date('Y-m-d H:i:s', strtotime($startDate . ' 00:00:00'));
            $end = date('Y-m-d H:i:s', strtotime($endDate . ' 23:59:59'));
            $this->db->where('created_at >=', $start);
            $this->db->where('created_at <=', $end);
        }
        $sale = $this->db->get()->row_object();

        //PEMBELIAN
        $this->db->select('SUM(amount) AS amount')->from('purchases');
        if ($startDate != '' && $endDate != '') {
            $start = date('Y-m-d H:i:s', strtotime($startDate . ' 00:00:00'));
            $end = date('Y-m-d H:i:s', strtotime($endDate . ' 23:59:59'));
            $this->db->where('created_at >=', $start);
            $this->db->where('created_at <=', $end);
        }
        $buy = $this->db->get()->row_object();

        //STOK AKHIR
        $this->db->select('SUM(unit_price * stock) AS amount')->from('products');
        $stock = $this->db->get()->row_object();

        //RETUR
        $this->db->select('SUM(amount) AS amount')->from('returs');
        $retur = $this->db->get()->row_object();

        return [$buy, $stock, $sale, $retur];
    }
}
