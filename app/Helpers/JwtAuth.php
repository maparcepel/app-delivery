<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class JwtAuth{

    public $key;

    public function __construct(){

        $this->key = 'clave_secreta';
    }

    public function signup($email, $password, $getToken = null){

        //Buscar si existe el usuario email

        $user = User::where([
            'email' => $email,
        ])->first();

        //Comprobar es correcto(objeto)

        $signup = false;
        if(is_object($user)){
            if($user->password == $password){

                $signup = true;
             }else{
                $error = 'Contraseña incorrecta.'; 
            }

        }else{

            $error = 'No existe ningún usuario con este email.';

        }

        if($signup){
               
            //Generar token con los datos del usuario en DB
            $token = array(
                'sub'       =>  $user->id,
                'name'      =>  $user->name,
                'email'     =>  $user->email,
                'phone'     =>  $user->phone,
                'user_type' =>  $user->user_type,
                'iat'       =>  time(),
                'exp'       =>  time() + (7 * 24 * 60 * 60)
            );

            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);

            //Devolver los datos decodificados o el token 

            if(is_null($getToken)){
                    
               
                $data = array(
                    "status" => 'success',
                    'code'      => 200,
                    "response" => array(
                        'token'     => $jwt,
                        'name'      =>  $user->name,
                        'phone'     =>  $user->phone,
                        'email'     =>  $user->email,
                        'user_type' =>  $user->user_type,
                        )
                );
            }else{
                $data = $decoded;
            }

        }else{
            $data = array(
                'status'    => 'error',
                'code'      => 404,
                'errors'    =>$error
            );
                

        }

        return $data;
    }

    //------------------------CHECKTOKEN--------------------------------------

    public function checkToken($jwt, $getIdentity = false){
        $auth = false;

        try{
            $jwt = str_replace('"', '', $jwt);
           
            $decoded = JWt::decode($jwt, $this->key, ['HS256']);

        }catch(\UnexpectedValueException $e){
            $auth = false;
        }catch(\DomainException $e){
            $auth = false; 
        }

        if(!empty($decoded) && is_object($decoded) && isset($decoded->sub)){
            $auth = true;
        }else{
            $auth = false;
        }

        if($getIdentity && $auth ==true){
            return $decoded;
        }
        return $auth;
    }

}
