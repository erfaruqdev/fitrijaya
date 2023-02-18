<?php

use phpDocumentor\Reflection\Types\This;

defined('BASEPATH') or exit('No direct script access allowed');

class ProductModel extends CI_Model
{
    public function categories()
    {
        return $this->db->get('categories')->result_object();
    }

	public function brands()
    {
        return $this->db->order_by('order', 'ASC')->get('brands')->result_object();
    }

    public function packages()
    {
        return $this->db->get('packages')->result_object();
    }

    public function units()
    {
        return $this->db->get('units')->result_object();
    }

    public function colors()
    {
        return $this->db->order_by('name', 'ASC')->get('colors')->result_object();
    }

    public function save()
    {
        $id = $this->input->post('id', true);
        $name = $this->input->post('name', true);
        $brand = $this->input->post('brand', true);
        $category = $this->input->post('category', true);
        $package = $this->input->post('package', true);
        $unit = $this->input->post('unit', true);
        $amount = $this->input->post('amount', true);
        $color = $this->input->post('color', true);
        $size = $this->input->post('size', true);
        $price = str_replace('.', '', $this->input->post('price', true));
        $priceTwo = str_replace('.', '', $this->input->post('price_two', true));
        $priceThree = str_replace('.', '', $this->input->post('price_three', true));
        $price = (int)$price;
		$priceTwo = (int)$priceTwo;
		$priceThree = (int)$priceThree;

        if ($name == '' || $brand == '' || $category == '' || $package == '' || $unit == '' || $amount == '') {
            return [
                'status' => 400,
                'message' => 'Pastikan semua bidang inputan sudah diisi'
            ];
        }

        
        if ($id == 0) {
            $idGenerator = date('Y') . mt_rand(1000, 9999);
            $data = [
                'id' => $idGenerator,
                'name' => strtoupper($name),
				'brand_id' => $brand,
                'category_id' => $category,
                'package_id' => $package,
                'unit_id' => $unit,
                'amount' => $amount,
                'color' => $color,
                'size' => $size,
                'price' => $price,
                'price_two' => $priceTwo,
                'price_three' => $priceThree,
                'stock' => 0,
                'created_at' => date("Y-m-d H:i:s")
            ];
            $this->db->insert('products', $data);
            if ($this->db->affected_rows() > 0) {
                //UPDATE LOG_PRICE
                $getLog = $this->db->order_by('created_at', 'DESC')->get_where('log_price', [
                    'product_id' => $idGenerator
                ])->row_object();
                if($getLog) {
                    $priceLog = $getLog->price;
                    if($priceLog < $price) {
                        $status = 'UP';
                    }elseif($priceLog > $price) {
                        $status = 'DOWN';
                    }else{
                        $status = 'SAME';
                    }
                } else {
                    $status = 'RESTOCK';
                }

                if($status != 'SAME') {
                    $this->db->insert('log_price', [
                        'product_id' => $idGenerator,
                        'price' => $price,
                        'status' => $status,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
                if($this->db->affected_rows() <= 0) {
                    return [
                        'status' => 400,
                        'message' => 'Gagal saat memperbarui log harga'
                    ];
                }

                return [
                    'status' => 200,
                    'message' => 'Satu data berhasil ditambahkan'
                ];
            } else {
                return [
                    'status' => 400,
                    'message' => 'Kesalahan server'
                ];
            }
        } else {
            $data = [
                'name' => strtoupper($name),
				'brand_id' => $brand,
                'category_id' => $category,
                'package_id' => $package,
                'unit_id' => $unit,
                'amount' => $amount,
                'price' => $price,
				'price_two' => $priceTwo,
				'price_three' => $priceThree,
                'color' => $color,
                'size' => $size,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $this->db->where('id', $id)->update('products', $data);
            if ($this->db->affected_rows() > 0) {
                $getLog = $this->db->order_by('created_at', 'DESC')->get_where('log_price', [
                    'product_id' => $id
                ])->row_object();
                if($getLog) {
                    $priceLog = $getLog->price;
                    if($priceLog < $price) {
                        $status = 'UP';
                    }elseif($priceLog > $price) {
                        $status = 'DOWN';
                    }else{
                        $status = 'SAME';
                    }
                } else {
                    $status = 'RESTOCK';
                }

                if($status != 'SAME') {
                    $this->db->insert('log_price', [
                        'product_id' => $id,
                        'price' => $price,
                        'status' => $status,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
                if($this->db->affected_rows() <= 0) {
                    return [
                        'status' => 400,
                        'message' => 'Gagal saat memperbarui log harga'
                    ];
                }

                return [
                    'status' => 200,
                    'message' => 'Satu data berhasil diubah'
                ];
            } else {
                return [
                    'status' => 200,
                    'message' => 'Tidak ada data yang berubah'
                ];
            }
        }
    }

    public function loadData()
    {
        $name = $this->input->post('name', true);
        $category = $this->input->post('category', true);
        $color = $this->input->post('color', true);
        $brand = $this->input->post('brand', true);

        $this->db->select('a.*, b.name AS category, c.name AS package, d.name AS unit')->from('products AS a');
        $this->db->join('categories AS b', 'a.category_id = b.id');
        $this->db->join('packages AS c', 'a.package_id = c.id');
        $this->db->join('units AS d', 'a.unit_id = d.id');

		if ($brand != '') {
			$this->db->where('a.brand_id', $brand);
		}

		if ($category != '') {
			$this->db->where('a.category_id', $category);
		}

		if ($color != '') {
			$this->db->where('a.color', $color);
		}

		if ($name != '') {
			$this->db->like('a.name', $name);
		}

        $result = $this->db->order_by('a.name ASC, a.color ASC, a.size ASC')->get();

        return [
            $result->result_object(),
            $result->num_rows()
        ];
    }

    public function edit()
    {
        $id = $this->input->post('id', true);
        $check = $this->db->get_where('products', [
            'id' => $id
        ])->row_object();

        if (!$check) {
            return [
                'status' => 400,
                'message' => 'Data tidak ditemukan'
            ];
        }

        return [
            'status' => 200,
            'message' => 'Success',
            'data' => [
                'name' => $check->name,
				'brand' => $check->brand_id,
                'category' => $check->category_id,
                'package' => $check->package_id,
                'unit' => $check->unit_id,
                'amount' => $check->amount,
                'color' => $check->color,
                'size' => $check->size,
                'price' => $check->price,
                'price_two' => $check->price_two,
                'price_three' => $check->price_three,
            ]
        ];
    }

    public function print()
    {
        $this->db->select('a.*, b.name AS category, c.name AS package, d.name AS unit')->from('products AS a');
        $this->db->join('categories AS b', 'a.category_id = b.id');
        $this->db->join('packages AS c', 'a.package_id = c.id');
        $this->db->join('units AS d', 'a.unit_id = d.id');
        $result = $this->db->order_by('a.created_at', 'DESC')->get();

        return [
            $result->result_object(),
            $result->num_rows()
        ];
    }
}
