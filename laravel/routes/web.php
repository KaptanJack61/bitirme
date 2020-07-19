<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['namespace' => 'Yonetim'], function () {
    Route::redirect('/', '/oturumac');
    Route::get('/oturumac', 'KullaniciController@oturumac')->name('yonetim.oturumac');
    Route::post('/oturumac', 'KullaniciController@postOturumac');
    Route::get('/oturumukapat', 'KullaniciController@oturumuKapat')->name('yonetim.oturumukapat');

    Route::post('/deneme/dosya', 'AnasayfaController@deneme');

    Route::get('/dosya-yoneticisi', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
    Route::post('/dosya-yoneticisi/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');

    Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
        ->name('ckfinder_connector');

    Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
        ->name('ckfinder_browser');

    Route::group(['middleware' => 'admin'], function () {

        Route::pattern('id', '[0-9]+');
        Route::get('/deneme', function () {
            return view('yonetim.deneme');
        })->name('yonetim.deneme');

        Route::get('/yetkisiz-erisim','AnasayfaController@yetkisizErisim')->name('yetkisiz.erisim');

        Route::get('/anasayfa', 'AnasayfaController@index')->name('yonetim.anasayfa');
        Route::get('/medyayoneticisi', 'AnasayfaController@medyayoneticisi')->name('yonetim.medyayoneticisi');
        Route::get('/dosyayoneticisi', 'AnasayfaController@dosyayoneticisi')->name('yonetim.dosyayoneticisi');

        //Şifre Değişikliği
        Route::post('/kullanici/sifredegistir','KullaniciController@changePassword')->name('change.password');
        Route::post('/kullanici/controlOldPassword','KullaniciController@controlOldPassword')->name('control.oldpassword');

        Route::group(['middleware' => 'super'], function () {
            //Kullanıcı Route
            Route::get('/kullanicilar', 'KullaniciController@index')->name('yonetim.kullanicilar');
            Route::get('/kullanicilar/ekle', 'KullaniciController@ekle')->name('yonetim.kullanicilar.ekle');
            Route::post('/kullanicilar/ekle', 'KullaniciController@postEkle')->name('yonetim.kullanicilar.post.ekle');
            Route::get('/kullanicilar/duzenle/{id}', 'KullaniciController@duzenle')->name('yonetim.kullanicilar.duzenle');
            Route::post('/kullanicilar/duzenle/{id}', 'KullaniciController@postDuzenle');
            Route::get('/kullanicilar/sil/{id}', 'KullaniciController@sil');

        });

        //Yapılan Yardımlar Route
        Route::get('/yapilanyardimlar','HelpController@index')->name('yapilanyardimlar.index');
        Route::get('/yapilanyardimlar2','HelpController@index2')->name('yapilanyardimlar.index2');
        Route::get('/tamamlanmayanyardimlar','HelpController@notCompletedHelps')->name('yapilanyardimlar.notCompletedHelps');
        Route::get('/getHelps','HelpController@getHelps')->name('yapilanyardimlar.getHelps');
        Route::get('/notCompletedHelps','HelpController@getNotCompletedHelps')->name('yapilanyardimlar.getNotCompletedHelps');
        Route::get('/yardimtalebi/ekle','HelpController@storeIndex')->name('yardimtalebi.storeIndex');
        Route::get('/yardimtalebi/ekle/kopyala/{id}','HelpController@copyHelpInfo')->name('yardimtalebi.copyHelpInfo');
        Route::get('/yardimtalebi/ekle/basarili/{id}','HelpController@addSuccess')->name('yardimtalebi.addSuccess');
        Route::post('/yardimtalebi/ekle','HelpController@store')->name('yardimtalebi.store');
        Route::post('/yardimtalebi/dogrula/ekle','HelpController@acceptStore')->name('yardimtalebi.verify.store');
        Route::post('/yardimtalebi/dogrula/','HelpController@verifyStore')->name('yardimtalebi.verifyStore');
        Route::get('/yapilanyardim/duzenle/{id}', 'HelpController@updateIndex')->name('yardimtalebi.updateIndex');
        Route::post('/yapilanyardim/duzenle', 'HelpController@update')->name('yapilanyardim.update');
        Route::post('/yapilanyardim/tamamla', 'HelpController@complete')->name('yapilanyardim.complete');
        Route::get('/yapilanyardim/sil/{id}','HelpController@destroy')->name('yardimtalebi.destroy');
        Route::get('/yapilanyardim/detail/{id}','HelpController@detail')->name('yardimtalebi.detail');

        //Yardım Talepleri
        Route::get('/yardimtalepleri','DemandController@index')->name('yardimtalepleri.demands');
        Route::get('/yardimtalepleri2','DemandController@index2')->name('yardimtalepleri.getDemands');
        Route::get('/getDemands','DemandController@getDemands')->name('yardimtalepleri.getDemands');
        Route::get('/yardimtalebi/sil/{id}','DemandController@destroy')->name('yardimtalebi.all.destroy');
        Route::get('/yardimtalebi/detay/{id}','DemandController@detail')->name('yardimtalebi.all.detail');
        Route::get('/yardimtalebi/duzenle/{id}', 'DemandController@updateIndex')->name('yardimtalebi.all.updateIndex');
        Route::post('/yardimtalebi/inlineEdit/{id}', 'DemandController@editAllInputForm')->name('yardimtalebi.edit');
        Route::post('/yardimtalebi/duzenle/{id}', 'DemandController@update')->name('yardimtalebi.update');

        //Eski Yardım Talepleri
        Route::get('/yardimtalebi/eski/ekle','OldHelpController@index')->name('eskiyardimtalepleri.index');
        Route::post('/yardimtalebi/eski/ekle','OldHelpController@store')->name('eskiyardimtalepleri.store');

        Route::group(['middleware' => 'super'], function () {
        //Yardım Türleri Route
        Route::get('/yardimturleri','HelpTypeController@index')->name('yardimturleri.index');
        Route::post('/yardimturu/ekle','HelpTypeController@store')->name('yardimturu.store');
        Route::post('/yardimturu/duzenle', 'HelpTypeController@update')->name('yardimturu.update');
        Route::get('/yardimturu/sil/{id}','HelpTypeController@destroy')->name('yardimturu.destroy');
        Route::get('/yardimturu/goruntule/{id}','HelpTypeController@showByAllHelps')->name('yardimturu.showByAllHelps');

        //Durum Bilgileri Route
        Route::get('/durumbilgileri','StatusController@index')->name('statuses.index');
        Route::post('/durumbilgisi/ekle','StatusController@store')->name('statuses.store');
        Route::post('/durumbilgisi/duzenle', 'StatusController@update')->name('statuses.update');
        Route::get('/durumbilgisi/sil/{id}','StatusController@destroy')->name('statuses.destroy');
        Route::get('/durumbilgisi/goruntule/{id}','StatusController@showByAllHelps')->name('statuses.showByAllHelps');


        //Trying routes
        Route::get('/trying','TryController@index')->name('trying.index');
        Route::get('/trying/export','TryController@export')->name('trying.export');
        Route::get('/trying/import','TryController@import')->name('trying.import');
        Route::get('/import/maske','TryController@maskImport')->name('trying.maskImport');
        Route::get('/import/maske2','TryController@mask2Import')->name('trying.mask2Import');

        });

        //Raporlar Route
        Route::get('/rapor','ReportController@index')->name('raporlar.index');
        Route::get('/rapor/gunlukrapor','ReportController@dailyReport')->name('raporlar.gunluk');
        Route::post('/rapor/olustur/tamamlanmayanyardimlar','ReportController@notCompletedHelpsToExcel')->name('report.notCompletedHelpsToExcel');
        Route::post('/rapor/olustur/yardimlar','ReportController@helpsToExcel')->name('report.yardimlar');
        Route::post('/rapor/olustur','ReportController@createReport')->name('report.create');


        //İstatistik Route
        Route::get('/istatistik','StatisticController@index')->name('statistic.index');
        Route::post('/istatistik/mahalle/pasta','StatisticController@neighborhoodPie')->name('statistic.neighborhoodPie');
        Route::post('/istatistik/mahalle/bar','StatisticController@neighborhoodBar')->name('statistic.neighborhoodBar');
        Route::post('/istatistik/yardimturu/cevrimsel','StatisticController@helpTypeCycle')->name('statistic.helptype.cycle');
        Route::post('/istatistik/yardimturu/bar','StatisticController@helpTypeBar')->name('statistic.helptype.bar');
        Route::post('/istatistik/gunluk/line','StatisticController@dailyLine')->name('statistic.daily.line');
        Route::post('/istatistik/ozellestir','StatisticController@customize')->name('statistic.customize');
        Route::post('/istatistik/ozellestir/gunluk','StatisticController@customizeDaily')->name('statistic.customize.daily');
        Route::post('/istatistik/ozellestir/yardimturu','StatisticController@customizeHelpType')->name('statistic.customize.helpType');
        Route::get('/istatistik/anasayfa/toplammaske','StatisticController@dashboardShowSumMask')->name('statistic.dashboard.dashboardShowSumMask');
        Route::get('/istatistik/anasayfa/toplamerzak','StatisticController@dashboardShowSumFood')->name('statistic.dashboard.dashboardShowSumFood');

        //Arama Route
        Route::get('/ara','SearchController@search')->name('search.search');


    });

});

/*Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/', 'AnasayfaController@index')->name('frontend.anasayfa');
    Route::get('/{slug}', 'YaziController@detay');
});
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
