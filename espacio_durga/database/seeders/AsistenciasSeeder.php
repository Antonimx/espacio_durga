<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class AsistenciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contratos = [
            ['id' => 1, 'inicio_mensualidad' => '2024-07-08', 'fin_mensualidad' => '2024-08-08'],
            ['id' => 2, 'inicio_mensualidad' => '2024-06-07', 'fin_mensualidad' => '2024-07-07'],
            ['id' => 3, 'inicio_mensualidad' => '2024-05-06', 'fin_mensualidad' => '2024-06-06'],
            ['id' => 4, 'inicio_mensualidad' => '2024-04-07', 'fin_mensualidad' => '2024-07-07'],
        ];

        foreach ($contratos as $contrato) {
            $inicio = Carbon::parse($contrato['inicio_mensualidad']);
            $fin = Carbon::parse($contrato['fin_mensualidad']);

            while ($inicio <= $fin) {
                // Generar una hora aleatoria entre 00:00 y 23:59
                $randomHour = rand(0, 23);
                $randomMinute = rand(0, 59);

                // Formatear la fecha y la hora
                $fechaHora = $inicio->copy()->addDays(rand(0, 6))
                    ->setTime($randomHour, $randomMinute)
                    ->format('Y-m-d H:i:s');

                // Insertar la asistencia
                DB::table('asistencias')->insert([
                    'contrato_plan_id' => $contrato['id'],
                    'fecha_hora' => $fechaHora,
                ]);

                // Avanzar una semana
                $inicio->addWeek();
            }
        }
    }
}
