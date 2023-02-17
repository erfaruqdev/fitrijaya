<?php

function CekLogin()
{
    $ci = get_instance();

    if (!$ci->session->userdata('user_id')) {
        redirect('auth');
    }
}

function CekLoginAkses()
{
    $ci = get_instance();

    $id = $ci->session->userdata('user_id');
    $role = $ci->session->userdata('role');

    if (!$id) {
        redirect('auth');
    } else {
        $ci->load->model('MenuModel', 'mmm');
        $url      = $ci->uri->segment(1);
        $idMenu = $ci->mmm->getURL($url);

        $cekAkses = $ci->mmm->cekUserMenu($idMenu, $role);

        if ($cekAkses <= 0 && $role != 'DEV') {
            redirect('block');
        }
    }
}

function getMenu()
{
    $ci = get_instance();
    $ci->load->model('menuModel');
    $role = $ci->session->userdata('role');

    return $ci->menuModel->getMenu($role);
}

function periodDisplay()
{
    $ci = get_instance();
    $ci->load->model('DataModel');

    return $ci->DataModel->periodDisplay();
}

function getHijri()
{
    $ci = get_instance();
    $ci->load->model('DataModel');

    return $ci->DataModel->getHijri();
}

function getHijriManual($date)
{
    $ci = get_instance();
    $ci->load->model('DataModel');

    return $ci->DataModel->getHijriManual($date);
}

function getHijriExplode()
{
    $ci = get_instance();
    $ci->load->model('DataModel');

    $result = $ci->DataModel->getHijri();
    return explode('-', $result);
}

function getMasehiExplode()
{
    $date = date('Y-m-d');
    return explode('-', $date);
}
