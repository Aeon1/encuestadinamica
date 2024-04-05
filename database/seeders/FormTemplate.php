<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormTemplate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('registro_form_templates')->insert(['texto' => 'Nombre completo', 'campo'=> 1, 'name'=>'nombre_completo', 'created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('registro_form_templates')->insert(['texto' => 'Nombres', 'campo'=> 1,  'name'=>'nombres', 'created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('registro_form_templates')->insert(['texto' => 'Apellido paterno', 'campo'=> 1,'name'=>'apellido_paterno','created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('registro_form_templates')->insert(['texto' => 'Apellido materno', 'campo'=> 1,'name'=>'apellido_materno','created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('registro_form_templates')->insert(['texto' => 'Edad', 'campo'=> 2,'name'=>'edad','created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('registro_form_templates')->insert(['texto' => 'Correo electrónico', 'campo'=> 3, 'name'=>'correo_electronico','created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('registro_form_templates')->insert(['texto' => 'Dirección', 'campo'=> 5, 'name'=>'direccion','created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('registro_form_templates')->insert(['texto' => 'Telefono (Ext)', 'campo'=> 1, 'name'=>'telefono_ext','created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('registro_form_templates')->insert(['texto' => 'Telefono (10 digitos)', 'campo'=> 2,'name'=>'telefono','created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('registro_form_templates')->insert(['texto' => 'Extensión', 'campo'=> 1, 'name'=>'extension','created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('registro_form_templates')->insert(['texto' => 'Dependencia', 'campo'=> 1, 'name'=>'dependencia','created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('registro_form_templates')->insert(['texto' => 'Institución', 'campo'=> 1, 'name'=>'institucion','created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('registro_form_templates')->insert(['texto' => 'Area', 'campo'=> 6, 'name'=>'area','created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
        DB::table('registro_form_templates')->insert(['texto' => 'Nivel jerárquico', 'campo'=> 7, 'name'=>'nivel_jerarquico','created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
    }
}
