<?php

namespace Database\Seeders;

use App\Models\ContratoPlan;
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
            ['nombre'=>'4 Clases','n_clases'=> 4,'valor'=> 18000,'cant_contratos_activos' => 1],
            ['nombre'=>'8 Clases','n_clases'=> 8,'valor'=> 30000, 'cant_contratos_activos' => 0],
            ['nombre'=>'12 Clases','n_clases'=> 12,'valor'=> 35000, 'cant_contratos_activos' => 0],
            ['nombre'=>'Libre','n_clases'=> 31,'valor'=> 40000, 'cant_contratos_activos' => 1],
        ]);
    }
}
