<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('UserModel', 'um');
        CekLoginAkses();
    }

    public function index()
    {
        $data = [
            'title' => 'Data User | e-bms'
        ];
        $this->load->view('user/user', $data);
    }

    public function getdata()
    {
        $data = [
            'datas' => $this->um->getdata()[0],
            'amount' => $this->um->getdata()[1]
        ];
        $this->load->view('user/ajax-data', $data);
    }

    public function changestatus()
    {
        $result = $this->um->changestatus();

        echo json_encode($result);
    }

    public function save()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('password_confirmation', 'Password Konfirmasi', 'required|matches[password]');
        $this->form_validation->set_rules('role', 'Akses', 'required');
        if ($this->form_validation->run() == FALSE) {
            $response = [
                'status' => 400,
                'errors' => [
                    'name' => form_error('name'),
                    'password' => form_error('password'),
                    'password_confirmation' => form_error('password_confirmation'),
                    'role' => form_error('role')
                ]
            ];
        } else {
            $result = $this->um->save();
            if ($result == 0) {
                $response = [
                    'status' => 500,
                    'username' => ''
                ];
            } else {
                $response = [
                    'status' => 200,
                    'username' => $result
                ];
            }
        }

        echo json_encode($response);
    }
}
