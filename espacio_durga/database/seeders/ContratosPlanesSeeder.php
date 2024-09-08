<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ContratosPlanesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contratos_planes')->insert([
        
            ['rut_alumno'=>'35891474-6','plan_mensual_id'=>1,'inicio_mensualidad'=>'2024-07-08', 'fin_mensualidad'=>'2024-08-08','n_clases_disponibles' => 4, 'estado' => 1],
            ['rut_alumno'=>'35891474-6','plan_mensual_id'=>2,'inicio_mensualidad'=>'2024-06-07', 'fin_mensualidad'=>'2024-07-07','n_clases_disponibles' => 0, 'estado' => 0],
            ['rut_alumno'=>'35891474-6','plan_mensual_id'=>3,'inicio_mensualidad'=>'2024-05-06', 'fin_mensualidad'=>'2024-06-06','n_clases_disponibles' => 2, 'estado' => 0],
            ['rut_alumno'=>'35891474-6','plan_mensual_id'=>4,'inicio_mensualidad'=>'2024-04-05', 'fin_mensualidad'=>'2024-07-05','n_clases_disponibles' => 11, 'estado' => 0],
        ]);
    }
}
