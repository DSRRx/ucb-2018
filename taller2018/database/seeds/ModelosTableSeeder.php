<?php

use Illuminate\Database\Seeder;

class ModelosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modelos')->insert([
        [
            'modelo'=>'Volkswagen',
            'anio'=>'2010',
            'cat_marca'=>'1',
            'created_at'=>today(),
        ],
        [
            'modelo'=>'Suzuki',
            'anio'=>'2010',
            'cat_marca'=>'1',
            'created_at'=>today(),
        ],
        [
            'modelo'=>'Chevrolet',
            'anio'=>'2010',
            'cat_marca'=>'1',
            'created_at'=>today(),
        ],
        [
            'modelo'=>'Toyota',
            'anio'=>'2010',
            'cat_marca'=>'1',
            'created_at'=>today(),
        ],
        [
            'modelo'=>'Honda',
            'anio'=>'2010',
            'cat_marca'=>'1',
            'created_at'=>today(),
        ],
        [
            'modelo'=>'Nissan',
            'anio'=>'2010',
            'cat_marca'=>'1',
            'created_at'=>today(),
        ],
        [
            'modelo'=>'Bentley',
            'anio'=>'2010',
            'cat_marca'=>'1',
            'created_at'=>today(),
        ],
        [
            'modelo'=>'Nissan',
            'anio'=>'2010',
            'cat_marca'=>'1',
            'created_at'=>today(),
        ],

        [
            'modelo'=>'Hyundai',
            'anio'=>'2010',
            'cat_marca'=>'1',
            'created_at'=>today(),
        ],


        ]);
    }
}
