<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Yazilar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnasayfaController extends Controller
{
    public function index()
    {

        $yazilar = Yazilar::where('durum', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.anasayfa')->with([
            'yazilar' => $yazilar
        ]);
    }
}
