<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OrderModel extends CI_Model
{
    public function setting()
    {
        $user = $this->session->userdata('user_id');
        $check = $this->db->get_where('orders', [
            'user_id' => $user, 'status' => 'ACTIVE'
        ])->row_object();

        if (!$check) {
            return [
                'invoice' => 0,
                'customer_id' => 0,
                'customer_name' => ''
            ];
        }

        $getCustomer = $this->db->get_where('customers', ['id' => $check->customer_id])->row_object();

        return [
            'invoice' => $check->id,
            'customer_id' => $check->customer_id,
            'customer_name' => $getCustomer->name
        ];
    }

    public function customer()
    {
        return $this->db->get('customers')->result_object();
    }

    public function setInvoice()
    {
        $user = $this->session->userdata('user_id');
        $status = $this->input->post('status', true);
        $customer = $this->input->post('customer', true);
        $invoice = $this->input->post('invoice', true);

        if ($status == 'ADD') {
            //CHECK ACTIVE INVOICE
            $check = $this->db->get_where('orders', [
                'user_id' => $user, 'status' => 'ACTIVE'
            ])->num_rows();

            if ($check > 0) {
                return [
                    'status' => 400,
                    'message' => 'Masih ada faktur yang belum selesai'
                ];
            }

            //CHECK MARKET
            $checkCustomer = $this->db->get_where('customers', ['id' => $customer])->num_rows();
            if ($checkCustomer <= 0) {
                return [
                    'status' => 400,
                    'message' => 'Toko yang dipilih tidak valid'
                ];
            }

            $id = mt_rand(1000, 9999) . date('Y') . date('m') . date('d');
            $this->db->insert('orders', [
                'id' => $id,
                'customer_id' => $customer,
                'amount' => 0,
                'discount' => 0,
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
            $check = $this->db->get_where('orders', ['id' => $invoice])->num_rows();
            if ($check <= 0) {
                return [
                    'status' => 400,
                    'message' => 'Nomor faktur tidak valid'
                ];
            }

            $this->db->where('id', $invoice)->update('orders', [
                'status' => 'ORDERED'
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
		$this->db->like('name', $keyword, 'after');
		$this->db->or_like('color', $keyword, 'after');
		$this->db->or_like('size', $keyword, 'after');
		$data = $this->db->order_by('name ASC, color ASC, size ASC')->limit(10)->get('products')->result_object();

        if ($data) {
            foreach ($data as $d) {
                $response[] = [
					'label' => $d->name.' '.strtoupper($d->color).' - '.convertSize($d->size),
					'value' => $d->name.' '.strtoupper($d->color).' - '.convertSize($d->size),
                    'id' => $d->id
                ];
            }
        }

        return $response;
    }

    public function getDetailProduct()
    {
        $id = $this->input->post('id', true);
		$price = $this->input->post('price', true);

		$product = $this->db->get_where('products', ['id' => $id])->row_object();
		if (!$product) {
			return [
				'status' => 400,
				'message' => 'ID produk tidak valid'
			];
		}

		if ($price === 'price') {
			$price = $product->price;
		}elseif ($price === 'price_two') {
			$price = $product->price_two;
		}else{
			$price = $product->price_three;
		}

		return [
			'status' => 200,
			'message' => 'Sukses',
			'stock' => $this->getProductStock($product->id),
			'price' => $price,
			'price_display' => number_format($price, 0, ',', '.')
		];
    }

    public function getProductStock($id)
    {
        $stockProduct = $this->db->select('stock')->from('products')->where('id', $id)->get()->row_object();
        $this->db->select_sum('qty')->from('stock_temp');
        $stockTemp = $this->db->where('product_id', $id)->get()->row_object();

        if (!$stockTemp) {
            $stockTemp = 0;
        } else {
            $stockTemp = $stockTemp->qty;
        }

        // JIKA TIDAK ADA ATAU NOL BERARTI STOK PAKET DAN UNIT AMBIL DARI TABLE PRODUCTS
        return $stockProduct->stock - $stockTemp;
    }

    public function loadData()
    {
        $status = $this->input->post('status', true);
        $customer = $this->input->post('customer', true);
        $startDate = $this->input->post('startDate', true);
        $endDate = $this->input->post('endDate', true);

        $this->db->select('a.*, b.name AS customer, b.address');
        $this->db->from('orders AS a')->join('customers AS b', 'b.id = a.customer_id');
        $this->db->where('a.status !=', 'ACTIVE');
        if ($status != '') {
            $this->db->where('a.status', $status);
        }
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

        $this->db->select('SUM(amount) AS total')->from('orders');
        $this->db->where('status !=', 'ACTIVE');
        if ($status != '') {
            $this->db->where('status', $status);
        }
        if ($startDate != '' && $endDate != '') {
            $start = date('Y-m-d H:i:s', strtotime($startDate . ' 00:00:00'));
            $end = date('Y-m-d H:i:s', strtotime($endDate . ' 23:59:59'));
            $this->db->where('created_at >=', $start);
            $this->db->where('created_at <=', $end);
        }
        if ($customer != '') {
            $this->db->where('customer_id', $customer);
        }
        $total = $this->db->get()->row_object();

        return [
            $data->result_object(),
            $data->num_rows(),
            $total->total
        ];
    }

    public function loadAdd()
    {
        $invoice = $this->input->post('invoice', true);

        $this->db->select('a.*, b.name, b.color, b.size')->from('order_detail AS a');
        $this->db->join('products AS b', 'a.product_id = b.id');
        $this->db->where('a.order_id', $invoice);
        $result = $this->db->order_by('a.id', 'DESC')->get();

        $data = $result->result_object();
        $row = $result->num_rows();
        if ($data) {
			$total = 0;
            foreach ($data as $d) {
                $rows[] = [
                    'id' => $d->id,
                    'product' => $d->name.' '.strtoupper($d->color).' - '.convertSize($d->size),
                    'qty' => $d->qty,
                    'price' => number_format($d->price, 0, ',', '.'),
                    'amount' => number_format($d->amount, 0, ',', '.')
                ];
				$total += $d->amount;
            }

            return [
                'status' => 200,
                'data' => $rows,
                'amount' => number_format($total, 0, ',', '.'),
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

    public function loadDetail()
    {
        $invoice = $this->input->post('invoice', true);
        $this->db->select('a.*, b.name, b.color, b.size')->from('order_detail AS a');
        $this->db->join('products AS b', 'a.product_id = b.id');
        $this->db->where('a.order_id', $invoice);
        $result = $this->db->order_by('a.id', 'DESC')->get();

        $data = $result->result_object();
        $row = $result->num_rows();
        if ($data) {
			$total = 0;
            foreach ($data as $d) {
                $rows[] = [
                    'id' => $d->id,
                    'product' => $d->name.' '.strtoupper($d->color).' - '.convertSize($d->size),
                    'qty' => $d->qty,
                    'price' => number_format($d->price, 0, ',', '.'),
                    'amount' => number_format($d->amount, 0, ',', '.')
                ];
				$total += $d->amount;
            }

            return [
                'status' => 200,
                'data' => $rows,
                'amount' => number_format($total, 0, ',', '.'),
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
        $orderId = $this->input->post('order_id', true);
        $productId = $this->input->post('product_id', true);
        $price = $this->input->post('price', true);
        $qty = $this->input->post('qty', true);

        //GET PRODUCTS
        $product = $this->db->get_where('products', ['id' => $productId])->row_object();
        if (!$product) {
            return [
                'status' => 400,
                'message' => 'Produk tidak valid'
            ];
        }

        if ($qty <= 0) {
            return [
                'status' => 400,
                'message' => 'QTY tidak boleh NOL/Kosong'
            ];
        }

		$getQty = $this->getProductStock($productId);
		if ($qty > $getQty) {
			return [
				'status' => 400,
				'message' => 'Stok tidak cukup'
			];
		}

        //CHECK LAST PRODUCT IN SAME TRANSACTION
        $checkProductSameTransaction = $this->db->get_where('order_detail', [
            'order_id' => $orderId, 'product_id' => $productId
        ])->row_object();

		if ($checkProductSameTransaction) {
			//UPDATE DATA
			$this->db->where('id', $checkProductSameTransaction->id)->update('order_detail', [
				'qty' => $checkProductSameTransaction->qty + $qty,
				'amount' => ($price * $qty) + $checkProductSameTransaction->amount
			]);

			//GET STOCK TEMP FOR SAME PRODUCK IN THIS TRANSACTION
			$getStockTemp = $this->db->get_where('stock_temp', [
				'order_id' => $orderId, 'product_id' => $productId
			])->row_object();
			if ($getStockTemp){
				$idStockTemp = $getStockTemp->id;
				$this->db->where('id', $idStockTemp)->update('stock_temp', ['qty' => $qty + $getStockTemp->qty]);
			}
		}else {
			$this->db->insert('order_detail', [
				'order_id' => $orderId,
				'product_id' => $productId,
				'qty' => $qty,
				'price' => $price,
				'amount' => $price * $qty,
				'created_at' => date('Y-m-d H:i:s')
			]);

			$this->db->insert('stock_temp', [
				'order_id' => $orderId,
				'product_id' => $productId,
				'qty' => $qty
			]);
		}
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
        $check = $this->db->get_where('order_detail', ['id' => $id])->row_object();
        if (!$check) {
            return [
                'status' => 400,
                'message' => 'Data transaksi tidak valid'
            ];
        }
        $order = $check->order_id;
        $product = $check->product_id;

        $this->db->where(['order_id' => $order, 'product_id' => $product])->delete('stock_temp');
        if ($this->db->affected_rows() <= 0) {
            return [
                'status' => 400,
                'message' => 'Internal server error'
            ];
        }

        $this->db->where('id', $id)->delete('order_detail');
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

    public function deleteOrder()
    {
        $invoice = $this->input->post('id', true);
        $this->db->where('order_id', $invoice)->delete('order_detail');
        $this->db->where('id', $invoice)->delete('orders');
        if ($this->db->affected_rows() <= 0) {
            return [
                'status' => 400,
                'message' => 'Internal server error'
            ];
        }

        $this->db->where('order_id', $invoice)->delete('stock_temp');

        return [
            'status' => 200,
            'message' => 'Sukses'
        ];
    }

    public function saveOrder()
    {
        $invoice = $this->input->post('id', true);
        $checkOrder = $this->db->get_where('orders', ['id' => $invoice])->num_rows();
        $checkOrderDetail = $this->db->get_where('order_detail', ['order_id' => $invoice])->num_rows();

        if ($checkOrder <= 0) {
            return [
                'status' => 400,
                'message' => 'Nomor faktur tidak valid'
            ];
        }

        if ($checkOrderDetail <= 0) {
            return [
                'status' => 400,
                'message' => 'Belum ada item yang diorder'
            ];
        }

        //AMBIL JUMLAH QTY DI ORDER_DETAIL
        $getCount = $this->getTotalOrder($invoice);
        $amount = $getCount->amount;

        $this->db->where('id', $invoice)->update('orders', [
            'amount' => $amount,
			'discount' => 0,
			'payment' => 'CASH',
			'nominal' => $amount,
			'updated_at' => date('Y-m-d H:i:s'),
            'status' => 'DONE'
        ]);
        if ($this->db->affected_rows() <= 0) {
            return [
                'status' => 400,
                'message' => 'Internal server error'
            ];
        }

        return [
            'status' => 200,
            'message' => 'Sukses',
			'url' => base_url().'order/printout/'.encrypt_url($invoice)
        ];
    }

    public function getTotalOrder($id)
    {
        $this->db->select('SUM(qty) AS qty, SUM(amount) AS amount')->from('order_detail');
        return $this->db->where('order_id', $id)->get()->row_object();
    }

	public function printOut($id)
	{
		//GET TABLE ORDERS AND CUSTOMERS
		$this->db->select('a.*, b.name')->from('orders AS a')->join('customers AS b', 'a.customer_id = b.id');
		$getOrder = $this->db->where('a.id', $id)->get()->row_object();
		if (!$getOrder) {
			return [
				'status' => 400,
				'message' => 'Data customer dan pesanan tidak valid'
			];
		}

		$this->db->select('a.*, b.name AS product, b.color, b.size')->from('order_detail AS a');
		$this->db->join('products AS b', 'a.product_id = b.id');
		$this->db->where('a.order_id', $id);
		$result = $this->db->order_by('a.id', 'ASC')->get();
		$datas = $result->result_object();
		$count = $result->num_rows();
		if (!$datas) {
			return [
				'status' => 400,
				'message' => 'Data barang tidak valid'
			];
		}

		$total = 0;
		$item = 0;
		foreach ($datas as $d) {
			$data[] = [
				'product' => $d->product.' '.strtoupper($d->color).'  NO. '.convertSize($d->size),
				'qty' => $d->qty,
				'price' => $d->price,
				'amount' => $d->amount
			];
			$total += $d->amount;
			$item += $d->qty;
		}

		return [
			'status' => 200,
			'message' => 'Sukses',
			'id' => $id,
			'customer' => $getOrder->name,
			'sales' => $this->session->userdata('name'),
			'date' => dateTimeShortenFormat($getOrder->updated_at),
			'amount' => $total,
			'discount' => $getOrder->discount,
			'nominal' => $getOrder->nominal,
			'count' => $count,
			'item' => $item,
			'data' => $data
		];
	}
}
