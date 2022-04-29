<?php


function tambah_nol_didepan($value, $threshold = null){
    // tanda . adalah concat
    return sprintf("%0". $threshold . "s",  $value);
}                      // titik     // titik  // koma

// Tanggal Indonesia
function tanggal_indonesia($tgl, $tampil_hari = true){

    $nama_hari = array( 'minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jum\'at', 'sabtu');
    
    $nama_bulan = array( 1 => 'januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'disember'

    );

    // 2022 - 03 - 08
    $tahun = substr($tgl, 0, 4);
    // $bulan = substr($tgl, 4, 2);
    $bulan = $nama_bulan[(int) substr($tgl, 5, 2)];
    $tanggal = substr($tgl, 8, 2);

    if($tampil_hari){
        $urutan_hari = date('w', mktime(0,0,0, substr($tgl, 5,2), $tanggal, $tahun));
        $hari = $nama_hari[$urutan_hari];
        $text = "$hari, $tanggal $bulan $tahun";
    
    }else {

        $text = "$tanggal $bulan $tahun";

    }
    
    return $text;
}


// Mengubah format angka
function format_uang($angka){

    return number_format($angka,0,",",".");
}


// Membaca Angka
function terbilang($angka){

        $angka = abs($angka);

        $baca = array('','satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan','sepuluh','sebelas');

        $terbilang = '';

        if($angka <12){ // 1 - 11

            $terbilang = ' ' . $baca[$angka];

        } elseif ($angka <20){ // 12 - 19

            $terbilang = terbilang($angka - 10) . ' belas';

        } elseif ($angka <100){ // 20 - 99

            $terbilang = terbilang($angka / 10) . ' puluh' . terbilang($angka % 10);

        } elseif ($angka <200){ // 100 - 199

            $terbilang = 'seratus ' . terbilang($angka - 100);

        } elseif ($angka < 1000){ // 200 - 999

            $terbilang = terbilang($angka / 100) . ' ratus' . terbilang($angka % 100);

        } elseif ($angka < 2000){ // 1000 - 1999
            
            $terbilang = 'seribu ' . terbilang($angka - 1000);
        
        } elseif ($angka < 1000000){ // 2000 - 9999

            $terbilang = terbilang($angka / 1000) . ' ribu ' . terbilang($angka % 1000);

        } elseif ($angka < 1000000000){


            $terbilang = terbilang($angka / 1000000) . ' juta' . terbilang($angka % 1000000);

        }

          return $terbilang;
}