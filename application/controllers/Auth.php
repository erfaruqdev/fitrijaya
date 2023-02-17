<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('AuthModel', 'am');
    }

    public function index()
    {
        $userId = $this->session->userdata('user_id');
        if ($userId) {
            redirect(base_url());
        } else {
            $data = [
                'title' => 'Login | Fitri Jaya'
            ];
            $this->load->view('auth/login', $data);
        }
    }

    public function login()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $response = [
                'status' => 400,
                'errors' => [
                    'username' => form_error('username'),
                    'password' => form_error('password')
                ]
            ];
        } else {
            $response = $this->am->login();
        }

        echo json_encode($response);
    }

    public function logout()
    {
        $data = [
            'user_id',
            'username',
            'role',
            'name',
            'text_role'
        ];
        $this->session->unset_userdata($data);

        redirect(base_url());
    }
}
