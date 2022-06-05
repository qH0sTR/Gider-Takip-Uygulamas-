<?php

namespace App\Http\Controllers;

use App\Giderler;
use Illuminate\Support\Facades\Input;

class HomeGetController extends HomeController
{
    public function get_index()
    {
        $tu = Input::get("tu");
        $k = base64_decode(Input::get("k"));

        $a = base64_decode(Input::get("a"));
        $ta = Input::get("ta");
        $x = $k;

        $tu1 =  (isset($tu) && explode("-", $tu)[0]) != "" ? explode("-", $tu)[0] : -9999999999999999999999999999999999999;
        $tu2 =  (isset($tu) && explode("-", $tu)[1] != "") ? explode("-", $tu)[1]  : 9999999999999999999999999999999999999;
        $ta1 =  isset($ta) ? date('Y-m-d H:i:s', substr(explode("-", $ta)[0], 0, strlen(explode("-", $ta)[0]) - 3) + 7200) : "";
        $ta2 =  isset($ta)  ? date('Y-m-d H:i:s', substr(explode("-", $ta)[1], 0, strlen(explode("-", $ta)[1]) - 3) + 7200) : "";
        // $ta1 =  isset($ta) ? substr(explode("-", $ta)[0], 0, strlen(explode("-", $ta)[0]) - 3) : null;
        // $ta2 =  isset($ta) ? substr(explode("-", $ta)[1], 0, strlen(explode("-", $ta)[1]) - 3) : null;
        $x = $k;
        $giderler = Giderler::where([
            ["tutar", ">", $tu1],
            ["tutar", "<", $tu2],
            ["tarih", ">", $ta1 == "" ? date('Y-m-d H:i:s', 0) : $ta1],
            ['kategori', 'LIKE', '' . $k . '%'],
            ['açıklama', 'LIKE', '' . $a . '%'],
            // ["tarih", "<", $ta2 == "" ? date('Y-m-d H:i:s', '2234567890') : $ta2]
        ])->whereDate("tarih", "<", ($ta2 == "1970-01-01 02:00:00" || $ta2 == "") ? date('Y-m-d H:i:s', '2234567890') : $ta2)->paginate(5);

        $giderler->appends([
            "tu" => $tu,
            "k" => $k,
            "a" => $a,
            "ta" => $ta,
        ]);
        $all = Giderler::all();
        $locations = [];
        foreach ($all as $row) {
            if ($row->konum != "") {
                $lat = explode(",", $row->konum)[0];
                $lng = explode(",", $row->konum)[1];
                array_push($locations, [$row->tutar, $lat, $lng, $row->kategori, $row->tarih]);
            }
        }
        $gonderilecekler = [
            'giderler' => $giderler,
            'locations' => $locations,
            "tu" => [$tu1 == -9999999999999999999999999999999999999 ? null : $tu1, $tu2 == 9999999999999999999999999999999999999 ? null : $tu2],
            "k" => $k,
            "a" => $a,
            "ta" => [(isset($ta1) && $ta1 != "1970-01-01 02:00:00") ? $ta1 : "", (isset($ta2) && $ta2 != "1970-01-01 02:00:00") ? $ta2 : ""],
            "x" => $x
        ];
        return view('index', $gonderilecekler);
    }
    public function get_index_yonlendir()
    {
        return redirect('/');
    }
    public function get_gider_ekle()
    {
        $all = Giderler::all();
        $locations = [];
        foreach ($all as $row) {
            if ($row->konum != "") {
                $lat = explode(",", $row->konum)[0];
                $lng = explode(",", $row->konum)[1];
                array_push($locations, [$row->tutar, $lat, $lng, $row->kategori, $row->tarih]);
            }
        }
        return view('gider_ekle')->with('locations', $locations);
    }
    public function get_google()
    {
        $locations = [
            ['Mumbai', 19.0760, 72.8777],
            ['Pune', 18.5204, 73.8567],
            ['Bhopal ', 23.2599, 77.4126],
            ['Agra', 27.1767, 78.0081],
            ['Delhi', 28.7041, 77.1025],
            ['Rajkot', 22.2734719, 70.7512559],
        ];
        return view('google')->with("locations", $locations);
    }
    public function get_google2()
    {
        $locations = [
            ['Mumbai', 19.0760, 72.8777],
            ['Pune', 18.5204, 73.8567],
            ['Bhopal ', 23.2599, 77.4126],
            ['Agra', 27.1767, 78.0081],
            ['Delhi', 28.7041, 77.1025],
            ['Rajkot', 22.2734719, 70.7512559],
        ];
        return view('google2')->with("locations", $locations);
    }


    public function get_gider_rapor()
    {
        $locations = [
            ['Mumbai', 19.0760, 72.8777],
            ['Pune', 18.5204, 73.8567],
            ['Bhopal ', 23.2599, 77.4126],
            ['Agra', 27.1767, 78.0081],
            ['Delhi', 28.7041, 77.1025],
            ['Rajkot', 22.2734719, 70.7512559],
        ];
        $all = Giderler::all();
        $categories2 = [];
        $_categories = [];
        foreach ($all as $row) {
            $kategori_zaten_var = 0;
            for ($i = 0; $i < count($_categories); $i++) {
                if ($row->kategori == $_categories[$i]) {
                    $kategori_zaten_var = $_categories[$i];
                }
            }
            if ($kategori_zaten_var) {
                $new_count = $categories2[$kategori_zaten_var]["count_of_payments"] + 1;
                $new_total = $categories2[$kategori_zaten_var]["total_payment"] + $row->tutar;
                $new_mean = $new_total / $new_count;

                $categories2[$kategori_zaten_var] = ['count_of_payments' => $new_count, 'mean_of_payments' => $new_mean, 'total_payment' => $new_total];
            } else {
                $categories2[$row->kategori] = ['count_of_payments' => 1, 'mean_of_payments' => $row->tutar, 'total_payment' => $row->tutar];
                array_push($_categories, $row->kategori);
            }
        }


        $categories = [
            'kategori1' => ['count_of_payments' => 6, 'mean_of_payments' => 3, 'total_payment' => 100,],
            'kategori2' => ['count_of_payments' => 2, 'mean_of_payments' => 4, 'total_payment' => 540,],
            'kategori3' => ['count_of_payments' => 5, 'mean_of_payments' => 2, 'total_payment' => 240,],
            'kategori4' => ['count_of_payments' => 12, 'mean_of_payments' => 43, 'total_payment' => 550,],
            'kategori5' => ['count_of_payments' => 14, 'mean_of_payments' => 1, 'total_payment' => 150,],
            'kategori6' => ['count_of_payments' => 52, 'mean_of_payments' => 23, 'total_payment' => 550,],
        ];
        return view('rapor')->with('locations', $locations)->with('categories', $categories2);
    }
}
