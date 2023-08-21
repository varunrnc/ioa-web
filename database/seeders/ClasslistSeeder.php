<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasslistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classlists')->insert([
            'class' => '9',
            'description' => 'Class 9',
        ]);

        DB::table('classlists')->insert([
            'class' => '10',
            'description' => 'Class 10',
        ]);

        DB::table('classlists')->insert([
            'class' => '11',
            'description' => 'Class 11',
        ]);

        DB::table('classlists')->insert([
            'class' => '12',
            'description' => 'Class 12',
        ]);

        DB::table('classlists')->insert([
            'class' => '12pass',
            'description' => '12 Pass',
        ]);
    }
}
