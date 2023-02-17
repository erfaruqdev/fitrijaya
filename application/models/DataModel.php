<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataModel extends CI_Model
{
    public function getperiod()
    {
        $get = $this->db->order_by('id', 'DESC')->get('period')->row_object();
        if ($get) {
            return $get->name;
        } else {
            return '';
        }
    }

    public function periodDisplay()
    {
        $get = $this->db->order_by('id', 'DESC')->get('period')->row_object();
        if ($get) {
            return $get->name;
        } else {
            return 'Belum diatur';
        }
    }

    public function getHijri()
    {
        $now = new DateTime('now');
        $jam  = $now->format('H:m');
        $set = new DateTime('tomorrow');
        if ($jam > '18:00' and $jam < '23:59') {
            $set = new DateTime('tomorrow');
            $result = $set->format('Y-m-d');
        } else {
            $result = $now->format('Y-m-d');
        }

        $data = $this->db->get_where('calendar', ['masehi' => $result])->row_object();

        if ($data) {
            $hijri = $data->hijri;
        } else {
            $hijri = '0000-00-00';
        }

        return $hijri;
    }

    public function getHijriManual($date)
    {
        $data = $this->db->get_where('calendar', ['masehi' => $date])->row_object();

        if ($data) {
            $hijri = $data->hijri;
        } else {
            $hijri = '0000-00-00';
        }

        return $hijri;
    }
}
