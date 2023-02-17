<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReturModel extends CI_Model
{
    public function customer()
    {
        return $this->db->get('customers')->result_object();
    }

    public function loadData()
    {
        $customer = $this->input->post('customer', true);
        $startDate = $this->input->post('startDate', true);
        $endDate = $this->input->post('endDate', true);

        $this->db->select('a.*, b.name AS customer, b.address');
        $this->db->from('returs AS a')->join('customers AS b', 'b.id = a.customer_id');
        if ($customer != '') {
            $this->db->where('a.customer_id', $customer);
        }
        if ($startDate != '' && $endDate != '') {
            $start = date('Y-m-d H:i:s', strtotime($startDate . ' 00:00:00'));
            $end = date('Y-m-d H:i:s', strtotime($endDate . ' 23:59:59'));
            $this->db->where('a.created_at >=', $start);
            $this->db->where('a.created_at <=', $end);
        }
        $data = $this->db->order_by('a.created_at', 'DESC')->get();

        $this->db->select('SUM(amount) AS total')->from('returs');
        if ($customer != '') {
            $this->db->where('customer_id', $customer);
        }
        if ($startDate != '' && $endDate != '') {
            $start = date('Y-m-d H:i:s', strtotime($startDate . ' 00:00:00'));
            $end = date('Y-m-d H:i:s', strtotime($endDate . ' 23:59:59'));
            $this->db->where('created_at >=', $start);
            $this->db->where('created_at <=', $end);
        }
        $total = $this->db->get()->row_object();

        return [
            $data->result_object(),
            $data->num_rows(),
            $total->total
        ];
    }

    public function checkTransaction()
    {
        $id = $this->input->post('id', true);
        if ($id == '' || $id == 0) {
            return [
                'status' => 400,
                'message' => 'Pastikan Nomor Faktur sudah diisi'
            ];
        }

        $check = $this->db->get_where('orders', ['id' => $id])->row_object();
        if (!$check) {
            return [
                'status' => 400,
                'message' => 'Nomor Faktur tidak valid'
            ];
        }

        $checkItem = $this->db->get_where('order_detail', [
            'order_id' => $id, 'status !=' => 'RETURED'
        ])->num_rows();
        if ($checkItem <= 0) {
            return [
                'status' => 400,
                'message' => 'Tidak ada produk yang bisa diretur'
            ];
        }

        return [
            'status' => 200,
            'message' => $id
        ];
    }

    public function loadTransaction()
    {
        $id = $this->input->post('id', true);
        $detail = $this->detailOrder($id);
        if (!$detail) {
            return [
                'status' => 400,
                'message' => 'Tidak ada produk yang dipesan'
            ];
        }

        $getOrder = $this->db->get_where('orders', ['id' => $id])->row_object();

        foreach ($detail as $d) {
            $rows[] = [
                'id' => $d->id,
                'product' => $d->name,
                'qty' => $this->getDetailProductOrder($d->product_id, $d->qty),
                'status' => $d->status
            ];
        }

        return [
            'status' => 200,
            'data' => $rows,
            'customer' => $this->getCustomerName($id),
            'invoice' => $id,
            'customer_id' => $getOrder->customer_id
        ];
    }

    public function getCustomerName($id)
    {
        $this->db->select('b.name, a.customer_id, a.status')->from('orders AS a');
        $this->db->join('customers AS b', 'a.customer_id = b.id');
        $data = $this->db->where('a.id', $id)->get()->row_object();

        if (!$data) {
            return 0;
        }

        return $data->name;
    }

    public function detailOrder($invoice)
    {
        $this->db->select('a.*, b.name')->from('order_detail AS a');
        $this->db->join('products AS b', 'a.product_id = b.id');
        $this->db->where('a.order_id', $invoice);
        $result = $this->db->order_by('a.id', 'DESC')->get();

        return $result->result_object();
    }

    public function getDetailProductOrder($id, $qty)
    {
        $this->db->select('a.unit_amount, b.name AS package, c.name AS unit')->from('products AS a');
        $this->db->join('packages AS b', 'a.package_id = b.id');
        $this->db->join('units AS c', 'a.unit_id = c.id');
        $data = $this->db->where('a.id', $id)->get()->row_object();

        // return $this->db->last_query();

        $package = $data->package;
        $unit = $data->unit;
        $unitAmount = $data->unit_amount;

        if ($qty < $unitAmount) {
            $result = $qty . ' ' . $unit;
        } else {
            $countPackage = floor($qty / $unitAmount);
            $packageToUnit = $countPackage * $unitAmount;
            $residual = $qty - $packageToUnit;
            if ($residual <= 0) {
                $result = $countPackage . ' ' . $package;
            } else {
                $result = $countPackage . ' ' . $package . ' + ' . ($qty - $packageToUnit) . ' ' . $unit;
            }
        }

        return $result;
    }

    public function returOrder()
    {
        $invoice = $this->input->post('invoice', true);
        $id = $this->input->post('id', true);
        $customer = $this->input->post('customer', true);
        $package = $this->input->post('package', true);
        $unit = $this->input->post('unit', true);

        $check = $this->db->get_where('order_detail', ['id' => $id])->row_object();
        if (!$check) {
            return [
                'status' => 400,
                'message' => 'Data tidak valid'
            ];
        }

        if ($package <= 0 && $unit <= 0) {
            return [
                'status' => 400,
                'message' => 'Pastikan quantiti sudah diisi'
            ];
        }

        $product = $check->product_id;
        $qty = $check->qty;
        $checkProduct = $this->db->get_where('products', ['id' => $product])->row_object();
        if (!$checkProduct) {
            return [
                'status' => 400,
                'message' => 'Produk tidak valid'
            ];
        }
        $unitAmount = $checkProduct->unit_amount;
        $price = $checkProduct->unit_price;
        $stock = $checkProduct->stock;

        if ($package <= 0) {
            $qtyRetur = $unit;
        } else {
            if ($unit <= 0) {
                $qtyRetur = $unitAmount * $package;
            } else {
                $qtyRetur = ($unitAmount * $package) + $unit;
            }
        }

        if ($qty < $qtyRetur) {
            return [
                'status' => 400,
                'message' => 'Kuantiti tidak valid'
            ];
        }

        $checkRetur = $this->db->get_where('returs', ['order_id' => $invoice])->row_object();
        if (!$checkRetur) {
            $this->db->insert('returs', [
                'order_id' => $invoice,
                'customer_id' => $customer,
                'item' => 1,
                'qty' => $qtyRetur,
                'amount' => $price * $qtyRetur,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $idRetur = $this->db->insert_id();
        } else {
            $idRetur = $checkRetur->id;
            $this->db->where('id', $idRetur)->update('returs', [
                'item' => $checkRetur->qty + 1,
                'qty' => $checkRetur->qty + $qtyRetur,
                'amount' => $checkRetur->amount + ($price * $qtyRetur),
            ]);
        }

        $this->db->insert('retur_detail', [
            'retur_id' => $idRetur,
            'product_id' => $product,
            'qty' => $qtyRetur,
            'nominal' => $price,
            'amount' => $price * $qtyRetur
        ]);

        //UPDATE STOCK
        $this->db->where('id', $product)->update('products', ['stock' => $stock + $qtyRetur]);
        //UPDATE ORDER DETAIL
        $this->db->where('id', $id)->update('order_detail', ['status' => 'RETURED']);

        return [
            'status' => 200,
            'message' => $qtyRetur,
            'id' => $invoice
        ];
    }

    public function detail()
    {
        $id = $this->input->post('id', true);

        $this->db->select('a.*, b.name')->from('retur_detail AS a');
        $this->db->join('products AS b', 'b.id = a.product_id');
        return $this->db->where('retur_id', $id)->get()->result_object();
    }
}
