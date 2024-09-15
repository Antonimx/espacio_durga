<?php

namespace Database\Seeders;

use App\Models\ContratoPlan;
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
        $contratos = ContratoPlan::all();

        foreach ($contratos as $contrato) {
            $inicio = Carbon::parse($contrato->inicio_mensualidad);

            for ($i=0;$i<4;$i++) {
                $randomHour = rand(0, 23);
                $randomMinute = rand(0, 59);

                // Formatear la fecha y la hora
                $fechaHora = $inicio->copy()->addDays(rand(0, 6))
                    ->setTime($randomHour, $randomMinute)
                    ->format('Y-m-d H:i:s');

                // Insertar la asistencia
                DB::table('asistencias')->insert([
                    'contrato_plan_id' => $contrato->id,
                    'rut_alumno'=>$contrato->rut_alumno,
                    'fecha_hora' => $fechaHora,
                ]);

                // Avanzar una semana
                $inicio->addWeek();
            }
        }
    }
}
