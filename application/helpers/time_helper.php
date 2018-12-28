<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function tgleng($tgl)
{
    if ($tgl != "")
    {
        // Konversi hari dan tanggal ke dalam format Indonesia
        $hari_array = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
        $hr = date('w', strtotime($tgl));
        $hari = $hari_array[$hr];
        $tgl = date('d-m-Y', strtotime($tgl));
        $hr_tgl = "$hari, $tgl";
        return $hr_tgl;
    }
}

function lockcode_format($tgl)
{
    if ($tgl != "")
    {
        // Konversi hari dan tanggal ke dalam format Indonesia
//        $hari_array = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
        $hasil1 = date('Y-m-d', strtotime($tgl));
        $h = date('H', strtotime($tgl));
        return $hasil1.'T'.$h.':00:00';
    }
}

function tglin($tgl)
{
    if ($tgl != "")
    {
        // Konversi hari dan tanggal ke dalam format Indonesia
//        $hari_array = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
        $tgl = date('d-m-Y', strtotime($tgl));
        return $tgl;
    }
}

function timein($tgl)
{
    if ($tgl != "")
    {
        // Konversi hari dan tanggal ke dalam format Indonesia
//        $hari_array = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
        $tgl = date('H:i:s', strtotime($tgl));
        return $tgl;
    }
}

function tglshort($tgl)
{
    if ($tgl != "")
    {
        // Konversi hari dan tanggal ke dalam format Indonesia
//        $hari_array = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
        $tgl = date('d-m', strtotime($tgl));
        return $tgl;
    }
}

function tglmonth($tgl)
{
    if ($tgl != "")
    {
        // Konversi hari dan tanggal ke dalam format Indonesia
//        $hari_array = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
        $tgl = date('m-Y', strtotime($tgl));
        return $tgl;
    }
}

function tglincomplete($tgl)
{
    if ($tgl != "")
    {
        // Konversi hari dan tanggal ke dalam format Indonesia
//        $hari_array = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
        $tgl = date('d F Y', strtotime($tgl));
        return $tgl;
    }
}

function split_date($tgl,$type)
{
    return date($type, strtotime($tgl));  
}

function waktuindo()
{
      // Ambil waktu server terkini
      $dat_server = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date("Y"));
     // echo 'Waktu server (US): '.date("H:i:s", $dat_server);
      // Ambil perbedaan waktu server dengan GMT
      $diff_gmt = substr(date("O",$dat_server),1,2);
      // karena perbedaan waktu adalah dalam jam, maka kita jadikan detik
      $datdif_gmt = 60 * 60 * $diff_gmt;
      // Hitung perbedaannya

      if (substr(date("O",$dat_server),0,1) == '+') {
      $dat_gmt = $dat_server - $datdif_gmt;
      } else {
      $dat_gmt = $dat_server + $datdif_gmt;
      }
       //      echo 'Waktu GMT: '.date("H:i:s", $dat_gmt);

      // Hitung perbedaan GMT dengan waktu Indonesia (GMT+7)

      // karena perbedaan waktu adalah dalam jam, maka kita jadikan detik
      $datdif_id = 60 * 60 * 7;
      $dat_id = $dat_gmt + $datdif_id;
      return date("H:i:s", $dat_id);
}

function get_month_romawi($val)
{
    $res = null;
    switch ($val)
    {
        case 1: $res = 'I'; break;
        case 2: $res = 'II'; break;
        case 3: $res = 'III'; break;
        case 4: $res = 'IV'; break;
        case 5: $res = 'V'; break;
        case 6: $res = 'VI'; break;
        case 7: $res = 'VII'; break;
        case 8: $res = 'VIII'; break;
        case 9: $res = 'IX'; break;
        case 10: $res = 'X'; break;
        case 11: $res = 'XI'; break;
        case 12: $res = 'XII'; break;
        default: $res = NULL;
    }
    return $res;
}

function get_month($val)
{
    $res = null;
    switch ($val)
    {
        case 1: $res = 'January'; break;
        case 2: $res = 'February'; break;
        case 3: $res = 'March'; break;
        case 4: $res = 'April'; break;
        case 5: $res = 'May'; break;
        case 6: $res = 'June'; break;
        case 7: $res = 'July'; break;
        case 8: $res = 'August'; break;
        case 9: $res = 'September'; break;
        case 10: $res = 'October'; break;
        case 11: $res = 'November'; break;
        case 12: $res = 'December'; break;
        default: $res = NULL;
    }
    return $res;
}

function get_month_indo($val)
{
    $res = null;
    switch ($val)
    {
        case 1: $res = 'Januari'; break;
        case 2: $res = 'Februari'; break;
        case 3: $res = 'Maret'; break;
        case 4: $res = 'April'; break;
        case 5: $res = 'Mei'; break;
        case 6: $res = 'Juni'; break;
        case 7: $res = 'Juli'; break;
        case 8: $res = 'Agustus'; break;
        case 9: $res = 'September'; break;
        case 10: $res = 'Oktober'; break;
        case 11: $res = 'November'; break;
        case 12: $res = 'Desember'; break;
        default: $res = NULL;
    }
    return $res;
}

function get_month_number($val)
{
    $res = null;
    switch ($val)
    {
        case 'January': $res = 1; break;
        case 'February': $res = 2; break;
        case 'March': $res = 3; break;
        case 'April': $res = 4; break;
        case 'May': $res = 5; break;
        case 'June': $res = 6; break;
        case 'July': $res = 7; break;
        case 'August': $res = 8; break;
        case 'September': $res = 9; break;
        case 'October': $res = 10; break;
        case 'November': $res = 11; break;
        case 'December': $res = 12; break;
        default: $res = NULL;
    }
    return $res;
}

function combo_month()
{
    for($i=1; $i<=12; $i++)
    {$data['options'][$i] = get_month($i);}
    return $data;
}

function combo_time()
{
    for($i=0; $i<=23; $i++)
    {$data['options'][$i] = $i;}
    return $data;
}

function get_total_days($val)
{
   $res = null;
   switch ($val)
   {
      case 1: $res = 31; break;
      case 2: $res = 30; break;
      case 3: $res = 31; break;
      case 4: $res = 30; break;
      case 5: $res = 31; break;
      case 6: $res = 30; break;
      case 7: $res = 31; break;
      case 8: $res = 31; break;
      case 9: $res = 30; break;
      case 10: $res = 31; break;
      case 11: $res = 30; break;
      case 12: $res = 31; break;
      default: $res = NULL;
    }
    return $res; 
}

function previous_month($month){ if ($month == 1){ return 12;  }else { return $month-1; } }

function previous_year($month,$year){ if ($month == 1){ return $year-1;  }else { return $year; } }

// date time picker

function picker_between_split($val,$order)
{
    if ($val)
    {
      $res = explode('-', $val);
      if ($order == 0){ return picker_split($res[0]); }else { return picker_split($res[1]); }
    }else { return null; }
    
}

function picker_split($val)
{
   $res = explode('/', $val);
   return implode('-', $res);
}

function idr_format($angka)
{
  $jadi = number_format($angka,0,',','.');
  return $jadi;
}