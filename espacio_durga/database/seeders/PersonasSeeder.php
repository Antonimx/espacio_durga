<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PersonasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('personas')->insert([
            ['nombre'=>'Antonia','apellido'=>'Muñoz','rut'=>'20987602-7','fecha_nac'=>'2002-03-19','direccion'=>'4 norte 675 Viña del Mar','fono'=>'+56976543210','extranjero'=>0,'genero'=>'F'],
            ['nombre'=>'Carolina','apellido'=>'Cortés','rut'=>'15346028-0','fecha_nac'=>'1983-02-06','direccion'=>'4 norte 675 Viña del Mar','fono'=>'+56976543211','extranjero'=>0,'genero'=>'F'],
            ['nombre'=>'Bard','apellido'=>'Habbes','rut'=>'12345678-5','fecha_nac'=>'1997-07-24','direccion'=>'101 Fairview Avenue','fono'=>'+56976543212','extranjero'=>0,'genero'=>'M'],
            ['nombre'=>'Natale','apellido'=>'Nijssen','rut'=>'11222333-4','fecha_nac'=>'1978-03-27','direccion'=>'5 Swallow Hill','fono'=>'+56976543213','extranjero'=>0,'genero'=>'M'],
            ['nombre'=>'Rubetta','apellido'=>'Peel','rut'=>'98765432-2','fecha_nac'=>'2017-10-02','direccion'=>'20 Ridgeview Parkway','fono'=>'+56976543214','extranjero'=>0,'genero'=>'F'],
            ['nombre'=>'Jeno','apellido'=>'Odhams','rut'=>'87654321-1','fecha_nac'=>'2009-11-05','direccion'=>'7414 Buell Point','fono'=>'+56976543215','extranjero'=>0,'genero'=>'M'],
            ['nombre'=>'Mickie','apellido'=>'Grendon','rut'=>'19876543-K','fecha_nac'=>'1983-12-09','direccion'=>'2 Rutledge Hill','fono'=>'+56976543216','extranjero'=>1,'genero'=>'M']
        ]);
        
    }
}
