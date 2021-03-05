<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{

    //*********************SIGNUP**********************
    
    public function signup(Request $request){
      
        //Recoger datos

        $json = $request->input('json', null);
        $params = json_decode($json); 
        $params_array = json_decode($json, true); 

       if (!empty($params) && !empty($params_array)) {
                
            //Limpiar datos
            $params_array = array_map('trim', $params_array);

            //Validar datos
            $validate = \Validator::make($params_array, [
                'name'      => 'required|alpha',
                'surname'   => 'required|alpha',
                'phone'     => 'required|numeric',
                'email'     => 'required|email|unique:users',
                'password'  => 'required',
                'user_type_id' => 'required|numeric',
            ]);

            if ($validate->fails()) {

                //La validación ha fallado
                $data = array(
                    'status'    => 'error',
                    'code'      => 404,
                    'message'   => 'El usuario no se ha creado',
                    'errors'    =>$validate->errors()
                );

            } else {
            
                //Cifrar password
                $pwd = hash('sha256', $params->password);

                //crear usuario

                $user = new User();
                $user->name = $params_array['name'];
                $user->surname = $params_array['surname'];
                $user->phone = $params_array['phone'];
                $user->email = $params_array['email'];
                $user->password = $pwd;
                $user->user_type_id = $params_array['user_type_id'];

                $user->save();

                $data = array(
                    'status'    => 'success',
                    'code'      => 200,
                    'message'   => 'El usuario se ha creado correctamente'
                );
            }

        }else{

            $data = array(
                'status' => 'error',
                'code'      => 404,
                'message'   => 'Los datos no se han recibido correctamente.',
            );
        }

        return response()->json($data);
    }



    //*********************LOGIN**********************


    public function login(Request $request){

        $jwtAuth = new \JwtAuth();

        //Recibir datos por post
        $json = $request->input('json', null);
        $params = json_decode($json); 
        $params_array = json_decode($json, true); 

        //Validar datos
        $validate = \Validator::make($params_array, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            //La validación ha fallado

            $signup = array(
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'El usuario no se ha podido identificar',
                'errors'    =>$validate->errors()
            );

        } else {
            //Cifrar la contraseña
            $pwd = hash('sha256', $params->password);

            //Devolver token o datos
            $signup = $jwtAuth->signup($params->email, $pwd);

            if (!empty($params->getToken)) {
                $signup = $jwtAuth->signup($params->email, $pwd, true);
            }
        }

        return json_encode($signup);
    }


    
    //*********************USER/EDIT**********************


    public function edit(Request $request){

        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);

        //Compruebo validez del token
        if ($checkToken) {
            $json = $request->input('json', null);
            $params_array = json_decode($json, true);

            //Validar los datos
            $user_id = $jwtAuth->checkToken($token, true);
            $validate = \Validator::make($params_array, [
                'name'          => 'required',
                'surname'       => 'required',
                'email'         => 'required|email|unique:users,email,'.$user_id->sub,
                'phone'         => 'required|numeric'
            ]);

            if ($validate->fails()) {

                $data = array(
                    'status'    => 'error',
                    'code'      => 404,
                    'message'   => 'El usuario no se ha podido editar',
                    'errors'    =>$validate->errors()
                );

            }else{ 

                unset($params_array['password']);

                $user_update = User::where('id', $user_id->sub)->update($params_array);

                $data = array(
                    'code' => 200,
                    'status' => 'success',
                    'message'   => 'Usuario editado correctamente'
                );
            }

        } else{

            $data = array(
                'code' => 400,
                'status' => 'error',
                'message' => 'Usuario no identificado',
            );

        }

        return json_encode($data);

    }



}
