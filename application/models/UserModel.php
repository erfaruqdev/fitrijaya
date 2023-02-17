<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{
    public function getdata()
    {
        $status = $this->input->post('status', true);
        $role = $this->input->post('role', true);

        $this->db->select('*')->from('users')->where('role !=', 'DEV');
        if ($status != '') {
            $this->db->where('status', $status);
        }

        if ($role != '') {
            $this->db->where('role', $role);
        }
        $data = $this->db->get()->result_object();

        $this->db->select('*')->from('users')->where('role !=', 'DEV');
        if ($status != '') {
            $this->db->where('status', $status);
        }

        if ($role != '') {
            $this->db->where('role', $role);
        }
        $amount = $this->db->get()->num_rows();

        return [$data, $amount];
    }

    public function changestatus()
    {
        $id = $this->input->post('id', true);
        $status = $this->input->post('status', true);

        $this->db->where('id', $id)->update('users', [
            'status' => $status
        ]);

        if ($this->db->affected_rows() > 0) {
            $result = [
                'status' => 200
            ];
        } else {
            $result = [
                'status' => 400
            ];
        }

        return $result;
    }

    public function save()
    {
        $username = mt_rand(10000, 99999);
        $data = [
            'name' => strtoupper($this->input->post('name', true)),
            'username' => $username,
            'password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            'role' => $this->input->post('role', true),
            'status' => 'INACTIVE'
        ];
        $this->db->insert('users', $data);

        if ($this->db->affected_rows() > 0) {
            return $username;
        } else {
            return 0;
        }
    }
}
