<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('truncate table statuses');

        $list = [
            [
                "name" => "İşleme Alındı",
                "finisher" => false
            ],
            [
                "name" => "Bildirildi",
                "finisher" => true
            ],
            [
                "name" => "Tamamlandı",
                "finisher" => true
            ],
            [
                "name" => "Tamamlanamadı",
                "finisher" => false
            ]
        ];

        for ($i=0;$i<count($list);$i++) {
            $status = new Status;
            $status->name = $list[$i]['name'];
            $status->finisher = $list[$i]['finisher'];
            $status->save();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
