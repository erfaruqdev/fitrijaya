<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HomeModel extends CI_Model
{
    public function topFive()
    {
        $product = $this->db->select('COUNT(id) AS total')->from('products')->get()->row_object();

        $this->db->select('SUM(a.qty) AS amount, b.name')->from('order_detail AS a');
        $this->db->join('products AS b', 'b.id = a.product_id');
        $this->db->group_by('a.product_id')->limit(5)->order_by('amount', 'DESC');
        $top = $this->db->get()->result_object();

        $this->db->select('SUM(a.qty) AS amount, b.name')->from('order_detail AS a');
        $this->db->join('products AS b', 'b.id = a.product_id');
        $this->db->group_by('a.product_id')->limit(5)->order_by('amount', 'ASC');
        $bottom = $this->db->get()->result_object();

        return [
            $product,
            $top,
            $bottom
        ];
    }
}
