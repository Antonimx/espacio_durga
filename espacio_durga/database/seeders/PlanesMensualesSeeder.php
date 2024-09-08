<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PlanesMensualesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('planes_mensuales')->insert([
            ['nombre'=>'4 Clases','n_clases'=> 4,'valor'=> 18000],
            ['nombre'=>'8 Clases','n_clases'=> 8,'valor'=> 30000],
            ['nombre'=>'12 Clases','n_clases'=> 12,'valor'=> 35000],
            ['nombre'=>'Libre','n_clases'=> 31,'valor'=> 40000],
        ]);
    }
}
