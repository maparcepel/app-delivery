<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function setOrder(Request $request)
    {
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
                'user_id'           => 'required|numeric',
                'pickup_day'        => 'required',
                'pickup_time'       => 'required',
                'address'           => 'required',
                'payment_type_id'   => 'required|numeric',

                //Order items
                'items.*.product_id'    => 'required|numeric',
                'items.*.quantity'      => 'required|numeric',
                'items.*.unit_price'    => 'required|numeric',
            ]);

            if ($validate->fails()) {

                $data = array(
                    'status'    => 'error',
                    'code'      => 400,
                    'message'   => 'Error en los datos recibidos',
                    'errors'    => $validate->errors()
                );

            }else{ 

                $order = new Order();
                $order->user_id     = $params_array['user_id'];
                $order->pickup_day  = $params_array['pickup_day'];
                $order->pickup_time = $params_array['pickup_time'];
                $order->address     = $params_array['address'];
                $order->order_date  = now();
                $order->payment_type_id = $params_array['payment_type_id'];

                $order->save();

                //Order items
                foreach($params_array['items'] as $item){
                    
                    $orderItems = new OrderItem();
                    $orderItems->product_id = $item['product_id'];
                    $orderItems->quantity   = $item['quantity'];
                    $orderItems->unit_price = $item['unit_price'];
    
                    $order->orderItems()->save($orderItems);
                }
                
                $data = array(
                    'code' => 200,
                    'status' => 'success',
                    'message'   => 'La orden se ha creado correctamente'
                );
            }

        } else{

            $data = array(
                'code' => 400,
                'status' => 'error',
                'message' => 'Usuario no identificado. Token no válido',
            );

        }

        return json_encode($data);
    }

}
