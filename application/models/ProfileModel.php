<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProfileModel extends CI_Model
{
    public function checkusername()
    {
        $username = $this->input->post('username', true);
        $checkUsername = $this->db->get_where('users', [
            'username' => $username
        ])->num_rows();
        if ($checkUsername > 0) {
            return [
                'status' => 400
            ];
        } else {
            return [
                'status' => 200
            ];
        }
    }

    public function savechangeuser()
    {
        $username = $this->session->userdata('username');
        $newUsername = $this->input->post('new_username', true);
        $password = $this->input->post('current_password_change_username', true);

        $getUser = $this->db->get_where('users', [
            'username' => $username
        ])->row_object();
        $oldPassword = $getUser->password;
        if (password_verify($password, $oldPassword) == FALSE) {
            return 500;
        } else {
            $this->db->where('username', $username)->update('users', ['username' => $newUsername]);
            $this->session->unset_userdata('username');
            $this->session->set_userdata(['username' => $newUsername]);
            return 200;
        }
    }

    public function savenewpassword()
    {
        $username = $this->input->post('current_username', true);
        $oldPassword = $this->input->post('current_password', true);
        $newPassword = $this->input->post('password', true);

        $getUser = $this->db->get_where('users', [
            'username' => $username
        ])->row_object();
        if (password_verify($oldPassword, $getUser->password) == FALSE) {
            return 500;
        } else {
            $this->db->where('username', $username)->update('users', [
                'password' => password_hash($newPassword, PASSWORD_DEFAULT)
            ]);
            return 200;
        }
    }
}
