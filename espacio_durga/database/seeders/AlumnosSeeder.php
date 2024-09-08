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
        
            ['rut'=>'92376816-5','observaciones'=>'consectetur felis.'],
            ['rut'=>'64136171-0','observaciones'=>'Nullam vel lorem justo.'],
            ['rut'=>'37829830-3','observaciones'=>'Sed faucibus accumsan mi sed tincidunt.'],
            ['rut'=>'35891474-6','observaciones'=>'Donec nulla neque,'],
            ['rut'=>'42252481-1','observaciones'=>'feugiat vitae accumsan sed,']
        ]);
    }
}
