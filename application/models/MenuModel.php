<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MenuModel extends CI_Model
{
    public function getMenu($role)
    {
        $this->db->select('*')->from('user_menu')->join('menus', 'menus.id = menu_id');
        if ($role != 'DEV') {
            $this->db->where(['role' => $role, 'status' => 'ACTIVE']);
        }
        return $this->db->group_by('menu_id')->get()->result_object();
    }

    public function getdata()
    {
        $status = $this->input->post('status', true);

        $this->db->select('*')->from('menus');
        if ($status != '') {
            $this->db->where('status', $status);
        }
        $data = $this->db->get()->result_object();

        return $data;
    }

    public function getURL($url)
    {
        $data = $this->db->get_where('menus', ['url' => $url])->row_object();
        return $data->id;
    }

    public function cekUserMenu($id, $role)
    {
        return $this->db->get_where('user_menu', [
            'menu_id' => $id, 'role' => $role
        ])->num_rows();
    }

    public function save()
    {
        $data = [
            'name' => ucwords($this->input->post('name', true)),
            'icon' => $this->input->post('icon', true),
            'url' => $this->input->post('url', true),
            'status' => 'ACTIVE'
        ];
        $this->db->insert('menus', $data);

        return $this->db->affected_rows();
    }

    public function updatestatus()
    {
        $id = $this->input->post('id', true);
        $status = $this->input->post('status', true);
        $this->db->where('id', $id)->update('menus', ['status' => $status]);

        return $this->db->affected_rows();
    }

    public function addusermenu()
    {
        $id = $this->input->post('id', true);
        $role = $this->input->post('role', true);

        $cekMenu = $this->db->get_where('menus', ['id' => $id])->num_rows();
        if ($cekMenu > 0) {
            $cekUserMenu = $this->db->get_where('user_menu', [
                'menu_id' => $id, 'role' => $role
            ])->num_rows();
            if ($cekUserMenu > 0) {
                $result = 500;
            } else {
                $this->db->insert('user_menu', [
                    'menu_id' => $id, 'role' => $role
                ]);
                $result = $this->db->affected_rows();
            }
        } else {
            $result = 0;
        }

        return $result;
    }

    public function getrole($id)
    {
        return $this->db->get_where('user_menu', [
            'menu_id' => $id, 'role !=' => 'DEV'
        ])->result_object();
    }

    public function deleteusermenu()
    {
        $id = $this->input->post('id', true);
        $this->db->where('id', $id)->delete('user_menu');
        return $this->db->affected_rows();
    }
}
