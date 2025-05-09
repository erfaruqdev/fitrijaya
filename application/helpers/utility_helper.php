<?php

function datetimeIDFormat($tanggal)
{
    $tgl = date('Y-m-d', strtotime($tanggal));
    $jam = date('H:i:s', strtotime($tanggal));

    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tgl);

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0] . ' ' . $jam;
}

function datetimeIDShortFormat($tanggal)
{
    $tgl = date('Y-m-d', strtotime($tanggal));
    $jam = date('H:i:s', strtotime($tanggal));

    $bulan = array(
        1 =>   'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul',
        'Agu',
        'Sep',
        'Okt',
        'Nov',
        'Des'
    );
    $pecahkan = explode('-', $tgl);

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0] . ' ' . $jam;
}

function dateTimeShortenFormat($tanggal)
{
    $tgl = date('Y-m-d', strtotime($tanggal));
    $jam = date('H:i:s', strtotime($tanggal));
    $pecahkan = explode('-', $tgl);

    return $pecahkan[2] . '/' . $pecahkan[1] . '/' . $pecahkan[0] . ' ' . $jam;
}

function datetimeIDDate($tanggal)
{
    $tgl = date('Y-m-d', strtotime($tanggal));

    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tgl);

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function dateIDFormat($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function dateIDFormatShort($tanggal)
{
    $bulan = array(
        1 =>   'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul',
        'Agu',
        'Sep',
        'Okt',
        'Nov',
        'Des'
    );
    $pecahkan = explode('-', $tanggal);

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function dateHijriFormat($tanggal)
{
    $bulan = array(
        '--',
        'Muharram',
        'Shafar',
        'Rabi\'ul Awal',
        'Rabi\'ul Tsani',
        'Jumadal Ula',
        'Jumadal Tsaniyah',
        'Rajab',
        'Sya\'ban',
        'Ramadhan',
        'Syawal',
        'Dzul Qo\'dah',
        'Dzul Hijjah'
    );

    $pecahkan = explode('-', $tanggal);

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function step($step)
{
    $steps = [
        'Belum diatur',
        'Tahap I',
        'Tahap II',
        'Tahap III',
        'Tahap IV',
        'Tahap V',
        'Tahap VI',
        'Tahap VII',
        'Tahap VIII',
        'Tahap IX',
        'Tahap X',
        'Tahap XI',
    ];
    return $steps[$step];
}

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}

function convertSize($size, $categoryId)
{
	if ($categoryId == 2) {
		if ($size == 10) {
			$size = 'NO. S';
		}elseif ($size == 11) {
			$size = 'NO. M';
		}elseif ($size == 12) {
			$size = 'NO. L';
		}elseif ($size == 13) {
			$size = 'NO. XL';
		}elseif ($size == 14) {
			$size = 'NO. 2XL';
		}elseif ($size == 15) {
			$size = 'NO. 3XL';
		}elseif ($size == 16) {
			$size = 'NO. 4XL';
		}elseif ($size == 17) {
			$size = 'NO. 5XL';
		}else {
			$size = 'NO. '.$size;
		}
	} elseif ($categoryId == 3) {
		$size = 'NO. '.$size;
	} else {
		$size = '';
	}

    return $size;
}

function convertSizeShort($size) {
	if ($size == 10) {
		$size = '10/S';
	}elseif ($size == 11) {
		$size = '11/M';
	}elseif ($size == 12) {
		$size = '12/L';
	}elseif ($size == 13) {
		$size = '13/XL';
	}elseif ($size == 14) {
		$size = '14/2XL';
	}elseif ($size == 15) {
		$size = '15/3XL';
	}elseif ($size == 16) {
		$size = '16/4XL';
	}elseif ($size == 17) {
		$size = '17/5XL';
	}else {
		$size;
	}

	return $size;
}

function convertSizePrint($size, $categoryId){
	if ($categoryId == 2) {
		if ($size == 10) {
			$size = 'S';
		}elseif ($size == 11) {
			$size = 'M';
		}elseif ($size == 12) {
			$size = 'L';
		}elseif ($size == 13) {
			$size = 'XL';
		}elseif ($size == 14) {
			$size = '2XL';
		}elseif ($size == 15) {
			$size = '3XL';
		}elseif ($size == 16) {
			$size = '4XL';
		}elseif ($size == 17) {
			$size = '5XL';
		}else {
			$size = $size;
		}
	} elseif ($categoryId == 3) {
		$size = $size;
	} else {
		$size = '';
	}

	return $size;
}
