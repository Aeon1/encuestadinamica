<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\Roles;
use App\Models\emailsUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MailsController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersAuthController extends Controller
{


    public function index() {
        return view('index');
    }  

    public function customLogin(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $data = $request->all();
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            try{
                $user = User::select('id','name','rol','primerlogin')->where('email',$data['email'])->where('activo',1)->firstOrFail();
                if($user->primerlogin == 1){
                    $actualizacion = User::where('email',$data['email'])->update(array('remember_token' => $data['_token']));         
                    if($actualizacion){
                        return redirect("ChangePass/$data[_token]");
                    }else{
                        return redirect("Login")->with('error','Ocurrió un error');
                    }
                }else{
                    session(['id' => $user->id, 'nombre' => $user->name, 'rol' => $user->rol]);
                    return redirect()->intended('Dashboard');
                }
            }catch(ModelNotFoundException $e){
                return redirect("Login")->with('error','Datos Incorrectos');
            }
        }
  
        return redirect("Login")->with('error','Datos Incorrectos');
    }

    public function registration() {
        $roles = Roles::where('estatus',1)->get();
        return view('auth.registration', compact('roles'));
    }

    public function customRegistration(Request $request) {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required'  => 'El correo es obligatorio',
            'email.email' => 'Debe ingresar un correo valido',
            'email.unique' => 'El usuario ya se encuentra registrado',
            'password.required' => 'Debe ingresar la contraseña',
            'password.min:6' => 'La contraseña debe tener al menos 6 caracteres'
          ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("success")->with( ['registro_usuarios'=> "El Usuario $data[name] fue registrado correctamente"]);
    }

    public function create(array $data) {
      $saveUser = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'rol' => 1,
        'hash' => hash('ripemd128',$data['email'])
      ]);
      if($saveUser){
            MailsController::registroUsuario($data['email'],$data['password']);
        
        return $saveUser;
      }
    }    

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('Login');
    }

    public function resetPassword() {
        return view('auth.passwords.reset');
    }

    public function emailReset(Request $request) {
        $data = $request->all();
        // revisar si el usuario existe (hacer)
        $actualizacion = User::where('email',$data['email'])->update(array('remember_token' => $data['_token']));         
        if($actualizacion){
            MailsController::htmlmail($data['email'],$data['_token']);
        }else{
            return back()->with('error','Ocurrio un error inesperado, intente de nuevo');
        }
        
        return redirect("Login")->with('success','Se ha enviado exitosamente un correo con instrucciones');
    }

    public function emailRestablecer($token) {
        $usuario = User::select('id')->where('remember_token',$token)->first();
        if (!empty($usuario->id)) {
            return view('auth.passwords.newPass','compact'('usuario'));
        }else{
            return redirect("Login")->with('error','No se encontro la solicitud indicada');
        }
        
    }

    public function emailResetNew(Request $request) {
        $request->validate([
            'id' => 'required',
            'password1' => 'required|min:6',
            'password2' => 'required|min:6'
        ]);
        $data = $request->all();
        if ($data['password1'] == $data['password2']) {
            $actualizacion = User::where('id',$data['id'])->update(array('password' => Hash::make($data['password1']))); 
            if ($actualizacion) {
                User::where('id',$data['id'])->update(array('remember_token' => '','primerlogin'=>0));
                return redirect("Login")->with('success','Contraseña cambiada exitosamente');
            }
        }else{
            return back()->with('error','Las contraseñas ingresadas deben de coincidir');
        }
    }

    public function userManagement(){
        if(Auth::check()){
            $users = User::select('users.id','users.name','users.email','roles.tipo','users.activo')
            ->leftJoin('roles','roles.id','users.rol')
            ->get();
            return view('auth.users.management', compact('users'));
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function userOptions($id =''){
        if(Auth::check()){
            $user['datos'] = User::where('id',$id)->firstOrFail();
            $user['roles'] = Roles::where('estatus',1)->get();
            return view('auth.users.options', compact('user'));
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function userOptionsSave(Request $request){
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email|min:6'
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required'  => 'El correo es obligatorio',
            'email.email' => 'Debe ingresar un correo valido'
          ]);
        $data = $request->all();
        $check = User::where('id',$data['id'])
            ->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'rol' => 1,
                'activo' => !empty($data['estatus'])?1:0
            ]);
        if ($check) {
            return redirect("Gestion")->with('success','Usuario actualizado correctamente');
        }else {
            return back()->with('error','Ocurrio un error, intente de nuevo');
        }
        
    }

}
