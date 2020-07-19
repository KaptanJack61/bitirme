<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Kategori;
use App\Models\Yazilar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class YaziController extends Controller
{
    public function detay($slug)
    {

        $yazi = Yazilar::where('slug', $slug)
                        ->where('durum',1)
                        ->get();

        if ($yazi->count() < 1) {
            return view('errors.404');
        } else {
            foreach ($yazi as $y) {
                return view('frontend.yazilar.detay')->with([
                    'yazi' => $y
                ]);
            }
        }


    }
}
