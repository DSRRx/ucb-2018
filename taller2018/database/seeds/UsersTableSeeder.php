<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            // Para que los tres tipos de roles puedan darse ejecutar:
            // IMPORTANTE:  composer dump-autoload
            // Poner     php artisan migrate:fresh --seed       para hacer la migración del seed
            // PRIEMRO:  php artisan db:seed --class=RolesTableSeeder
            //SEGUNDO:   php artisan db:seed --class=UsersTableSeeder
            //TERCERO:   php artisan db:seed --class=Users_RolesSeeder
          [
            'id' => '3',
            'sur_name' => 'Juan',
            'last_name'=> 'Reyes',
            'email' => 'rata_reyes1@hotmail.com',
            'email_verified_at'=> now(),
            'password' => Hash::make('hola123'),
            'remember_token' => str_random(10),
          ],
          [
            'id' => '2',
            'sur_name' => 'Cinthia',
            'last_name'=> 'Alvarez',
            'email' => 'cinthia1@gmail.com',
            'email_verified_at'=> now(),
            'password' => Hash::make('hola123'),
            'remember_token' => str_random(10),
          ],
          [
            'id' => '1',
            'sur_name' => 'Diego',
            'last_name'=> 'Rocha',
            'email' => 'dsrr2r@gmail.com',
            'email_verified_at'=> now(),
            'password' => Hash::make('111111'),
            'remember_token' => str_random(10),
          ],
          [
          'id' => '4',
            'sur_name' => 'Sebastian',
            'last_name'=> 'Rocha',
            'email' => 'diego_capricornio_2r@hotmail.com',
            'email_verified_at'=> now(),
            'password' => Hash::make('111111'),
            'remember_token' => str_random(10),
        ]
        ]);
    }
}
