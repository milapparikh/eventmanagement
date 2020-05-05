<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use App\Role;

use Illuminate\Http\Response;


use Illuminate\Support\Facades\Auth; 
use Validator;
class UserController extends Controller 
{
    public $createdStatus = 201;
    public $successStatus = 200;
    public $unAuthorisedStatus = 401;

/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['status' => '200','success' => $success], Response::HTTP_OK); 
        } 
        else{ 
            return response()->json(['status' => '401',
                'error'=>'Unauthorised'], Response::HTTP_UNAUTHORIZED );  
        } 
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);

        if ($validator->fails()) { 
            return response()->json(['status' => '401','error'=>$validator->errors()], Response::HTTP_UNAUTHORIZED);            
        }

        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $admin_role = Role::where('name', 'user')->first();
        $input['role_id'] = $admin_role->id;

        $user = User::create($input); 

        //$user->roles()->attach(Role::where('name', 'user')->first());
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        
        return response()->json(['status' => '201','success'=>$success], Response::HTTP_CREATED ); 
    }
    
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
     /* 
    public function details() 
    { 
     //   $user = Auth::user(); 
     //   return response()->json(['success' => $user], $this-> successStatus); 
    } */
}