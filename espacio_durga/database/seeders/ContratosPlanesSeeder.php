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
        
            ['rut_alumno'=>'35891474-6','plan_mensual_id'=>1,'inicio_mensualidad'=>'2024-08-08', 'fin_mensualidad'=>'2024-09-08','n_clases_disponibles' => 4, 'estado' => 1],
            ['rut_alumno'=>'42252481-1','plan_mensual_id'=>2,'inicio_mensualidad'=>'2024-06-07', 'fin_mensualidad'=>'2024-07-07','n_clases_disponibles' => 0, 'estado' => 0],
            ['rut_alumno'=>'35891474-6','plan_mensual_id'=>3,'inicio_mensualidad'=>'2024-05-06', 'fin_mensualidad'=>'2024-06-06','n_clases_disponibles' => 2, 'estado' => 0],
            ['rut_alumno'=>'35891474-6','plan_mensual_id'=>4,'inicio_mensualidad'=>'2024-04-05', 'fin_mensualidad'=>'2024-07-05','n_clases_disponibles' => 11, 'estado' => 0],
            ['rut_alumno'=>'92376816-5','plan_mensual_id'=>1,'inicio_mensualidad'=>'2024-08-05', 'fin_mensualidad'=>'2024-09-05','n_clases_disponibles' => 0, 'estado' => 0],
            ['rut_alumno'=>'64136171-0','plan_mensual_id'=>4,'inicio_mensualidad'=>'2024-08-01', 'fin_mensualidad'=>'2024-08-01','n_clases_disponibles' => 28, 'estado' => 1],
            ['rut_alumno'=>'37829830-3','plan_mensual_id'=>2,'inicio_mensualidad'=>'2024-04-05', 'fin_mensualidad'=>'2024-07-05','n_clases_disponibles' => 0, 'estado' => 0],
            ['rut_alumno'=>'35891474-6','plan_mensual_id'=>1,'inicio_mensualidad'=>'2024-08-15', 'fin_mensualidad'=>'2024-09-15','n_clases_disponibles' => 1, 'estado' => 0],
        ]);
    }
}
