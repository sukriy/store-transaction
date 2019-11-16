<?php
    function check_array($array, $value0, $key1, $key0)
    {
        $temp0 = 0;

        foreach ($array as $key=>$value) {
            if ($value[$key1] == $value0) {
                if ($key0 == 'nama' || $key0 == 'satuan' || $key0 == 'bayar' || $key0 == 'qty0') {
                    return $value[$key0];
                } elseif ($key0 == 'id_transaksi') {
                    $temp0++;
                } elseif ($key0 == 'tagihan') {
                    $temp1 = hitung($value['subtotal'], 1, $value['diskon']);
                    $temp0 += $temp1;
                } elseif ($key0 == 'harga') {
                    $temp0 = $value['harga'];
                } else {
                    $temp0 += $value[$key0];
                }
            }
        }
        return $temp0;
    }
    function hitung($harga, $qty, $diskon)
    {
        $diskon = str_replace(",", "", $diskon);
        $qty = round(str_replace(",", "", $qty), 2);
        $harga = str_replace(",", "", $harga);
        $hitung = $harga*$qty;

        if (stripos($diskon, "%")) {
            $diskon = explode("+", $diskon);
            if (is_array($diskon)) {
                foreach ($diskon as $key=>$value) {
                    if (stripos($value, "%")) {
                        $hitung = $hitung * (100-str_replace("%", "", $value)) / 100;
                    } else {
                        $hitung = $hitung - $value;
                    }
                }
            } else {
                if (stripos($diskon, "%")) {
                    $hitung = $hitung * (100-str_replace("%", "", $diskon)) / 100;
                } else {
                    $hitung = $hitung - $diskon;
                }
            }
        } else {
            $hitung = $hitung - $diskon;
        }
        return round($hitung, 0);
    }
    function cetak_diskon($str)
    {
        $str = str_replace(",", "", $str);
        if (!(stripos($str, "%") || stripos($str, "+"))) {
            $str = number_format($str, 0);
        }
        return $str;
    }
    function array_to_object($array)
    {
        if (is_array($array)) {
            return (object) array_map(__FUNCTION__, $array);
        } else {
            return $array;
        }
    }

    function cetak_print($str)
    {
        $str = htmlentities(ucwords(strtolower($str)), ENT_QUOTES, 'UTF-8');
        $str = html_entity_decode($str);
        return $str;
    }
    function cetak($str)
    {
        return htmlentities(ucwords(strtolower($str)), ENT_QUOTES, 'UTF-8');
    }
    function cetak0($str)
    {
        $str = str_replace(",", "", $str);
        return htmlentities(ucwords(strtolower($str)), ENT_QUOTES, 'UTF-8');
    }
    function console($str)
    {
        echo "<script>console.log('".$str."');</script>";
    }
    function hash_password($password)
    {
        $salt = "security";
        $hash = hash('sha512', $salt.$password);
        return $hash;
    }
    function cetak_tgl($str)
    {
        if ($str=='0000-00-00 00:00:00' || $str=='') {
            return '';
        } else {
            $temp = explode('-', $str);
            return $temp[2].'-'.$temp[1].'-'.$temp[0];
        }
    }
    function cetak_tglwkt($str)
    {
        if ($str=='0000-00-00 00:00:00' || $str=='') {
            return '';
        } else {
            $temp0 = explode(' ', $str);
            $temp = explode('-', $temp0[0]);
            return $temp[2].'-'.$temp[1].'-'.$temp[0].' '.$temp0[1];
        }
    }
    function pre($txt)
    {
        echo '<pre>';
        print_r($txt);
        echo '</pre>';
    }
