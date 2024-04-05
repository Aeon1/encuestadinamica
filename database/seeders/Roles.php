<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->insert(['id' => 1, 'tipo' => 'Administrador', 'estatus' => 1, 'created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('roles')->insert(['id' => 2, 'tipo' => 'Gestor', 'estatus' => 1,'created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('roles')->insert(['id' => 3, 'tipo' => 'Visualizador', 'estatus' => 1, 'created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('users')->insert(['id' => 1, 'name' => 'Administrador','email' =>'administrador@encuestas.com', 'password' =>'$2y$10$iqT4r5leomsLSMJqPVqNFuBWNhG/A4uweKHdaP0sPcq6.Qw.IEzZS',
        'rol' => 1, 'primerlogin' => 0, 'activo' => 1,'hash' =>'a179e3a2d0bc42bf58725ad423058062']);
    }
}
