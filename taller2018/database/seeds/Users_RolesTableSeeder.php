z<?php

use Illuminate\Database\Seeder;

class Users_RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_role')->insert([
            [
                'id'=>'1',
                'id_role'=>'1',//Admin
                'id_user'=>'1',//Diego
                'created_at'=>today(),
            ],
            [
                'id'=>'2',
                'id_role'=>'2',//User
                'id_user'=>'1',//Diego
                'created_at'=>today(),
            ],
            [
                'id'=>'3',
                'id_role'=>'3',//Owner
                'id_user'=>'1',//Diego
                'created_at'=>today(),
            ],
            [
                'id'=>'4',
                'id_role'=>'2',//Owner
                'id_user'=>'2',//Cinthia
                'created_at'=>today(),
            ],
            [
                'id'=>'5',
                'id_role'=>'2',//Owner
                'id_user'=>'3',//Juani
                'created_at'=>today(),
            ],
            [
                'id'=>'6',
                'id_role'=>'3',//Owner
                'id_user'=>'3',//Juani
                'created_at'=>today(),
            ],
            [
                'id'=>'7',
                'id_role'=>'1',//Admin
                'id_user'=>'4',//Sebastian
                'created_at'=>today(),
            ],
            [
                'id'=>'8',
                'id_role'=>'2',//Admin
                'id_user'=>'4',//Sebastian
                'created_at'=>today(),
            ],
            [
                'id'=>'9',
                'id_role'=>'3',//Admin
                'id_user'=>'4',//Sebastian
                'created_at'=>today(),
            ]
        ]);
    }
}
