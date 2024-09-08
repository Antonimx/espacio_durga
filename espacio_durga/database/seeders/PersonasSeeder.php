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
            ['nombre'=>'Antonia','apellido'=>'Muñoz','rut'=>'20987602-7','fecha_nac'=>'2002-03-19','direccion'=>'4 norte 675 Vinña del Mar','fono'=>'976950321','extranjero'=>0],
            ['nombre'=>'Putnem','apellido'=>'Baress','rut'=>'23943330-4','fecha_nac'=>'1988-06-16','direccion'=>'7033 La Follette Street','fono'=>'928-987-6652','extranjero'=>1],
            ['nombre'=>'Daryl','apellido'=>'Rivard','rut'=>'46426126-7','fecha_nac'=>'2017-02-12','direccion'=>'362 Spaight Junction','fono'=>'505-136-1491','extranjero'=>0],
            ['nombre'=>'Bard','apellido'=>'Habbes','rut'=>'92376816-5','fecha_nac'=>'1997-07-24','direccion'=>'101 Fairview Avenue','fono'=>'480-798-7865','extranjero'=>0],
            ['nombre'=>'Estel','apellido'=>'Brookes','rut'=>'09401098-5','fecha_nac'=>'2018-02-08','direccion'=>'06 Lakewood Hill','fono'=>'826-961-2820','extranjero'=>1],
            ['nombre'=>'Kennedy','apellido'=>'Vasin','rut'=>'60477532-2','fecha_nac'=>'2020-11-20','direccion'=>'7 Surrey Trail','fono'=>'567-983-6836','extranjero'=>1],
            ['nombre'=>'Rebe','apellido'=>'Welbourn','rut'=>'56665224-7','fecha_nac'=>'2002-12-22','direccion'=>'10359 Alpine Alley','fono'=>'414-179-2136','extranjero'=>0],
            ['nombre'=>'Natale','apellido'=>'Nijssen','rut'=>'64136171-0','fecha_nac'=>'1978-03-27','direccion'=>'5 Swallow Hill','fono'=>'692-912-3990','extranjero'=>0],
            ['nombre'=>'Rubetta','apellido'=>'Peel','rut'=>'37829830-3','fecha_nac'=>'2017-10-02','direccion'=>'20 Ridgeview Parkway','fono'=>'935-902-2647','extranjero'=>0],
            ['nombre'=>'Jeno','apellido'=>'Odhams','rut'=>'35891474-6','fecha_nac'=>'2009-11-05','direccion'=>'7414 Buell Point','fono'=>'158-962-4663','extranjero'=>0],
            ['nombre'=>'Mickie','apellido'=>'Grendon','rut'=>'42252481-1','fecha_nac'=>'1983-12-09','direccion'=>'2 Rutledge Hill','fono'=>'820-144-9358','extranjero'=>1]
        ]);
        
    }
}
