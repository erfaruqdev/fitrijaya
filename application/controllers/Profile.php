<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('ProfileModel', 'pm');
        CekLogin();
    }

    public function index()
    {
        $data = [
            'title' => 'Profil Pengguna',
            'classProfile' => 'active'
        ];
        $this->load->view('profile/profile', $data);
    }

    public function checkusername()
    {
        $result = $this->pm->checkusername();

        echo json_encode($result);
    }

    public function savechangeuser()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('current_password_change_username', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $response = [
                'status' => 400,
                'errors' => [
                    'current_password_change_username' => form_error('current_password_change_username')
                ]
            ];
        } else {
            $result = $this->pm->savechangeuser();
            $response = [
                'status' => $result,
                'errors' => []
            ];
        }

        echo json_encode($response);
    }

    public function savenewpassword()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('password_confirmation', 'Kombinasi Password', 'required|matches[password]');
        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
        if ($this->form_validation->run() == FALSE) {
            $response = [
                'status' => 400,
                'errors' => [
                    'password' => form_error('password'),
                    'password_confirmation' => form_error('password_confirmation'),
                    'current_password' => form_error('current_password')
                ]
            ];
        } else {
            $result = $this->pm->savenewpassword();
            $response = [
                'status' => $result,
                'errors' => []
            ];
        }

        echo json_encode($response);
    }

    public function upload()
    {
        $id = $this->session->userdata('user_id');
        $image = $this->input->post('image');

        if ($image) {
            $imageOld = 'assets/images/users/' . $id . '.png';
            if ($imageOld) {
                unlink($imageOld);
            }

            $imageExplode1 = explode(';', $image);
            $imageExplode1 = explode(',', $imageExplode1[1]);
            $data = base64_decode($imageExplode1[1]);

            $imageName = 'assets/images/users/' . $id . '.png';
            file_put_contents($imageName, $data);

            echo base_url() . $imageName;
        }
    }
}
