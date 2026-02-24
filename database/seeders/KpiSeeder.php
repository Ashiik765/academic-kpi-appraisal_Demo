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
            ['teaching','Innovative teaching methods',5],
            ['teaching','Student feedback score',5],
            ['teaching','Course material preparation',5],

            // RESEARCH
            ['research','Journal publications',10],
            ['research','Conference papers',5],
            ['research','Research grants',10],

            // INTERNAL
            ['internal','Committee participation',5],
            ['internal','Department contributions',5],

            // LEARNING
            ['learning','Workshops attended',5],
            ['learning','Certifications completed',5],
        ];

        foreach ($data as $d) {
            Kpi::create([
                'category'   => $d[0],
                'criteria'   => $d[1],
                'weightage'  => $d[2],
                'created_by' => $adminId
            ]);
        }
    }
}
