<?php

use App\Models\HelpType;
use Illuminate\Database\Seeder;

class HelpTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('truncate table help_types');

        $list = [
            [
                "name" => "Çocuk Bezi",
                'metrik' => "paket",
                'isSingle' => 1
            ],
            [
                "name" => "Çölyak",
                'metrik' => "adet",
                'isSingle' => 0
            ],
            [
                "name" => "Erzak Yardımı",
                'metrik' => "koli",
                'isSingle' => 1
            ],
            [
                "name" => "Kitap",
                'metrik' => "adet",
                'isSingle' => 1
            ],
            [
                "name" => "LKYS Talepleri",
                'metrik' => "adet",
                'isSingle' => 0
            ],
            [
                "name" => "Mama",
                'metrik' => "paket",
                'isSingle' => 0
            ],
            [
                "name" => "Maske",
                'metrik' => "adet",
                'isSingle' => 1
            ],
            [
                "name" => "Sağlık Çalışanı",
                'metrik' => "kişi",
                'isSingle' => 0
            ],
            [
                "name" => "Sokak Hayvanları",
                'metrik' => "adet",
                'isSingle' => 0
            ],
            [
                "name" => "Süt",
                'metrik' => "litre",
                'isSingle' => 1
            ],
            [
                "name" => "Diğer Talepler",
                'metrik' => "adet",
                'isSingle' => 0
            ]

        ];


        for ($i=0;$i<count($list);$i++) {
            $help = new HelpType;
            $help->name = $list[$i]['name'];
            $help->slug = str_slug($help->name);
            $help->isSingle = $list[$i]['isSingle'];
            $help->metrik = $list[$i]['metrik'];
            $help->save();
        }


        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
