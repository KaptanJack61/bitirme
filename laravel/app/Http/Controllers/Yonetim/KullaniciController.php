<?php

namespace App\Http\Controllers\Yonetim;

use Alert;
use App\Models\User;
use Hash;
use Redirect;
use Session;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class KullaniciController extends Controller
{
    public function oturumac()
    {
        if (Auth::guard('yonetim')->check() && Auth::guard('yonetim')->user()->admin) {
            return redirect()->route('yonetim.anasayfa');
        }
        return view('yonetim.oturum.oturumac');
    }

    public function postOturumac()
    {
        $this->validate(request(), [
            'username' => 'required',
            'sifre' => 'required'
        ]);

        $bilgiler = [
            'username' => request('username'),
            'password' => request('sifre')
        ];

        if (Auth::guard('yonetim')->attempt($bilgiler, request()->has('benihatirla'))) {
            activity()
                ->causedBy(auth()->guard('yonetim')->user())
                ->log("Giriş yapıldı");

            return redirect()->route('yonetim.anasayfa');
        } else {
            return back()->withInput()->withErrors(['hata' => 'Giriş Hatalı!']);
        }

    }

    public function oturumuKapat()
    {
        activity()
            ->causedBy(auth()->guard('yonetim')->user())
            ->log("Çıkış yapıldı");

        Auth::guard('yonetim')->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->route('yonetim.oturumac');
    }

    public function index()
    {
        $kullanicilar = User::all();
        Session::put('menu_aktif', 'kullanicilar');
        Session::put('menu_acilma', 'kullanicilar');
        return view('yonetim.kullanicilar.kullanicilar')->with([
            'kullanicilar' => $kullanicilar
        ]);
    }

    public function ekle()
    {

        Session::put('menu_aktif', 'kullanicilar');
        Session::put('menu_acilma', 'kullanicilar');
        return view('yonetim.kullanicilar.ekle');
    }

    public function postEkle()
    {
        $rules = array(
            'adsoyad' => 'required|max:255|min:3',
            'email' => 'required',
            'username' => 'required|min:3|max:20',
            'password' => 'required',
            'password2' => 'required',
            'admin' => 'required',
            'aktif' => 'required'

        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            Alert::error('Hata', 'Girilen bilgiler eksik veya hatalı');
            return Redirect::back()
                ->withErrors($validator)
                ->WithInput();
        }

        $kullanici = new User();
        $kullanici->name = Input::get('adsoyad');
        $kullanici->slug = str_slug(Input::get('adsoyad'));
        $kullanici->username = Input::get('username');
        if (Input::get('fotograf')=="")
            $kullanici->photo = "/img/avatar04.png";
        else
            $kullanici->photo = Input::get('fotograf');
        $kullanici->active = Input::get('aktif');
        $kullanici->admin = Input::get('admin');
        $kullanici->detail = Input::get('detail');

        if (User::where('email', Input::get('email'))->count() == 0) {
            $kullanici->email = Input::get('email');
        } else {
            Alert::error('Hata', 'Girilen mail adresi kullanılıyor.');
            return redirect()->back()->withInput();
        }

        if (Input::get('password') == Input::get('password2')) {
            $kullanici->password = Hash::make(Input::get('password'));
        } else {
            Alert::error('Hata', 'Girilen şifreler birbiri ile uyuşmuyor.');
            return redirect()->back()->withInput();
        }


        if ($kullanici->save()) {
            Alert::success('Başarılı', 'Kullanıcı başarıyla eklendi');
            return redirect()->route('yonetim.kullanicilar');
        } else {
            Alert::error('Hata', 'Kullanıcı veri tabanına kaydedilemedi.');
            return redirect()->back()->withInput();
        }
    }

    public function duzenle($id)
    {
        $kullanici = User::find($id);
        Session::put('menu_aktif', 'kullanicilar');
        Session::put('menu_acilma', 'kullanicilar');
        return view('yonetim.kullanicilar.duzenle')->with([
            'kullanici' => $kullanici
        ]);
    }

    public function postDuzenle($id)
    {
        $rules = array(
            'adsoyad' => 'required|max:255|min:3',
            'email' => 'required',
            'username' => 'required|min:3|max:20',
            'admin' => 'required',
            'aktif' => 'required'

        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            Alert::error('Hata', 'Girilen bilgiler eksik veya hatalı');
            return Redirect::back()
                ->withErrors($validator)
                ->WithInput();
        }

        $kullanici = User::find($id);
        $kullanici->name = Input::get('adsoyad');
        $kullanici->username = Input::get('username');
        $kullanici->slug = str_slug(Input::get('adsoyad'));
        $kullanici->photo = Input::get('fotograf');
        $kullanici->active = Input::get('aktif');
        $kullanici->admin = Input::get('admin');
        $kullanici->detail = Input::get('detail');

        if ($kullanici->email != Input::get('email')) {
            if (User::where('email', Input::get('email'))->count() == 0) {
                $kullanici->email = Input::get('email');
            } else {
                Alert::error('Hata', 'Girilen mail adresi kullanılıyor.');
                return redirect()->back()->withInput();
            }
        }

        if (Input::get('password') != "" and Input::get('password2') != "") {
            if (Input::get('password') == Input::get('password2')) {
                $kullanici->password = Hash::make(Input::get('password'));
            } else {
                Alert::error('Hata', 'Girilen şifreler birbiri ile uyuşmuyor.');
                return redirect()->back()->withInput();
            }
        }

        if ($kullanici->save()) {
            Alert::success('Başarılı', 'Kullanıcı başarıyla güncellendi.');
            return redirect()->back();
        } else {
            Alert::error('Hata', 'Kullanıcı veri tabanında güncellenemedi.');
            return redirect()->back()->withInput();
        }
    }

    public function sil($id)
    {

        if ($id==1 or $id==2){
            Alert::error('Hata', 'Süper Admini silemezsiniz!');
            return redirect()->back();
        }

        $kullanici = User::find($id);
        if ($kullanici->delete()) {
            Alert::success('Başarılı', 'Kullanıcı başarıyla silindi');
            return redirect()->route('yonetim.kullanicilar');
        } else {
            Alert::error('Hata', 'Kullanıcı silinemedi');
            return redirect()->back();
        }
    }

    public function controlOldPassword(Request $request){
        if (Hash::check($request->oldpassword,Auth::guard('yonetim')->user()->getAuthPassword())){
            return 1;
        }else
            return 0;
    }

    public function changePassword(Request $request){
        $password1 = $request->newpassword1;
        $password2 = $request->newpassword2;

        if ($password1 != $password2) {
            Alert::error('Hata','Girilen şifreler birbirinden farklı');
            return redirect()->back();
        }

        $user = User::find(Auth::guard('yonetim')->user()->id);
        $user->password = Hash::make($password1);

        if ($user->save()){
            Alert::success('Başarılı','Şifreniz başarıyla değiştirildi.');
            return redirect()->back();
        }else {
            Alert::error('Hata','Şifreniz değiştirilemedi.');
            return redirect()->back();
        }

    }

}
