<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_type')->insert([
            'name' => 'Administrador',
            'description' => '',
            'state' => 1,
        ]);

        DB::table('establishments')->insert([
            'code' => '0000',
            'name' => 'Tacna',
            'short_name' => 'Tacna',
            'description' => '',
            'ubigee' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
            'size_pos' => '480',
            'type_print' => 'pdf',
            'validate_stock' => 0,
            'validate_price' => 0,
            'state' => 1,
        ]);

        DB::table('warehouse')->insert([
            'id_establishment' => 1,
            'code' => '0000',
            'name' => 'Tacna',
            'short_name' => 'Tacna',
            'description' => '',
            'default' => 1,
            'state' => 1,
        ]);

        DB::table('users')->insert([
            'id_user_type' => 1,
            'establishment' => '[1]',
            'name' => 'yonathan william',
            'last_name' => 'Mamani calisaya',
            'user' => 'YMamani',
            'email' => 'yonathan@gmail.com',
            'password' => Hash::make('123'),
            'phone' => '999999999',
            'api_token' => Str::random(60),
            'remember_token' => null,
            'state' => 1,
        ]);


        DB::table('privileges')->insert([
            'name' => 'Listar',
            'state' => 1,
        ]);
        DB::table('privileges')->insert([
            'name' => 'Agregar',
            'state' => 1,
        ]);
        DB::table('privileges')->insert([
            'name' => 'Editar',
            'state' => 1,
        ]);
        DB::table('privileges')->insert([
            'name' => 'Eliminar',
            'state' => 1,
        ]);
        DB::table('privileges')->insert([
            'name' => 'Ver',
            'state' => 1,
        ]);


        DB::table('zones')->insert([
            'name' => 'Tipo de Usuario',
            'module' => 'UserType',
            'Group' => 'Mantenimiento',
            'state' => 1,
        ]);

        DB::table('zone_privileges')->insert([
            'id_user_type' => 1,
            'id_privilege' => 1,
            'id_zone' => 1,
            'state' => 1,
        ]);
        DB::table('zone_privileges')->insert([
            'id_user_type' => 1,
            'id_privilege' => 2,
            'id_zone' => 1,
            'state' => 1,
        ]);DB::table('zone_privileges')->insert([
            'id_user_type' => 1,
            'id_privilege' => 3,
            'id_zone' => 1,
            'state' => 1,
        ]);DB::table('zone_privileges')->insert([
            'id_user_type' => 1,
            'id_privilege' => 4,
            'id_zone' => 1,
            'state' => 1,
        ]);DB::table('zone_privileges')->insert([
            'id_user_type' => 1,
            'id_privilege' => 5,
            'id_zone' => 1,
            'state' => 1,
        ]);
    }
}
