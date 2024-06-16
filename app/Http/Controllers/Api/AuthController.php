<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;



class AuthController extends Controller
{
    public function register(Request $request){
        
        $data= $request->json()->all();
        try{
            $request->validate([
                'name'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>'required',
            ]);
            $user = new User();
            
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->save();
            
    
            return response()->json([
                "message"=>"Metodo register ok"
               ]);

        }catch(\Exception $e){
            return response()->json([
                "message"=>"Fallido $e" ,
                "datos"=> $data
               ]);
        }

       

        

    }
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);
    
        if(Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken; 
            $cookie = cookie('cookie_token', $token, 60*24);
            return response(["token" => $token], Response::HTTP_OK)->withCookie($cookie); 
        } else {
            return response(["message" => "Credenciales Inválidas"], Response::HTTP_UNAUTHORIZED); 
        }
    }
    

    public function userProfile(Request $request){
        $userData = auth()->user();
        return response()->json($userData);
        
    }

    public function logout(){

        $cookie = Cookie::forget('cookie_token');
        return response(["message"=>"Cierre de session con exito"],Response::HTTP_OK)->withCookie($cookie);
        
        
    }

    public function allUsers(){

        
    }
    
}
