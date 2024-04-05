<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FaceMeet;
use Mail;
use App\Models\emailsUsers;
use App\Models\agenda;
use DB;
class MailsController extends Controller
{
    static function registroUsuario($email,$pass){
        $data = ['user' => $email,'pass' => $pass];
        // Ruta o nombre de la plantilla de hoja que se va a representar
        $template_path = 'emails.registro_usuario';
        
        Mail::send($template_path, $data, function($message) use($email) {
            // Configure el destinatario y el asunto del correo.
            $message->to($email)->subject('Sistema de encuestas - Instrucciones para ingresar');
            
        });

        return "Correo electrónico básico enviado, revise su bandeja de entrada.";
    }




    static function htmlmail($email,$token){
        $data = ['token'=>$token];
        // Ruta o nombre de la plantilla de hoja que se va a representar
        $template_path = 'emails.email_recuperar';
        
        Mail::send($template_path, $data, function($message) use($email) {
            // Configure el destinatario y el asunto del correo.
            $message->to($email)->subject('Cambio de contraseña');
        });

        return "Correo electrónico básico enviado, revise su bandeja de entrada.";
    }

}
