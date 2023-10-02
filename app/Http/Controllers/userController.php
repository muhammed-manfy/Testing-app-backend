<?php

namespace App\Http\Controllers\APIs;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Response;

class userController extends Controller
{

   public function register (Request $request){

       $vlaidator = Validator::make($request->all(),[
                'name'=> 'required',
                'email'=> 'required|email|max:255|unique:users',
                'password'=> 'required|min:8'
            ]);
            if($vlaidator->fails())
                return response()->json($validator->errors());
        try{
            User::create([
                'name' => $request->name,
                'email'=> $request->email,
                'password'=> $request->password
            ]);
                return response()->json([
                        'message' => 'User registration Successfully!'
                    ],201);

        }catch(Exception $error){
            return response()->json([
                'message' => $error->message
            ],500);
        }

    }

    public function login(Request $request){

        $validatorUser = Validator::make($request->all() ,[

            'email'=>'required|email|max:255',
            'password'=>'required|min:8'

        ]);
            if($validatorUser->fails())
                return response()->json($validatorUser->errors());

        $user = User::where('email',$request->email)->first();

        if($user){

            if($user -> password != $request->password){
                    return response()->json([
                        'message' => "Invalid password",
                        'status' => false
                    ],402);
            }

            else{

                $token = JWTAuth::fromUser($user);
                    return response()->json([
                        'message' => "You are already logged in",
                        'status' => true,
                        'token' => $token,
                        'user_id' => $user->id
                ], 200 );
            }
        } else {
               return response()->json([
                    'message' => "Invalid email",
                    'status' => false
                ],404);
        }
    }

    public function getUser($id){
        try{
            $user = User::find($id);
            return response()->json([
                'data' => $user
            ],200);
        }catch(Exception $error){
            return response()->json([
                'message' => $error->message
            ],504);
        }
    }
}
