<?php

use App\Models\Neighborhood;
use Illuminate\Database\Seeder;

class NeighborhoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('truncate table neighborhoods');

        $list = [
            "Arabacıalanı","Aşağı Dereköy","Bahçelievler","Beşköprü",
            "Esentepe","İstiklal","Kemalpaşa","Köprübaşı","Orta Mahalle",
            "Otuziki Evler","Vatan","Aralık","Beşevler","Çubuklu","Dağyoncalı",
            "Hamitabat","Kazımpaşa","Kızılcıklı","Kuruçeşme","Meşeli",
            "Reşadiye","Selahiye","Uzunköy","Yukarı Dereköy","Mahalle Yok",
        ];

        for ($i=0;$i<count($list);$i++) {
            $neighborhood = new Neighborhood;
            $neighborhood->name = $list[$i];
            $neighborhood->slug = str_slug($neighborhood->name);
            $neighborhood->save();
        }


        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
