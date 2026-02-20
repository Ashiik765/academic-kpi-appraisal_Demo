<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kpi;

class KpiSeeder extends Seeder
{
    public function run()
    {
        $adminId = 1; // first admin user

        $data = [

            // TEACHING
            ['teaching','Innovative teaching methods',2,5],
            ['teaching','Student feedback score',2,5],
            ['teaching','Course material preparation',1,5],

            // RESEARCH
            ['research','Journal publications',3,10],
            ['research','Conference papers',2,5],
            ['research','Research grants',3,10],

            // INTERNAL
            ['internal','Committee participation',1,5],
            ['internal','Department contributions',1,5],

            // LEARNING
            ['learning','Workshops attended',1,5],
            ['learning','Certifications completed',2,5],
        ];

        foreach ($data as $d) {
            Kpi::create([
                'category'   => $d[0],
                'item'       => $d[1],
                'weight'     => $d[2],
                'max_marks'  => $d[3],
                'created_by' => $adminId
            ]);
        }
    }
}
