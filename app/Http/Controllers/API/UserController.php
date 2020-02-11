<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   
    public $successStatus = 200;

/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password',
            'role_id'   => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success = 'Pendaftaran Berhasil!';
        return response()->json(['success'=>$success], $this-> successStatus); 
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    
    public function details($id){

        $user = User::where('nik',$id)->first();
        $data =['status_code' =>'00',
                    'nama' =>$user->name,
                    'email' =>$user->email,
                    'id'    =>$user->id,
                    'role_id'    =>$user->role_id,
                    'nik'    =>$user->nik,
                    ];
            return response()->json([$data]);
        }
    

    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $req){ 
        if(Auth::attempt(['email' => $req->email, 'password' => $req->password])){ 
           $user = Auth::user();
           $user=User::where('email',$req->email)->first();
           $data =['status_code' =>'00',
                   'nama' =>$user->name,
                   'email' =>$user->email,
                   'id'    =>$user->id,
                   'role_id'    =>$user->role_id,
                   'nik'    =>$user->nik,
                   ];
           return response()->json($data);
       } 
       else{ 
            $data =['status_code' =>'11',
               ];
           return response()->json($data); 
       } 
   }

   public function ubahpass(Request $req){
  
    $user = User::find($req->id);
    $user->password = Hash::make($req->password);
    $user->update();
        return response()->json([$user]);

    }

    
    
}
