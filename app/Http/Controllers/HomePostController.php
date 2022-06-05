<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Giderler;

class HomePostController extends HomeController
{
    public function post_iletisim(Request $request)
    {
        try {
            $email = "serkanseker2319@gmail.com";
            $array = [
                'name' => 'Serkan',
                'surname' => 'Seker',
                'date' => date("Y-m-d")
            ];
            mail::send('mail.hosgeldin', $array, function ($message) use ($email) {
                $message->subject("İLETİŞİM FORMU");
                $message->to($email);
            });
            return response(['durum' => 'success', 'baslik' => 'Başarılı', 'icerik' => 'Mail Gönderildi']);
        } catch (\Exception $e) {
            return response(['durum' => 'error', 'baslik' => 'Hatalı', 'icerik' => 'Mail Gönderilemedi' . $e, 'hata' => $e]);
        }
    }
    public function post_index_sil(Request $request)
    {
        try {
            Giderler::where('id', $request->id)->delete();
            return response(["success" => "Gider Silindi"]);
        } catch (\Exception $e) {
            return response(["warning" => "Gider Silinemedi :("]);
        }
    }
    public function post_gider_ekle(Request $request)
    {
        try {
            Giderler::create($request->all());
            return response(["success" => "Gider Eklendi"]);
        } catch (\Exception $e) {
            return response(["warning" => $request->all()]);
        }
    }
    public function post_gider_duzenle(Request $request)
    {
        $id = $request->id;
        unset($request["id"]);
        try {
            Giderler::where("id", $id)->update($request->all());
            return response(["success" => "Gider Düzenlendi"]);
        } catch (\Exception $e) {
            return response(["warning" => $request->all()]);
            // return response(["warning" => "Gider Düzenlenemedi :("]);
        }
    }
}
