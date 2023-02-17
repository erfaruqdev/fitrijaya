<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MasterModel extends CI_Model
{
    public function save()
    {
        $id = $this->input->post('id', true);
        $table = $this->input->post('table', true);
        $name = $this->input->post('name', true);
        $address = $this->input->post('address', true);
        $phone = str_replace('-', '', $this->input->post('phone', true));

        if ($table == '' || $name == '' || $address == '' || $phone == '') {
            return [
                'status' => 400,
                'message' => 'Pastikan semua bidang inputan sudah diisi'
            ];
        }

        if ($table == 'markets') {
            $generator = date('Y') . mt_rand(1000, 9999);
        } else {
            $generator = mt_rand(1000, 9999) . date('Y');
        }

        if ($id == 0) {
            $data = [
                'id' => $generator,
                'name' => strtoupper($name),
                'address' => ucwords($address),
                'phone' => $phone,
                'created_at' => date("Y-m-d H:i:s")
            ];
            $this->db->insert($table, $data);
            if ($this->db->affected_rows() > 0) {
                return [
                    'status' => 200,
                    'message' => 'Satu data berhasil ditambahkan',
                    'table' => $table
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
                'address' => ucwords($address),
                'phone' => $phone,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $this->db->where('id', $id)->update($table, $data);
            if ($this->db->affected_rows() > 0) {
                return [
                    'status' => 200,
                    'message' => 'Satu data berhasil diubah',
                    'table' => $table
                ];
            } else {
                return [
                    'status' => 200,
                    'message' => 'Tidak ada data yang berubah',
                    'table' => $table
                ];
            }
        }
    }

    public function edit()
    {
        $id = $this->input->post('id', true);
        $table = $this->input->post('table', true);
        $check = $this->db->get_where($table, [
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
                'address' => $check->address,
                'phone' => $check->phone
            ]
        ];
    }

    public function editOther()
    {
        $id = $this->input->post('id', true);
        $table = $this->input->post('table', true);
        $check = $this->db->get_where($table, [
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
            'name' => $check->name
        ];
    }

    public function saveOther()
    {
        $id = $this->input->post('id', true);
        $table = $this->input->post('table', true);
        $name = $this->input->post('name', true);

        if ($table == '' || $name == '') {
            return [
                'status' => 400,
                'message' => 'Pastikan semua bidang inputan sudah diisi'
            ];
        }

        if ($id == 0) {
            $data = [
                'name' => ucwords($name)
            ];
            $this->db->insert($table, $data);
            if ($this->db->affected_rows() > 0) {
                return [
                    'status' => 200,
                    'message' => 'Satu data berhasil ditambahkan',
                    'table' => $table
                ];
            } else {
                return [
                    'status' => 400,
                    'message' => 'Kesalahan server'
                ];
            }
        } else {
            $data = [
                'name' => ucwords($name)
            ];
            $this->db->where('id', $id)->update($table, $data);
            if ($this->db->affected_rows() > 0) {
                return [
                    'status' => 200,
                    'message' => 'Satu data berhasil diubah',
                    'table' => $table
                ];
            } else {
                return [
                    'status' => 200,
                    'message' => 'Tidak ada data yang berubah'
                ];
            }
        }
    }

    public function loadCategory()
    {
        return $this->db->get('categories')->result_object();
    }

    public function loadColor()
    {
        return $this->db->get('colors')->result_object();
    }

    public function loadPackage()
    {
        return $this->db->get('packages')->result_object();
    }

    public function loadUnit()
    {
        return $this->db->get('units')->result_object();
    }

    public function loadMarket()
    {
        return $this->db->get('markets')->result_object();
    }

    public function loadCustomer()
    {
        return $this->db->get('customers')->result_object();
    }
}
