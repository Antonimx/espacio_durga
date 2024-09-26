<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AlumnosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alumnos')->insert([
        
            ['rut'=>'12345678-5','observaciones'=>'consectetur felis.'],
            ['rut'=>'11222333-4','observaciones'=>'Nullam vel lorem justo.'],
            ['rut'=>'98765432-2','observaciones'=>'Sed faucibus accumsan mi sed tincidunt.'],
            ['rut'=>'87654321-1','observaciones'=>'Donec nulla neque,'],
            ['rut'=>'19876543-K','observaciones'=>'feugiat vitae accumsan sed,']
        ]);
    }
}
