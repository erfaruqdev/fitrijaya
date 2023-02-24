<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PurchaseModel extends CI_Model
{
    public function setting()
    {
        $user = $this->session->userdata('user_id');
        $check = $this->db->get_where('purchases', [
            'user_id' => $user, 'status' => 'ACTIVE'
        ])->row_object();

        if (!$check) {
            return [
                'invoice' => 0,
                'market_id' => 0,
                'market_name' => ''
            ];
        }

        $getMarket = $this->db->get_where('markets', ['id' => $check->market_id])->row_object();

        return [
            'invoice' => $check->id,
            'market_id' => $check->market_id,
            'market_name' => $getMarket->name
        ];
    }

    public function market()
    {
        return $this->db->get('markets')->result_object();
    }

    public function setInvoice()
    {
        $user = $this->session->userdata('user_id');
        $status = $this->input->post('status', true);
        $market = $this->input->post('market', true);
        $invoice = $this->input->post('invoice', true);
        if ($status == 'ADD') {
            //CHECK ACTIVE INVOICE
            $check = $this->db->get_where('purchases', [
                'user_id' => $user, 'status' => 'ACTIVE'
            ])->num_rows();

            if ($check > 0) {
                return [
                    'status' => 400,
                    'message' => 'Masih ada faktur yang belum selesai'
                ];
            }

            //CHECK MARKET
            $checkMarket = $this->db->get_where('markets', ['id' => $market])->num_rows();
            if ($checkMarket <= 0) {
                return [
                    'status' => 400,
                    'message' => 'Toko yang dipilih tidak valid'
                ];
            }

            $id = date('Y') . date('m') . date('d') . mt_rand(1000, 9999);
            $this->db->insert('purchases', [
                'id' => $id,
                'market_id' => $market,
                'amount' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'user_id' => $user,
                'status' => 'ACTIVE'
            ]);
            if ($this->db->affected_rows() <= 0) {
                return [
                    'status' => 400,
                    'message' => 'Internal server error'
                ];
            }

            return [
                'status' => 200,
                'message' => 'Sukses'
            ];
        } elseif ($status == 'DONE') {
            $check = $this->db->get_where('purchases', ['id' => $invoice])->num_rows();
            if ($check <= 0) {
                return [
                    'status' => 400,
                    'message' => 'Nomor faktur tidak valid'
                ];
            }

            $this->db->where('id', $invoice)->update('purchases', [
                'status' => 'INACTIVE'
            ]);

            if ($this->db->affected_rows() <= 0) {
                return [
                    'status' => 400,
                    'message' => 'Internal server error'
                ];
            }

            return [
                'status' => 200,
                'message' => 'Sukses'
            ];
        } else {
            return [
                'status' => 400,
                'message' => 'Method tidak valid'
            ];
        }
    }

	public function getProduct()
	{
		$keyword = $this->input->post('keyword', true);

		$this->db->select('*');
		$this->db->like('keyword', $keyword);
		$data = $this->db->order_by('size ASC, color ASC, name ASC')->limit(10)->get('products')->result_object();

		if ($data) {
			foreach ($data as $d) {
				$response[] = [
					'label' => $d->name.' '.strtoupper($d->color).' '.convertSize($d->size, $d->category_id),
					'value' => $d->name.' '.strtoupper($d->color).' '.convertSize($d->size, $d->category_id),
					'id' => $d->id,
					'price' => $this->lastPrice($d->id)
				];
			}
		}

		return $response;
	}

    public function lastPrice($id)
    {
//        $getLastPrice = $this->db->order_by('created_at', 'DESC')->get_where('log_price', [
//            'product_id' => $id
//        ])->row_object();

		$getLastPrice = $this->db->order_by('created_at', 'DESC')->get_where('purchase_detail', [
            'product_id' => $id
        ])->row_object();
        if ($getLastPrice) {
            return $getLastPrice->nominal;
        }else {
            return 0;
        }
    }

    public function loadData()
    {
        $market = $this->input->post('market', true);
        $startDate = $this->input->post('startDate', true);
        $endDate = $this->input->post('endDate', true);

        $this->db->select('a.*, b.name AS market, b.address');
        $this->db->from('purchases AS a')->join('markets AS b', 'b.id = a.market_id');
        $this->db->where('a.status !=', 'ACTIVE');
        if ($market != '') {
            $this->db->where('a.market_id', $market);
        }

        if ($startDate != '' && $endDate != '') {
            $startConvert = DateTime::createFromFormat('Y-m-d', $startDate);
            $endConvert = DateTime::createFromFormat('Y-m-d', $endDate);
            $start = $startConvert->format('Y-m-d H:i:s');
            $end = $endConvert->format('Y-m-d H:i:s');

            $this->db->where('a.created_at >=', $start);
            $this->db->where('a.created_at <=', $end);
        }
        $data = $this->db->order_by('a.created_at', 'DESC')->get();

        $this->db->select('SUM(amount) AS total')->from('purchases');
        $this->db->where('status !=', 'ACTIVE');
        if ($market != '') {
            $this->db->where('market_id', $market);
        }
        $total = $this->db->get()->row_object();

        return [
            $data->result_object(),
            $data->num_rows(),
            $total->total
        ];
    }

    public function comparePrice($invoice, $id, $nominal)
    {
        $get = $this->db->order_by('id', 'DESC')->get_where('purchase_detail', [
            'purchase_id !=' => $invoice,'product_id' => $id
        ])->row_object();
        
        if($get) {
            $price = $get->nominal;
            if ($price == $nominal) {
                return '<small class="text-success"><i class="fas fa-arrows-alt-h"></i> Stabil</small>';
            } else {
                if ($nominal > $price) {
                    return '<small class="text-danger"><i class="fas fa-arrow-up"></i> Naik</small>';
                } else {
                    return '<small class="text-danger"><i class="fas fa-arrow-down"></i> Turun</small>';
                }
            }
        }else{
            return '<small class="text-success"><i class="fas fa-check"></i> Awal</small>';
        }
    }

    public function loadAdd()
    {
        $invoice = $this->input->post('invoice', true);
        $this->db->select('a.*, b.name, b.color, b.size')->from('purchase_detail AS a');
        $this->db->join('products AS b', 'a.product_id = b.id');
        $this->db->where('a.purchase_id', $invoice);
        $result = $this->db->order_by('a.id', 'DESC')->get();

        $data = $result->result_object();
        $row = $result->num_rows();
        if ($data) {
            foreach ($data as $d) {
                $product = $d->product_id;
                $nominal = $d->nominal;
                $rows[] = [
                    'id' => $d->id,
                    'product' => $d->name.' '.strtoupper($d->color).' NO '.$d->size,
                    'qty' => $d->qty,
                    'nominal' => number_format($d->nominal, 0, ',', '.'),
                    'amount' => number_format($d->amount, 0, ',', '.'),
                    'status' => $this->comparePrice($invoice, $product, $nominal)
                ];
            }

            $amount = $this->db->select_sum('amount')->from('purchase_detail')->where('purchase_id', $invoice)->get()->row_object();

            return [
                'status' => 200,
                'data' => $rows,
                'amount' => number_format($amount->amount, 0, ',', '.'),
                'item' => $row
            ];
        } else {
            return [
                'status' => 400,
                'data' => 0,
                'amount' => 0,
                'item' => 0
            ];
        }
    }

    public function save()
    {
        $purchase_id = $this->input->post('purchase_id', true);
        $product_id = $this->input->post('product_id', true);
        $qty = $this->input->post('qty', true);
        $nominal = (int)str_replace('.', '', $this->input->post('nominal', true));

        if ($qty <= 0) {
            return [
                'status' => 400,
                'message' => 'Kuantitas tidak boleh NOL/Kosong'
            ];
        }

        if ($nominal <= 0 || $nominal == '') {
            return [
                'status' => 400,
                'message' => 'Nominal belum diisi'
            ];
        }

        $this->db->insert('purchase_detail', [
            'purchase_id' => $purchase_id,
            'product_id' => $product_id,
            'qty' => $qty,
            'nominal' => $nominal,
            'amount' => $nominal * $qty
        ]);

        if ($this->db->affected_rows() <= 0) {
            return [
                'status' => 400,
                'message' => 'Server tidak merespon'
            ];
        }

        return [
            'status' => 200,
            'message' => 'Sukses'
        ];
    }

    public function deleteDetail()
    {
        $id = $this->input->post('id', true);
        $check = $this->db->get_where('purchase_detail', ['id' => $id])->num_rows();
        if ($check <= 0) {
            return [
                'status' => 400,
                'message' => 'Data transaksi tidak valid'
            ];
        }

        $this->db->where('id', $id)->delete('purchase_detail');
        if ($this->db->affected_rows() <= 0) {
            return [
                'status' => 400,
                'message' => 'Internal server error'
            ];
        }

        return [
            'status' => 200,
            'message' => 'Sukses'
        ];
    }

    public function deleteTransaction()
    {
        $invoice = $this->input->post('id', true);
        $this->db->where('purchase_id', $invoice)->delete('purchase_detail');
        $this->db->where('id', $invoice)->delete('purchases');
        if ($this->db->affected_rows() <= 0) {
            return [
                'status' => 400,
                'message' => 'Internal server error'
            ];
        }

        return [
            'status' => 200,
            'message' => 'Sukses'
        ];
    }

    public function saveTransaction()
    {
        $invoice = $this->input->post('id', true);

        $checkPurchase = $this->db->get_where('purchases', ['id' => $invoice])->num_rows();
        $purchaseDetail = $this->db->get_where('purchase_detail', [
            'purchase_id' => $invoice
        ]);

        if ($checkPurchase <= 0) {
            return [
                'status' => 400,
                'message' => 'Nomor faktur tidak valid'
            ];
        }

        if ($purchaseDetail->num_rows() <= 0) {
            return [
                'status' => 400,
                'message' => 'Belum ada item yang dibeli'
            ];
        }

        $data = $purchaseDetail->result_object();
        if ($data) {
            foreach ($data as $d) {
                $qty = $d->qty;
                $this->updateStock($d->product_id, $qty);
            }
        }

        $this->db->select('SUM(amount) AS total')->from('purchase_detail');
        $amount = $this->db->where('purchase_id', $invoice)->get()->row_object();

        $this->db->where('id', $invoice)->update('purchases', [
            'amount' => $amount->total,
            'status' => 'INACTIVE'
        ]);
        if ($this->db->affected_rows() <= 0) {
            return [
                'status' => 400,
                'message' => 'Internal server error'
            ];
        }

        return [
            'status' => 200,
            'message' => 'Sukses'
        ];
    }

    public function updateStock($product_id, $qty)
    {
        $check = $this->db->get_where('products', ['id' => $product_id])->row_object();

        $stock = $check->stock;
        $this->db->where('id', $product_id)->update('products', [
            'stock' => $stock + $qty
        ]);
    }
}
